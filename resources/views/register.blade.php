@extends('templateLogin')

@section('contenu')
    <title>Xeyrus | Inscription</title>
    <div class="register-box">
      <div class="register-logo">
        <img width="50%" src="dist/img/logo_max_b.png">
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Inscrivez-vous pour accéder à la plateforme</p>

        <form action="../../index.html" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Clé d'inscription">
            <span class="glyphicon glyphicon-wrench form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Confirmation de mot de passe">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Inscription</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <br>
        <a href="login" class="text-center">Je suis déjà inscrit</a>
      </div>
      <!-- /.form-box -->
    </div>
    <!-- /.register-box -->
@endsection
