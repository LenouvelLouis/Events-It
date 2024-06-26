<?php

function ajoutcinema(){

    require './controle/utilisateur.php';
    closedNotifier();

    $nom = isset($_POST['nom_cinema']) ? $_POST['nom_cinema'] : '';
    $adresse = isset($_POST['lieu_cinema']) ? $_POST['lieu_cinema'] : '';
    $telephone = isset($_POST['telephone_cinema']) ? $_POST['telephone_cinema'] : '';
    $email = isset($_POST['mail_cinema']) ? $_POST['mail_cinema'] : '';
    $indoor = isset($_POST['Indoor'])?($_POST['Indoor']):'';
    $outdoor = isset($_POST['Outdoor'])?($_POST['Outdoor']):'';
    $handicape = isset($_POST['Handicape']) ? ($_POST['Handicape'] == 'on' ? 1 : 0) : 0;
    $sourd = isset($_POST['Sourd']) ? ($_POST['Sourd'] == 'on' ? 1 : 0) : 0;
    $malvoyant = isset($_POST['Malvoyant']) ? ($_POST['Malvoyant'] == 'on' ? 1 : 0) : 0;
    $nombreSalles = isset($_POST['nombreSalles'])?($_POST['nombreSalles']):'';
    if($nombreSalles == ''  || $nom == '' || $adresse == '' || $telephone == '' || $email == '' || ($indoor == '' && $outdoor == '')){
        $msgErr = "Veuillez remplir tous les champs";
        $_SESSION['msgErr'] = $msgErr;
        $_SESSION['msgType'] = 'error';
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "./?path=pages/accueil";
        header("Location:" . $url);
        die();
    }

    $regex = "/^[a-zA-Z0-9\s,.'-]{3,}$/";
    if (!preg_match($regex, $adresse)) {
        $msgErr = "Adresse invalide";
        $_SESSION['msgErr'] = $msgErr;
        $_SESSION['msgType'] = 'error';
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "./?path=pages/accueil";
        header("Location:" . $url);
        die();
    }
    if ($indoor == 'on') {
        $typeCine = 1;
    } else {
        $nombreSalles = 1;
        $typeCine = 0;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $nomImage = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];
        $directory = './vue/img/cinemas/';
        $extension = pathinfo($nomImage, PATHINFO_EXTENSION);
        $newNomImage = str_replace(' ', '_', $nom) . '.' . $extension;
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        require './modele/cinemaBD.php';
        if (CinemaAlreadyExist($nom)) {
            $msgErr = "Ce cinéma existe déjà";
            $_SESSION['msgErr'] = $msgErr;
            $_SESSION['msgType'] = 'error';
            $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "./?path=pages/accueil";
            header("Location:" . $url);
            die();
        }
        if(move_uploaded_file($tmpName, $directory . $newNomImage)){
            $idcinema = cinemaToDB($nom, $adresse, $telephone, $email, $typeCine, $handicape, $sourd, $malvoyant, $newNomImage);
            for ($i = 1; $i <= $nombreSalles; $i++) {
                $nomSalle = "Salle " . $i;
                salleToDB($nomSalle, $idcinema);
            }
            $msgAcc = "Cinéma ajouté";
            $_SESSION['msgAcc'] = $msgAcc;
            $_SESSION['msgType'] = 'success';
            $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "./?path=pages/accueil";
            header("Location:" . $url);
        }

    }
    else{
        $msgErr = "Veuillez ajouter une image";
        $_SESSION['msgErr'] = $msgErr;
        $_SESSION['msgType'] = 'error';
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "./?path=pages/accueil";
        header("Location:" . $url);
        die();
    }

}

function getInfoCinema(){
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    require './modele/cinemaBD.php';
    if($id == ''){
        $msgErr = "Cinéma introuvable";
        $_SESSION['msgErr'] = $msgErr;
        http_response_code(401);
        echo json_encode(array('error' => $msgErr));
        return;
    }
    $cinema = getCinema($id);
    if(!$cinema){
        $msgErr = "Cinéma introuvable";
        $_SESSION['msgErr'] = $msgErr;
        $_SESSION['msgType'] = 'error';
        http_response_code(401);
        echo json_encode(array('error' => $msgErr));
        return;
    }
    /*$apiKey = 'AIzaSyCZWKhJ6oeb5R24igcHB0b3DDvwUwkHS9k';

    $address = $cinema['adresse'];
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=' . $apiKey;
    $data = json_decode(file_get_contents($url));
    var_dump($data);
    if ($data->status === 'OK') {
        $placeId = $data->results[0]->place_id;
        $cinema['google_maps_embed_url'] = 'https://www.google.com/maps/embed/v1/place?key=' . $apiKey . '&q=place_id:' . $placeId;
    }*/

    echo json_encode($cinema);

}


?>