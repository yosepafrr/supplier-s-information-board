@extends('layout')

@section('konten')

    <div class="mt-2 mx-5">
        <div class="d-flex align-items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Selamat Datang di Supplier's Information Board</h1>
            </div>
        </div>
            @if(in_array(auth()->user()?->role, ['super_admin']))
                <a href="{{ route('register') }}" type="button" class="btn btn-outline-info w-100 py-5 text-3xl text-bold text-uppercase  mt-3">Tambah User Baru</a>
            @endif
        <div class="d-flex gap-3 justify-content-center mb-1">
            @if(in_array(auth()->user()?->role, ['supplier', 'super_admin']))
            <a href="{{ route('supply.user.user-reg') }}" type="button" class="btn btn-outline-primary w-100 py-5 text-3xl text-bold text-uppercase">Registrasi Antrian Supplier</a>
            @endif

            @if(in_array(auth()->user()?->role, ['supplier', 'super_admin', 'admin_ppic', 'admin_qc']))
            <a href="{{ route('supply.user.user-monitor') }}" type="button" class="btn btn-outline-primary w-100 py-5 text-3xl text-bold text-uppercase">Monitoring Antrian Supplier</a>
            @endif
        </div>
        <div class="d-flex gap-3 justify-content-center my-1">
            @if(in_array(auth()->user()?->role, ['super_admin', 'admin_qc']))
            <a href="{{ route('supply.admin.qc') }}" type="button" class="btn btn-outline-success w-100 py-5 text-3xl text-bold text-uppercase">Admin Quality Control</a>
            @endif
            @if(in_array(auth()->user()?->role, ['super_admin', 'admin_ppic']))
            <a href="{{ route('supply.admin.ppic') }}" type="button" class="btn btn-outline-success w-100 py-5 text-3xl text-bold text-uppercase">Admin PPIC</a>
            @endif
        </div>
        <div class="d-flex gap-3 justify-content-center my-1">
            @if(in_array(auth()->user()?->role, ['super_admin', 'admin_ppic', 'admin_qc']))
            <a href="{{ route('arsip.ng') }}" type="button" class="btn btn-outline-secondary w-100 py-5 text-3xl text-bold text-uppercase">Arsip Not Good (NG)</a>
            <a href="{{ route('arsip.hold') }}" type="button" class="btn btn-outline-secondary w-100 py-5 text-3xl text-bold text-uppercase">Arsip Hold</a>
            @endif
        </div>
    </div>

@endsection