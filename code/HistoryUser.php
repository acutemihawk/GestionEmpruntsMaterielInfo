<?php
require_once("Controller/control-session.php");
require_once("Controller/UserController.php");
require_once("ControllerDAO/UserDAO.php");
ob_start();

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 && isset($_GET['id_user_toDisplay']) || $_GET['id_user_toDisplay'] == $_SESSION['id_user'] && isset($_GET['id_user_toDisplay'])) {
    if (!UserDAO::userExists($_GET['id_user_toDisplay'])) {
        ob_end_clean();
        header('Location: DashBoard.php');
    }
    try {
        $finalStatement = UserDAO::getHistory($_GET['id_user_toDisplay']);

        if (isset($finalStatement) && $finalStatement != null) {
            if ($finalStatement->rowCount() > 0) {
                while ($donnees = $finalStatement->fetch()) {
                    require "view/historyUser.view.php";

                }
            } else {
                echo "<p>L'utilisateur n'a emprunté aucun objet jusqu'à présent.</p>";
            }
        }

    } catch (Exception $e) {
        echo "<p>" . $e->getMessage() . "</p>";
    }


} else {
    echo "<p>Erreur veuillez contacter le support</p>";
}

