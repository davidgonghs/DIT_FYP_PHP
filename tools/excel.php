<?php

require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
for($i = 0;$i<10;$i++){
        $sheet->setCellValue( pack("C1",65+$i).'1', $i);
}




$writer = new Xlsx($spreadsheet);
$writer->save('../xls/hello world.xlsx');
