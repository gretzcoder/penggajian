@extends('layouts.admin')

@section('title', 'Penambahan dan Potongan ')

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
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-10">
                                    <h4>Potongan</h4>
                                </div>
                                <div class="col-2">
                                    <button title="Rumus" type="button" class="ml-3 btn btn-sm btn-light text-secondary"
                                        data-toggle="modal" data-target="#exampleModalCenter"><i
                                            class="fas fa-question-circle fa-2x"></i>
                                    </button>
                                </div>
                            </div>
                            @if (session()->has('potongan'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('potongan') }}
                            </div>
                            @endif
                            <hr>
                            <form action="{{ url('admin/potongan') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="npo" class="col-sm-4 col-form-label">Nama Potongan</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control @error('npo') is-invalid @enderror"
                                            id="npo" name="npo" value="{{ old('npo') }}">
                                        @error('npo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rpo" class="col-sm-4 col-form-label">Rumus Potongan</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control @error('rpo') is-invalid @enderror"
                                            id="rpo" name="rpo" value="{{ old('rpo') }}">
                                        @error('rpo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="spo" class="col-sm-4 col-form-label">Syarat Potongan</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control @error('spo') is-invalid @enderror"
                                            id="spo" name="spo" value="{{ old('spo') }}">
                                        @error('spo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary float-right mt-2" type="submit">Buat!</button>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <hr>
                            <h5 class="text-center font-weight-bold">Daftar Potongan</h5>
                            <hr>
                            @if (session()->has('deleted_potongan'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('deleted_potongan') }}
                            </div>
                            @endif
                            @if (session()->has('updated_potongan'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('updated_potongan') }}
                            </div>
                            @endif
                            @if (session()->has('gagal_potongan'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('gagal_potongan') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 p-1">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablePotongan" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="align-middle">Nama Potongan</th>
                                            <th class="align-middle">Rumus Potongan</th>
                                            <th class="align-middle">Syarat Potongan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($potongan as $po)
                                        <tr class="text-center">
                                            <td class="align-middle">{{ $po->name }}</td>
                                            <td class="align-middle">{{ $po->formula }}</td>
                                            <td class="align-middle">{{ $po->condition }}</td>
                                            <td class="text-center align-middle p-0">
                                                <button type="button" style="width:60px"
                                                    class="btn btn-warning btn-sm mx-1 my-1" data-toggle="modal"
                                                    data-target="#exampleModalCenter{{ $po->id }}">Ubah</button>
                                                <button type="button" class="btn btn-danger btn-sm d-inline my-1"
                                                    style="width:60px" data-toggle="modal"
                                                    data-target="#exampleModalCenter2{{ $po->id }}">Hapus</button>
                                            </td>
                                        </tr>
                                        <!-- Ubah Modal -->
                                        <div class="modal fade" id="exampleModalCenter{{ $po->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form action="{{ url('admin/potongan/'.$po->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Ubah
                                                                Potongan</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="form-group row">
                                                                <label for="npot" class="col-sm-4 col-form-label">Nama
                                                                    Potongan</label>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control @error('npot') is-invalid @enderror"
                                                                        id="npot" name="npot"
                                                                        value="{{ old('npot', $po->name) }}">
                                                                    @error('npot')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="rpot" class="col-sm-4 col-form-label">Rumus
                                                                    Potongan</label>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control @error('rpot') is-invalid @enderror"
                                                                        id="rpot" name="rpot"
                                                                        value="{{ old('rpot', $po->formula) }}">
                                                                    @error('rpot')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="spot" class="col-sm-4 col-form-label">Syarat
                                                                    Potongan</label>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control @error('spot') is-invalid @enderror"
                                                                        id="spot" name="spot"
                                                                        value="{{ old('spot', $po->condition) }}">
                                                                    @error('spot')
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
                                        <div class=" modal fade" id="exampleModalCenter2{{ $po->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                                            Yakin ingin
                                                            menghapus Potongan ?</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Data Potongan akan dihapus secara permanen dan tidak
                                                        dapat
                                                        dikembalikan.
                                                    </div>
                                                    <div class="modal-footer p-0 px-3">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form method="POST"
                                                            action="{{ url('/admin/penambahan-potongan/'.$po->id) }}"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-10">
                                    <h4>Penambahan</h4>
                                </div>
                                <div class="col-2">
                                    <button title="Rumus" type="button" class="ml-3 btn btn-sm btn-light text-secondary"
                                        data-toggle="modal" data-target="#exampleModalCenter"><i
                                            class="fas fa-question-circle fa-2x"></i>
                                    </button>
                                </div>
                            </div>
                            @if (session()->has('penambahan'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('penambahan') }}
                            </div>
                            @endif
                            @if (session()->has('pegawai_update'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('pegawai_update') }}
                            </div>
                            @endif
                            <hr>
                            <form action="{{ url('admin/penambahan') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="np" class="col-sm-4 col-form-label">Nama Penambahan</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control @error('np') is-invalid @enderror"
                                            id="np" name="np" value="{{ old('np') }}">
                                        @error('np')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rp" class="col-sm-4 col-form-label">Rumus Penambahan</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control @error('rp') is-invalid @enderror"
                                            id="rp" name="rp" value="{{ old('rp') }}">
                                        @error('rp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sp" class="col-sm-4 col-form-label">Syarat Penambahan</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control @error('sp') is-invalid @enderror"
                                            id="sp" name="sp" value="{{ old('sp') }}">
                                        @error('sp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary float-right mt-2" type="submit">Buat!</button>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <hr>
                            <h5 class="text-center font-weight-bold">Daftar Penambahan</h5>
                            <hr>
                            @if (session()->has('deleted_penambahan'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('deleted_penambahan') }}
                            </div>
                            @endif
                            @if (session()->has('updated_penambahan'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('updated_penambahan') }}
                            </div>
                            @endif
                            @if (session()->has('gagal_penambahan'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('gagal_penambahan') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 p-1">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablePenambahan" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="align-middle">Nama Penambahan</th>
                                            <th class="align-middle">Rumus Penambahan</th>
                                            <th class="align-middle">Syarat Penambahan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penambahan as $p)
                                        <tr class="text-center">
                                            <td class="align-middle">{{ $p->name }}</td>
                                            <td class="align-middle">{{ $p->formula }}</td>
                                            <td class="align-middle">{{ $p->condition }}</td>
                                            <td class="text-center align-middle p-0">
                                                <button type="button" class="btn btn-warning btn-sm mx-1 my-1"
                                                    style="width:60px" data-toggle="modal"
                                                    data-target="#exampleModalCenter{{ $p->id }}">Ubah</button>
                                                <button type=" button" class="btn btn-danger btn-sm d-inline my-1"
                                                    style="width:60px" data-toggle="modal"
                                                    data-target="#exampleModalCenter2{{ $p->id }}">Hapus</button>
                                            </td>
                                        </tr>
                                        <!-- Ubah Modal -->
                                        <div class="modal fade" id="exampleModalCenter{{ $p->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form action="{{ url('admin/penambahan/'.$p->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Ubah
                                                                Penambahan</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="form-group row">
                                                                <label for="npe" class="col-sm-4 col-form-label">Nama
                                                                    Penambahan</label>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control @error('npe') is-invalid @enderror"
                                                                        id="npe" name="npe"
                                                                        value="{{ old('npe', $p->name) }}">
                                                                    @error('npe')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="rpe" class="col-sm-4 col-form-label">Rumus
                                                                    Penambahan</label>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control @error('rpe') is-invalid @enderror"
                                                                        id="rpe" name="rpe"
                                                                        value="{{ old('rpe', $p->formula) }}">
                                                                    @error('rpe')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="spe" class="col-sm-4 col-form-label">Syarat
                                                                    Penambahan</label>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control @error('spe') is-invalid @enderror"
                                                                        id="spe" name="spe"
                                                                        value="{{ old('spe', $p->condition) }}">
                                                                    @error('spe')
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
                                        <div class=" modal fade" id="exampleModalCenter2{{ $p->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                                            Yakin ingin
                                                            menghapus Penambahan ?</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Data Penambahan akan dihapus secara permanen dan tidak
                                                        dapat
                                                        dikembalikan.
                                                    </div>
                                                    <div class="modal-footer p-0 px-3">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form method="POST"
                                                            action="{{ url('/admin/penambahan-potongan/'.$p->id) }}"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 style="text-decoration: underline;">Rumus</h5>
                contoh : g*5/100 (5% dari Gaji Pokok)
                <h5 style="text-decoration: underline;" class="pt-3">Syarat</h5>
                contoh : m == 1 (Menikah == Benar)
                <h5 style="text-decoration: underline;" class="pt-3">Kode</h5>
                <div class="text-center" style="font-size: 12px">
                    g : Gaji Pokok |
                    m : Menikah |
                    c : Jumlah Anak |
                    h : Kehadiran <br>
                    t : Keterlambatan |
                    a : Ketidakhadiran <br><br>

                    == : sama dengan |
                    != : tidak sama dengan <br>
                    <= : lebih kecil dari sama dengan |>= : lebih besar dari sama dengan <br>
                        < : lebih kecil dari |> : lebih besar dari | &&: dan | || : atau
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

<!-- Page level custom scripts -->
<script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script>

<script>
    $(function(){
              $(".alert-success").delay(3000).slideUp(300);
          });
</script>

@endsection