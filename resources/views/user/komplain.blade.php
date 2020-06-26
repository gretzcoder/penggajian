@extends('layouts.user')

@section('title', 'Kelola '.$employee->full_name)

@section('head-link')
<!-- Custom fonts for this template-->
<link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
<!-- Custom styles for this page -->
<link href="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/fileinput.css') }}" rel="stylesheet">

<style>
    .bg-success:hover {
        background-color: #5cb85c !important;
    }

    .bg-danger:hover {
        background-color: #d9534f !important;
    }

    .bg-light:hover {
        background-color: #f7f7f7 !important;
    }
</style>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Kirimkan komplain baru</h4>
                            @if(session()->has('berhasil'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('berhasil') }}
                            </div>
                            @endif
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 overflow-auto">
                            <form action="{{ url('komplain') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="judul">Judul</label>
                                <div class="input-group mb-3">
                                    <input type="text" aria-describedby="basic-addon1"
                                        class="form-control uang @error('judul') is-invalid @enderror" id="judul"
                                        name="judul" value="{{ old('judul') }}" required>
                                    @error('judul')
                                    <div class=" invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <label for="isi">Isi</label>
                                <div class="input-group mb-3">
                                    <textarea class="form-control here @error('isi') is-invalid @enderror" id="isi"
                                        name="isi" required>{{ old('isi') }}</textarea>
                                    @error('isi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <label for="file-1">Gambar</label>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <input type="file" id="file-1" name="images[]" multiple accept="image/*">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">Batal</a>
                                    <button class="btn btn-primary" type="submit">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Riwayat Komplain</h4>
                            @if(session()->has('delete_gagal'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('delete_gagal') }}
                            </div>
                            @endif
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 overflow-auto">
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <tbody>
                                        @if (!count($complaints))
                                        <h6 class="mt-2 text-center">Tidak ada data.</h6>
                                        @endif
                                        @foreach ($complaints as $c )
                                        <tr class="clickable-row @if(!empty($c->response)) @if($c->response->status == 1) bg-success text-white @else bg-danger text-white @endif @else bg-light text-dark @endif"
                                            data-href="{{ url('komplain/'.$c->id) }}"
                                            style="cursor: pointer; border-bottom: 1px solid #e3e6f0">
                                            <td style="border-right:none !important;">{{ $c->subject }}</td>
                                            <td style="border-left:none !important; text-align: right;">
                                                {{ Carbon\Carbon::parse($c->created_at)->toDateString() }}
                                            </td>
                                        </tr>
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
<script src="{{ URL::asset('js/fileinput.js') }}"></script>
<script src="{{ URL::asset('js/fa/theme.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script>

<script>
    $(function () {
        $(".alert-success").delay(3000).slideUp(300);
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });

            $("#file-1").fileinput({    
                theme: 'fa',
                showUpload: false,
                showClose: false,
            })

            var $container = $(document.createElement('div')).append(content);
    $container.find('.file-thumbnail-footer').remove();
    return $container.html();
    });
</script>
@endsection