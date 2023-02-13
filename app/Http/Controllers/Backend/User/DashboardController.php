<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Jobs\GeneratePDFtoZIP;
use App\Model\HistoryTransaction;
use App\Model\HotelPGU;
use App\Model\JenisTiketReffSW;
use App\Model\KodeScanAWA;
use App\Model\KodeScanDufan;
use App\Model\KodeScanJBL;
use App\Model\KodeScanODS;
use App\Model\KodeScanSW;
use App\Model\Unit;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Session;
use Zip;

class DashboardController extends Controller
{
    public function index()
    {
        $unit = Unit::get();
        $jenis = JenisTiketReffSW::all();
        return view('pages.user.dashboard', compact('unit', 'jenis'));
    }

    public function reservation(Request $request)
    {
        session()->forget('codeTicket');

        $messages = [
            'required'              => ':attribute wajib diisi',
            'min'                   => ':attribute harus diisi minimal digit :min ',
            'max'                   => ':attribute harus diisi maksimal :max karakter',
            'g-recaptcha-response.required'  => 'Captcha wajib diisi',
            'dateEnd.after_or_equal' => 'Tanggal Akhir Salah'
        ];

        $this->validate($request, [
            'unit'                  => 'required',
            'kuota'                 => 'required|integer',
            'dateStart'             => 'required|date',
            'dateEnd'               => 'required|date|after_or_equal:dateStart',
            // 'g-recaptcha-response'  => 'required|captcha',
        ], $messages);

        $unit = Unit::all();

        $codeAll = array();

        $jenisid = array();

        for ($i = 0; $i < $request->kuota; $i++) {
            $getUnit = implode("", $request->unit);
            $countUnit = count($request->unit);

            $timeStamp = Carbon::now()->timestamp;
            $length = 6;
            $randomLetterNumber = substr(str_shuffle("CFHJKLMNPQRTVWXYZ123456789"), 0, $length);

            $lengthDigit = 12 - ($countUnit * 2);
            if ($lengthDigit != 0) {
                $randomNumber = substr(str_shuffle("1234567890"), 0, $lengthDigit);
                $generatekode = 'SG' . $randomLetterNumber . $getUnit . $randomNumber;
            } elseif ($lengthDigit == 0) {
                $generatekode = 'SG' . $randomLetterNumber . $getUnit;
            }

            $codeAll[] = $generatekode;

            $data = array(
                'no_referensi'  => 'SELEBGRAM',
                'kode'          => $generatekode,
                'mulai_berlaku' => $request->dateStart . ' 00:00:00',
                'akhir_berlaku' => $request->dateEnd . ' 23:59:59',
                'status'        => '1',
                'waktu_masuk'   => null,
                'keterangan'    => '-',
                'kuota'         => $request->kuotaTiket
            );
            // 245

            foreach ($unit as $u) {
                foreach ($request->unit as $du => $value) {
                    if ($u->kode == $value and $value == "SW") {
                        $data['jenis_tiket'] = 372;
                        KodeScanSW::create($data);
                        $jenisid['SW'] = 372;
                        // echo "SW";
                    } elseif ($u->kode == $value and $value == "DF") {
                        $data['jenis_tiket'] = 245;
                        KodeScanDufan::create($data);
                        $jenisid['DF'] = 245;
                        // echo "DF";
                    } elseif ($u->kode == $value and $value == "PG") {
                        if ($request->vehicle != 0) {
                            $kndaraanByr = "1";
                        } else {
                            $kndaraanByr = "0";
                        }

                        if ($request->vehicle == "Tanpa Kendaraan") {
                            $kendaraan = 0;
                        } else {
                            $kendaraan = $request->countVehicle;
                        }

                        $dataPGU = array(
                            'hotelID'           => 5,
                            'guestCode'         =>  $generatekode,
                            'guestPemohon'      => Auth::guard('web')->user()->nama,
                            'guestName'         => 'Influencer',
                            'guestInstansi'     => 'Influencer',
                            'guestJumlah'       => $request->kuotaTiket,
                            'guestTujuan'       => 'MASUK PGU',
                            'guestKeperluan'    => '---',
                            'guestKendaraanByr' => $kndaraanByr,
                            'guestKendaraan'    => $kendaraan,
                            'guestKendaraanType'    => $request->vehicle,
                            'guestNopol'        => '---',
                            'guestCarColor'     => '---',
                            'guestCarMerk'      => '---',
                            'checkIn'           => $request->dateStart . ' 00:00:00',
                            'checkOut'          => $request->dateEnd . ' 23:59:59',
                            'expireDate'        => $request->dateEnd . ' 23:59:59',
                            'ticketYear'        => Carbon::now()->year,
                            'entryID'           => $generatekode,
                            'entryIDHistory'    => $generatekode,
                            'ticketStatus'      => 1,
                            'jenis'             => 'Compliment',
                            'guestCard'         => 'CARD-080',
                            'CreatedBy'         => Auth::guard('web')->user()->nama,
                            'CreatedDate'       => Carbon::now()->format('Y-m-d H:i:s'),
                            'ModifiedBy'        => Carbon::now()->format('Y-m-d H:i:s'),
                            'ModifiedDate'      => Carbon::now()->format('Y-m-d H:i:s'),
                            'IsActive'          => 1,
                            'passType'          => 'quota',
                            'guestHeadCode'     => null
                        );
                        HotelPGU::create($dataPGU);
                        $jenisid['PGU'] = "CARD-080";
                    } elseif ($u->kode == $value and $value == "OD") {
                        $data['jenis_tiket'] = 353;
                        KodeScanODS::create($data);
                        $jenisid['ODS'] = 353;
                    } elseif ($u->kode == $value and $value == "AW") {
                        $data['jenis_tiket'] = 216;
                        KodeScanAWA::create($data);
                        $jenisid['AWA'] = 216;
                    } elseif ($u->kode == $value and $value == "JB") {
                        $data['jenis_tiket'] = 24;
                        KodeScanJBL::create($data);
                        $jenisid['JBL'] = 24;
                    }
                }
            }
        }

        session()->put('codeTicket', $codeAll);
        session()->put('dateTransaksi', $request->dateStart);
        session()->put('quotaPeople', $request->kuotaTiket);
        session()->put('quotaVenicle', $request->countVehicle);

        $dataHistory = array(
            'jenisid'                       => $jenisid,
            'kode'                          => $codeAll,
            'unit'                          => $request->unit,
            'jumlah_tiket'                  => $request->kuota,
            'jumlah_org_per_tiket'          => $request->kuotaTiket,
            'tgl_mulai'                     => $request->dateStart,
            'tgl_berlaku'                   => $request->dateEnd,
            'kendaran'                      => $request->vehicle,
            'jumlah_kendaraan_per_tiket'    => $request->countVehicle,
            'user_create'                   => Auth::guard('web')->user()->id
        );
        HistoryTransaction::create($dataHistory);
        return redirect()->back()->with('success', 'Reservasi Berhasil')->with('loader', true);
    }

    public function downloadBarcode($id)
    {
        $pdf = PDF::loadview('barcode.card');
        return $pdf->download('invoice.pdf');
    }

    public function backReservasion()
    {
        session()->forget('codeTicket');
        return redirect()->back()->with('loader', true);
    }

    public function profile()
    {
        return view('pages.user.profile');
    }

    public function changeProfile(Request $request)
    {
        if ($request->oldPassword and $request->newPassword) {
            if (Auth::guard('web')->attempt([
                'email'     => Auth::guard('web')->user()->email,
                'password'  => $request->oldPassword,
            ]) == true) {
                $data = array(
                    'password' => Hash::make($request->newPassword)
                );
                User::findOrFail(Auth::guard('web')->user()->id)->update($data);
                return redirect()->back()->with('success', 'Password Berhasil Diubah');
            } else {
                return redirect()->back()->with('info', 'Password Salah');
            }
        }
    }

    public function downloadTiketZip()
    {
        $kode = array();

        $customPaper = array(0, 0, 425.19, 283.80);
        $customPaper = array(0, 0, 960.09, 540);
        $filename = "Reservasi Tiket.zip";
        $zip = new ZipArchive();

        $kode = session()->get('codeTicket');

        foreach ($kode as $key => $value) {
            // $pdf = PDF::loadview('pages.user.ticket', [
            //     'value' => $value
            // ])->setPaper($customPaper, 'landscape');

            $pdf = PDF::loadview('barcode.card', [
                'value'         => $value,
                'dateVisit'     => session()->get('dateTransaksi'),
                'quotaPeople'   => session()->get('quotaPeople'),
                'quotaVenicle'  => session()->get('quotaVenicle'),
            ]);

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
    }

    public function history()
    {
        $dataHistory = HistoryTransaction::where('user_create', Auth::guard('web')->user()->id)->latest()->get();
        return view('pages.user.history', compact('dataHistory'));
    }

    public function downloadHistory($id)
    {
        dd($id);
    }
}
