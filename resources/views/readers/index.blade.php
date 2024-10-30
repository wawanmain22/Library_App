@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Header Section -->
        <div class="readers-header mb-4">
            <h1><i class="fas fa-book-reader me-2"></i>Daftar Pembaca Buku</h1>
            <p class="text-muted">Kelola data pembaca perpustakaan</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"></i>Data Pembaca</span>
                            <div class="button-group">
                                <button type="button" class="btn btn-primary custom-btn" data-bs-toggle="modal"
                                    data-bs-target="#createModal">
                                    <i class="fas fa-plus me-2"></i>Tambah Data
                                </button>
                                <a href="{{ route('export.excel') }}" class="btn btn-success custom-btn">
                                    <i class="fas fa-file-excel me-2"></i>Export Excel
                                </a>
                                <a href="{{ route('export.pdf') }}" class="btn btn-danger custom-btn">
                                    <i class="fas fa-file-pdf me-2"></i>Export PDF
                                </a>
                                <button type="button" class="btn btn-info custom-btn" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="fas fa-file-import me-2"></i>Import Data
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 search-container">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" class="form-control custom-search"
                                placeholder="Cari data...">
                        </div>
                        <div class="table-responsive">
                            <table class="table custom-table" id="readersTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Buku</th>
                                        <th>Tanggal Baca</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($readers as $reader)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $reader->name }}</td>
                                            <td>{{ $reader->book }}</td>
                                            <td>{{ Carbon\Carbon::parse($reader->created_at)->format('d/m/Y') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning custom-btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $reader->id }}">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger custom-btn-sm delete-btn"
                                                    data-id="{{ $reader->id }}" data-name="{{ $reader->name }}">
                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                </button>
                                                <form id="delete-form-{{ $reader->id }}"
                                                    action="{{ route('readers.destroy', $reader) }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="custom-pagination">
                            {{ $readers->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            Download template:
                            <div class="mt-2">
                                <a href="{{ route('template.import', 'xlsx') }}" class="btn btn-sm btn-success">Excel
                                    Template</a>
                                <a href="{{ route('template.import', 'csv') }}" class="btn btn-sm btn-primary">CSV
                                    Template</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih File Excel/CSV</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pembaca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('readers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Buku</label>
                            <input type="text" name="book" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Baca</label>
                            <input type="date" name="read_date" class="form-control" value="{{ date('Y-m-d') }}"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach ($readers as $reader)
        <div class="modal fade" id="editModal{{ $reader->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Pembaca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('readers.update', $reader) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ $reader->name }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Buku</label>
                                <input type="text" name="book" class="form-control" value="{{ $reader->book }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Baca</label>
                                <input type="date" name="read_date" class="form-control"
                                    value="{{ Carbon\Carbon::parse($reader->created_at)->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Header Styling */
        .readers-header {
            padding: 20px 0;
        }

        .readers-header h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 600;
        }

        /* Card Styling */
        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .custom-card .card-header {
            background: #2c3e50;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px 20px;
        }

        /* Button Styling */
        .custom-btn {
            border-radius: 8px;
            padding: 8px 15px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            margin: 0 5px;
        }

        .custom-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .custom-btn-sm {
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 0.875rem;
            margin: 0 2px;
        }

        /* Search Box Styling */
        .search-container {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .custom-search {
            padding-left: 40px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            padding: 12px 12px 12px 40px;
        }

        .custom-search:focus {
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
            border-color: #2c3e50;
        }

        /* Table Styling */
        .custom-table {
            margin-bottom: 0;
        }

        .custom-table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #2c3e50;
            color: #2c3e50;
            font-weight: 600;
        }

        .custom-table tbody tr {
            transition: all 0.3s;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Pagination Styling */
        .custom-pagination {
            margin-top: 20px;
        }

        .custom-pagination .pagination {
            justify-content: center;
            gap: 5px;
        }

        .custom-pagination .page-link {
            color: #2c3e50;
            border: 1px solid #dee2e6;
            padding: 8px 16px;
            border-radius: 8px;
            margin: 0;
            transition: all 0.3s ease;
        }

        .custom-pagination .page-link:hover {
            background-color: #f8f9fa;
            color: #2c3e50;
            border-color: #2c3e50;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #2c3e50;
            border-color: #2c3e50;
            color: white !important;
            font-weight: bold;
        }

        .custom-pagination .page-item.disabled .page-link {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #6c757d;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 15px;
        }

        .modal-header {
            background: #2c3e50;
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .modal-footer {
            border-top: none;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: `Akan menghapus data pembaca "${name}"`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${id}`).submit();
                        }
                    });
                });
            });

            // Search functionality
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const table = document.getElementById('readersTable');
                const rows = table.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) {
                    const row = rows[i];
                    const cells = row.getElementsByTagName('td');
                    let found = false;

                    for (let j = 0; j < cells.length - 1; j++) {
                        const cellText = cells[j].textContent || cells[j].innerText;
                        if (cellText.toLowerCase().indexOf(searchValue) > -1) {
                            found = true;
                            break;
                        }
                    }

                    row.style.display = found ? '' : 'none';
                }
            });
        </script>
    @endpush
@endsection
