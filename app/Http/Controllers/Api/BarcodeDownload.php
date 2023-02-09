<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf;

class BarcodeDownload extends Controller
{
    public function downloadTiket()
    {
        $kode = array();

        $customPaper = array(0, 0, 425.19, 283.80);
        $filename = "Reservasi Tiket.zip";
        $zip = new ZipArchive();

        $kode = session()->get('codeTicket');

        foreach ($kode as $key => $value) {
            $pdf = PDF::loadview('pages.user.ticket', [
                'value' => $value
            ])->setPaper($customPaper, 'landscape');

            $outputPDF = $pdf->output();
            if ($zip->open($filename, ZIPARCHIVE::CREATE) == TRUE) {
                $zip->addFromString('Tiket-' . $value . ".pdf", $outputPDF);
                $zip->close();
            }
        }

        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        clearstatcache();

        header("Content-Length: " . filesize($filename));
        readfile($filename);
        unlink($filename);

        return response()->download($filename);
    }
}
