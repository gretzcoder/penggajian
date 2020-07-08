@extends('layouts.user')

@section('title', auth()->user()->employee->full_name)

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
                <img src="{{ URL::asset('img/employeePic/'.$employee->profile_pic) }}" alt=""
                    onerror="this.onerror=null;this.src='{{ URL::asset('img/employeePic/default.png') }}';" />
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
                @if (session()->has('profile_update'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session()->get('profile_update') }}
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
                            <label>Posisi</label>
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
            <a href="{{ url('profile/edit') }}" class="profile-edit-btn btn btn-secondary">Edit Profile</a>
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

@if (Hash::check('cakecode', auth()->user()->password))
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Reset Password</h5>
                </button>
            </div>
            <form action="{{ url('profile/update-password') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="oldpassword" value="cakecode">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" id="exampleInputPassword1">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="cpassword" id="exampleInputPassword1">
                        @error('cpassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(window).on('load',function(){
                $('#exampleModalCenter').modal({backdrop: 'static', keyboard: false});
                $('#exampleModalCenter').modal('show');
            });
</script>
@elseif(is_null(auth()->user()->employee->marital_status))
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content px-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Masukan Data Anda</h5>
                </button>
            </div>
            <form action="{{ url('profile/update-profile') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @method('patch')
                    @csrf
                    <div class="form-group row">
                        <label for="username" class="col-4 col-form-label">Nip</label>
                        <div class="col-8">
                            <input id="username" placeholder="{{ $employee->user->nip }}"
                                class="form-control here  @error('nip') is-invalid @enderror" required="required"
                                type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-4 col-form-label">Nama Lengkap</label>
                        <div class="col-8">
                            <input id="name" placeholder="{{ $employee->full_name }}" required
                                class="form-control here @error('nama') is-invalid @enderror" required type="text"
                                readonly>
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-4 col-form-label">Posisi</label>
                        <div class="col-8">
                            <input id="name" placeholder="{{ $employee->position->position }}" required
                                class="form-control here @error('nama') is-invalid @enderror" required type="text"
                                readonly>
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="validationTextarea" class="col-4 col-form-label">Alamat</label>
                        <div class="col-8">
                            <textarea class="form-control here @error('alamat') is-invalid @enderror"
                                id="validationTextarea" name="alamat" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="text" class="col-4 col-form-label">No. Telp</label>
                        <div class="col-8">
                            <input id="text" name="telp" class="form-control here @error('telp') is-invalid @enderror"
                                required="required" type="text" maxlength="12" value="{{ old('telp') }}">
                            @error('telp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="marital" class="col-4 col-form-label">Status Pernikahan</label>
                        <div class="col-8">
                            <select class="form-control @error('pernikahan') is-invalid @enderror" id="marital"
                                name="pernikahan" required>
                                <option selected value="{{ old('pernikahan') ? 1 : 0 }}">
                                    {{ old('pernikahan') ? 'Kawin' : 'Belum Kawin' }}</option>
                                <option value="{{ old('pernikahan') ? 0 : 1 }}">
                                    {{ old('pernikahan') ? 'Belum Kawin' : 'Kawin' }}</option>
                            </select>
                            @error('pernikahan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="text" class="col-4 col-form-label">Jumlah Anak</label>
                        <div class="col-8">
                            <input id="text" name="anak" class="form-control here @error('anak') is-invalid @enderror"
                                required="required" type="text" maxlength="12" value="{{ old('anak') }}">
                            @error('anak')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputGroupFile01" class="col-4 col-form-label">Foto</label>
                        <div class="col-8 d-flex">
                            <img id="blah" src="{{ asset('img/employeePic/'.$employee->profile_pic) }}"
                                class="img-thumbnail mr-2" alt="your image" height="60" width="60" />
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                    id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="image"
                                    required>
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <label class="custom-file-label" for="inputGroupFile01"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
            </form>
        </div>
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#exampleModalCenter').modal({backdrop: 'static', keyboard: false});
                $('#exampleModalCenter').modal('show');
            });
        </script>
        <script>
            $('#inputGroupFile01').on('change',function(){
                //get the file name
                var fileName = $(this).val();
                var cleanFileName = fileName.replace('C:\\fakepath\\', " ");
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(cleanFileName);
            })

            function readURL(input) {
            if (input.files && input.files[0]) {
              var reader = new FileReader();
              
              reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
              }
              
              reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
          }

          $("#inputGroupFile01").change(function() {
            readURL(this);
          });
        </script>
        @endif

        <script>
            $(function(){
                $(".alert").delay(3000).slideUp(300);
            });
        </script>

        @endsection