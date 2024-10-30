<?php

namespace App\Imports;

use App\Models\BooksReader;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BooksReaderImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        try {
            $date = Carbon::createFromFormat('d/m/Y', $row['tanggal_baca'])->startOfDay();
        } catch (\Exception $e) {
            throw new \Exception('Format tanggal harus dd/mm/yyyy. Contoh: 30/10/2024');
        }

        return new BooksReader([
            'name' => $row['nama'],
            'book' => $row['buku'],
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'buku' => 'required',
            'tanggal_baca' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Kolom nama harus diisi',
            'buku.required' => 'Kolom buku harus diisi',
            'tanggal_baca.required' => 'Kolom tanggal_baca harus diisi',
        ];
    }
}
