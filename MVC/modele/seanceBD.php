<?php

function get_film()
{
    require('./modele/connectSQL.php');
    $sql = "SELECT id, titre FROM `film`";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        $result = $commande->fetchAll(PDO::FETCH_ASSOC);
        echo(json_encode($result));
    } catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die();
    }
}

function get_cinema()
{
    require('./modele/connectSQL.php');
    $sql = "SELECT id, nom, type_cine FROM `cinema`";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        $result = $commande->fetchAll(PDO::FETCH_ASSOC);
        echo(json_encode($result));
    } catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die();
    }
}

function get_salle()
{
    require('./modele/connectSQL.php');
    $sql = "SELECT nom, id_cinéma FROM `salle`";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        $result = $commande->fetchAll(PDO::FETCH_ASSOC);
        echo(json_encode($result));
    } catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die();
    }

}

?>