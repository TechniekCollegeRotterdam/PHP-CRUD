<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Toon leverancier</title>
</head>
<body>
    <?php
        // controleren of de gebruiker afkomt van het vorige scherm
        // Dat weet je doordat hij dan daar de submit knop heeft ingedrukt
        if (!isset($_POST["submitdelsuppl"]) && !isset($_POST["submt-upd-del-supp"]))
        {
            header("Refresh: 4, url=upd-getpk.php");
            echo "<h2>Je bent hier niet op de juiste manier gekomen!</h2>";
            exit();
        }

        // Formulierveld ophalen naar een variabele en gelijk opschonen bij invoer lev.nr
        if (isset($_POST["submitdelsuppl"]))
        {
            $supp_pk = test_input($_POST["supp_pk"]);
            $return_prog = "del-getpk.php";
        } else
        {
            $supp_pk = test_input($_POST["sel-supp-pk"]);
            $return_prog = "upd-del-selpk.php";
        }
        if (!is_numeric($supp_pk))
        {
            header("Refresh: 4, url=$return_prog");
            echo "<h2>Je moet een nummer opgeven!!</h2>";
            exit();
        }

        // Controleren of de opgegeven Primary Key daadwerkelijk aanwezig is in de database
        // Hiervoor doe je een SELECT op de gewenste tabel.

        // Pas na alle controles bouw je de header (met navigatie) op.

        include "header.php";
        require_once "dbconnect.php";

        try 
        {
            $sQuery = "SELECT * FROM supplier WHERE id = :supp_pk";
            $oStmt = $db->prepare($sQuery);
            $oStmt->bindValue(":supp_pk", $supp_pk);
            $oStmt->execute();

            /* Wanneer er twee of meer records gevonden worden, is er iets fout in de database. De primary key moet
               uniek zijn.
               Wanneer er géén record gevonden worden, bestaat de opgegeven primary key niet.
            */
            if ($oStmt->rowCount() <> 1) 
            {
                header("Refresh: 4, url=upd-getpk.php");
                echo "<h2>Het opgegeven leveranciersnummer bestaat niet!</h2>";
                exit();
            }
        } catch (PDOException $e) 
        {
            $sMsg = '<p> 
                        Regelnummer: ' . $e->getLine() . '<br /> 
                        Bestand: ' . $e->getFile() . '<br /> 
                        Foutmelding: ' . $e->getMessage() . ' 
                    </p>';
    
            trigger_error($sMsg);
            die();
        }

        // Haal nu de gegevens op van het éne record dat is gevonden.
        $dataSupplier = $oStmt->fetch(PDO::FETCH_ASSOC);
        
        /* alle gegevens van de gewenste supplier staan nu in de named array $dataSupplier.
           Je stopt nu het werken met PHP om het formulier gewoon in HTML te kunnen tonen.

           Elk veld in het formulier wordt gevuld met gegevens uit de $dataSupplier. 
           Dat gebeurt telkens met een klein stukje PHP waarin de value van het veld met "echo" wordt gevuld.

           LET OP: bij elke value staat ook een dubbele aanhalingsteken openen, dat na het stukje PHP wordt
           afgesloten. Dat is noodzakelijk omdat anders de input bij de eerste spatie wordt afgebroken. Zonder
           de aanhalingstekens zou van een bedrijfsnaam 'Monster Transport' alleen het 'Monster' te zien zijn.

           Tot slot: omdat het gaat om het verwijderen van gegevens, mag de gebruiker de velden niet wijzigen. Alle
           velden zijn daarom readonly.
        */
   ?>
        <h2 class="centering">Wijzigen leverancier</h2>
        <form action="update_supplier.php" method="post" class="tabledisp">
            <input type="hidden" name="supp_pk" value="<?php echo $supp_pk; ?>" >

            <fieldset class="tbodyflex">
                <label for="supp_company">Naam leverancier : </label>
                <input type="text" name="supp_company" required readonly value="<?php echo $dataSupplier["company"]; ?>" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_streetaddress">Adres leverancier : </label>
                <input type="text" name="supp_streetaddress" readonly value="<?php echo $dataSupplier["streetaddress"]; ?>" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_zipcode">Postcode : </label>
                <input type="text" name="supp_zipcode" readonly value="<?php echo $dataSupplier["zipcode"]; ?>" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_city">Vestigingsplaats : </label>
                <input type="text" name="supp_city" required readonly value="<?php echo $dataSupplier["city"]; ?>" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_country">Land : </label>
                <input type="number" name="supp_country" required readonly value="<?php echo $dataSupplier["idcountry"]; ?>" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_email">Email adres : </label>
                <input type="email" name="supp_email" readonly value="<?php echo $dataSupplier["emailaddress"]; ?>" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_domain">Domeinnaam : </label>
                <input type="text" name="supp_domain" readonly value="<?php echo $dataSupplier["domain"]; ?>" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_telephone">Telefoonnummer : </label>
                <input type="text" name="supp_telephone" readonly value="<?php echo $dataSupplier["telephonenumber"]; ?>" >
            </fieldset>
    <!-- Een "reset" knop (leeg maken van het formulier) heeft hieronder geen zin. Dan zijn alle gegevens
         van de leverancier verdwenen. Het is daarom beter om terug te keren naar het eerste formulier. daar
         kan de gebruiker de gegevens opnieuw opvragen. 
         Bij het openen van het programma is het aanleverende programma vastgelegd in variabele $return_prog -->
            <fieldset>
                <button type="submit" formaction="<?php echo $return_prog; ?>">Breek af</button>
                <input type="submit" value="Verwerk" name="supp_deletebtn">
            </fieldset>
        </form>


    
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