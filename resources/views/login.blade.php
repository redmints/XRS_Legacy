<@extends('templateLogin')

@section('contenu')
    <title>Xeyrus | Connexion</title>
    <div class="login-box">
      <div class="login-logo">
        <img width="50%" src="dist/img/logo_max_b.png">
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Connectez-vous à la plateforme</p>

        <form action="login" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Connexion</button>
            </div>
          </div>
        </form>
        <br>
        <a href="#">Mot de passe oublié</a><br>
        <a href="register" class="text-center">Pas encore inscrit ?</a>

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
