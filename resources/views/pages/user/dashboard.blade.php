@extends('layouts.app')
@push('after-link')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <style>
        lottie-player {
            margin: 0 auto;
        }
    </style>
@endpush

@section('content')
    <div id="app">
        <div class="pagetitle">
            <h1>Generate Tiket Ancol</h1>
            {{-- <a href="{{ route('downloadBarcode') }}">KLIK</a> --}}
            {{-- <br>
            <a href="{{ route('backReservasion') }}" class="btn btn-secondary btns-sm">RESET</a> --}}
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                @if (Session::has('generatekode'))
                    <div class="col-lg-12 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">BARCODE TIKET <br> Silahkan Klik Untuk Download Barkode</h5>
                                <div class="visible-print text-center">
                                    <a href="#" id="qrdownload">
                                        {!! QrCode::size(300)->generate(session()->get('generatekode')) !!}
                                    </a>


                                    <p id="showCode">{{ session()->get('generatekode') }}</p>
                                    {{-- <a href="{{ route('downloadBarcode', session()->get('generatekode')) }}"
                                    class="btn btn-success" id="qrdownload2">DOWNLOAD
                                    BARCODE</a> --}}
                                    {{-- <button class="btn btn-success" id="qrdownload" target="_BLANK">DOWNLOAD
                                    BARCODE</button> --}}
                                    <a href="{{ route('backReservasion') }}" class="btn btn-warning">KEMBALI</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Generate Tiket Selegram / Influencer</h5>

                                <!-- Multi Columns Form -->
                                <form class="row g-3" method="POST" action="{{ route('reservation') }}">
                                    @csrf
                                    <input type="hidden" name="status" id="status">

                                    <div class="col-md-6">
                                        <label for="jenis" class="form-label">Pilih Jenis Tiket</label>
                                        <select class="form-select js-example-basic-single" name="jenis" id="jenis"
                                            required multiple="multiple" autofocus>
                                            <option value="SG">SELEBGRAM</option>
                                            {{-- @foreach ($jenis as $j)
                                                <option value="{{ $j->jenis_tiket }}">{{ $j->keterangan }} |
                                                    {{ $j->jenis_tiket }}</option>
                                            @endforeach --}}
                                        </select>
                                        @error('jenis')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="unit" class="form-label">Pilih Unit</label>
                                        <select class="form-select js-example-basic-multiple" name="unit[]" id="unit"
                                            required multiple="multiple" autofocus>
                                            @foreach ($unit as $u)
                                                <option value="{{ $u->kode }}">{{ $u->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="kuota" class="form-label">Jumlah Tiket</label>
                                        <input type="number" class="form-control" id="kuota" name="kuota" required
                                            value="0" min="0">
                                        @error('kuota')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="kuota" class="form-label">Jumlah Orang Per Tiket</label>
                                        <input type="number" class="form-control" id="kuotaTiket" name="kuotaTiket"
                                            required value="0" min="0">
                                        @error('kuotaTiket')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="dateStart" class="form-label">Tanggal Mulai Berlaku</label>
                                        <input type="text" class="form-control" id="dateStart" name="dateStart" required
                                            autocomplete="off">
                                        @error('dateStart')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="dateEnd" class="form-label">Tanggal Akhir Berlaku</label>
                                        <input type="text" class="form-control" id="dateEnd" name="dateEnd" required
                                            autocomplete="off">
                                        @error('dateEnd')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3" id="fVehicle">
                                        <label for="vehicle" class="form-label">Kendaraan</label>
                                        <select name="vehicle" id="vehicle" class="form-select">
                                            <option disabled selected></option>
                                            <option value="Tanpa Kendaraan">Tanpa Kendaraan</option>
                                            <option value="Motor">Motor</option>
                                            <option value="Mobil">Mobil</option>
                                        </select>
                                        @error('vehicle')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4" id="fCountVehicle">
                                        <label for="countVehicle" class="form-label">Jumlah Kendaraan Per Tiket</label>
                                        <input type="number" name="countVehicle" id="countVehicle" class="form-control"
                                            min="0">
                                        @error('countVehicle')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12" id="guestName">
                                        <label for="guestName" class="form-label">Tiket Diberikan untuk
                                            <strong class="text-danger">(*Diisi Nama
                                                Selegram/Influencer/Pengunjung)</strong>
                                        </label>
                                        <input type="text" name="guestName" id="guestName" class="form-control">
                                        @error('guestName')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-12">
                                        <div
                                            class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Captcha</label>
                                            <div class="col-md-6">
                                                {!! app('captcha')->display() !!}
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-exclamation-octagon me-1"></i>
                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary w-100">RESERVASI</button>
                                    </div>
                                </form><!-- End Multi Columns Form -->
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        @if (Session::has('codeTicket'))
            <div class="section">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Silahkan Download Tiket</h5>
                                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_tyfgyfbk.json"
                                    background="transparent" speed="1" style="width: 100px; height: 100px;" loop
                                    autoplay></lottie-player>
                                <?php
                                $codeSession = session()->get('codeTicket');
                                ?>
                                <a href="{{ route('download-tiket-zip') }}" class="btn btn-success" id="download-tiket">
                                    {{-- <i class="bi bi-cloud-download me-1"></i> --}}
                                    <strong>DOWNLOAD TIKET</strong>
                                </a>
                                {{-- @foreach ($codeSession as $c)
                                    <p>{{ $c }}</p>
                                @endforeach --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('after-script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.min.js"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <script>
        $(document).ready(function() {
            $("#dateStart").datepicker({
                minDate: new Date(),
                dateFormat: 'yy-mm-dd',
            });
            $("#dateEnd").datepicker({
                minDate: new Date(),
                dateFormat: 'yy-mm-dd',
            });
            $('#fVehicle').hide();
            $('#fCountVehicle').hide();
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();
            $('#kuota').keyup(function(e) {
                if (/\D/g.test(this.value)) {
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
            });
        });
    </script>
    <script>
        $('#qrdownload').click(function() {
            var code = $('#showCode').text();
            var qrCodeBaseUri = 'https://api.qrserver.com/v1/create-qr-code/?',
                params = {
                    data: code,
                    size: '350x350',
                    margin: 10,
                    download: 1
                };
            window.location.href = qrCodeBaseUri + $.param(params);
            $('#pageLoader').hide();
            Swal.fire(
                'Good job!',
                'DOWNLOAD QR CODE BERHASIL',
                'success'
            );
            // window.location.reload();
        });

        // $('#download-tiket').click(function() {
        //     var code = $('#showCode').text();
        //     var qrCodeBaseUri = 'https://api.qrserver.com/v1/create-qr-code/?',
        //         params = {
        //             data: code,
        //             size: '350x350',
        //             margin: 10,
        //             download: 1
        //         };
        //     window.location.href = qrCodeBaseUri + $.param(params);
        //     $('#pageLoader').hide();
        //     Swal.fire(
        //         'Download Berhasil',
        //         'Silahkan Menunggu...',
        //         'success'
        //     );
        //     window.location.reload();
        // });
    </script>
    <script>
        $('#unit').change(function() {
            var unit = $(this).val();
            if (unit.includes("PG") == true) {
                $('#fVehicle').show();
                $('#fCountVehicle').show();
                $('#status').val("1");
            } else {
                $('#fVehicle').hide();
                $('#fCountVehicle').hide();
                $('#status').val("0");
            }
        })
    </script>
@endpush
