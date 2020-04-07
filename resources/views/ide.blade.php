@extends('templateIde')

@section('contenu')
    <title>Xeyrus | {{$projet->nom}}</title>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-code"></i> <span>PHP Terminale S3 (F. Hoguin)</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"> index.php</a></li>
            <li><a href="index2.html"> demo.php</a></li>
            <li><a href="index2.html"> test.php</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <link rel="stylesheet" href="codemirror/lib/codemirror.css">
      <link rel="stylesheet" href="codemirror/theme/dracula.css">
      <script src="codemirror/lib/codemirror.js"></script>
      <script src="codemirror/mode/javascript/javascript.js"></script>
      <script src="codemirror/addon/selection/active-line.js"></script>
      <script src="codemirror/addon/edit/matchbrackets.js"></script>

      <form><textarea id="code" name="code">
      function findSequence(goal) {
        function find(start, history) {
          if (start == goal)
            return history;
          else if (start > goal)
            return null;
          else
            return find(start + 5, "(" + history + " + 5)") ||
                   find(start * 3, "(" + history + " * 3)");
        }
        return find(1, "1");
      }</textarea></form>

      <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
          lineNumbers: true,
          styleActiveLine: true,
          matchBrackets: true,
          theme: "dracula"
        });
      </script>

      <iframe width="100%" height="330" frameborder="0" allowfullscreen src="
      https://xeyrus.com:4433/?hostname=xeyrus.com&port={{$projet->port}}&username={{strtolower($utilisateur->prenom).strtolower($utilisateur->nom)}}&password={{base64_encode(strtolower($utilisateur->unix_password))}}
      "></iframe>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
