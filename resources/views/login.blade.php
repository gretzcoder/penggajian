<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login Page</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background-image: url({{ URL::asset('img/auth_background.jpg') }}); background-repeat : no-repeat; background-position: center bottom; background-size: cover;">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center mt-5">

      <div class="col-xl-6 col-lg-6 col-md-6">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                    @error('blocked')
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <form class="user" action="/login" method="post">
                    @csrf
                    <div class="form-group">
                      <input type="text" maxlength="8" class="@error('nip') is-invalid @enderror form-control form-control-user text-center" id="exampleInputEmail" placeholder="NIP" name="nip" value="{{ old('nip') }}" >
                      @error('nip')
                      <div class="invalid-feedback text-center">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <input type="password" class="@error('password') is-invalid @enderror form-control form-control-user text-center" id="exampleInputPassword" placeholder="Password" name="password" >
                      <div class="valid-feedback text-center">
                        Default password : cakecode
                      </div>
                      @error('password')
                      <div class="invalid-feedback text-center">
                       {{ $message }}
                      </div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember_token">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                    <hr>
                    <div class="valid-feedback text-center d-block text-info">
                      Default password : cakecode
                    </div>
                  </form>
                </div>
            </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <script>
    $(function(){
        $(".alert").delay(3000).slideUp(300);
    });
</script>

</body>

</html>