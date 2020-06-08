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
        <!-- div pour l'arborescence du projet -->
        <div id="projet">
        </div>

    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Les onglets des fichiers ouverts dans l'IDE-->
    <div class="onglets">
        <ul class="nav nav-tabs" id="listeOnglets" style="height:22.3px">
            <li class="nav active" id="Accueil" style="height:100%;width:150px" >
                <a class="nav-link" href="" data-toggle="tab" style="line-height:0;color:#4b0082;text-align:center;border-color:#4b0082">
                    Accueil Xeyrus
                    <button style="margin-top:-10px;visibility:hidden" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </a>
            </li>

            <!-- Bouton + nouveau fichier-->
            <li class="nav" style="float:right;margin-top: -1px;height:100%">
                <a class="nav-link" data-toggle="modal" data-target="#newFileModal" style="color:#4b0082;line-height:0;font-size:px;font-weight:bold">&plus;</a>
            </li>
            <!-- Fenetre modal pour la creation du nouveau fichier-->
            <div class="modal fade" id="newFileModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                            <h4 class="modal-title" style="color:black">Création d'un nouveau fichier</h4>
                        </div>
                        <form class="col" id="formNewFile" role="form">
                            <div class="modal-body" >
                                <p><b style="color:black">Nom du nouveau fichier :</b></p>
                                <input type="text" id="newFile" style="color:black;width:350px" value="/home/{{ strtolower($utilisateur['nom']) }}{{ strtolower($utilisateur['prenom']) }}/{{ $projet['nom'] }}/" autofocus>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" >Valider</button>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fenetre modal pour la confirmation de la fermeture d'un onglet-->
            <div class="modal fade" id="closeOngletModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="color:black">Des changements ont été effectués dans le fichier:  <label style="color:red" id="nomOngletASupp"><label> </h4>
                        </div>
                        <form class="col" id="formCloseOnglet" role="form">
                        <div class="modal-body" >
                            <p><b style="color:black">Voulez-vous sauvegarder l'onglet ?</b></p>
                            <p><b style="color:black">Les changements seront perdus si vous fermez l'onglet sans sauvegarder</b></p>
                            <input type="hidden" id="closeOnglet" >
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" value="Sauvegarder">Sauvegarder</button>
                            <button type="submit" class="btn btn-warning" value="Annuler">Annuler</button>
                            <button type="submit" class="btn btn-danger" value="Ne pas sauvegarder">Ne pas sauvegarder</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </ul>
    </div>

    <form><textarea id="code" name="code">
        Bienvenue sur 'Xeyrus'.com !

            Vous voici sur notre éditeur vous êtes maintenant prêts à travailler sur ce projet.

        Bonne continuation !
    </textarea></form>
    <iframe width="102%" height="330" frameborder="0" allowfullscreen src="http://localhost:1664/?hostname=localhost&port={{$projet->port}}&username={{preg_replace("/[^a-zA-Z0-9]+/", "", strtolower(strtr($utilisateur->prenom, $unwanted_array )).strtolower(strtr($utilisateur->nom, $unwanted_array )))}}&password={{base64_encode(strtolower($utilisateur->unix_password))}}">
    </iframe>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<link rel="stylesheet" href="codemirror/lib/codemirror.css">
<link rel="stylesheet" href="codemirror/theme/material-palenight.css">
<script src="codemirror/lib/codemirror.js"></script>
<script src="codemirror/mode/javascript/javascript.js"></script>
<script src="codemirror/addon/selection/active-line.js"></script>
<script src="codemirror/addon/edit/matchbrackets.js"></script>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script>

        //Variable des contenus des onglets actifs sur la page
        var ongletsCodeMirror = {"Accueil":"        Bienvenue sur 'Xeyrus'.com !\n \n            Vous voici sur notre éditeur vous êtes maintenant prêts à travailler sur ce projet.\n \n        Bonne continuation ! "};

        //Onglet actif
        var ongActif = "Accueil";

        //Paramètres de l'éditeur de texte
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            theme: "material-palenight"
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


        //Donne l'utilisateur Unix pour les requetes ajax sur le docker
        function getUtilisateur(){
            return "{{preg_replace('/[^a-zA-Z0-9]+/', '', strtolower(strtr($utilisateur->prenom, $unwanted_array )).strtolower(strtr($utilisateur->nom, $unwanted_array )))}}";
        }

        //Donne le mot de passe de l'utilisateur Unix pour les requetes ajax sur le docker
        function getMdp(){
            return "{{base64_encode(strtolower($utilisateur->unix_password))}}";
        }

        //Actualisation de CodeMirror à la fermeture d'un onglet
        function switchOngletOnClose(data){
            var ajoutCode = ongletsCodeMirror[data];
            editor.setValue(ajoutCode);
            ongActif = data;
        }


        //Sauvegarde toutes les 10 secondes le contenu de l'onglet actif
        function save(ongletsCodeMirror){

            $(".nav").each(function(){
                if($(this).hasClass("active")){
                    var sauveg = editor.getValue();
                    var path = $(this).attr("id");
                    ongletsCodeMirror[path]=sauveg;

                    $.ajax({
                        type: "get",
                        url: "commandeFileSystem?action=ecrire-fichier&port={{$projet['port']}}&nomProjet={{$projet['nom']}}&pathFichier=" + path + "&data=" + sauveg + "&utilisateur=" + getUtilisateur() + "&mdp=" + getMdp(),

                    });
                }
            })
            //Send another request in 10sec.
            setTimeout(function(){
                save(ongletsCodeMirror);
            }, 10000);

        }
        save(ongletsCodeMirror);


        $(function(){

            //Affichage de la croix de fermeture lorque le curseur entre sur l'élément de la liste
            $("#listeOnglets").on("mouseenter",".nav",function(){
                $(this).children().children().last().css("visibility","visible");

            });

            //Disparition de la croix de fermeture lorque le curseur entre sur l'élément de la liste
            $("#listeOnglets").on("mouseleave",".nav",function(){
                $(this).children().children().last().css("visibility","hidden");

            });

            //Changement de couleur de la croix lorsque le curseur passe dessus
            $("#listeOnglets").on("mouseenter",".close",function(){
                $(this).children().last().css("color","#4b0082");
            });

            //Retour de l'ancienne couleur de la crois quand le curseur quitte la croix
            $("#listeOnglets").on("mouseleave",".close",function(){
                $(this).children().last().css("color","#6C6C6C");
            });

            //Traitement de la fermeture des onglets
            $("#listeOnglets").on("click",".close",function(e){
                var onglet = $(this).parent().parent();
                var ongToCloseId = onglet.attr("id");
                //Si l'onglet à fermer est l'Accueil
                if(ongToCloseId == "Accueil"){
                    //Empeche d'activer l'evenement d'un clic sur un élément li lorsque l'on clic sur la croix de ce li
                    e.preventDefault();
                    e.stopPropagation();
                    var ongKeys = Object.keys(ongletsCodeMirror);
                    //Si c'est ler dernier onglet
                    if(ongKeys.length == 1){
                        window.location = "projet?id_projet={{$projet['id']}}";
                    }
                    //Sinon
                    else{
                        onglet.remove();
                        delete ongletsCodeMirror[ongToCloseId];
                        //Si c'est l'onglet actif alors on change l'attribut actif et on l'associe au premier onglet de la liste
                        if(onglet.hasClass("active")){
                            $(".nav").each(function(){
                                var ongKeys = Object.keys(ongletsCodeMirror);
                                if($(this).attr("id") == ongKeys[0]){
                                    var classe = $(this).attr("class") + " active";
                                    $(this).addClass(classe);
                                    switchOngletOnClose($(this).attr("id"));

                                }
                            });
                        }

                    }
                }
                //Sinon
                else{
                    //Si c'est l'onglet actif, on choisi un autre onglet comme actif
                    if(onglet.hasClass("active")){
                        //Si il y a eu un changement non sauvegarder entre le contenu de l'editeur et la sauvegarde dans le tableau js, affichage du modal de confirmation
                        if(editor.getValue() != ongletsCodeMirror[ongToCloseId]){
                            //Empeche d'activer l'evenement d'un clic sur un élément li lorsque l'on clic sur la croix de ce li
                            e.preventDefault();
                            e.stopPropagation();
                            $("#closeOngletModal").modal("show");
                            $("#closeOnglet").val(ongToCloseId);
                            var splitPath = ongToCloseId.split("/");
                            var nomFichierAssocie = splitPath[splitPath.length-1];
                            $("#nomOngletASupp").text(nomFichierAssocie);
                        }
                        //Sinon on ferme sans sauvegarder
                        else{
                            onglet.remove();
                            delete ongletsCodeMirror[ongToCloseId];
                            //Empeche d'activer l'evenement d'un clic sur un élément li lorsque l'on clic sur la croix de ce li
                            e.preventDefault();
                            e.stopPropagation();
                            var ongKeys = Object.keys(ongletsCodeMirror);
                            //Si ce n'est pas le dernier onglet
                            if(ongKeys.length > 0){
                                $(".nav").each(function(){
                                    if($(this).attr("id") == ongKeys[0]){
                                        var classe = $(this).attr("class") + " active";
                                        $(this).addClass(classe);
                                        switchOngletOnClose($(this).attr("id"));
                                    }
                                });
                            }
                            //Sinon on redirige sur la page du projet
                            else{
                                window.location = "projet?id_projet={{$projet['id']}}";

                            }
                        }

                    }
                    //Sinon on ferrme sans sauvegarder
                    else{
                        onglet.remove();
                        delete ongletsCodeMirror[ongToCloseId];
                    }

                }

            });



            //Ouverture d'onglet et affichage du contenu du fichier cliqué dans l'arborescence
            /*$("#listeOnglets").on("click",".nav",function(){
                var pathFile = $(this).attr("id");
                $.ajax({
                    type:"get",
                    url:"commandeFileSystem?action=lire-fichier&port={{ $projet['port'] }}&nomProjet={{ $projet['nom'] }}&pathFichier=" + pathFile  + "&utilisateur=" + getUtilisateur() + "&mdp=" + getMdp(),
                    success:function(result){
                        ongletsCodeMirror[pathFile] = result;
                        var nomFichier = pathFile.split("/");
                        $(".nav-tabs").append("<li class='nav' id='"+ pathFile +"' style='height:100%;width:150px'><a class='nav-link' href='' data-toggle='tab' style='line-height:0;color:#4b0082;text-align:center;border-color:#4b0082'>"+ nomFichier[nomFichier.length-1] +"<button style='margin-top:-10px;visibility:hidden' type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button></a></li>");
                        var ancienCode = editor.getValue();
                        ongletsCodeMirror[ongActif] = ancienCode;
                        $.ajax({
                            type:"get",
                            url:"commandeFileSystem?action=ecrire-fichier&port={{$projet['port']}}&nomProjet={{$projet['nom']}}&pathFichier=" + ongActif + "&data=" + ancienCode + "&utilisateur=" + getUtilisateur() + "&mdp=" + getMdp(),
                            success:function(){

                            }
                        });
                        $(".nav").each(function(){
                            if($(this).attr("id") == pathFile){
                                var classe = $(this).attr("class") + " active";
                                $(this).addClass(classe);
                                switchOngletOnClose($(this).attr("id"));
                            }
                        });
                    }
                });
            });*/

            //Traitement code mirror lorsque l'on switch d'onglets
            $("#listeOnglets").on("click",".nav",function(){
                var pathFile = $(this).attr("id");
                var ancienCode = editor.getValue();
                ongletsCodeMirror[ongActif] = ancienCode;
                $.ajax({
                    type:"get",
                    url:"commandeFileSystem?action=ecrire-fichier&port={{$projet['port']}}&nomProjet={{$projet['nom']}}&pathFichier=" + ongActif + "&data=" + ancienCode + "&utilisateur=" + getUtilisateur() + "&mdp=" + getMdp(),
                    success:function(){

                    }
                });
                var ajoutCode = ongletsCodeMirror[pathFile];
                editor.setValue(ajoutCode);
                ongActif = pathFile;
            });






            //Sauvegarde lors d'un appui sur control+s
            $(document).on("keydown", function(e){
                if(e.ctrlKey && e.keyCode == 83){
                    //empecher le traitement du ctrl+s du navigateur
                    e.preventDefault();
                    $(".nav").each(function(){
                        if($(this).hasClass("active")){
                            var sauvegarde = editor.getValue();
                            var path = $(this).attr("id");
                            ongletsCodeMirror[path] = sauvegarde;
                            $.ajax({
                                type:"get",
                                url:"commandeFileSystem?action=ecrire-fichier&port={{$projet['port']}}&nomProjet={{$projet['nom']}}&pathFichier=" + path + "&data=" + sauvegarde  + "&utilisateur=" + getUtilisateur() + "&mdp=" + getMdp(),
                                success:function(){

                                }

                            });

                        }

                    });
                };
            });

            });






            //Form New file
            $("#formNewFile").on("submit",function(e){
                //Empeche l'envoi du formulaire et donc le rechargement de la page
                e.preventDefault();
                var path = $("#newFile").val();
                $.ajax({
                    type:"get",
                    url:"commandeFileSystem?action=nouveau-fichier&port={{$projet['port']}}&nomProjet={{$projet['nom']}}&nom=" + path  + "&utilisateur=" + getUtilisateur() + "&mdp=" + getMdp(),
                    success:function(){

                    }

                });
                var nomFichier = path.split("/");
                $(".nav-tabs").append("<li class='nav' id='"+ path +"' style='height:100%;width:150px'><a class='nav-link' href='' data-toggle='tab' style='line-height:0;color:#4b0082;text-align:center;border-color:#4b0082'>"+ nomFichier[nomFichier.length-1] +"<button style='margin-top:-10px;visibility:hidden' type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button></a></li>");
                ongletsCodeMirror[path] = "";
                $("#newFileModal").modal("hide");
                $(".nav").each(function(){
                    if($(this).attr("id") == path){
                        $(this).children()[0].click();
                    }
                });

            });

            //Form Close Onglet
            $("#formCloseOnglet button").on("click",function(e){
                e.preventDefault();
                var valOnglet = $(this).attr("value");
                var path = $("#closeOnglet").attr("value");

                //Si Sauvegarder
                if(valOnglet == "Sauvegarder"){
                    var sauveg = editor.getValue();
                    ongletsCodeMirror[path]=sauveg;

                    $.ajax({
                        type: "get",
                        url: "commandeFileSystem?action=ecrire-fichier&port={{$projet['port']}}&nomProjet={{$projet['nom']}}&pathFichier="+ path + "&data="+ sauveg + "&utilisateur=" + getUtilisateur() + "&mdp=" + getMdp(),

                    });
                    $(".nav").each(function(){
                        if($(this).attr("id") == path){
                            $(this).remove();
                            delete ongletsCodeMirror[path];
                            $("#closeOngletModal").modal("hide");
                            var ongKeys = Object.keys(ongletsCodeMirror);
                            //Si le nombre de clés c'est à dire le nombre d'onglet ouverts est supérieur à 1 après la suppression, on passe en actif un autre onglet
                            if(ongKeys.length > 0){
                                $(".nav").each(function(){
                                    if($(this).attr("id") == ongKeys[0]){
                                        var classe = $(this).attr("class") + " active";
                                        $(this).addClass(classe);
                                        switchOngletOnClose($(this).attr("id"));
                                    }
                                });
                            }
                            //Sinon s'il n'y a plus d'onglet à afficher on redirige vers la page du projet
                            else if(ongKeys.length == 0){
                                window.location = "projet?id_projet={{$projet['id']}}";
                            }
                        }
                    });
                }
                //Sinon si Annuler
                else if(valOnglet == "Annuler"){
                    $("#closeOngletModal").modal("hide");
                }
                //Sinon si Ne pas sauvegarder
                else if(valOnglet == "Ne pas sauvegarder"){
                    $(".nav").each(function(){
                        if($(this).attr("id") == path){
                            $(this).remove();
                            delete ongletsCodeMirror[path];
                            $("#closeOngletModal").modal("hide");
                            var ongKeys = Object.keys(ongletsCodeMirror);
                            //Si le nombre de clés c'est à dire le nombre d'onglet ouverts est supérieur à 1 après la suppression, on passe en actif un autre onglet
                            if(ongKeys.length > 0){
                                $(".nav").each(function(){
                                    if($(this).attr("id") == ongKeys[0]){
                                        var classe = $(this).attr("class") + " active";
                                        $(this).addClass(classe);
                                        switchOngletOnClose($(this).attr("id"));
                                    }
                                });
                            }
                            //Sinon s'il n'y a plus d'onglet à afficher on redirige vers la page du projet
                            else if(ongKeys.length == 0){
                                window.location = "projet?id_projet={{$projet['id']}}";
                            }
                        }
                    });
                }
            });



</script>




<script>
            //Construction de l'arborescence
            function arborescence(data){
                var html = "<ul id='myUL'>";

                $.each(data, function(key,value){

                    if(typeof value !== "object"){
                        html += "<li><span class='caret2'>";
                        html += key;
                        html += "</span>";
                        html += "<ul class='nested'><li>";
                        html += value;
                        html += "</li></ul></li>";
                    }
                    else {
                        html += "<li><span class='caret2'>";
                        html += key;
                        html += "</span>";
                        html += arborescence2(value);
                        html += "</li>";
                    }
                });

                html += "</ul>";
                return html;
            }

            function arborescence2(data){
                var html2 = "<ul class='nested'>";

                $.each(data,function(key, value){

                    if(typeof value !== "object"){
                        if(value == ""){
                            html2 += "<li>";
                            html2 +=  key;
                            html2 += "</li>";
                        }
                        else{
                            html2 += "<li><span class='caret2'>";
                            html2 += key;
                            html2 += "</span>";
                            html2 += "<ul class='nested'><li>";
                            html2 += value;
                            html2 += "</li></ul></li>";
                        }
                    }
                    else{
                        html2 += "<li><span class='caret2'>" + key + "</span>";
                        html2 += arborescence2(value);
                        html2 += "</li>";
                    }
                });

                html2 += "</ul>";
                return html2;
            }

            $(function constructionArborescence(){

                $("#projet").append(arborescence({!!$arborescence_projet!!}));



            });

</script>


@endsection
