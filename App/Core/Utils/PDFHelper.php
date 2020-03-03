<?php

// namespace App\Core\Utils;

// require('fpdf/fpdf.php');

// class PDFHelper extends FPDF
// {
//     // Load data
//     function generate($header, $arr)
//     {
//         foreach ($arr as $line)
//             $data[] = explode(';', trim($line));

//         // Column widths
//         $w = array(40, 35, 40, 45);
//         // Header
//         for ($i = 0; $i < count($header); $i++) {
//             $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
//         }

//         $this->Ln();
//         // Data
//         foreach ($data as $row) {
//             $this->Cell($w[0], 6, $row[0], 'LR');
//             $this->Cell($w[1], 6, $row[1], 'LR');
//             $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
//             $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
//             $this->Ln();
//         }

//         // Closing line
//         $this->Cell(array_sum($w), 0, '', 'T');
//     }
// }

// // $pdf = new PDF();
// // // Column headings
// // $header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// // // Data loading
// // $data = $pdf->LoadData('countries.txt');
// // $pdf->SetFont('Arial', '', 14);
// // $pdf->AddPage();
// // $pdf->BasicTable($header, $data);
// // $pdf->AddPage();
// // $pdf->ImprovedTable($header, $data);
// // $pdf->Output();
