<?php

class FrameworkController{
    public function refresh(){
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT * FROM verleihe WHERE verleih_status=0');
        $statement->execute();
        $credits = $statement->fetchAll();

        require 'app/Views/viewCredit.view.php';
    }

    public function create(){
        $title = '';
        $pdo = connectDatabase();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $telefon = $_POST['telefon'];

            $raten = $_POST['raten'];
            $creditPackage = $_POST['creditPackage'];

            $statement = $pdo->prepare("INSERT INTO `verleihe` (name, email, telefon, anzahl_raten, fk_kreditpaketID) VALUES 
            (:name, :email, :telefon, :anzahl_raten, :fk_kreditpaketID)");
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':telefon', $telefon, PDO::PARAM_STR);
            $statement->bindParam(':anzahl_raten', $raten, PDO::PARAM_STR);
            $statement->bindParam(':fk_kreditpaketID', $creditPackage, PDO::PARAM_STR);
            $statement->execute();

            header('Location: http://localhost/Framework/view'); // Besser: header('Location: http://localhost/deinProjekt/task);
        }

        require 'app/Views/createCredit.view.php';
    }

    public function update(){
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $telefon = $_POST['telefon'];

            $kredit_packet = $_POST['kredit_packet'];
            $verleih_status = $_POST['verleih_status'];

            $statement = $pdo->prepare('UPDATE `verleihe` SET name = :name, email = :email, telefon = :telefon, fk_kreditpaketID = :fk_kreditpaketID, verleih_status = :verleih_status
            WHERE verleihID = :id');
            $statement->bindParam(':name', $name);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':telefon', $telefon);
            $statement->bindParam(':fk_kreditpaketID', $kredit_packet);
            $statement->bindParam(':verleih_status', $verleih_status);
            $statement->bindParam(':id', $id);
            $statement->execute();
            // var_dump($statement);
            // var_dump($_POST);
            header('Location: http://localhost/uek_projektarbeit/credit/view');
        }else{
        $statement = $pdo->prepare('SELECT * FROM verleihe WHERE verleihID = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $credit = $statement->fetchAll();
        }
        require 'app/Views/editCredit.view.php';
    }

    public function sync(){
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $pdo->prepare('UPDATE `verleihe` SET verleih_status=1 WHERE verleihID = :id');
            $statement->bindParam(':id', $id);
            $statement->execute();
            // var_dump($statement);
            // var_dump($_POST);
            header('Location: http://localhost/uek_projektarbeit/credit/view');

            $statement = $pdo->prepare('SELECT * FROM verleihe WHERE verleihID = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $credit = $statement->fetchAll();

         require 'app/Views/editCredit.view.php';
    }
}