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

        .content {
            font-size: 16px;
            color: #000;
            text-align: left;
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
        <div class="title">Sistem MAIS</div>

        <!-- Greeting -->
        <div class="content">
            <p>Assalamualaikum,</p>
            <p>Permohonan anda untuk pendaftaran profil institusi telah diluluskan.Sekarang anda akan dapat log masuk
                dengan e-mel berdaftar.
            </p>

            <div class="info-box">
                <table class="info-table">
                    <tr>
                        <td class="bold">Katanama</td>
                        <td>:</td>
                        <td class="bold">{{ $email }}</td>
                    </tr>
                </table>
            </div>

            <p>Terima kasih.</p>
        </div>
    </div>
</body>

</html>
