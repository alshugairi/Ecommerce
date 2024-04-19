<!DOCTYPE html>
<html lang="{{ $language }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RGB | Ecommerce</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="p{{ asset('assets/admin') }}/lugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/custom.css">
    @if(session('locale') === 'ar')
        <link href="{{ asset('assets/admin') }}/css/rtl.css" rel="stylesheet" />
    @endif

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.sidebar')
