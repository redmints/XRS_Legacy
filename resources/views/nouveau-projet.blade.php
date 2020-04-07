@extends('templateClassique')

@section('contenu')
    <title>Xeyrus | Nouveau Projet</title>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content container-fluid">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Création d'un nouveau projet</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="nouveau-projet" method="post">
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Nom</label>
                <input class="form-control" type="text" name="nom" placeholder="Nom du projet" required>
              </div>
              @if ($utilisateur->status == $constants["STATUS_ENSEIGNANT"])
                  <div class="form-group">
                    <label for="exampleInputEmail1">Type</label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="optionsRadios" value="option1" checked>
                        Projet basique
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="optionsRadios" value="option2">
                        Classroom
                      </label>
                    </div>
                  </div>
              @endif
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Créer</button>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
