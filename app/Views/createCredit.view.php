<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="shortcut icon" href="assets/favicon.ico">
    <title>Verleih Erfassung</title>
</head>

<body>

    <?php
    include("nav.view.php");
    ?>

    <form action="create" method="POST">
        <fieldset>
            <legend>Personal Daten</legend>

            <label for="Name">Name:</label>
            <input type="text" name="name" id="name" require><br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" require><br><br>

            <label for="telefon">Telefon:</label>
            <input type="text" name="telefon" id="telefon"><br><br>
        </fieldset>
        <fieldset>
            <legend>Verleih Daten</legend>
            <label for="raten">Anzahl Raten:</label>
            <input type="text" name="raten" id="raten" require><br><br>
            <label id="returnDate">Rückzahlungsdatum: </label><br><br>
            <label for="creditPackage">Kredit Paket:</label>
            <input type="text" name="creditPackage" id="creditPackage" require>
        </fieldset>
        <button type="submit" name="form-submit">Kreditverleih erfassen</button>
    </form>
    <script src="public/js/clientSideValidation.js"></script>
    <script>
    window.addEventListener("load", function() {
        document.querySelector('#raten').addEventListener('change', function(evt) {
            const timeElapsed = Date.now() + ((document.getElementById("raten").value * 15) * 86400000);
            const date = new Date(timeElapsed).toLocaleDateString();
            document.getElementById("returnDate").textContent = ("Rückzahlungsdatum: " + date);
        });
    });
    </script>
</body>

</html>