<?php

namespace App\Jobs;

use App\Mail\RegisterEmail;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class GeneratePDFtoZIP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $codeAll;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($codeAll)
    {
        // $this->codeAll = $codeAll;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        session()->put('codeTicket', $this->codeAll);

        // $data = array(
        //     'email'     => 'dadadadad@gmail.com',
        //     'nama'      => 'dadad',
        //     'password'  => 'dadadada',
        //     'status'    => true,
        //     'token'     => null,
        //     'photo'     => 'dadada'
        // );
        // User::create($data);

        // $customPaper = array(0, 0, 425.19, 283.80);
        // $filename = "test.zip";
        // $zip = new ZipArchive();

        // $kode = $this->codeAll;

        // $pdf = PDF::loadview('pages.user.ticket', compact('kode'))->setPaper($customPaper, 'landscape');
        // return $pdf->download('invoice.pdf');

        // $outputPDF = $pdf->output();
        // if ($zip->open($filename, ZIPARCHIVE::CREATE) == TRUE) {
        //     $zip->addFromString('Barcode Tiket-' . $kode . ".pdf", $outputPDF);
        //     $zip->close();
        // }

        // header("Content-Type: application/zip");
        // header("Content-Disposition: attachment; filename=\"" . $filename . "\"");

        // clearstatcache();

        // header("Content-Length: " . filesize($filename));
        // readfile($filename);
        // unlink($filename);
    }
}
