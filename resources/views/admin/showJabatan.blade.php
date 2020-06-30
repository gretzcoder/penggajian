@extends('layouts.admin')

@section('title', 'Data '.$position->position)

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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Kelola Jabatan</h4>
                            @if (session()->has('jabatan_update'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('jabatan_update') }}
                            </div>
                            @endif
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 overflow-auto">
                            <form action="{{ url('admin/jabatan/'.$position->id.'/edit') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="form-group">
                                    <label for="jabatan">Nama Jabatan</label>
                                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                        id="jabatan" name="jabatan" value="{{ $position->position }}">
                                    @error('jabatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <label for="gaji">Gaji Pokok</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" aria-describedby="basic-addon1"
                                        class="form-control uang @error('gaji') is-invalid @enderror" id="gaji"
                                        name="gaji" value="{{ $position->salary }}">
                                    @error('gaji')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <label for="tunjangan">Tunjangan Jabatan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">Rp.</span>
                                    </div>
                                    <input type="text" aria-describedby="basic-addon2"
                                        class="form-control uang @error('tunjangan') is-invalid @enderror"
                                        id="tunjangan" name="tunjangan" value="{{ $position->job_allowance }}">
                                    @error('tunjangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="{{ url('admin/jabatan') }}" class="btn btn-secondary mr-auto">Kembali</a>
                                    <button type="button" class="btn btn-danger mr-2" data-toggle="modal"
                                        data-target="#jabatanModal">Hapus</button>
                                    {{-- Delete Modal --}}
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                            <div class="modal fade" id="jabatanModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Yakin ingin menghapus
                                                jabatan ?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Seluruh data jabatan akan dihapus secara permanen dan tidak dapat
                                            dikembalikan.
                                        </div>
                                        <div class="modal-footer p-0 px-3">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
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
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Data Pegawai</h4>
                            @if (session()->has('delete_gagal'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('delete_gagal') }}
                            </div>
                            @endif
                            @if (session()->has('pegawai_update'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('pegawai_update') }}
                            </div>
                            @endif
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 overflow-auto">
                            @if (count($employees) == 0)
                            <div class="text-center">
                                Tidak ada data pegawai
                            </div>
                            @else
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataPositionPegawai" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nip</th>
                                            <th>Nama Lengkap</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->user->nip }}</td>
                                            <td>{{ $employee->full_name }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-info btn-sm" style="width: 60px;"
                                                    href="{{ url('admin/data-karyawan/'.$employee->id) }}"
                                                    role="button">Lihat</a>
                                                <button type="button" class="btn btn-warning btn-sm mx-1"
                                                    style="width: 60px;" data-toggle="modal"
                                                    data-target="#exampleModalCenter{{ $employee->id }}">Ubah</button>
                                                <button type="button" class="btn btn-danger btn-sm d-inline"
                                                    style="width: 60px;" data-toggle="modal"
                                                    data-target="#exampleModalCenter2{{ $employee->id }}">Hapus</button>
                                            </td>
                                        </tr>

                                        <!-- Ubah Modal -->
                                        <div class="modal fade" id="exampleModalCenter{{ $employee->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form action="{{ url('admin/jabatan/'.$employee->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Ubah
                                                                Jabatan Pegawai</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="form-group row">
                                                                <label for="name" class="col-4 col-form-label">Nama
                                                                    Lengkap</label>
                                                                <div class="col-8">
                                                                    <input id="name" value="{{ $employee->full_name }}"
                                                                        class="form-control here" type="text" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="position"
                                                                    class="col-4 col-form-label">Jabatan</label>
                                                                <div class="col-8">
                                                                    <select
                                                                        class="form-control @error('posisi') is-invalid @enderror"
                                                                        id="position" name="posisi">
                                                                        <option selected
                                                                            value="{{ $employee->position->id }}">
                                                                            {{ $employee->position->position }}</option>
                                                                        @php($positions = \App\Position::all())
                                                                        @foreach ($positions as $position)
                                                                        @if ($position->id != $employee->position->id)
                                                                        <option value="{{ $position->id }}">
                                                                            {{ $position->position }}</option>
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                    @error('posisi')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button name="submit" type="submit"
                                                                class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Delete Modal --}}
                                        <div class="modal fade" id="exampleModalCenter2{{ $employee->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Yakin ingin
                                                            menghapus akun ?</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Seluruh data akun akan dihapus secara permanen dan tidak dapat
                                                        dikembalikan.
                                                    </div>
                                                    <div class="modal-footer p-0 px-3">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form method="POST"
                                                            action="{{ url('/admin/akun/'.$employee->id) }}"
                                                            class="m-0 p-0">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="form-group">
                                                                <input type="submit" class="mt-3 btn btn-danger"
                                                                    value="Hapus">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
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
              $(".alert-success").delay(3000).slideUp(300);
          });
</script>

<script src="{{ URL::asset('js/jquery.mask.js') }}"></script>


<script>
    $(document).ready(function(){

            // Format mata uang.
            $( '.uang' ).mask('000.000.000', {reverse: true});

            })
</script>
@endsection