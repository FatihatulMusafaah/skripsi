
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f3f4f6;
        }

        .sidebar{
            width:250px;
            height:100vh;
            background:#111827;
            position:fixed;
            left:0;
            top:0;
            padding-top:20px;
        }

        .sidebar h2{
            color:white;
            text-align:center;
            margin-bottom:30px;
        }

        .sidebar a{
            display:block;
            color:white;
            padding:15px 25px;
            text-decoration:none;
            transition:0.3s;
        }

        .sidebar a:hover{
            background:#2563eb;
        }

        .main{
            margin-left:250px;
            padding:30px;
        }

        .header{
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
            margin-bottom:30px;
        }

        .header h1{
            color:#111827;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
            gap:20px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        .card h3{
            color:#374151;
            margin-bottom:10px;
        }

        .card p{
            font-size:28px;
            font-weight:bold;
            color:#2563eb;
        }

        .menu-table{
            background:white;
            margin-top:30px;
            padding:25px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        .menu-table h2{
            margin-bottom:20px;
            color:#111827;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th,
        table td{
            padding:15px;
            border-bottom:1px solid #e5e7eb;
            text-align:left;
        }

        table th{
            background:#2563eb;
            color:white;
        }

        .logout-btn{
            margin-top:30px;
        }

        .logout-btn button{
            padding:12px 20px;
            background:#dc2626;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-size:15px;
        }

        .logout-btn button:hover{
            background:#b91c1c;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>OWNER PANEL</h2>

        <a href="/dashboard">Dashboard</a>
        <a href="/pegawai">Data Pegawai</a>
        <a href="/absensi">Absensi</a>
        <a href="/cuti">Cuti</a>
        <a href="/kasbon">Kasbon</a>
        <a href="/penggajian">Penggajian</a>
        <a href="/laporan">Laporan</a>
        <div class="logout-btn">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
    </div>

    <div class="main">

        <div class="header">
            <h1>Dashboard Owner</h1>
            <p>Selamat datang di Sistem Informasi Kepegawaian</p>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Total Pegawai</h3>
                <p>25</p>
            </div>

            <div class="card">
                <h3>Total Absensi</h3>
                <p>120</p>
            </div>

            <div class="card">
                <h3>Total Kasbon</h3>
                <p>15</p>
            </div>

            <div class="card">
                <h3>Total Penggajian</h3>
                <p>30</p>
            </div>
              


        </div>

        <div class="menu-table">
            <h2>Data Aktivitas Pegawai</h2>

            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>

                <tr>
                    <td>1</td>
                    <td>Ahmad</td>
                    <td>Masuk</td>
                    <td>01-05-2026</td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Budi</td>
                    <td>Cuti</td>
                    <td>02-05-2026</td>
                </tr>
            </table>

        </div>
    </div>
 
</body>
</html>
