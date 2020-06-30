@extends('layouts.admin')

@section('title', 'Presensi Karyawan CakeCode')

@section('head-link')
<!-- Custom fonts for this template-->
<link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

<!-- Custom styles for this page -->
<link href="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('vendor/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row align-middle justify-content-between mx-3">
        <div class="col-6">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Presensi karyawan CakeCode</h1>
            <p class="mb-4">Seluruh data Presensi karyawan CakeCode</p>
        </div>
        {{-- <td><a href="#" class="status" data-type="select" data-pk="1" data-value="1" data-url="{{ url('api/admin/active') }}"
        data-title="Select status"></a></td> --}}
        <div class="col-5 justify-content-end">
            <form action={{ url('admin/presensi') }} method="post">
                <div class="input-group daterange mr-3 mt-3" style="height: 48px;">
                    @csrf
                    <input type="date" name="tanggalAwal" style="text-align: center; font-weight: bolder;"
                        min="{{ $min }}" max="{{ $max }}" class="form-control text-primary" value="{{ $first }}">
                    <button class="btn btn-sm btn-secondary" style="height: 38px; font-weight:900; padding-bottom: 5px;"
                        disabled>-</button>
                    <input type="date" name="tanggal" style="text-align: center; font-weight: bolder;" min="{{ $min }}"
                        max="{{ $max }}" class="form-control text-primary mr-3" value="{{ $last }}">
                    <input type="submit" class="btn btn-sm btn-primary" style="height: 38px;" value="submit">
                </div>
            </form>
        </div>

    </div>
    @if (session()->has('presensi_update'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('presensi_update') }}
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableAbsensi" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Nip</th>
                            <th>Nama Lengkap</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presences as $presence)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($presence->created_at)->locale('id')->dayName }}</td>
                            <td><span
                                    style="display:none;">{{ Carbon\Carbon::parse($presence->created_at)->getTimestamp() }}</span>
                                {{ Carbon\Carbon::parse($presence->created_at)->locale('id')->day }}
                                {{ Carbon\Carbon::parse($presence->created_at)->locale('id')->monthName }}
                                {{ Carbon\Carbon::parse($presence->created_at)->year }}</td>
                            <td>{{ $presence->datetime ? Carbon\Carbon::parse($presence->datetime)->toTimeString() : '-' }}
                            </td>
                            <td>{{ $presence->employee->user->nip }}</td>
                            <td>{{ $presence->employee->full_name }}</td>
                            <td style="font-weight: bolder"
                                class="@if($presence->status ==  'h') text-primary @elseif($presence->status ==  'a') text-danger @else text-warning @endif">
                                {{ ($presence->status == 'h' ? 'Hadir' : ($presence->status == 'a' ? 'Tidak Hadir' : 'Terlambat')) }}
                            </td>
                            <td class="text-center">
                                <form action="{{ url('admin/presensi/edit') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $presence->id }}">
                                    <input type="hidden" name="first" value="{{ $first }}">
                                    <input type="hidden" name="last" value="{{ $last }}">
                                    <button title="Edit Presensi" type="submit" class="btn btn-warning btn-sm mx-1"
                                        style="width: 60px;" href="{{ url('admin/presensi/edit') }}" role="button"><i
                                            class="fas fa-fw fa-edit"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
<script src="{{ URL::asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/jszip.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/buttons.colVis.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script>

<script>
    $(function(){            
            $(".alert").delay(3000).slideUp(300);
        });
</script>
@endsection