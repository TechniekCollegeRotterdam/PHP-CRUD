<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Opslaan supplier</title>
</head>
<body>
    <?php
        // controleren of de gebruiker afkomt van het vorige scherm
        // Dat weet je doordat hij dan daar de submit knop heeft ingedrukt
        if (!isset($_POST["supp_applychanges"]))
        {
            header("Refresh: 4, url=upd-getpk.php");
            echo "<h2>Je bent hier niet op de juiste manier gekomen!</h2>";
            exit();
        }

        /* De eerste stap is nu het binnenhalen en opschonen van alle velden van het formulier. Hiervoor gebruik
           de functie 'test-input' die je aan het einde van de <body> toevoegt.
        */
        $supp_pk = $_POST["supp_pk"]; // Dit is niet te wijzigen door de gebruiker, kan rechtstreeks overnemen

        $supp_company = test_input(($_POST["supp_company"]));
        $supp_streetaddress = test_input(($_POST["supp_streetaddress"]));
        $supp_zipcode = test_input(($_POST["supp_zipcode"]));
        $supp_city = test_input(($_POST["supp_city"]));
        $supp_country = test_input(($_POST["supp_country"]));
        $supp_email = test_input(($_POST["supp_email"]));
        $supp_domain = test_input(($_POST["supp_domain"]));
        $supp_telephone = test_input(($_POST["supp_telephone"]));


    ?>

    <?php
        // Hier komen alle functies te staan

        // test_input zorgt voor het opschonen van een veld in een formulier.
        function test_input($inpData)
        {
            $inpData = trim($inpData);
            $inpData = stripslashes($inpData);
            $inpData = htmlspecialchars($inpData);
            return $inpData;
        }

    ?>    


</body>
</html>