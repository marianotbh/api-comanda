<?php

namespace App\Services;

use App\Core\Data\QueryBuilder;
use App\Core\Exceptions\AppException;
use App\Core\Utils\PDFHelper;

class ExportService
{
    function export($filters, $page, $length, $field, $order)
    {
        $pdf = new PDFHelper();

        $users = new QueryBuilder("users");
        $users = new QueryBuilder("reviews");
        $users = new QueryBuilder("logs");
        $users = new QueryBuilder("");

        $users->select("*")->where("");

        //sreturn $pdf->generate([""]);
    }
}
