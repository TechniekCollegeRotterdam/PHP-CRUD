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
    <h2 class="centering">Welke leverancier wilt u wijzigen?</h2>
    <form action="upd_checkpk.php" method="post" class="tabledisp">
        <label for="supp_pk">Leveranciersnummer : </label>
        <input type="number" name="supp_pk" required>
        <input type="reset" value="Maak leeg">
        <input type="submit" value="Zoek op" name="submitbtnsuppl">
    </form>
</body>
</html>