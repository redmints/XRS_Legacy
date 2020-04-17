@extends('templateClassique')

@section('contenu')
<title>Xeyrus | Modification des informations du compte</title>
<div class="content-wrapper">
  <section class="content container-fluid">
    <h1><center><bold>Mon compte</bold><center></h1>
      <div class="login-box">
        <div class="login-box-body">
          @if (isset($erreur) && $erreur == $constants["NOT_SAME_PASSWORD"])
              <div class="callout callout-danger">
              <h4>Erreur</h4>
              <p>Les deux mots de passes entrés ne correspondent pas</p>
              </div>
          @endif
          <p class="login-box-msg">Modification des informations de votre compte</p>
          <form action="modificationCompte" method="post">
            <div class="form-group has-feedback" style="text-align: center">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
            </div>
            <div class="form-group has-feedback">
              <input type="text" list="prenom" class="form-control" value="{{ $utilisateur['prenom'] }}" name="prénom" placeholder="Prénom" autofocus>
              <datalist id="prenom">
                <option value="{{$utilisateur['prenom']}}">
                </datalist>
              </div>
              <div class="form-group has-feedback">
                <input type="text" list="nom" class="form-control" value="{{ $utilisateur['nom'] }}" name="nom" placeholder="Nom de famille" >
                <datalist id="nom">
                  <option value="{{$utilisateur['nom']}}">
                  </datalist>
                </div>
                <div class="form-group has-feedback">
                  <input type="email" class="form-control" name="email" placeholder="Email">
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" class="form-control" name="password" placeholder="Nouveau Mot de passe">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" padding-up class="form-control" name="confPassword" placeholder="Confirmez votre Nouveau Mot de passe">
                  <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Enregistrer</button>
                  </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </form>
            </div>
          </div>
        </section>
      </div>
      @endsection
