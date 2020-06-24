@extends('layouts.user')

@section('title', 'Kelola '.$employee->full_name)

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
        <div class="col-md-5">
		    <div class="card">
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-12">
                        <h4>Buat komplain baru</h4>
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
                            <form action="{{ url('admin/jabatan/'.$employee->id.'/edit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <label for="judul">Judul</label>
                                <div class="input-group mb-3">
                                  <input type="text" aria-describedby="basic-addon1" class="form-control uang @error('judul') is-invalid @enderror" id="judul" name="judul"">
                                  @error('judul')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                                    <label for="isi" class="col-4 col-form-label">Isi</label> 
                                    <div class="input-group mb-3">
                                      <textarea class="form-control here @error('isi') is-invalid @enderror" id="isi" name="isi" required></textarea>
                                      @error('isi')
                                      <div class="invalid-feedback">
                                        {{ $message }}
                                      </div>
                                      @enderror
                                    </div>
                                    <label for="image" class="col-4 col-form-label">Foto</label> 
                                    <div class="form-group row">
                                        <div class="col-12 d-flex">
                                          {{-- <img id="blah" src="{{ asset('img/employeePic/'.$employee->profile_pic) }}" class="img-thumbnail mr-2" alt="your image" height="60" width="60"/> --}}
                                          <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" aria-describedby="inputGroupFileAddon01" accept="image/*" name="image[]" multiple>
                                            @error('image')
                                            <div class="invalid-feedback">
                                              {{ $message }}
                                            </div>
                                            @enderror
                                            <label class="custom-file-label" for="image"></label>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="image_preview"></div>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="{{ url('admin/jabatan') }}" class="btn btn-secondary mr-auto">Kembali</a>
                                    <button type="button" class="btn btn-danger mr-2" data-toggle="modal" data-target="#jabatanModal">Hapus</button>
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                            
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
                        <h4>Riwayat Komplain</h4>
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
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                <tbody>
                                    <tr class="clickable-row" data-href="awow.com" style="cursor: pointer; border-bottom: 1px solid #e3e6f0">
                                        <td style="border-right:none !important;">{{ $employee->full_name }}</td>
                                        <td style="border-left:none !important; text-align: right;">{{ Carbon\Carbon::parse($employee->created_at)->toDateString() }}</td>
                                    </tr>
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

        <!-- Page level custom scripts -->
        <script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script>
        
        <script>
          $(function(){
              $(".alert-success").delay(3000).slideUp(300);
              $(".clickable-row").click(function() {
                    window.location = $(this).data("href");
                });
            });

            $("#image").change(function(){
            $('#image_preview').html("");
            var total_file=document.getElementById("image").files.length;
            for(var i=0;i<total_file;i++)
            {
            $('#image_preview').append("<img class='img-thumbnail' style='height: 100px; ' src='"+URL.createObjectURL(event.target.files[i])+"'>");
            }
            });
        </script>
@endsection