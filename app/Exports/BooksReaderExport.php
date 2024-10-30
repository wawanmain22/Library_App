<?php

namespace App\Exports;

use App\Models\BooksReader;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BooksReaderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BooksReader::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Buku',
            'Tanggal Baca',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        static $counter = 0;
        $counter++;

        return [
            $counter, // Nomor urut
            $row->name, // Nama
            $row->book, // Buku
            Carbon::parse($row->created_at)->format('d/m/Y'), // Tanggal Baca
        ];
    }
}
