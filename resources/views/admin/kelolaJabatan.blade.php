@extends('layouts.admin')

@section('title', 'Kelola Jabatan')

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
    <h1 class="h3 mb-2 text-gray-800">Data Jabatan CakeCode</h1>
    <p class="mb-4">Seluruh data jabatan yang ada di Database Aplikasi Penggajian CakeCode</p>
    @if (session()->has('jabatan_update'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('jabatan_update') }}
    </div>
    @endif
    @if (session()->has('jabatan_store'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('jabatan_store') }}
    </div>
    @endif
    @if (session()->has('deleted'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('deleted') }}
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablePosition" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jabatan</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Total Pegawai</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($positions as $position)
                        <a href="">
                            <tr>
                                <td>{{ $position->position }}</td>
                                <td>Rp. {{ number_format($position->salary,0,'','.') }}</td>
                                <td>Rp. {{ number_format($position->job_allowance,0,'','.') }}</td>
                                <td>{{ count($position->employees) }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm mx-1" style="width: 60px;"
                                        href="{{ url('admin/jabatan/'.$position->id) }}" role="button">Kelola</a>
                                    {{-- <button type="button" class="btn btn-danger btn-sm d-inline" style="width: 60px;" data-toggle="modal" data-target="#exampleModalCenter{{ $position->id }}">Hapus</button>
                                    --}}
                                </td>
                            </tr>
                        </a>

                        {{-- Delete Modal
                        <div class="modal fade" id="exampleModalCenter{{ $position->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Yakin ingin menghapus jabatan ?
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Seluruh data jabatan akan dihapus secara permanen dan tidak dapat dikembalikan.
                                </div>
                                <div class="modal-footer p-0 px-3">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form method="POST" action="{{ url('/admin/jabatan/'.$position->id) }}"
                                        class="m-0 p-0">
                                        @csrf
                                        @method('delete')
                                        <div class="form-group">
                                            <input type="submit" class="mt-3 btn btn-danger" value="Hapus">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
            </div> --}}
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