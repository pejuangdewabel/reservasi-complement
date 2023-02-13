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
        /* @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100;1,300;1,400;1,500&display=swap'); */
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700&display=swap');

        @font-face {
            font-family: 'Grenadine MVB Med';
            src: url('{{ asset('assets/font/font1.ttf') }}');
        }

        * {
            font-family: 'Kanit', sans-serif;
        }

        body {
            position: relative;
            width: 817px;
            height: 1376px;
            background: #FFFFFF;
        }

        .img-card {
            position: absolute;
            width: 710px;
            height: 1056px;
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
            width: 279px;
            height: 286px;
            left: 220px;
            top: 20px;
        }

        .kode {
            position: absolute;
            width: 468px;
            height: 43px;
            left: 125px;
            top: 280px;

            /* font-family: 'Kanit', sans-serif; */

            font-family: 'Grenadine MVB Med';
            /* font-style: normal;
            font-weight: 700; */
            font-size: 26px;
            line-height: 43px;

            text-align: center;

            color: #0033A0;
        }

        .judul {
            position: absolute;
            width: 468px;
            height: 83px;
            left: 214px;
            top: 356px;

            font-family: 'Grenadine MVB Med';
            font-size: 50px;
            line-height: 83px;
            text-align: center;
            color: #0033A0;
        }

        .judul2 {
            position: absolute;
            width: 468px;
            height: 40px;
            left: 125px;
            top: 508px;

            font-family: 'Grenadine MVB Med';
            font-size: 24px;
            line-height: 40px;
            text-align: center;
            color: #FFFFFF;
        }

        .judul3 {
            position: absolute;
            width: 468px;
            height: 33px;
            left: 125px;
            top: 790px;

            font-family: 'Grenadine MVB Med';
            font-size: 20px;
            line-height: 33px;
            text-align: center;

            color: #FFFFFF;
        }

        .column1 {
            /* position: absolute;
            width: 205px;
            height: 85px;
            left: 240px;
            top: 530px;

            font-family: 'Roboto', sans-serif;
            font-style: normal;
            font-weight: 400;
            font-size: 18px;
            line-height: 21px;
            color: #172F89; */

            position: absolute;
            width: 344px;
            height: 219px;
            left: 69px;
            top: 550px;

            font-family: 'Grenadine MVB Med';
            font-size: 20px;
            line-height: 20px;

            color: #FDFDFF;
        }

        .column1 ol li {
            font-family: 'Grenadine MVB Med';
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
            height: 72px;
            left: 69px;
            top: 830px;

            font-family: 'Grenadine MVB Med';
            font-size: 20px;
            line-height: 20px;

            color: #FFFDFD;
        }

        .paragraf1 ol li {
            font-family: 'Grenadine MVB Med';
        }

        /* .paragraf2 {
            position: absolute;
            font-family: 'Grenadine MVB Med';
            width: 635px;
            height: 124px;
            left: 69px;
            top: 948px;
        } */
    </style>
</head>

<body>
    <img src="{{ public_path('/assets/ecard/images/bg-card-v3.jpg') }}" class="img-card">
    {{-- <img src="{{ public_path('/assets/ecard/images/v7_4.png') }}" class="barcode"> --}}
    <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate($value)) !!} " class="barcode">
    <div class="kode">
        {{ $value }}
    </div>
    <div class="judul">
        INFLUENCER
    </div>
    <div class="judul2">
        AKSES MASUK
    </div>
    <div class="column1">
        <ol>
            @if (str_contains($value, 'SW'))
                <li>Sea World</li>
            @else
                <li>---</li>
            @endif

            @if (str_contains($value, 'DF'))
                <li>Dunia Fantasi</li>
            @else
                <li>---</li>
            @endif

            @if (str_contains($value, 'PG'))
                <li>PGU Ancol</li>
            @else
                <li>---</li>
            @endif

            @if (str_contains($value, 'OD'))
                <li>Ocean Dream Samudra</li>
            @else
                <li>---</li>
            @endif

            @if (str_contains($value, 'AW'))
                <li>Atlantis Water Adventures</li>
            @else
                <li>---</li>
            @endif

            @if (str_contains($value, 'JB'))
                <li>Jakarta Bird Land</li>
            @else
                <li>---</li>
            @endif
        </ol>
    </div>
    <div class="judul3">
        SYARAT DAN KETENTUAN
    </div>
    <div class="paragraf1">
        <ol>
            <li>
                Eticket berlaku pada tanggal {{ tanggal_indonesia($dateVisit) }}
            </li>
            @if (Session::has('quotaVenicle'))
                <li>
                    Eticket berlaku {{ $quotaPeople }} orang dan {{ $quotaVenicle }} kendaraan
                </li>
            @else
                <li>
                    Eticket berlaku {{ $quotaPeople }} orang dan 0 kendaraan
                </li>
            @endif
        </ol>
        <br>
    </div>
    {{-- <div class="paragraf2">
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
    </div> --}}
</body>

</html>
