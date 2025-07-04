@extends('layout')

@section('konten')

    <div class="mt-2 mx-5">
        <div class="d-flex align-items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Selamat Datang di Supplier's Information Board</h1>
            </div>
        </div>
        <div class="d-flex gap-3 justify-content-center mb-1 mt-3">
            <a href="{{ route('supply.user.user-reg') }}" type="button" class="btn btn-outline-primary w-100 py-5 text-3xl text-bold text-uppercase">Registrasi Antrian
                Supplier</a>
            <a href="{{ route('supply.user.user-monitor') }}" type="button" class="btn btn-outline-primary w-100 py-5 text-3xl text-bold text-uppercase">Monitoring Antrian Supplier</a>
        </div>
        <div class="d-flex gap-3 justify-content-center my-1">
            <a href="{{ route('supply.admin.qc') }}" type="button" class="btn btn-outline-success w-100 py-5 text-3xl text-bold text-uppercase">Admin Quality COntrol</a>
            <a href="{{ route('supply.admin.ppic') }}" type="button" class="btn btn-outline-success w-100 py-5 text-3xl text-bold text-uppercase">Admin PPIC</a>
        </div>
        <div class="d-flex gap-3 justify-content-center my-1">
            <a href="{{ route('arsip.ng') }}" type="button" class="btn btn-outline-secondary w-100 py-5 text-3xl text-bold text-uppercase">Arsip Not Good (NG)</a>
            <a href="{{ route('arsip.hold') }}" type="button" class="btn btn-outline-secondary w-100 py-5 text-3xl text-bold text-uppercase">Arsip Hold</a>
        </div>
    </div>

@endsection