<?php

$title = "Details de l'equipement";
$erreur = "";

require_once("Controller/control-session.php");
require_once("Model/Equipment.php");
require_once("Controller/EquipmentController.php");
require_once "Controller/Functions.php";
require_once("Controller/UserController.php");
require_once("Controller/BorrowController.php");
ob_start();


if (isset($_GET['ref_equip']) && $_GET['ref_equip'] != null) {
    $currentEquipment = null;

    try {
        $equipmentController = new EquipmentController();
        $equipmentController->loadEquipmentFromDDB($_GET['ref_equip']);
        $currentEquipment = $equipmentController->getEquipment();

        if (isset($_POST['reserveEquipment']) && isset($_POST['dateRes']) && isset($_POST['quantiteNumber']) && isset($equipmentController) && $equipmentController != null) {

            $dateFinBorrow = $_POST['dateRes'];
            $quantite_equip = $_POST['quantiteNumber'];

            $userController = new UserController($_SESSION['id_user']);
            try {
                if ($currentEquipment != null) {
                    $userController->startBorrow($equipmentController, $currentEquipment->getRefEquip(), $dateFinBorrow, $quantite_equip, $_SESSION['id_user']);
                    $erreur = "Réservation réussie.";
                }
            } catch (Exception $e) {
                $erreur = "<p>" . $e->getMessage() . "</p>";
            }
            ob_end_clean();


        }
        ?>

        <?php
        //INCLUDE VIEW:

        include_once("view/detailEquipment.view.php");


        ?>


        <?php


    } catch (Exception $e) {
        ob_end_clean();
        header("refresh:3;url=DashBoard.php");
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<p> Redirection dans 3 secondes.. </p>";
    }
} else {
    ob_end_clean();

    header('Location: DashBoard.php');

}


