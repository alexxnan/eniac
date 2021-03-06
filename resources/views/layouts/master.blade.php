
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ENIAC | CRM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
            <div class="input-group input-group-sm w-50" style="margin-left: 20%; margin-right: 20%;">
                <input class="form-control form-control-navbar" @keyup="searchIt" v-model="search" type="search" placeholder="Cauta" aria-label="Search">
               <!-- <div class="input-group-append">
                    <button class="btn btn-navbar" @click="searchIt">
                        <i class="fas fa-search"></i>
                    </button>
                </div> -->
            </div>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="./img/logo.png" alt="ENIAC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">ENIAC</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 d-flex">
                <div class="image">
                    <img src="./img/profile/{{Auth::user()->photo}}" class="img-circle" alt="User Image">
                </div>
                <div class="info" style="margin-bottom:-5%;">
                    <a href="#" class="d-block"><h5 style="margin-top:-6%;">{{ Auth::user()->name }}</h5>
                        <p style="margin-top:-6%;">{{Auth::user()->type}}</p>
                    </a>

                </div>
            </div>

            <!-- SidebarSearch Form
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            Sfarsit SidebarSearch -->

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt text-blue"></i>
                            <p>
                                Dashboard
                            </p>
                        </router>
                    </li>

                    @can('isAdmin')
                    <li class="nav-item">
                        <a href="#" class="nav-link" style="background-color: #1d643b; border-radius: 3px;">
                            <i class="nav-icon fas fa-code-branch text-green"></i>
                            <p>
                                Management

                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <router-link to="/users" class="nav-link">
                                    <i class="fas fa-users-cog nav-icon text-orange"></i>
                                    <p class="text-white">Users</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/factura" class="nav-link">
                                    <i class="fas fa-file-invoice-dollar nav-icon text-orange"></i>
                                    <p class="text-white">Factura</p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link to="/orders" class="nav-link">
                                    <i class="fas fa-file-invoice-dollar nav-icon text-blue"></i>
                                    <p class="text-white">Comanda</p>
                                </router-link>
                            </li>

                        </ul>
                    </li>
                    @endcan

                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link">
                            <i class="nav-icon fas fa-user text-cyan"></i>
                            <p>
                                Profil
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-power-off text-red"></i>
                            <p>
                                {{ __('Logout') }}
                            </p>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>



                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <router-view></router-view>

                <vue-progress-bar></vue-progress-bar>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer text-red">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline text-red">
            Optimal Solution Provider for your business!
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2021 <a href="https://nanit.ro">nanit.ro</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->


@auth
    <script>
        window.user = @json(auth()->user())
    </script>
@endauth

<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>

</body>
</html>
