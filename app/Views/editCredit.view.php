<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verleih Bearbeitung</title>
</head>

<body>
    <form action="update?id=<?= $credit[0][0] ?>" method="post">
        <fieldset>
            <legend>Personal Daten</legend>
            <label for="Name">Name:</label>
            <input type="text" name="name" value="<?= $credit[0][1] ?>"><br><br>

            <label for="email">Email:</label>
            <input type="text" name="email" value="<?= $credit[0][2] ?>"><br><br>

            <label for="telefon">Telefon:</label>
            <input type="text" name="telefon" value="<?= $credit[0][3] ?>"><br><br>

        </fieldset>
        <fieldset>
            <legend>Verleih Daten</legend>
            <label for="raten">Raten: <?= $credit[0][4] ?></label><br><br>
            <label for="kredit_packet">Kredit-Paket:</label>
            <input type="text" name="kredit_packet" value="<?= $credit[0][5] ?>"><br><br>

            <label for="verleih_status">Verleih-Status:</label>
            <input type="text" name="verleih_status" value="<?= $credit[0][6] ?>"><br><br>
        </fieldset>
        <button type="submit" name="form-submit">Verleih bearbeiten</button>
    </form>
    <script src="../public/js/clientSideValidation.js"></script>
</body>

</html>