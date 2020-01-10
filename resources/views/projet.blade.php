@extends('templateClassique')

@section('contenu')
    <title>Xeyrus | Accueil</title>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PHP Terminale S3
        <small>F. Hoguin</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <a class="btn btn-app" href="ide">
        <i class="fa fa-code"></i> IDE
      </a>
      <a class="btn btn-app">
        <i class="fa fa-list"></i> Evaluations
      </a>
      <a class="btn btn-app">
        <i class="fa fa-cogs"></i> Paramètres
      </a>
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
