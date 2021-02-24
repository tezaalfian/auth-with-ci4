<?php

namespace App\Libraries;

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report
{
    private $mpdf;
    // public $formatPage = "A4-P";
    private $spreadsheet;
    private $writer;

    public function __construct($format = "A4-P")
    {
        $this->mpdf = new \Mpdf\Mpdf([
            'format' => $format,
            'setAutoTopMargin' => 'stretch',
            'autoMarginPadding' => 0,
            'debug' => FALSE,
            'mode' => 'utf-8',
        ]);
        $this->mpdf->shrink_tables_to_fit = 1;
        $this->spreadsheet = new Spreadsheet();
        $this->writer = new Xlsx($this->spreadsheet);
    }

    public function pdf($title = "Default", $data = ['header' => [], 'data' => [], 'footer' => []])
    {
        $viewHeader = view("admin/report/header", ['title' => $title, 'header' => $data['header']]);
        $this->mpdf->SetHTMLHeader($viewHeader);
        $viewBody = view("admin/report/body", $data);
        // echo $viewBody;
        // die;
        $this->mpdf->WriteHTML($viewBody);
        $this->mpdf->Output($title . '.pdf', 'I');
        exit;
    }

    public function excel($title = "Default", $data = ['header' => [], 'data' => [], 'footer' => []])
    {
        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', $title)
            ->setCellValue('A2', 'Pesantren Tahfizh Al-Quran Daarul Uluum Lido')
            ->setCellValue('A3', 'Jl. Mayjen HR Edi Sukma KM 22 Muara Ciburuy Cigombong Bogor 16110 Jawa Barat');
        $j = 5;
        foreach ($data['header'] as $key) {
            $this->spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $j++, $key);
        }
        $char = 'A';
        $j++;
        foreach ($data['data']['title'] as $key) {
            $this->spreadsheet->setActiveSheetIndex(0)->setCellValue($char . $j, $key);
            $char++;
        }
        $j++;
        foreach ($data['data']['row'] as $key) {
            $char = 'A';
            foreach ($key as $val) {
                $this->spreadsheet->setActiveSheetIndex(0)->setCellValue($char . $j, $val);
                $char++;
            }
            $j++;
        }
        $j++;
        foreach ($data['footer'] as $key => $val) {
            $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $j, $key);
            $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $j, $val);
            $j++;
        }
        $this->writer = new Xlsx($this->spreadsheet);

        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $title . ".xls");
        header("Cache-Control: max-age-0");
        $this->writer->save('php://output');
    }
}
