<?php
function format_uang($nominal)
{
    return 'Rp. ' . number_format($nominal, 0, ',', '.');
}

function terbilang($angka)
{
    $angka = abs($angka);

    $baca = array(
        '',
        'Satu',
        'Dua',
        'Tiga',
        'Empat',
        'Lima',
        'Enam',
        'Tujuh',
        'Delapan',
        'Sembilan',
        'Sepuluh',
        'Sebelas'
    );

    $terbilang = '';

    if ($angka < 12) { // 1 - 11
        $terbilang = '' . $baca[$angka];
    } elseif ($angka < 20) { // 12 - 19
        $terbilang = terbilang($angka - 10) . ' Belas';
    } elseif ($angka < 100) { // 20 - 99
        $terbilang = terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
    } elseif ($angka < 200) { //100 - 199
        $terbilang = ' Seratus ' . terbilang($angka - 100);
    } elseif ($angka < 1000) { //200 - 999
        $terbilang = terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
    } elseif ($angka < 2000) { // 1000 - 1999
        $terbilang = ' Seribu ' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) { // 2000 - 999.999
        $terbilang = terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) { // 1.000.000 - 9.999.999.999
        $terbilang = terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
    }

    return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
    $nama_hari = array(
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jum\'at',
        'Sabtu'
    );

    $nama_bulan = array(
        1 =>
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

    $tahun      = substr($tgl, 0, 4);
    $bulan      = $nama_bulan[(int) substr($tgl, 5, 2)];
    $tanggal    = substr($tgl, 8, 2);

    $text = '';

    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari = $nama_hari[$urutan_hari];
        $text .= "$hari, $tanggal $bulan $tahun";
    } else {
        $text .= "$tanggal $bulan $tahun";
    }

    return $text;
}

function add_null_inthefront($value, $threshold = null)
{
    return sprintf("%0" . $threshold . "s", $value);
}
