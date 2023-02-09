<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    {{-- <style>
        @media print {

            html,
            body {
                position: absolute;
                width: 720px;
                height: 1280px;
            }
        }

        .img-card {
            width: 567px;
            height: 1009px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            margin-left: 70px !important;
        }
    </style> --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100;1,300;1,400;1,500&display=swap');

        body {
            position: relative;
            width: 817px;
            height: 1376px;
            background: #FFFFFF;
        }

        .img-card {
            position: absolute;
            width: 717px;
            height: 1276px;
            left: 0px;
            top: 0px;
        }

        h1 {
            position: absolute;
            width: 63px;
            height: 30px;
            left: 327px;
            top: 366px;
            color: #000000;
        }

        .barcode {
            position: absolute;
            width: 325px;
            height: 333px;
            left: 196px;
            top: 61px;
        }

        .kode {
            position: absolute;
            width: 468px;
            height: 30px;
            left: 125px;
            top: 413px;

            font-family: 'Roboto', sans-serif;
            font-style: normal;
            font-weight: 700;
            font-size: 26px;
            line-height: 30px;
            text-align: center;

            color: #172F89;
        }

        .judul {
            position: absolute;
            width: 468px;
            height: 30px;
            left: 240px;
            top: 504px;

            font-family: 'Roboto', sans-serif;
            font-style: normal;
            font-weight: 700;
            font-size: 26px;
            line-height: 30px;
            text-align: center;
            color: #172F89;
        }

        .column1 {
            position: absolute;
            width: 205px;
            height: 85px;
            left: 240px;
            top: 530px;

            font-family: 'Roboto', sans-serif;
            font-style: normal;
            font-weight: 400;
            font-size: 18px;
            line-height: 21px;
            color: #172F89;
        }

        .column2 {
            position: absolute;
            width: 282px;
            height: 80px;
            left: 439px;
            top: 530px;

            font-family: 'Roboto', sans-serif;
            font-style: normal;
            font-weight: 400;
            font-size: 18px;
            line-height: 21px;
            color: #172F89;
        }

        .paragraf1 {
            position: absolute;
            width: 635px;
            height: 138px;
            left: 44px;
            top: 670px;

            font-family: 'Roboto', sans-serif;
            font-style: normal;
            font-weight: 400;
            font-size: 12px;
            line-height: 21px;
            letter-spacing: 1px;

            color: #FFFDFD;
        }

        .paragraf2 {
            position: absolute;
            width: 635px;
            height: 347px;
            left: 44px;
            top: 823px;

            font-family: 'Roboto', sans-serif;
            font-style: normal;
            font-weight: 400;
            font-size: 12px;
            line-height: 21px;
            letter-spacing: 1px;

            color: #FFFDFD;
        }
    </style>
</head>

<body>
    <img src="{{ public_path('/assets/ecard/images/bg-card.jpg') }}" class="img-card">
    {{-- <img src="{{ public_path('/assets/ecard/images/v7_4.png') }}" class="barcode"> --}}
    <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate($value)) !!} " class="barcode">
    <div class="kode">
        {{ $value }}
    </div>
    <div class="judul">
        AKSES MASUK
    </div>
    <div class="column1">
        <ul>
            @if (str_contains($value, 'SW'))
                <li>Sea World</li>
            @endif

            @if (str_contains($value, 'DF'))
                <li>Dunia Fantasi</li>
            @endif

            @if (str_contains($value, 'PG'))
                <li>PGU Ancol</li>
            @endif
        </ul>
    </div>

    <div class="column2">
        <ul>
            @if (str_contains($value, 'OD'))
                <li>Ocean Dream Samudra</li>
            @endif

            @if (str_contains($value, 'AW'))
                <li>Atlantis Water Adventures</li>
            @endif

            @if (str_contains($value, 'JB'))
                <li>Jakarta Bird Land</li>
            @endif
        </ul>
    </div>
    <div class="paragraf1">
        Syarat dan Ketentuan : <br>
        <ol>
            <li>
                Eticket berlaku pada tanggal {{ tanggal_indonesia($dateVisit) }}
            </li>
            <li>
                Eticket berlaku untuk 1 (satu) kali kunjungan ke Dunia Fantasi dan wajib dijadikan ecard
            </li>
            <li>
                Eticket berlakuk untuk 1 (satu) kali kunjungan ke Ancol
            </li>
            <li>
                Eticket tidak berlaku kendaraan
            </li>
        </ol>
        <br>
    </div>
    <div class="paragraf2">
        Cara Penggunaan Eticket : <br>
        <ol>
            <li>
                Eticket wajib dijadikan ecard terlebih dahulu sebelum memasuki area Dunia Fantasi
            </li>
            <li>
                Activasi ecard wajib dilakukan paling lambat pada saat kunjungan pertama ke Dufan
            </li>
            <li>
                Untuk Kunjungan kedua dan seterusnya wajib melakukan reservasi di reservasi.ancol.com
            </li>
            <li>
                Mekasnisme pengaktifan ecard : http://bit.ly/ecardpass
            </li>
            <li>
                Ecard berlaku mulai dari tanggal aktivasi dan berlaku untuk kunjangan pertama
            </li>
            <li>
                Jam Operasional Dunia Fantasi mulai pukul Weekday 10.00 sd 17.00 WIB dan Weekend 10.00 sd 19.00 WIB
                (Sabtu, Minggu/Hari libur)
            </li>
            <li>
                Loket dan Pintu Gerbang Dunia Fantasi tutup 1 jam sebelum jam operasional berakhir
            </li>
            <li>
                Jam operasional sewaktu-waktu dapat berubah tanpa pemberitahuan sebelumnya
            </li>
        </ol>
        <br>
    </div>
</body>

</html>
