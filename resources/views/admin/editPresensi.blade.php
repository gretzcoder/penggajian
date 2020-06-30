@extends('layouts.admin')

@section('title', 'Edit Presensi ' . $data->employee->full_name)

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

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Input Akun Baru</h1>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col-xl-6 col-md-6 mb-6">
      <div class="card shadow h-100 py-2">
        <div class="card-body">
          <form action="{{ url('admin/presensi/edit/'.$data->id) }}" method="POST">
            @csrf
            @method('patch')
            <input type="hidden" name="first" value="{{ $first }}">
            <input type="hidden" name="last" value="{{ $last }}">
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="text" maxlength="8" class="form-control" id="tanggal" disabled
                value="{{ Carbon\Carbon::parse($data->date)->locale('id')->dayName }}, {{ Carbon\Carbon::parse($data->date)->locale('id')->day }} {{ Carbon\Carbon::parse($data->date)->locale('id')->monthName }} {{ Carbon\Carbon::parse($data->date)->year }}">
            </div>
            <div class="form-group">
              <label for="nip">NIP</label>
              <input type="text" maxlength="8" class="form-control" id="nip" disabled
                value={{ $data->employee->user->nip }}>
            </div>
            <div class="form-group">
              <label for="fullname">Nama Lengkap</label>
              <input type="text" class="form-control" id="fullname" disabled value="{{ $data->employee->full_name }}">
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                <option value="{{ $data->status == 'h' ? 'h' : 'a' }}">
                  {{ $data->status == 'h' ? 'Hadir' : 'Tidak Hadir' }}</option>
                <option value="{{ $data->status == 'h' ? 'a' : 'h' }}">
                  {{ $data->status == 'h' ? 'Tidak Hadir' : 'Hadir' }}</option>
              </select>
              @error('status')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            <button class="btn btn-primary float-right mt-3" type="submit">Simpan</button>
          </form>
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
@endsection