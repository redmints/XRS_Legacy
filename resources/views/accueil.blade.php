@extends('templateClassique')

@section('contenu')
    <title>Xeyrus | Accueil</title>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content container-fluid">
        <a type="button" href="nouveau-projet" class="btn btn-success btn-sm">Nouveau</a>
        <br><br>

        @if (isset($_GET["erreur"]) && $_GET["erreur"] == $constants["ACCESS_DENIED"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>Vous n'avez pas les droits pour ce projet</p>
            </div>
        @endif

        @if (isset($_GET["erreur"]) && $_GET["erreur"] == $constants["INVALID_PROJECT"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>Ce projet n'existe pas</p>
            </div>
        @endif

        @if (isset($_GET["erreur"]) && $_GET["erreur"] == $constants["RUN_ERROR"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>Erreur de démarrage du conteneur</p>
            </div>
        @endif

        @if (isset($_GET["erreur"]) && $_GET["erreur"] == $constants["BUILD_ERROR"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>Erreur de compilation du conteneur</p>
            </div>
        @endif
        @if (sizeof($data) != 0)
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Liste de vos classrooms</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                      <tr>
                        <th>Nom</th>
                        <th>Rôle</th>
                        <th>Créateur</th>
                      </tr>
                      @foreach ($data as $projet)
                          <tr onclick="document.location = 'projet?id_projet={{$projet["id"]}}';">
                            <td>{{$projet["nom"]}}</td>
                            <td>
                                @if ($projet['role'] == $constants["ROLE_ADMIN"])
                                    Propriétaire
                                @endif
                                @if ($projet['role'] == $constants["ROLE_DEV"])
                                    Développeur
                                @endif
                            </td>
                            <td>{{$projet["createur"]}}</td>
                          </tr>
                      @endforeach
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
            </div>
        @else
            <div class="row">
              <div class="col-xs-12">
                  <center>
                  <img src="dist/img/nothing.png" width="100px"></img>
                  <h1>Vous n'avez aucun projet.</h1>
                  <h1>Vous pouvez en créer un nouveau.</h1>
              </center>
              </div>
          </div>

        @endif

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
