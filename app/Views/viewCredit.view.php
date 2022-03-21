<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <title>Verleih Bearbeitung</title>
</head>

<body>

    <?php
    include("nav.view.php");
    ?>

    <h1>Verleihdaten</h1>

    <table>

        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Anzahl Raten</th>
            <th>Kredit Paket</th>
            <th>Verleih erfasst am</th>
            <th>Abgeschlossen</th>
            <th>Bearbeiten</th>
        </tr>

        <?php foreach ($credits as $credit) : ?>
        <tr>
            <td><?= $credit['name'] ?></td>
            <td><?= $credit['email'] ?></td>
            <td><?= $credit['telefon'] ?></td>
            <td><?= $credit['anzahl_raten'] ?></td>
            <td><?= $credit['fk_kreditpaketID'] ?></td>
            <td><?= $credit['created_at'] ?></td>
            <td><input type="checkbox" id="myCheck"
                    onclick="myFunction()"><?= strtotime(strtotime($credit['created_at']) + ((15 * $credit['anzahl_raten']) * 24 * 60 * 60)) >= strtotime(time()) ? "🌞" : "⚡" ?>
            </td>
            <td><a href="update?id=<?= $credit['verleihID'] ?>">Verleih bearbeiten</a></td>
        </tr>
        <?php endforeach; ?>

    </table>

    <script>
    function myFunction() {
        var checkBox = document.getElementById("myCheck");
        var text = document.getElementById("text");
        if (checkBox.checked == true) {
            text.style = "display: block; float: right;"
        } else {
            text.style.display = "none";
        }
    }
    </script>

    <a href="create"><button>Verleih hinzufügen</button></a>
    <a id="text" style="display: none;" href="sync?id=<?= $credit['verleihID'] ?>"><button><i
                class="fas fa-sync-alt"></i> Refresh</button></a>

    <?php
    include("footer.view.php");
    ?>
</body>

</html>