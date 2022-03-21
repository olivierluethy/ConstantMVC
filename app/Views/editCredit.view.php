<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="shortcut icon" href="assets/favicon.ico">
    <title>Verleih Bearbeitung</title>
</head>

<body>

    <?php
    include("nav.view.php");
    ?>

    <form action="update?id=<?= $credit[0][0] ?>" method="POST">
        <fieldset>
            <legend>Personal Daten</legend>
            <label for="Name">Name:</label>
            <input type="text" name="name" id="name" value="<?= $credit[0][1] ?>" require><br><br>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?= $credit[0][2] ?>" require><br><br>

            <label for="telefon">Telefon:</label>
            <input type="text" name="telefon" id="telefon" value="<?= $credit[0][3] ?>" require><br><br>

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
    <script src="public/js/clientSideValidation.js"></script>
</body>

</html>