@extends('layouts.admin')

@section('title', 'Edit '.$employee->full_name )

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
<div class="container ml-md-5">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Akun</h4>
              @if (session()->has('password_update'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session()->get('password_update') }}
              </div>
              @endif
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 overflow-auto">
              <form action="{{ url('admin/akun/'.$employee->user->id) }}" method="POST">
                @csrf
                @method('patch')
                <div class="form-group">
                  <label for="exampleInputPassword2">New Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="exampleInputPassword2" name="password" required>
                  @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword3">Confirm Password</label>
                  <input type="password" class="form-control @error('cpassword') is-invalid @enderror"
                    id="exampleInputPassword3" name="cpassword" required>
                  @error('cpassword')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group row justify-content-end mr-1">
                  <button name="submit" type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Profile</h4>
              @if (session()->has('profile_update'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session()->get('profile_update') }}
              </div>
              @endif
              @if (session()->has('profile_update_nochanges'))
              <div class="alert alert-info alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session()->get('profile_update_nochanges') }}
              </div>
              @endif
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 overflow-auto">
              <form action="{{ url('admin/data-karyawan/'.$employee->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="form-group row">
                  <label for="username" class="col-4 col-form-label">Nip</label>
                  <div class="col-8">
                    <input id="username" name="nip" value="{{ $employee->user->nip }}"
                      class="form-control here @error('nip') is-invalid @enderror" required="required" type="text"
                      readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="name" class="col-4 col-form-label">Nama Lengkap</label>
                  <div class="col-8">
                    <input id="name" name="nama" value="{{ $employee->full_name }}" required
                      class="form-control here @error('nama') is-invalid @enderror" type="text">
                    @error('nama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="position" class="col-4 col-form-label">Jabatan</label>
                  <div class="col-8">
                    <select class="form-control @error('posisi') is-invalid @enderror" id="position" name="posisi">
                      <option selected value="{{ $employee->position->id }}">{{ $employee->position->position }}
                      </option>
                      @php($positions = \App\Position::all())
                      @foreach ($positions as $position)
                      @if ($position->id != $employee->position->id)
                      <option value="{{ $position->id }}">{{ $position->position }}</option>
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
                <div class="form-group row">
                  <label for="validationTextarea" class="col-4 col-form-label">Alamat</label>
                  <div class="col-8">
                    <textarea class="form-control here @error('alamat') is-invalid @enderror" id="validationTextarea"
                      name="alamat" required>{{ $employee->address }}</textarea>
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
                      required="required" type="text" maxlength="12" value="{{ $employee->phone }}">
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
                      name="pernikahan">
                      <option selected value="{{ $employee->marital_status ? 1 : 0}}">
                        {{ $employee->marital_status ? 'Kawin' : 'Belum Kawin' }}</option>
                      <option value="{{ $employee->marital_status ? 0 : 1 }}">
                        {{ $employee->marital_status ? 'Belum Kawin' : 'Kawin' }}</option>
                    </select>
                    @error('pernikahan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="anak" class="col-4 col-form-label">Jumlah Anak</label>
                  <div class="col-8">
                    <input id="anak" name="anak" class="form-control here @error('anak') is-invalid @enderror"
                      required="required" type="text" maxlength="12" value="{{ $employee->number_of_children }}">
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
                      class="img-thumbnail mr-2" alt="your image" height="60" width="60"
                      onerror="this.onerror=null;this.src='{{ URL::asset('img/employeePic/default.png') }}';" />
                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                        id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="image">
                      @error('image')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                      <label class="custom-file-label" for="inputGroupFile01"></label>
                    </div>
                  </div>
                </div>
                <div class="form-group row justify-content-end mr-1">
                  <a href="{{ url('admin/data-karyawan/'.$employee->id) }}" class="btn btn-secondary mr-3">Lihat
                    Profile</a>
                  <button name="submit" type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
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

<script>
  $(function(){
              $(".alert").delay(3000).slideUp(300);
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
@endsection