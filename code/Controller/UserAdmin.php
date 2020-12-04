<?php

include("DataBase.php");

class UserAdmin extends User
{
    public function consultUser($_id_user)
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $query="SELECT * FROM users WHERE id_user=?;";
        $stmt=$con->prepare($query);
        $stmt->execute([$_id_user]);
        $result=$stmt->fetchAll();

        echo 'pseudo :', $result['matricule_user'];
        echo 'email :', $result['email_user '];
        echo 'prenom :', $result['name_user'];
        echo 'nom :', $result['lastname_user'];
        echo 'numero :', $result['phone_user'];
        closeCon();
    }
    public function createUser($_matricule_user,$_email_user,$_password_user,$_name_user,$_lastname_user,$_phone,$_isAdmin_user)
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $query="INSERT INTO users (matricule_user,email_user,password_user,name_user,lastname_user,phone_user,isAdmin_user) VALUES (?,?,?,?,?,?,?);";
        $stmt=$con->prepare($query);
        $stmt->execute([$_matricule_user,$_email_user,$_password_user,$_name_user,$_lastname_user,$_phone,$_isAdmin_user]);
        closeCon();
    }

    /* */
    public function deleteEquipment($_ref_equipDel)
    {
        $bdd = new DataBase();
        $con = $bdd->getCon();
        $con->beginTransaction();
        try
        {
            $requestDelete = " DELETE FROM device WHERE isAvailable = TRUE AND ref_equip = ? ; ";
            $myStatement = $con->prepare($requestDelete);
            $myStatement->execute([$_ref_equipDel]);
            $con->commit();
        }
        catch(PDOExecption $e)
        {
            $con->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        closeCon();
    }

    public function modifyEquipment($_ref_equip)
    {

    }

    public function createEquipment($_ref_equip)
    {

    }

    public function modifyRole($_id_user,$_new_isAdmin_user)
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $query="UPDATE users SET isAdmin_user=? WHERE id_user=?;";
        $stmt=$con->prepare($query);
        $stmt->execute([$_new_isAdmin_user,$_id_user]);
        closeCon();

    }
    public function modifyAnyProfile($_id_role,$_matricule_user,$_email_user,$_password_user,$_name_user,$_lastname_user,$_phone,$_isAdmin_user)
    {
        $bdd= new DataBase();
        $con= $bdd->getCon();
        $query="UPDATE users SET matricule_user=?,email_user=?,password_user=?,name_user=?,lastname_user=?,phone_user=?,isAdmin_user=? WHERE id_role=?;";
        $stmt=$con->prepare($query);
        $stmt->execute([$_matricule_user,$_email_user,$_password_user,$_name_user,$_lastname_user,$_phone,$_isAdmin_user,$_id_role]);
        closeCon();
    }

}