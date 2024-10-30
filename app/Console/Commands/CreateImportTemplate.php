<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateImportTemplate extends Command
{
    protected $signature = 'make:import-template';
    protected $description = 'Create Excel and CSV templates for books reader import';

    public function handle()
    {
        $this->info('Creating templates...');
        $directory = storage_path('app/template');

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Create Excel template
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers and data
        $headers = ['nama', 'buku', 'tanggal_baca'];
        $data = [
            ['John Doe', 'Harry Potter', '30/10/2024'],
            ['Jane Smith', 'Lord of the Rings', '29/10/2024'],
        ];

        $this->createExcelFile($spreadsheet, $headers, $data, $directory);
        $this->createCsvFile($headers, $data, $directory);

        $this->info('Templates created successfully!');
    }

    private function createExcelFile($spreadsheet, $headers, $data, $directory)
    {
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        foreach ($headers as $index => $header) {
            $sheet->setCellValue(chr(65 + $index) . '1', $header);
            $sheet->getStyle(chr(65 + $index) . '1')->getFont()->setBold(true);
        }

        // Set data
        $row = 2;
        foreach ($data as $rowData) {
            foreach ($rowData as $index => $value) {
                $sheet->setCellValue(chr(65 + $index) . $row, $value);
            }
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($directory . '/template_import_pembaca.xlsx');
    }

    private function createCsvFile($headers, $data, $directory)
    {
        $file = fopen($directory . '/template_import_pembaca.csv', 'w');

        // Tulis header terpisah
        fputcsv($file, ['nama', 'buku', 'tanggal_baca'], ',');

        // Tulis data dengan benar
        foreach ($data as $row) {
            fputcsv($file, $row, ',');
        }

        fclose($file);
    }
}
