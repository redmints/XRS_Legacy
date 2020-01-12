@extends('templateLogin')

@section('contenu')
    <title>Xeyrus | Inscription</title>
    <div class="register-box">
      <div class="register-logo">
        <img width="50%" src="dist/img/logo_max_b.png">
      </div>

      <div class="register-box-body">
        @if (isset($erreur))
            <div class="callout callout-danger">
            <h4>Erreur</h4>
            @if ($erreur == $constants["NOT_SAME_PASSWORD"])
                <p>Les mots de passe ne sont pas identiques</p>
            @endif
            @if ($erreur == $constants["INVALID_KEY"])
                <p>La clé que vous avez saisie est incorrecte</p>
            @endif
            @if ($erreur == $constants["INVALID_EMAIL"])
                <p>L'email que vous avez saisi existe déjà</p>
            @endif
            </div>
        @endif
        <p class="login-box-msg">Inscrivez-vous pour accéder à la plateforme</p>

        <form action="register" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="cle" placeholder="Clé d'inscription">
            <span class="glyphicon glyphicon-wrench form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmation de mot de passe">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Inscription</button>
            </div>
            <!-- /.col -->
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <br>
        <a href="login" class="text-center">Je suis déjà inscrit</a>
      </div>
      <!-- /.form-box -->
    </div>
    <!-- /.register-box -->
@endsection
