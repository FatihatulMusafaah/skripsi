
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f1f5f9;
        }

        .header{
            background:#2563eb;
            color:white;
            padding:20px;
            border-bottom-left-radius:20px;
            border-bottom-right-radius:20px;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
        }

        .header h2{
            font-size:24px;
        }

        .header p{
            margin-top:5px;
            font-size:14px;
        }

        .container{
            padding:20px;
        }

        .card{
            background:white;
            padding:18px;
            border-radius:15px;
            margin-bottom:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
            transition:0.3s;
        }

        .card:hover{
            transform:scale(1.02);
        }

        .card a{
            text-decoration:none;
            color:#111827;
            font-size:18px;
            font-weight:bold;
            display:block;
        }

        .icon{
            font-size:35px;
            margin-bottom:10px;
        }

        .logout{
            width:100%;
            padding:14px;
            border:none;
            border-radius:12px;
            background:#dc2626;
            color:white;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
        }

        .logout:hover{
            background:#b91c1c;
        }

        .footer{
            text-align:center;
            margin-top:30px;
            color:gray;
            font-size:13px;
        }

        @media(max-width:600px){
            .header h2{
                font-size:20px;
            }

            .card a{
                font-size:16px;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Dashboard Karyawan</h2>
        <p>Selamat datang di Sistem Informasi Kepegawaian</p>
    </div>

    <div class="container">

        <div class="card">
            <div class="icon">🕒</div>
            <a href="/absensi">Menu Absensi</a>
        </div>

        <div class="card">
            <div class="icon">📅</div>
            <a href="/cuti-karyawan">Pengajuan Cuti</a>
        </div>

        <div class="card">
            <div class="icon">💰</div>
            <a href="/kasbon">Menu Kasbon</a>
        </div>

        <div class="card">
            <div class="icon">📄</div>
            <a href="/penggajian">Data Penggajian</a>
        </div>

        <br>

        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout">
                Logout
            </button>
        </form>

        <div class="footer">
            Sistem Informasi Kepegawaian
        </div>

    </div>

</body>
</html>
