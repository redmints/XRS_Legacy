@extends('templateClassique')

@section('contenu')
    <title>Xeyrus | {{$projet->nom}}</title>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$projet->nom}}
        <small>{{$createur->prenom}} {{$createur->nom}}</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <a class="btn btn-app" href="ide">
        <i class="fa fa-code"></i> IDE
      </a>
      @if ($projet->type == $constants["TYPE_CLASSROOM"])
          <a class="btn btn-app">
            <i class="fa fa-list"></i> Evaluations
          </a>
      @endif
      @if ($utilisateur->id == $createur->id)
          <a class="btn btn-app" href="settings?id_projet={{$projet->id}}">
            <i class="fa fa-cogs"></i> Paramètres
          </a>
      @endif
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
