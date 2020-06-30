@extends('layouts.admin')

@section('title', 'Komplain Karyawan CakeCode')

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

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Komplain Karyawan CakeCode</h1>
    <p class="mb-4">Seluruh data Komplain karyawan CakeCode</p>
    @if (session()->has('response'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('response') }}
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataComplaint" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Nip</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th>Subject</th>
                            <th>Tanggal</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($complaints as $c)
                        <tr class="clickable-row" data-href="{{ url('admin/komplain/'.$c->id.'/respon') }}"
                            style="cursor: pointer">
                            <td>{{ $c->employee->user->nip }}</td>
                            <td>{{ $c->employee->full_name }}</td>
                            <td>{{ $c->employee->position->position }}</td>
                            <td>{{ $c->subject }}</td>
                            <td><span
                                    style="display:none;">{{ Carbon\Carbon::parse($c->created_at)->getTimestamp() }}</span>{{ Carbon\Carbon::parse($c->created_at)->locale('id')->isoFormat('d MMMM YYYY') }}
                            </td>
                            <td
                                class="font-weight-bold align-middle text-center @if(!empty($c->response)) @if($c->response->status == 1) text-success @else text-danger @endif @else text-dark @endif">
                                @if(!empty($c->response)) @if($c->response->status == 1) Disetujui @else Ditolak
                                @endif @else Perlu direspon @endif</td>
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
            $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
        });
</script>
@endsection