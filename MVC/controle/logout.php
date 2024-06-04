<?php
/**
 * Fonction de déconnexion
 * @return void
 */
function deconnexion(){
    session_destroy();
    $defaultUrl = "./?path=pages/accueil";
    $referrerUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $defaultUrl;
    // Liste des pages à exclure
    $excludedPages = ["profile", "ajoutfilm", "ajoutseance","statseance"];

    foreach ($excludedPages as $page) {
        if (strpos($referrerUrl, $page) !== false) {
            $referrerUrl = $defaultUrl;
            break;
        }
    }

    header("Location:" . $referrerUrl);
}
?>