@extends('templateLogin')

@section('contenu')
    <title>Xeyrus | Connexion</title>
    <div class="login-box">
      <div class="login-logo">
        <img width="50%" src="dist/img/logo_max_b.png">
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        @if (isset($erreur) && $erreur == $constants["UNKNOWN_MAIL"])
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            <p>Mail inconnu</p>
            </div>
        @endif
        <p class="login-box-msg">Vous avez oublié votre mot de passe ? Veuillez renseigner votre mail nous allons vous envoyer un mail de récupération.</p>

        <form action="mdpOublier" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Envoyer</button>
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
