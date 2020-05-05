@extends('templateLogin')

@section('contenu')
    <title>Xeyrus | Connexion</title>
    <div class="login-box">
      <div class="login-logo">
        <img width="50%" src="dist/img/logo_max_b.png">
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
      @if (isset($erreur) && $erreur == $constants["INVALID_PASSWORD"])
          <div class="callout callout-danger">
          <h4>Erreur</h4>
          <p>Vos identifiants sont incorrects</p>
          </div>
      @endif
      @if (isset($erreur) && $erreur == $constants["CLE_INVALIDE"])
          <div class="callout callout-danger">
          <h4>Erreur</h4>
          <p>L'authentication a échoué veillez effectuer une nouvelle demande de mot de passe oublié</p>
          </div>
      @endif
      @if (isset($erreur) && $erreur == $constants["VALID"])
          <div class="callout callout-success">
          <h4>Votre compte à bien été créé</h4>
          <p>Merci de vous identifier</p>
          </div>
      @endif
        <p class="login-box-msg">Connectez-vous à la plateforme</p>

        <form action="login" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Connexion</button>
            </div>
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <br>
        <a href="mdpOublier">Mot de passe oublié</a><br>
        <a href="register" class="text-center">Pas encore inscrit ?</a>

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
