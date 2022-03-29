<?php

class FrameworkController{
    public function index(){
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT * FROM Person');
        $statement->execute();
        $daten = $statement->fetchAll();

        require 'app/Views/viewData.view.php';
    }

    public function create(){
        $pdo = connectDatabase();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $vorname = $_POST['vorname'];
            $email = $_POST['email'];

            $statement = $pdo->prepare("INSERT INTO `Person` (name, vorname, email) VALUES 
            (:name, :vorname, :email)");
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':vorname', $vorname, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->execute();

            header('Location: http://localhost/Constant_Framework/');
        }

        require 'app/Views/createData.view.php';
    }

    public function update(){
        $id = $_GET['id'];

        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $vorname = $_POST['vorname'];
            $email = $_POST['email'];

            $statement = $pdo->prepare('UPDATE `Person` SET name = :name, vorname = :vorname, email = :email WHERE id = :id');
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':vorname', $vorname, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':id', $id, PDO::PARAM_STR);
            $statement->execute();
            // var_dump($statement);
            // var_dump($_POST);
            header('Location: http://localhost/Constant_Framework/');
        }else{
            $statement = $pdo->prepare('SELECT * FROM Person WHERE id = :id');
            $statement->bindParam(':id', $id, PDO::PARAM_STR);
            $statement->execute();
            $daten = $statement->fetchAll();
        }
        require 'app/Views/editData.view.php';
    }

    public function delete(){
        $id = $_GET['id'];

        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('DELETE FROM `Person` WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();
        // var_dump($statement);
        // var_dump($_POST);
        header('Location: http://localhost/Constant_Framework/');
    }
}