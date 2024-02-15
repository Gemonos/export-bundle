<?php

namespace Gemonos\ExportBundle\Export;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExporter implements ExporterInterface {

    public function __construct(
        private readonly string $exportPath,
    ) {}

    /**
     * @throws Exception
     */
    public function export(array $entities, array $fields, bool $includeHeader = true): string
    {

        $entity = $entities[0];
        $labels = $entity->resolveLabels($fields);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Condition pour configurer l'en-tête si demandé
        if ($includeHeader) {
            $this->configureHeader($sheet, count($entities), $fields);
        }
        $dataStartRow = $includeHeader ? 4 : 1;

        // Définir les en-têtes de colonne dans Excel
        $columnIndex = 1;
        foreach ($labels as $field => $label) {
            $cell = Coordinate::stringFromColumnIndex($columnIndex) . '1';
            $sheet->setCellValue($cell, $label);
            $columnIndex++;
        }

        // Remplir les données
        $rowIndex = 2; // Commencer à la deuxième ligne, après les en-têtes
        foreach ($entities as $entity) {
            $columnIndex = 1;
            foreach ($fields as $field) {
                // Utiliser une méthode getter ou la réflexion pour obtenir la valeur de l'entité
                $getter = 'get' . ucfirst($field);
                $value = method_exists($entity, $getter) ? $entity->$getter() : 'N/A';

                $cell = Coordinate::stringFromColumnIndex($columnIndex) . $rowIndex;
                $sheet->setCellValue($cell, $value);
                $columnIndex++;
            }
            $rowIndex++;
        }


        // Générer le fichier Excel
        $fileName = $this->exportPath . '/export_' . date('Y-m-d_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($fileName);

        return $fileName;
    }


    public function configureHeader(Worksheet $sheet, int $entityCount, array $fields): void
    {
        // Ajouter la ligne informative sur le nombre d'éléments
        $sheet->setCellValue('A1', 'Nombre d\'éléments : ' . $entityCount);

        // Définir les en-têtes de colonne à partir de la troisième ligne
        $columnIndex = 1;
        $headerRow = 3;
        foreach ($fields as $field) {
            $cell = Coordinate::stringFromColumnIndex($columnIndex) . $headerRow;
            $sheet->setCellValue($cell, $field);
            $columnIndex++;
        }
    }


}