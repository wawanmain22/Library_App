@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="dashboard-header mb-4">
            <h1><i class="fas fa-chart-line me-2"></i>Dashboard Overview</h1>
            <p class="text-muted">Statistik dan analisis perpustakaan</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-card-content">
                        <i class="fas fa-users stat-icon"></i>
                        <div>
                            <h6>Total Pembaca</h6>
                            <h3>{{ $monthlyReaders->sum('count') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-card-content">
                        <i class="fas fa-book stat-icon"></i>
                        <div>
                            <h6>Judul Buku Berbeda</h6>
                            <h3>{{ $bookDistribution->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-card-content">
                        <i class="fas fa-chart-bar stat-icon"></i>
                        <div>
                            <h6>Rata-rata Pembaca/Bulan</h6>
                            <h3>{{ round($monthlyReaders->avg('count')) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card dashboard-card">
                    <div class="card-header">
                        <i class="fas fa-chart-line me-2"></i>Trend Pembaca per Bulan
                    </div>
                    <div class="card-body">
                        <canvas id="readersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card dashboard-card">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Buku yang Dibaca
                    </div>
                    <div class="card-body">
                        <canvas id="bookPieChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card dashboard-card">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-2"></i>Statistik Detail
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-users me-2"></i>Total Pembaca</span>
                                <span class="badge bg-primary rounded-pill">{{ $monthlyReaders->sum('count') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-book me-2"></i>Judul Buku Berbeda</span>
                                <span class="badge bg-primary rounded-pill">{{ $bookDistribution->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-chart-bar me-2"></i>Rata-rata Pembaca per Bulan</span>
                                <span
                                    class="badge bg-primary rounded-pill">{{ round($monthlyReaders->avg('count')) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .dashboard-header {
            padding: 20px 0;
        }

        .dashboard-header h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 600;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            font-size: 2.5rem;
            color: #2c3e50;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 12px;
        }

        .stat-card h6 {
            color: #6c757d;
            margin-bottom: 5px;
        }

        .stat-card h3 {
            color: #2c3e50;
            margin: 0;
            font-weight: bold;
        }

        .dashboard-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .dashboard-card .card-header {
            background: #2c3e50;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px 20px;
            font-weight: 600;
        }

        .list-group-item {
            border: none;
            margin-bottom: 5px;
            border-radius: 8px !important;
            background: #f8f9fa;
        }

        .badge {
            font-size: 14px;
            padding: 8px 12px;
        }

        .bg-primary {
            background-color: #2c3e50 !important;
        }
    </style>

    <script>
        const lineCtx = document.getElementById('readersChart');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyReaders->pluck('month')) !!},
                datasets: [{
                    label: 'Jumlah Pembaca per Bulan',
                    data: {!! json_encode($monthlyReaders->pluck('count')) !!},
                    borderColor: '#2c3e50',
                    backgroundColor: 'rgba(44, 62, 80, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointBackgroundColor: '#2c3e50'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        const pieCtx = document.getElementById('bookPieChart');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($bookDistribution->pluck('book')) !!},
                datasets: [{
                    data: {!! json_encode($bookDistribution->pluck('total')) !!},
                    backgroundColor: [
                        '#2c3e50', '#3498db', '#e74c3c', '#2ecc71', '#f1c40f',
                        '#9b59b6', '#34495e', '#1abc9c', '#e67e22', '#95a5a6'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
