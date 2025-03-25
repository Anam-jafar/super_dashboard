<!DOCTYPE html>
<html>

<head>
    <title>Pengaktifan Akaun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }


        .name {
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 10px;
        }

        .content {
            font-size: 16px;
            color: #000;
            text-align: center;
        }

        .info-box {
            margin-top: 20px;
            display: inline-block;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 10px;
            font-size: 16px;
            color: #000;
        }

        .bold {
            font-weight: bold;
        }

        .footer {
            font-size: 14px;
            color: #000;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ $message->embed(public_path('assets/icons/logo_.png')) }}" alt="MAIS Logo" />
        </div>

        <!-- Title -->
        <div class="title">SISTEM PENGURUSAN MASJID</div>
        <div class="arabic_text">
            <img src="{{ $message->embed(public_path('assets/icons/arabic_text.png')) }}" alt="Logo" />
        </div>
        <div class="name">{{ $instituteName }}</div>

        <!-- Greeting -->
        <div class="content">
            <p>Terima Kasih Kerana Membuat Langganan Sistem eMasjid.</p>
            <p>Sila Log Masuk Ke dalam Sistem Untuk Muat Turun Invois dan Membuat Pembayaran.</p>

            <p>Terima Kasih
            </p>
        </div>
    </div>
</body>

</html>
