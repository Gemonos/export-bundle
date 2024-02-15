<?php

namespace Gemonos\ExportBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GemonosExportBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
