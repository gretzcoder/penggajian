@extends('layouts.admin')

@section('title', $employee->full_name)

@section('head-link')
<!-- Custom fonts for this template-->
<link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

<style>
    .emp-profile {
        padding: 15px;
        margin-top: 15px;
        margin-bottom: 3%;
        border-radius: 0.5rem;
        margin-left: 25px;
    }

    .profile-img {
        text-align: center;
    }

    .profile-img img {
        width: 45%;
        height: 100%;
    }

    .profile-head h5 {
        color: #333;
    }

    .profile-head h6 {
        color: #0062cc;
    }

    .profile-edit-btn {
        border: none;
        border-radius: 1.5rem;
        width: 70%;
        padding: 2%;
        font-weight: 600;
    }

    .profile-head .nav-tabs {
        margin-bottom: 5%;
        margin-top: 12%;
    }

    .profile-head .nav-tabs .nav-link {
        font-weight: 600;
        border: none;
    }

    .profile-head .nav-tabs .nav-link.active {
        border: none;
        border-bottom: 2px solid #0062cc;
    }

    .profile-tab label {
        font-weight: 600;
    }

    .profile-tab p {
        font-weight: 600;
        color: #0062cc;
    }
</style>
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container emp-profile">
    <div class="row">
        <div class="col-md-4">
            <div class="profile-img">
                <img src="{{ URL::asset('img/employeePic/'.$employee->profile_pic) }}" alt="" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="profile-head">
                <h5>
                    {{ $employee->full_name }}
                </h5>
                <h6>
                    {{ $employee->position->position }}
                </h6>
                @if (session()->has('password_update'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session()->get('password_update') }}
                </div>
                @endif
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">About</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content profile-tab" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <label>NIP</label>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $employee->user->nip }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nama Lengkap</label>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $employee->full_name }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Jabatan</label>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $employee->position->position }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Alamat</label>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $employee->address }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>No. Telp</label>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $employee->phone }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Status Pernikahan</label>
                        </div>
                        <div class="col-md-6">
                            <p>{{ ($employee->marital_status) ? 'Kawin' : 'Belum Kawin' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Jumlah Anak</label>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $employee->number_of_children }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <a href="{{ $employee->id }}/edit" class="profile-edit-btn btn btn-secondary">Edit Profile</a>
        </div>
    </div>
</div>
@endsection

@section('foot-link')
<!-- Bootstrap core JavaScript-->
<script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ URL::asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ URL::asset('js/sb-admin-2.min.js') }}"></script>
@endsection