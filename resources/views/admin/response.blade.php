@extends('layouts.admin')

@section('title', 'Respon '.$complaint->subject)

@section('head-link')
<!-- Custom fonts for this template-->
<link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/fileinput.css') }}" rel="stylesheet">

<style>
    img:hover {
        opacity: .5;
    }
</style>
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-10">
                        <h3 class="mt-2">{{ $complaint->subject }}</h3>
                        <h6 class="mt-2">oleh : <a
                                href="{{ url('admin/data-karyawan/'.$complaint->employee->id) }}">{{ $complaint->employee->full_name }}</a>
                        </h6>
                    </div>
                    <div class="col-2 align-middle mt-3">
                        <h5 class="text-right">
                            {{ Carbon\Carbon::parse($complaint->created_at)->locale('id')->dayName }},</h5>
                        <h5 class="text-right">
                            {{ Carbon\Carbon::parse($complaint->created_at)->locale('id')->isoFormat('DD MMMM YYYY') }}
                        </h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-justify">
                        {!! nl2br(e($complaint->body)) !!}
                        <br>
                        <br>
                        @foreach ($complaint->complaint_images as $i)
                        <a download="complaint-{{ $complaint->employee->full_name.'-'.$i->complaint_image }}"
                            href="{{ asset('img/complaintImg/'.$i->complaint_image) }}" title="ImageName">
                            <img src="{{ asset('img/complaintImg/'.$i->complaint_image) }}"
                                style="height: 85px; width: 85px; object-fit: cover; cursor: pointer;"
                                class="img-thumbnail pop">
                        </a>

                        @endforeach
                    </div>
                </div>
                <hr>
                <h4 class="text-center font-weight-bold">Respon</h4>
                <hr>
                @if (empty($complaint->response))
                <form action="{{ url('admin/respon/'.$complaint->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                name="judul" value="{{ old('judul') }}">
                            @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('isi') is-invalid @enderror" id="isi" rows="3"
                                name="isi">{{ old('isi') }}</textarea>
                            @error('isi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="inlineFormCustomSelectPref">Status</label>
                        <div class="col-sm-10">
                            <select class="custom-select my-1 mr-sm-2 @error('status') is-invalid @enderror"
                                id="inlineFormCustomSelectPref" name="status">
                                <option value="" disabled selected hidden>Choose...</option>
                                <option value="1">Disetujui</option>
                                <option value="0">Ditolak</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="file-1" class="col-sm-2 col-form-label">Gambar</label>
                        <div class="col-sm-10">
                            <input type="file" id="file-2" name="images[]" multiple accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Kirim</button>
                </form>
                @else
                <form action="#">
                    @csrf
                    <div class="form-group row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="judul"
                                value="{{ $complaint->response->subject }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="isi" rows="3"
                                readonly>{{ $complaint->response->response }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="inlineFormCustomSelectPref">Status</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inlineFormCustomSelectPref"
                                value="{{ $complaint->response->status ? 'Disetujui' : 'Ditolak' }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="file-1" class="col-sm-2 col-form-label">Gambar</label>
                        <div class="col-sm-10">
                            @if (count($complaint->response->response_images) == 0)
                            Tidak ada gambar.
                            @endif
                            @foreach ($complaint->response->response_images as $a)
                            <a download="response-{{ $complaint->employee->full_name.'-'.$a->response_image }}"
                                href="{{ asset('img/responseImg/'.$a->response_image) }}" title="ImageName">
                                <img src="{{ asset('img/responseImg/'.$a->response_image) }}"
                                    style="height: 85px; width: 85px; object-fit: cover; cursor: pointer;"
                                    class="img-thumbnail pop">
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ url('admin/jabatan') }}" class="btn btn-secondary float-right">Kembali</a>
                </form>
                @endif
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

<script src="{{ URL::asset('js/fileinput.js') }}"></script>
<script src="{{ URL::asset('js/fa/theme.js') }}"></script>

<script>
    $(function(){
            $(".alert").delay(3000).slideUp(300);
            $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });

        $("#file-2").fileinput({    
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