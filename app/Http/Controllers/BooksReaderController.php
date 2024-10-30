<?php

namespace App\Http\Controllers;

use App\Exports\BooksReaderExport;
use App\Imports\BooksReaderImport;
use App\Models\BooksReader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BooksReaderController extends Controller
{
    public function index()
    {
        $readers = BooksReader::latest('created_at')->paginate(10);
        return view('readers.index', compact('readers'));
    }

    public function create()
    {
        return view('readers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'book' => 'required',
            'read_date' => 'required|date',
        ]);

        // Parse tanggal yang dipilih
        $date = Carbon::parse($request->read_date);

        BooksReader::create([
            'name' => $request->name,
            'book' => $request->book,
            'created_at' => $date,
            'updated_at' => now(),
        ]);

        return redirect()->route('readers.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(BooksReader $reader)
    {
        return view('readers.edit', compact('reader'));
    }

    public function update(Request $request, BooksReader $reader)
    {
        $request->validate([
            'name' => 'required',
            'book' => 'required',
            'read_date' => 'required|date',
        ]);

        // Parse tanggal yang dipilih
        $date = Carbon::parse($request->read_date);

        // Update semua field termasuk timestamps
        $reader->name = $request->name;
        $reader->book = $request->book;
        $reader->created_at = $date;
        $reader->updated_at = now();
        $reader->save();

        return redirect()->route('readers.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(BooksReader $reader)
    {
        $reader->delete();
        return redirect()->route('readers.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportExcel()
    {
        return Excel::download(
            new BooksReaderExport,
            'daftar_pembaca_buku_' . date('d-m-Y') . '.xlsx'
        );
    }

    public function exportPDF()
    {
        $readers = BooksReader::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('readers.pdf', compact('readers'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('daftar_pembaca_buku_' . date('d-m-Y') . '.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new BooksReaderImport, $request->file('file'));
            return redirect()->route('readers.index')->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('readers.index')->with('error', 'Gagal import data. Pastikan format file sesuai template.');
        }
    }

    public function downloadTemplate($type)
    {
        $fileName = 'template_import_pembaca.' . $type;
        $filePath = storage_path('app/template/' . $fileName);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Template file tidak ditemukan');
        }

        $headers = [
            'Content-Type' => $type === 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return response()->download($filePath, $fileName, $headers);
    }

    public function dashboard()
    {
        // Data untuk line chart (trend pembaca per bulan)
        $monthlyReaders = BooksReader::selectRaw('COUNT(*) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Data untuk pie chart (distribusi buku yang dibaca)
        $bookDistribution = BooksReader::select('book', DB::raw('count(*) as total'))
            ->groupBy('book')
            ->orderByDesc('total')
            ->get();

        return view('dashboard', compact('monthlyReaders', 'bookDistribution'));
    }
}
