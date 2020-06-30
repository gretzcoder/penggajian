<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    @yield('head-link')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" style="position:relative;">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordiond" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <img src="{{ URL::asset('img/logo.png') }}" alt="CakeCode" width="100">
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ (request()->is('admin/akun*')) ? 'active' : '' }}">
                <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-user"></i>
                    <span> Akun</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ url('admin/akun/input-akun') }}">Input Akun Baru</a>
                        <a class="collapse-item" href="{{ url('admin/akun/kelola-akun') }}">Kelola Akun</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item {{ (request()->is('admin/data-karyawan*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/data-karyawan') }}">
                    <i class="fas fa-fw fa-user-tie"></i>
                    <span>Data Karyawan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ (request()->is('admin/jabatan*')) ? 'active' : '' }}">
                <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#jabatan" aria-expanded="true"
                    aria-controls="jabatan">
                    <i class="fas fa-fw fa-briefcase"></i>
                    <span>Jabatan</span>
                </a>
                <div id="jabatan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ url('admin/jabatan/input-jabatan') }}">Input Jabatan Baru</a>
                        <a class="collapse-item" href="{{ url('admin/jabatan') }}">Daftar Jabatan</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ (request()->is('admin/presensi*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/presensi') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Presensi</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ (request()->is('admin/penambahan-potongan*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/penambahan-potongan') }}">
                    <i class="fas fa-fw fa-coins"></i>
                    <span>Penambahan & Potongan</span></a>
            </li>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ (request()->is('admin/penggajian*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/penggajian') }}">
                    <i class="fas fa-fw fa-money-bill"></i>
                    <span>Penggajian</span></a>
            </li>

            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Charts -->
            <li class="nav-item {{ (request()->is('admin/komplain*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/komplain') }}">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Komplain</span></a>
            </li>

            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/logout') }}">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="min-height: 40rem">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        Learn Code With Some Cake~

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CakeCode 2019</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @yield('foot-link')

</body>

</html>