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

        /*
        Vervolgens controleer je alle invoervelden:
        - zijn alle verplichte velden ingevuld
        - hebben alle velden de juist informatie
        De verplichte velden zijn: company, city, country
        De informatie moet zijn:
            - company: alleen letters, cijfers en spaties
            - streetaddress: alleen letters, cijfers en spaties
            - zipcode: alleen letters, cijfers en spaties
            - city: alleen letters en spaties
            - country: moet een bestaand land zijn
            - email: moet een correct email-adres zijn
            - domain: moet een geldige URL zijn
            - telefoon: alleen cijfers, streepjes en spaties
        */

        /*
        Alle foutmeldingen worden verzameld in een array $errorMsg. Deze wordt hieronder aangemaakt
        */
        $errorMsg = [];

        if (empty($supp_company))
        {
            $errorMsg[] = "De leveranciersnaam mag niet leeg zijn";
        }
        if (empty($supp_city))
        {
            $errorMsg[] = "De vestigingsplaats mag niet leeg zijn";
        }
        if (empty($supp_country))
        {
            $errorMsg[] = "Het land mag niet leeg zijn";
        }

        if (!check_alfanum($supp_company))
        {
            $errorMsg[] = "De leveranciersnaam mag alleen letters, cijfers en spaties bevatten";
        }

        if (!check_alfanum($supp_streetaddress))
        {
            $errorMsg[] = "Het adres mag alleen letters, cijfers en spaties bevatten";
        }

        if (!check_alfanum($supp_zipcode))
        {
            $errorMsg[] = "De postcode mag alleen letters, cijfers en spaties bevatten";
        }

        if (!check_alfabet($supp_city))
        {
            $errorMsg[] = "De vestigingsplaats mag alleen letters en spaties bevatten";
        }

        // Controleer of het aangegeven land voorkomt in de tabel country
        try
        {
            $sQuery = "SELECT * FROM country WHERE idcountry = :cntry";
            $oStmt = $db->prepare($sQuery);
            $oStmt->bindValue(":cntry", $supp_country);
            $oStmt->execute();
    
            if ($oStmt->rowCount() <> 1) 
            {
                $errorMsg[] = "Het land moet een geldig land zijn";
            }
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
        
        if (!filter_var($supp_email, FILTER_VALIDATE_EMAIL)) 
        {
            $errorMsg[] = "Het emailadres moet een geldig email-adres zijn";
        }

        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$supp_domain)) 
        {
            $errorMsg[] = "De domeinnaam moet een geldige URL vormen";
        }

        if (!check_alfanum($supp_telephone))
        {
            $errorMsg[] = "Het telefoonnummer mag alleen letters, cijfers en spaties bevatten";
        }

        /* 
        Alle controles zijn geweest. Als $errorMsg leeg is, zijn er geen fouten gevonden.
        In dat geval schrijf je de wijzigingen naar de database.
        Anders stuur je de foutmeldingen naar het scherm en keer je terug naar het formulier.
        */
        if (empty($errorMsg))
        {
            try
            {
                $sQuery = "UPDATE `supplier` SET `company`=:scomp,
                                                 `streetaddress`=:saddr,
                                                 `zipcode`=:szip,
                                                 `city`=:scity,
                                                 `country`=:scntry,
                                                 `emailaddress`=:seml,
                                                 `domain`=:sdom,
                                                 `telephonenumber`=:stel 
                                    WHERE `id` = :spk";
                $oStmt = $db->prepare($sQuery);
                $oStmt->bindValue(":spk", $supp_pk);
                $oStmt->bindValue(":scomp", $supp_company);
                $oStmt->bindValue(":saddr", $supp_streetaddress);
                $oStmt->bindValue(":szip", $supp_zipcode);
                $oStmt->bindValue(":scity", $supp_city);
                $oStmt->bindValue(":scntry", $supp_country);
                $oStmt->bindValue(":seml", $supp_email);
                $oStmt->bindValue(":sdom", $supp_domain);
                $oStmt->bindValue(":stel", $supp_telephone);

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
            echo "<br><h2>Gegevens gewijzigd</h2><br>";
            echo "<h2>Je keert nu terug naar de thuispagina</h2><br>";
        }
        else
        {
            header("Refresh: 6, url=index.php");
            include "header.php";
            echo "<pre>";
            print_r($errorMsg);
            echo "</pre>";
            echo "<br><h2>Je keert nu terug naar de thuispagina</h2>";
        }
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
        function check_alfanum($inpData)
        {
            if (preg_match("/^[a-zA-Z0-9-' ]*$/",$inpData)) 
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        function check_alfabet($inpData)
        {
            if (preg_match("/^[a-zA-Z-' ]*$/",$inpData)) 
            {
                return true;
            }
            else
            {
                return false;
            }
        }


    ?>    

</body>
</html>