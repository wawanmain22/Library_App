<!DOCTYPE html>
<html>

<head>
    <title>Daftar Pembaca Buku</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .date {
            text-align: right;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Daftar Pembaca Buku</h2>
    </div>
    <div class="date">
        Tanggal: {{ date('d/m/Y') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Buku</th>
                <th>Tanggal Baca</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($readers as $index => $reader)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $reader->name }}</td>
                    <td>{{ $reader->book }}</td>
                    <td>{{ Carbon\Carbon::parse($reader->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
