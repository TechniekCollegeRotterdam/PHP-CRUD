<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Wijs supplier aan</title>
</head>
<body>
    <?php
        include "header.php";
    ?>
    <form action="upd_checkpk.php" method="post">
        <label for="supp_pk">Leveranciersnummer : </label>
        <input type="number" name="supp_pk" required>
        <input type="reset" value="Maak leeg">
        <input type="submit" value="Zoek op" name="submitbtnsuppl">
    </form>
</body>
</html>