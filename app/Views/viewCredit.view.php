<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verleih Ansicht</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <style>
        * {
            font-family: Arial;
        }

        table {
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        tr:first-child {
            background-color: #f2f2f2;
        }

        td a,
        a:visited {
            color: hsl(197, 0%, 23%);
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
            cursor: pointer;
        }

        button {
            padding: 20px;
            margin: 4px 0px;
            color: white;
            background-color: hsl(197, 100%, 23%);
            text-decoration: none;
            box-shadow: 2px 3px 5px gray;
            transition: 0.3s;
            border-radius: 8px;
            border: none;
        }

        button:hover {
            background-color: hsl(197, 100%, 33%);
            cursor: pointer;
        }
    </style>

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
                <td><input type="checkbox" id="myCheck" onclick="myFunction()"><?= strtotime(strtotime($credit['created_at']) + ((15 * $credit['anzahl_raten']) * 24 * 60 * 60)) >= strtotime(time()) ? "🌞" : "⚡" ?></td>
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
    <a id="text" style="display: none;" href="sync?id=<?= $credit['verleihID'] ?>"><button><i class="fas fa-sync-alt"></i> Refresh</button></a>
    <script src="../public/js/clientSideValidation.js"></script>
</body>

</html>