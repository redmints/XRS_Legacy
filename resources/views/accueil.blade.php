@extends('templateClassique')

@section('contenu')
    <title>Xeyrus | Accueil</title>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content container-fluid">
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
                    <th>Nom</th>
                    <th>Rôle</th>
                    <th>Créateur</th>
                  </tr>
                  @foreach ($data as $projet)
                      <tr onclick="document.location = 'projet?id={{$projet["id"]}}';">
                        <td>{{$projet["nom"]}}</td>
                        <td>{{$projet["role"]}}</td>
                        <td>{{$projet["createur"]}}</td>
                      </tr>
                  @endforeach
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
