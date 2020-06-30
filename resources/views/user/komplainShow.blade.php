@extends('layouts.user')

@section('title', 'Detail Komplain')

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
                @if (empty($complaint->response))
                <h4 class="text-center font-weight-bold">Respon</h4>
                <hr>
                <h6 class="text-center">Belum direspon.</h6>
                @else
                <h4
                    class="text-center font-weight-bold {{ $complaint->response->status ? 'text-success' : 'text-danger' }}">
                    {{ $complaint->response->status ? 'DISETUJUI' : 'DITOLAK' }}</h4>
                <hr>
                <div class="row">
                    <div class="col-10 d-flex align-items-center">
                        <h3>{{ $complaint->response->subject }}</h3>
                    </div>
                    <div class="col-2 align-middle mt-3">
                        <h5 class="text-right">
                            {{ Carbon\Carbon::parse($complaint->response->created_at)->locale('id')->dayName }},</h5>
                        <h5 class="text-right">
                            {{ Carbon\Carbon::parse($complaint->response->created_at)->locale('id')->isoFormat('DD MMMM YYYY') }}
                        </h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-justify">
                        {!! nl2br(e($complaint->response->response)) !!}
                        <br>
                        <br>
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