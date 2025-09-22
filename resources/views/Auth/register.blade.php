<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/profile.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>
        Supplier's Information Board - Registrasi
    </title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
</head>

<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4 class="font-weight-bolder">REGISTRASI USER BARU</h4>
                    </div>
                    <div class="card-body">
                        {{-- Alert error jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <span class="text-white">{{ $errors->first() }}</span>
                            </div>
                        @endif

                        {{-- Form Registrasi --}}
                        <form action="{{ route('register.submit') }}" method="POST">
                            @csrf
                            <div class="input-group input-group-outline mb-4">
                                {{-- <label class="form-label">Role</label> --}}
                                <select name="role" class="form-control" required>
                                    <option value="" disabled selected>Pilih Role</option>
                                    <option value="supplier" {{ old('role') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                    <option value="admin_qc" {{ old('role') == 'admin_qc' ? 'selected' : '' }}>Admin QC</option>
                                    <option value="manager_qc" {{ old('role') == 'manager_qc' ? 'selected' : '' }}>Manager QC</option>
                                    <option value="admin_ppic" {{ old('role') == 'admin_ppic' ? 'selected' : '' }}>Admin PPIC</option>
                                    <option value="manager_ppic" {{ old('role') == 'manager_ppic' ? 'selected' : '' }}>Manager PPIC</option>
                                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                </select>
                            </div>
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                            </div>

                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                            </div>

                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" id="passwordInput" class="form-control" required>
                                <button id="togglePasswordBtn" class="mt-2 opacity-7"
                                    style="background: none; border: 0;" onclick="togglePassword()" type="button">
                                    <i class="material-symbols-rounded" id="toggleIcon">visibility</i>
                                </button>
                            </div>

                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="confirmPasswordInput"
                                    class="form-control" required>
                                <button id="toggleConfirmBtn" class="mt-2 opacity-7"
                                    style="background: none; border: 0;" onclick="toggleConfirmPassword()" type="button">
                                    <i class="material-symbols-rounded" id="confirmIcon">visibility</i>
                                </button>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-2 text-muted">PT Astra Komponen Indonesia © {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('assets/js/material-dashboard.min.js?v=3.2.0') }}"></script>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("passwordInput");
        const toggleIcon = document.getElementById("toggleIcon");
        const isPasswordVisible = passwordInput.type === "text";
        passwordInput.type = isPasswordVisible ? "password" : "text";
        toggleIcon.innerText = isPasswordVisible ? "visibility" : "visibility_off";
    }

    function toggleConfirmPassword() {
        const confirmInput = document.getElementById("confirmPasswordInput");
        const confirmIcon = document.getElementById("confirmIcon");
        const isConfirmVisible = confirmInput.type === "text";
        confirmInput.type = isConfirmVisible ? "password" : "text";
        confirmIcon.innerText = isConfirmVisible ? "visibility" : "visibility_off";
    }
</script>

</html>
