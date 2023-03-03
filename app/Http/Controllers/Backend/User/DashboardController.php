<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Jobs\GeneratePDFtoZIP;
use App\Model\DetailJenisTiket;
use App\Model\HistoryTransaction;
use App\Model\HotelPGU;
use App\Model\JenisTiket;
use App\Model\JenisTiketReffComplement;
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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Zip;

class DashboardController extends Controller
{
    public function index()
    {
        $unit = Unit::get();
        $jenis = JenisTiketReffSW::all();
        $jenisTiket = JenisTiket::get();
        return view('pages.user.dashboard', compact('unit', 'jenis', 'jenisTiket'));
    }

    public function reservation(Request $request)
    {
        session()->forget('codeTicket');
        session()->forget('dateTransaksi');
        session()->forget('quotaPeople');
        session()->forget('quotaVenicle');
        session()->forget('typeTicket');

        $messages = [
            'required'              => ':attribute wajib diisi',
            'min'                   => ':attribute harus diisi minimal digit :min ',
            'max'                   => ':attribute harus diisi maksimal :max karakter',
            'g-recaptcha-response.required'  => 'Captcha wajib diisi',
            'dateEnd.after_or_equal' => 'Tanggal Akhir Salah',
            'guestName.required'    => 'Nama Selegram/Influencer/Pengunjung Wajib Diisi'
        ];

        $this->validate($request, [
            'unit'                  => 'required',
            'kuota'                 => 'required|integer|min:1',
            'kuotaTiket'            => 'required|integer|min:0',
            'dateStart'             => 'required|date',
            'dateEnd'               => 'required|date|after_or_equal:dateStart',
            'guestName'             => 'required|string'
            // 'g-recaptcha-response'  => 'required|captcha',
        ], $messages);

        $unit = Unit::all();

        $codeAll = array();

        $jenisid = array();

        for ($i = 0; $i < $request->kuota; $i++) {

            do {
                $getUnit = implode("", $request->unit);
                $countUnit = count($request->unit);

                $length = 6;
                $randomLetterNumber = substr(str_shuffle("CFHJKLMNPQRTVWXYZ123456789"), 0, $length);

                $lengthDigit = 12 - ($countUnit * 2);
                if ($lengthDigit != 0) {
                    $randomNumber = substr(str_shuffle("1234567890"), 0, $lengthDigit);
                    $generatekode = substr($request->jenis, 0, 2) . $randomLetterNumber . $getUnit . $randomNumber;
                } elseif ($lengthDigit == 0) {
                    $generatekode = substr($request->jenis, 0, 2) . $randomLetterNumber . $getUnit;
                }

                $seaworld = KodeScanSW::where('kode', $generatekode)->exists();
                $awa = KodeScanAWA::where('kode', $generatekode)->exists();
                $jbl = KodeScanJBL::where('kode', $generatekode)->exists();
                $ods = KodeScanODS::where('kode', $generatekode)->exists();
                $dufan = KodeScanDufan::where('kode', $generatekode)->exists();
                $hotel = HotelPGU::where('guestCode', $generatekode)->exists();
            } while ($seaworld and $awa and $jbl and $ods and $dufan and $hotel);

            $codeAll[] = $generatekode;

            $data = array(
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
                    $kodeJenis = DetailJenisTiket::with(['relasi_unit', 'relasi_jenis_tiket'])
                        ->where('unit_id', $u->id)
                        ->where('kode_jenis_tiket', $request->jenis)
                        ->first();
                    if ($u->kode == $value and $value == "SW") {
                        $data['no_referensi'] = $kodeJenis->relasi_jenis_tiket->keterangan;
                        $data['jenis_tiket'] = $kodeJenis->kode_jenis;
                        KodeScanSW::create($data);
                        $jenisid['SW'] = $kodeJenis->kode_jenis;

                        // $jenisid['SW'] = $kodeJenis->kode_jenis;
                        // echo "SW";
                    } elseif ($u->kode == $value and $value == "DF") {
                        $data['no_referensi'] = $kodeJenis->relasi_jenis_tiket->keterangan;
                        $data['jenis_tiket'] = $kodeJenis->kode_jenis;
                        KodeScanDufan::create($data);
                        $jenisid['DF'] = $kodeJenis->kode_jenis;

                        // $data['jenis_tiket'] = 245;
                        // KodeScanDufan::create($data);
                        // $jenisid['DF'] = 245;
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

                        $checkJenis = JenisTiket::where('kode', $request->jenis)->first();

                        $dataPGU = array(
                            'hotelID'           => 5,
                            'guestCode'         =>  $generatekode,
                            'guestPemohon'      => Auth::guard('web')->user()->nama,
                            'guestName'         => $request->guestName,
                            'guestInstansi'     => $checkJenis->keterangan,
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
                        $data['no_referensi'] = $kodeJenis->relasi_jenis_tiket->keterangan;
                        $data['jenis_tiket'] = $kodeJenis->kode_jenis;
                        KodeScanODS::create($data);
                        $jenisid['ODS'] = $kodeJenis->kode_jenis;

                        // $data['jenis_tiket'] = 353;
                        // KodeScanODS::create($data);
                        // $jenisid['ODS'] = 353;
                    } elseif ($u->kode == $value and $value == "AW") {
                        $data['no_referensi'] = $kodeJenis->relasi_jenis_tiket->keterangan;
                        $data['jenis_tiket'] = $kodeJenis->kode_jenis;
                        KodeScanAWA::create($data);
                        $jenisid['AWA'] = $kodeJenis->kode_jenis;

                        // $data['jenis_tiket'] = 216;
                        // KodeScanAWA::create($data);
                        // $jenisid['AWA'] = 216;
                    } elseif ($u->kode == $value and $value == "JB") {
                        $data['no_referensi'] = $kodeJenis->relasi_jenis_tiket->keterangan;
                        $data['jenis_tiket'] = $kodeJenis->kode_jenis;
                        KodeScanJBL::create($data);
                        $jenisid['JBL'] = $kodeJenis->kode_jenis;


                        // $data['jenis_tiket'] = 24;
                        // KodeScanJBL::create($data);
                        // $jenisid['JBL'] = 24;
                    }
                }
            }
        }

        session()->put('codeTicket', $codeAll);
        session()->put('dateTransaksi', $request->dateStart);
        session()->put('quotaPeople', $request->kuotaTiket);
        session()->put('quotaVenicle', $request->countVehicle);
        session()->put('typeTicket', $request->jenis);

        $dataHistory = array(
            'jenisid'                       => $jenisid,
            'kode_jenis_tiket'              => $request->jenis,
            'kode'                          => $codeAll,
            'unit'                          => $request->unit,
            'jumlah_tiket'                  => $request->kuota,
            'jumlah_org_per_tiket'          => $request->kuotaTiket,
            'tgl_mulai'                     => $request->dateStart,
            'tgl_berlaku'                   => $request->dateEnd,
            'kendaran'                      => $request->vehicle,
            'jumlah_kendaraan_per_tiket'    => $request->countVehicle,
            'user_create'                   => Auth::guard('web')->user()->id,
            'guestName'                     => $request->guestName
        );
        HistoryTransaction::create($dataHistory);
        return redirect()->back()->with('success', 'Reservasi Berhasil')->with('loader', true);
    }

    public function downloadBarcode()
    {
        // Generate PDF files

        $kode = array(
            '1212121',
            '2091092',
            '9209129'
        );

        foreach ($kode as $k) {
            $pdf = PDF::loadview('barcode.card', [
                'value'         => $k,
                'dateVisit'     => '2023-02-17',
                'quotaPeople'   => 10,
                'quotaVenicle'  => 2,
            ]);
            Storage::put('pdf/file' . $k . '.pdf', $pdf->output());
        }

        // Create zip file
        $zip = new ZipArchive;
        $zipFileName = 'pdf_files.zip';

        if ($zip->open(storage_path($zipFileName), ZipArchive::CREATE) === TRUE) {
            // Add PDF files to the zip file
            foreach ($kode as $k) {
                $zip->addFile(storage_path('app/pdf/file' . $k . '.pdf'), 'file' . $k . '.pdf');
            }
            $zip->close();
        }

        // Download the zip file
        return response()->download(storage_path($zipFileName));


        // foreach ($kode as $k) {
        //     // Membuat PDF
        //     $pdf = PDF::loadview('barcode.card', [
        //         'value'         => $k,
        //         'dateVisit'     => '2023-02-17',
        //         'quotaPeople'   => 10,
        //         'quotaVenicle'  => 2,
        //     ]);
        //     $pdfContents = $pdf->output();

        //     // Menyimpan PDF ke dalam penyimpanan Laravel
        //     $pdfFileName = 'example.pdf';
        //     Storage::put($pdfFileName, $pdfContents);

        //     // Membuat Zip Archive
        //     $zip = new ZipArchive;
        //     $zipFileName = 'example123.zip';

        //     if ($zip->open(storage_path($zipFileName), ZipArchive::CREATE) === true) {
        //         // Menambahkan PDF ke dalam Zip Archive
        //         $zip->addFromString($pdfFileName, $pdfContents);

        //         // Menutup Zip Archive
        //         $zip->close();
        //     }

        //     // Menghapus PDF dari penyimpanan Laravel
        //     Storage::delete($pdfFileName);

        //     // Mengirimkan Zip Archive sebagai respons HTTP
        //     return response()->download(storage_path($zipFileName))->deleteFileAfterSend();
        // }
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

        $zip = new ZipArchive;
        $zipFileName = 'Generate Tiket-' . Carbon::now()->timestamp . '.zip';

        $kode = session()->get('codeTicket');
        $nameTypeTicket = JenisTiket::where('kode', session()->get('typeTicket'))->first();

        if (count($kode) == 1) {
            foreach ($kode as $key => $value) {

                $pdf = PDF::loadview('barcode.card', [
                    'value'         => $value,
                    'dateVisit'     => session()->get('dateTransaksi'),
                    'quotaPeople'   => session()->get('quotaPeople'),
                    'quotaVenicle'  => session()->get('quotaVenicle'),
                    'nameTypeTicket'    => $nameTypeTicket->keterangan,
                ]);
                // Storage::put('pdf/Tiket-' . $value . '.pdf', $pdf->output());
                return $pdf->download('Tiket-' . $value . '.pdf');
            }
        } elseif (count($kode) > 1) {
            foreach ($kode as $key => $value) {
                $pdf = PDF::loadview('barcode.card', [
                    'value'         => $value,
                    'dateVisit'     => session()->get('dateTransaksi'),
                    'quotaPeople'   => session()->get('quotaPeople'),
                    'quotaVenicle'  => session()->get('quotaVenicle'),
                    'nameTypeTicket'    => $nameTypeTicket->keterangan,
                ]);
                Storage::put('pdf/Tiket-' . $value . '.pdf', $pdf->output());
            }

            if ($zip->open(storage_path($zipFileName), ZipArchive::CREATE) === TRUE) {
                // Add PDF files to the zip file
                foreach ($kode as $key => $value) {
                    $zip->addFile(storage_path('app/pdf/Tiket-' . $value . '.pdf'), 'Tiket-' . $value . '.pdf');
                }
                $zip->close();
            }

            // Download the zip file
            return response()->download(storage_path($zipFileName));
        }
    }

    public function history()
    {
        $dataHistory = HistoryTransaction::with(['relasi_tiket_jenis'])->where('user_create', Auth::guard('web')->user()->id)->latest()->get();

        return view('pages.user.history', compact('dataHistory'));
    }

    public function downloadHistory($id)
    {
        $kode = array();

        $data = HistoryTransaction::where('id', Crypt::decryptString($id))->get();
        $dataSingle = HistoryTransaction::with(['relasi_tiket_jenis'])->where('id', Crypt::decryptString($id))->first();

        foreach ($data as $d) {
            // $kode[] = $d->kode;
            array_push($kode, $d->kode);
        }

        $countArray = count($kode[0]);

        if ($countArray == 1) {
            for ($i = 0; $i < $countArray; $i++) {
                $pdf = PDF::loadview('barcode.card', [
                    'value'         => $kode[0][$i],
                    'dateVisit'     => $dataSingle->tgl_mulai,
                    'quotaPeople'   => $dataSingle->jumlah_org_per_tiket,
                    'quotaVenicle'  => $dataSingle->jumlah_kendaraan_per_tiket,
                    'nameTypeTicket'    => $dataSingle->relasi_tiket_jenis->keterangan,
                ]);
                // Storage::put('pdf/Tiket-' . $kode[0][$i] . '.pdf', $pdf->output());
                return $pdf->download('Tiket-' . $kode[0][$i] . '.pdf');
            }
        } elseif ($countArray > 1) {
            for ($i = 0; $i < $countArray; $i++) {
                $pdf = PDF::loadview('barcode.card', [
                    'value'         => $kode[0][$i],
                    'dateVisit'     => $dataSingle->tgl_mulai,
                    'quotaPeople'   => $dataSingle->jumlah_org_per_tiket,
                    'quotaVenicle'  => $dataSingle->jumlah_kendaraan_per_tiket,
                    'nameTypeTicket'    => $dataSingle->relasi_tiket_jenis->keterangan,
                ]);
                Storage::put('pdf/Tiket-' . $kode[0][$i] . '.pdf', $pdf->output());
            }

            $zip = new ZipArchive;
            $zipFileName = 'Generate Tiket-' . Carbon::now()->timestamp . '.zip';

            if ($zip->open(storage_path($zipFileName), ZipArchive::CREATE) === TRUE) {
                // Add PDF files to the zip file
                for ($i = 0; $i < $countArray; $i++) {
                    $zip->addFile(storage_path('app/pdf/Tiket-' . $kode[0][$i] . '.pdf'), 'Tiket-' . $kode[0][$i] . '.pdf');
                }

                $zip->close();
            }

            // Download the zip file
            return response()->download(storage_path($zipFileName));
        }
    }
}
