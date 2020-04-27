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
                                <th  style="text-align: center; vertical-align: middle;">Statut</th>
                                <th  style="text-align: center; vertical-align: middle;">Nom</th>
                                <th  style="text-align: center; vertical-align: middle;">Type</th>
                                <th  style="text-align: center; vertical-align: middle;">Rôle</th>
                                <th  style="text-align: center; vertical-align: middle;">Créateur</th>
                                <th  style="text-align: center; vertical-align: middle;">Actions</th>
                            </tr>
                            @foreach ($data as $projet)
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    @if ($projet['port'] == $constants['EN_ATTENTE'])
                                    <img src="dist/img/rond_orange.png" width="20" heigth="20" class="docker_status" alt=" Project Status: In Configuration">
                                    <p>En Configuration</p>
                                    @endif
                                    @if ($projet['port'] == $constants['VALID'])
                                    <img src="dist/img/rond_rouge.png" width="20" heigth="20" class="docker_status" alt=" Project Status: Extinct">
                                    <p>Éteint</p>
                                    @endif
                                    @if ($projet['port'] == $constants['1ST_PORT'])
                                    <img src="dist/img/rond_vert.png" width="20" heigth="20" class="docker_status" alt=" Project Status: In Operation">
                                    <p>En Fonctionnement</p>
                                    @endif
                                </td>
                                <td style="text-align: center; vertical-align: middle;">{{$projet["nom"]}}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    @if ($projet['type_projet'] == $constants['TYPE_CLASSROOM'])
                                    Classroom
                                    @endif
                                    @if ($projet['type_projet'] == $constants['TYPE_PROJET'])
                                    Projet
                                    @endif
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    @if ($projet['role'] == $constants["ROLE_ADMIN"])
                                    Propriétaire
                                    @endif
                                    @if ($projet['role'] == $constants["ROLE_DEV"])
                                    Développeur
                                    @endif
                                </td>
                                <td style="text-align: center; vertical-align: middle;">{{$projet["createur"]}}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a type="button" href="projet?id_projet={{$projet['id']}}" class="btn btn-success btn-sm">Entrer</a>&emsp;
                                    <a type="button" href="settings?id_projet={{$projet['id']}}" class="btn btn-warning btn-sm">Paramètres</a>&emsp;
                                    <button data-toggle="modal" data-target="#formulaire" class="btn btn-sm btn-danger">Supprimer</button>
                                    <div class="modal" id="formulaire">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Attention</h4>
                                                </div>
                                                <div class="modal-body" >
                                                    <p> Êtes-vous sûr de vouloir supprimer ce projet:<b style="color:red;"> {{$projet['nom']}}</b></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form class="col" role="form" action="settings?id_projet={{$projet["id"]}}" method="post" >
                                                        <input type="hidden" name="id_projet" value="{{$projet["id"]}}">
                                                        <input type="hidden" name="id_utilisateur" value="{{$utilisateur["id"]}}">
                                                        <input type="hidden" name="action" value="delete-projet">
                                                        <button type="submit" class="btn btn-sm btn-danger" >Oui</button>
                                                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" >Non</button>
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
