@extends('layouts.admin')

@section('title', 'Dashboard Penggajian CakeCode')

@section('head-link')
<!-- Custom fonts for this template-->
<link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-12 mb-2">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ count($komplen) == 0 ? 'success' : 'danger' }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h1 mb-0 font-weight-bold text-gray-800">{{ count($komplen) }}</div>
                            <div
                                class="text-xs font-weight-bold text-{{ count($komplen) == 0 ? 'success' : 'danger' }} text-uppercase mb-1">
                                Komplain Masuk (Harian)</div>
                        </div>
                        <div class="col-auto pb-4">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ count($absen) == 0 ? 'success' : 'danger' }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h1 mb-0 font-weight-bold text-gray-800">{{ count($absen) }}</div>
                            <div
                                class="text-xs font-weight-bold text-{{ count($absen) == 0 ? 'success' : 'danger' }} text-uppercase mb-1">
                                Karyawan Bolos (Harian)</div>
                        </div>
                        <div class="col-auto pb-4">
                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ count($terlambat) == 0 ? 'success' : 'danger' }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h1 mb-0 font-weight-bold text-gray-800">{{ count($terlambat) }}</div>
                            <div
                                class="text-xs font-weight-bold text-{{ count($terlambat) == 0 ? 'success' : 'danger' }} text-uppercase mb-1">
                                Karyawan Terlambat (Harian)</div>
                        </div>
                        <div class="col-auto pb-4">
                            <i class="fas fa-calendar-minus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@section('foot-link')
<!-- Bootstrap core JavaScript-->
<script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ URL::asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ URL::asset('js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ URL::asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ URL::asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ URL::asset('js/demo/chart-pie-demo.js') }}"></script>
@endsection