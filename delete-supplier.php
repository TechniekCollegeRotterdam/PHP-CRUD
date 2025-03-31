<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Verwijder supplier</title>
</head>
<body>
    <?php
        // controleren of de gebruiker afkomt van het vorige scherm
        // Dat weet je doordat hij dan daar de submit knop heeft ingedrukt
        if (!isset($_POST["supp_deletebtn"]))
        {
            header("Refresh: 4, url=upd-getpk.php");
            echo "<h2>Je bent hier niet op de juiste manier gekomen!</h2>";
            exit();
        }

        /* De eerste stap is nu het binnenhalen van de primary key van de te verwijderen supplier.
           Aangezien alle velden read-only zijn, hoef je niets te controleren.
        */
        $supp_pk = $_POST["supp_pk"]; // Dit is niet te wijzigen door de gebruiker, kan rechtstreeks overnemen

        /*
            Vervolgens maak je verbinding met de database
        */
        require_once "dbconnect.php";

        try
        {
            $sQuery = "DELETE FROM `supplier` WHERE `id` = :spk";
            $oStmt = $db->prepare($sQuery);
            $oStmt->bindValue(":spk", $supp_pk);

            $oStmt->execute();
        }
        catch(PDOException $e) 
        { 
            $sMsg = '<p> 
                    Regelnummer: '.$e->getLine().'<br /> 
                    Bestand: '.$e->getFile().'<br /> 
                    Foutmelding: '.$e->getMessage().' 
                </p>'; 
                
            trigger_error($sMsg); 
            die();
        }
        header("Refresh: 2, url=index.php");
        include "header.php";
        echo "<br><h2>Gegevens zijn verwijderd</h2><br>";
        echo "<h2>Je keert nu terug naar de thuispagina</h2><br>";
    ?>

</body>
</html>