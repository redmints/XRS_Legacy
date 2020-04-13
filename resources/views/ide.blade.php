@extends('templateIde')

@section('contenu')
    <style>
    /* Remove default bullets */
    ul, #myUL {
     list-style-type: none;
     color: white;
    }

    /* Remove margins and padding from the parent ul */
    #myUL {
     margin: 0;
     padding: 0;
    }

    /* Style the caret2/arrow */
    .caret2 {
     cursor: pointer;
     user-select: none; /* Prevent text selection */
    }

    /* Create the caret2/arrow with a unicode, and style it */
    .caret2::before {
     content: "\25B6";
     color: white;
     display: inline-block;
     margin-right: 6px;
    }

    /* Rotate the caret2/arrow icon when clicked on (using JavaScript) */
    .caret2-down::before {
     transform: rotate(90deg);
    }

    /* Hide the nested list */
    .nested {
     display: none;
    }

    /* Show the nested list when the user clicks on the caret2/arrow (with JavaScript) */
    .active {
     display: block;
    }
    </style>
    <title>Xeyrus | {{$projet->nom}}</title>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul id="myUL">
            <li>
                <span class="caret2">{{$projet->nom}}</span>
                <ul class="nested">
                    <li>Water</li>
                    <li>Coffee</li>
                    <li>
                        <span class="caret2">Tea</span>
                        <ul class="nested">
                            <li>Black Tea</li>
                            <li>White Tea</li>
                        </ul>
                    </li>
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

      <script src="bower_components/jquery/dist/jquery.min.js"></script>
      <script>
        //Paramètres de l'éditeur de texte
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
          lineNumbers: true,
          styleActiveLine: true,
          matchBrackets: true,
          theme: "dracula"
        });

        //Pour le browser de fichiers
        var toggler = document.getElementsByClassName("caret2");
        var i;
        for (i = 0; i < toggler.length; i++) {
          toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret2-down");
          });
        }

        //Envoi du keep_alive toutes les 5 minutes
        function send(){
            $.ajax({
                type: "get",
                url: "keep_alive?id_projet={{$projet->id}}",
                success:function(data)
                {
                    //Send another request in 5 minutes.
                    setTimeout(function(){
                        send();
                    }, 300000);
                }
            });
        }
        //Call our function
        send();
      </script>

      <iframe width="100%" height="330" frameborder="0" allowfullscreen src="
      https://xeyrus.com:4433/?hostname=xeyrus.com&port={{$projet->port}}&username={{preg_replace("/[^a-zA-Z0-9]+/", "", strtolower(strtr($utilisateur->prenom, $unwanted_array )).strtolower(strtr($utilisateur->nom, $unwanted_array )))}}&password={{base64_encode(strtolower($utilisateur->unix_password))}}
      "></iframe>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
