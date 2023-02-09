<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcode Tiket</title>

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
    <button class="btn-print" style="position: absolute; right: 1rem; top: rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">ANCOL</h3>
        <p>Reservasi Tiket</p>
        <p>{{ $data['kode'] }}</p>
    </div>
    <p class="text-center">
        <hr>
    </p>
    <br>
    <div class="visible-print text-center">
        {{-- {!! QrCode::size(100)->generate($transaksi->invoice) !!} --}}
        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate($data['kode'])) !!} ">
    </div>

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
