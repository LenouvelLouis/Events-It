<!DOCTYPE HTML>
<html lang="fr">
<meta charset="UTF-8">

<head>
    <link rel="stylesheet" href="./vue/ajoutfilm/ajoutfilm.css">
</head>
<div>
<?php require("./vue/navbar/nav.tpl"); ?>
<div class="barre">
    <a href="./?path=pages/accueil">Accueil</a>/
    <a id="links-film" href="./?path=pages/ajoutfilm">Ajout de film</a>
</div>
<form action="./?path=film/ajoutfilm" id="form-page" method="post" enctype="multipart/form-data">
<div class="container_ajout_film">

    <div class="container_affiche_film">
        <label> Affiche du film <span class="highlight">*</span> </label>
        <div class="image-container">
            <img src="" alt="Image du film">
        </div>
        <span id="delete-img" onclick="deleteimg()"><i class="fa-solid fa-xmark"></i></span>
        <div>
                <input type="file" id="imageChoisi" name="image" accept="image/*" class="container_affiche_film_bouton" onchange="ajoutimg(event)">
        </div>
    </div>
    <div class="container_info_film" >
        <label for="titre"> Nom du film  <span class="highlight">*</span> </label>
        <input name="titre" type="text" id="titre" required></input>

        <label for="genre"> Genre <span class="highlight">*</span> </label>
        <input name="genre" type="text" id="genre" required></input>

        <label for="duree"> Durée (Heures : minutes)<span class="highlight">*</span> </label>
        <input name="duree" type="time" id="durée" required></input>

        <div class ="container_espace">
            <label for="realisateur"> De <span class="highlight">*</span> </label>
            <input name="realisateur" type="text" id="realisateur" required></input>

            <label for="acteurs"> Avec </label>
            <input name="acteurs" type="text" id="acteurs"</input>
        </div>
    </div>
    <div class="container_synopsis_film">
        <label for="synopsis"> Synopsis <span class="highlight">*</span></label>
        <textarea id="synopsis" name="synopsis" placeholder="Entrez le synopsis ici..." required></textarea>
        <button class="button-ajout-film" type="submit">Ajout du film</button>
        <a class="icon modif" href="" ><i class="fa-solid fa-gear "></i><a>
                <a class="icon delete" href="" ><i class="fa-solid fa-trash"></i><a>
                        <a class="icon delete" href="" ><i class="fa-solid fa-trash"></i><a>
                                <a class="icon cancel" href=""  ><i class="fa-solid fa-ban"></i><a>
    </div>
</div>
</form>
<div class="seance-films">
<center><h3>Listes des séances</h3></center>
<?php if(isset($_SESSION['status']) && ($_SESSION['status'] == "admin" || $_SESSION['status'] == "gestionnaire") ) {
            echo("<div class='btn-ajoutseance'><a class='plus' href='./?path=pages/ajoutseance'><i class='fa-solid fa-plus'></i> Ajouter une séance</a></div>");
}
?>
<div class="display_flex_sceance">
    <div id="films-container"></div>
</div>
</div>
<?php require("./vue/footer/footer.tpl"); ?>
</body>
<script src="./vue/ajoutfilm/ajoutfilm.js"></script>
</html>