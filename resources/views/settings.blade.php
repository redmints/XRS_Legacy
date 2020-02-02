@extends('templateClassique')

@section('contenu')
    <title>Xeyrus | Paramètres</title>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content container-fluid">
        @if (isset($_GET["erreur"]) && $_GET["erreur"] == $constants["ALREADY_AUTHORIZED"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>Cet utilisateur est déjà enregistré</p>
            </div>
        @endif

        @if (isset($_GET["erreur"]) && $_GET["erreur"] == $constants["UNKNOWN_USER"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>Cet utilisateur n'existe pas</p>
            </div>
        @endif
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Ajout d'un nouvel utilisateur</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="settings?id_projet={{$projet->id}}" method="post">
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Nom</label>
                <input type="email" class="form-control" name="email" placeholder="Email de l'utilisateur">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Rôle</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="optionsRadios" value="option1" checked>
                    Administrateur
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="optionsRadios" value="option2">
                    Développeur
                  </label>
                </div>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Liste des participants</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Action</th>
                  </tr>
                  @foreach ($data as $participant)
                      <tr>
                        <td>{{$participant["prenom"]}} {{$participant["nom"]}}</td>
                        <td>{{$participant["email"]}}</td>
                        <td>
                            @if ($participant['role'] == $constants["ROLE_ADMIN"])
                                Administrateur
                            @endif
                            @if ($participant['role'] == $constants["ROLE_DEV"])
                                Développeur
                            @endif
                        </td>
                        <td>
                            @if ($participant['id'] != $utilisateur->id)
                                <form role="form" action="settings?id_projet={{$projet->id}}" method="post">
                                    <input type="hidden" name="id_projet" value="{{$projet->id}}">
                                    <input type="hidden" name="id_utilisateur" value="{{$participant["id"]}}">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            @else
                                <button type="button" class="btn btn-sm btn-disabled">Supprimer</button>
                            @endif
                        </td>
                      </tr>
                  @endforeach
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
