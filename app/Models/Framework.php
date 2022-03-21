<?php
class Framework
{
    public $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function create($name, $email, $telefon, $raten, $creditPackage)
    {
        $isValid = true;
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        if (strpos($email, "@") === false) {
            $isValid = false;
        }

        $telefon = htmlspecialchars($_POST['telefon']);
        if (preg_match("[^0-9\/()\+\-\s]", $telefon) !== 0) {
            $isValid = false;
        }

        $raten = htmlspecialchars($_POST['raten']);
        if ($raten < 1 || $raten > 10) {
            $isValid = false;
        }

        $creditPackage = htmlspecialchars($_POST['creditPackage']);
        if ($creditPackage < 1 || $creditPackage > 40) {
            $isValid = false;
        }

        if ($isValid) {
            $statement = $this->db->prepare("INSERT INTO `verleihe` (name, email, telefon, anzahl_raten, fk_kreditpaketID, created_at) VALUES 
        (:name, :email, :telefon, :anzahl_raten, :fk_kreditpaketID, :created_at)");
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':telefon', $telefon, PDO::PARAM_STR);
            $statement->bindParam(':anzahl_raten', $raten, PDO::PARAM_STR);
            $statement->bindParam(':fk_kreditpaketID', $creditPackage, PDO::PARAM_STR);
            $statement->bindParam(':created_at', date("Y/m/d"), PDO::PARAM_STR);
            $statement->execute();
        }
        return $isValid;
    }

    public function update($name, $email, $telefon, $kredit_packet, $verleih_status, $id)
    {
        $isValid = true;
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        if (strpos($email, "@") === false) {
            $isValid = false;
        }

        $telefon = htmlspecialchars($_POST['telefon']);
        if (preg_match("[^0-9\/()\+\-\s]", $telefon) !== 0) {
            $isValid = false;
        }

        $raten = htmlspecialchars($_POST['raten']);
        if ($$verleih_status !== null) {
            $isValid = false;
        }

        $creditPackage = htmlspecialchars($_POST['kredit_packet']);
        if ($kredit_packet < 1 || $kredit_packet > 40) {
            $isValid = false;
        }

        if ($isValid) {
            $statement = $this->db->prepare('UPDATE `verleihe` SET name = :name, email = :email, telefon = :telefon, fk_kreditpaketID = :fk_kreditpaketID, verleih_status = :verleih_status
        WHERE verleihID = :id');
            $statement->bindParam(':name', $name);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':telefon', $telefon);
            $statement->bindParam(':fk_kreditpaketID', $kredit_packet);
            $statement->bindParam(':verleih_status', $verleih_status);
            $statement->bindParam(':id', $id);
            $statement->execute();
        }
        return $isValid;
    }

    public function sync($id)
    {
        $statement = $this->db->prepare('UPDATE `verleihe` SET verleih_status=1 WHERE verleihID = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
}