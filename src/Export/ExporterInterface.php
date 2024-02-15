<?php

namespace Gemonos\ExportBundle\Export;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

interface ExporterInterface
{
    /**
     * Exporte les données vers un fichier Excel.
     *
     * @param array $entities Les entités à exporter.
     * @param array $fields Les champs à inclure dans l'exportation.
     * @param bool $includeHeader Indique si une en-tête doit être incluse.
     * @return string Le chemin du fichier exporté.
     */
    public function export(array $entities, array $fields, bool $includeHeader = true): string;

    /**
     * Configure l'en-tête du fichier Excel.
     *
     * @param Worksheet $sheet La feuille de calcul à configurer.
     * @param int $entityCount Le nombre d'entités à exporter.
     * @param array $fields Les champs pour l'en-tête.
     */
    public function configureHeader(Worksheet $sheet, int $entityCount, array $fields): void;
}
