<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BARCODE - TANGGAL</title>

    <?php
    $style = '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <style>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    * {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        font-family: "consolas", sans-serif;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    p {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        display: block;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        margin: 3px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        font-size: 10pt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    table td {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        font-size: 9pt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    .text-center {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        text-align: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    .text-right {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        text-align: right;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @media print {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @page {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            margin: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            size: 75mm
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ';
    ?>
    <?php
    $style .= !empty($_COOKIE['innerHeight']) ? $_COOKIE['innerHeight'] . 'mm; }' : '}';
    ?>
    <?php
    $style .= '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        html, body {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            width: 70mm;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        .btn-print {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            display: none;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </style>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ';
    ?>

    {!! $style !!}
</head>

<body>
    <div class="text-center">
        <img src="https://upload.wikimedia.org/wikipedia/id/thumb/3/3e/Logo_Taman_Impian_Jaya_Ancol_%282022%29.svg/2560px-Logo_Taman_Impian_Jaya_Ancol_%282022%29.svg.png"
            style="width: 50px; height: 20px;">
        <h3 style="margin-bottom: 5px;">ANCOL</h3>
        <p>Alamat</p>
        <p>NO WA</p>
    </div>
    <p class="text-center">
        <hr>
    </p>
    {{-- <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate('http://google.com')) !!} "> --}}
    <br>
    <div>
        <p style="float: left;">Tanggal Sekarang</p>
        <p style="float: right">NAMA</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>BARCODE: {{ $value }}</p>
    <p class="text-center">===================================</p>

    <br>
    {{-- <table width="100%" style="border: 0;">
        <tr>
            <td>No</td>
            <td>Produk</td>
            <td>Jumlah</td>
            <td>Subtotal</td>
        </tr>
        @foreach ($detail as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->relasi_produk_detail->desc }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ format_uang($item->sub_total) }}</td>
            </tr>
        @endforeach
    </table> --}}
    {{-- <p class="text-center">-----------------------------------</p> --}}

    {{-- <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">1212121</td>
        </tr>
        <tr>
            <td>Total Item:</td>
            <td class="text-right">2121</td>
        </tr>
        <tr>
            <td>Bayar:</td>
            <td class="text-right">2121</td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td class="text-right">12212</td>
        </tr>
    </table> --}}

    <p class="text-center">===================================</p>
    <p class="text-center">
        <img src="https://chart.googleapis.com/chart?cht=qr&chl=&chs=160x160&chld=L|0"
            style="width: 100px; height: 100px;" />
    </p>
    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight=" + ((height + 50) * 0.264583);
    </script>
</body>

</html>
