@extends('templateLogin')

@section('contenu')
    <title>Xeyrus | Connexion</title>
    <div class="login-box">
      <div class="login-logo">
        <img width="50%" src="dist/img/logo_max_b.png">
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        @if (isset($erreur) && $erreur == $constants["NOT_SAME_PASSWORD"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>Les deux mots de passes entrés ne correspondent pas</p>
            </div>
        @endif
        @if (isset($erreur) && $erreur == $constants["CLE_INVALIDE"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>L'authentication à échoué veillez effectuer une nouvelle demande'</p>
            </div>
        @endif
        <p class="login-box-msg">Entrez un nouveau mot de passe</p>

        <form action="modifMdpOublier" method="post" enctype="multipart/form-data">
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Nouveau Mot de passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" padding-up class="form-control" name="confPassword" placeholder="Confirmez votre Nouveau Mot de passe">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <input type="hidden" name="cle" value="{{$cle}}">
          <div class="row">
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Enregistrer</button>
            </div>
          </div>
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <br>
        <a href="register" class="text-center">Pas encore inscrit ?</a>

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
