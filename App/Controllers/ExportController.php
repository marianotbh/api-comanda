<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Services\ExportService;

class ExportController
{
    private $exportService;

    public function __construct()
    {
        $this->exportService = new ExportService();
    }

    function xls(Request $req, Response $res, $args)
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename-"./FileSystem/Reporting/Sales.xlsx"');
        header('Cache-Control: max-age=0');

        $file = $this->exportService->exportXLS();

        $writer = \PHPExcel_IOFactory::createWriter($file, "Excel2007");
        $writer->save("./App/FileSystem/Reporting/Sales.xlsx");

        return $res->withStatus(StatusCode::HTTP_OK);
    }

    function pdf(Request $req, Response $res, $args)
    {
        $pdf = $this->exportService->exportPdf();

        $pdf->Output("F", "./App/FileSystem/Reporting/Summary.pdf", true);

        return $res->withStatus(StatusCode::HTTP_OK);
    }
}
