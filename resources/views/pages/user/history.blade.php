@extends('layouts.app')
@push('after-link')
    <style>
        ul {
            list-style-type: none;
            /* Remove bullets */
            padding: 0;
            /* Remove padding */
            margin: 0;
            /* Remove margins */
        }
    </style>
@endpush

@section('content')
    <div id="app">
        <div class="pagetitle">
            <h1>Riwayat Generate Tiket Ancol</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Riwayat Generate Tiket</h5>
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Jenis Tiket</th>
                                        <th scope="col">Kode Tiket</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Tiket</th>
                                        <th scope="col">Tiket per orang</th>
                                        <th scope="col">Tanggal Berlaku</th>
                                        <th scope="col">Jenis Kendaraan</th>
                                        <th scope="col">Jumlah Kendaraan</th>
                                        <th scope="col">Pengunjung</th>
                                        <th scope="col">Download Tiket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataHistory as $dH)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                @foreach ($dH->jenisid as $key => $value)
                                                    | {{ $value }}
                                                @endforeach
                                            </td>
                                            <td>
                                                <ul>
                                                    @for ($i = 0; $i < count($dH->kode); $i++)
                                                        <li>{{ $dH->kode[$i] }}</li>
                                                    @endfor
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    @for ($i = 0; $i < count($dH->unit); $i++)
                                                        <li>{{ $dH->unit[$i] }}</li>
                                                    @endfor
                                                </ul>
                                            </td>
                                            <td>
                                                {{ $dH->jumlah_tiket }}
                                            </td>
                                            <td>
                                                {{ $dH->jumlah_org_per_tiket }}
                                            </td>
                                            <td>{{ tanggal_indonesia($dH->tgl_mulai) }} s/d
                                                {{ tanggal_indonesia($dH->tgl_berlaku) }}</td>
                                            <td>{{ $dH->kendaran ? $dH->kendaran : '---' }}</td>
                                            <td>{{ $dH->jumlah_kendaraan_per_tiket ? $dH->jumlah_kendaraan_per_tiket : '---' }}
                                            </td>
                                            <td>
                                                @if ($dH->guestName)
                                                    {{ $dH->guestName }}
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('download-tiket-history', Crypt::encryptString($dH->id)) }}"
                                                    class="btn btn-success btn-sm">
                                                    DOWNLOAD TIKET
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('after-script')
@endpush
