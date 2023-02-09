@extends('layouts.app')
@push('after-link')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.min.js">
@endpush

@section('content')
    <div class="pagetitle">
        <h1>Setting Profile</h1>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ Auth::guard('web')->user()->photo }}" alt="Profile" class="rounded-circle">
                        <h2>{{ Auth::guard('web')->user()->nama }}</h2>
                        <h3>{{ Auth::guard('web')->user()->email }}</h3>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('changeProfile') }}">
                            @csrf
                            {{-- <div class="row mb-3">
                                <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="nama" type="text" class="form-control" id="nama"
                                        value="{{ Auth::guard('web')->user()->nama }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="photo" class="col-md-4 col-lg-3 col-form-label">Foto</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="photo" type="file" class="form-control" id="photo">
                                </div>
                            </div> --}}

                            <div class="row mb-3">
                                <label for="oldPassword" class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="oldPassword" type="password" class="form-control" id="oldPassword"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="newPassword" type="password" class="form-control" id="newPassword"
                                        required>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">UBAH DATA</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('after-script')
@endpush
