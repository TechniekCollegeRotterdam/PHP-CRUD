<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Voeg leverancier toe</title>
</head>
<body>
    <?php

        include "header.php";
   ?>
        <h2 class="centering">Toevoegen leverancier</h2>
        <form action="create_supplier.php" method="post" class="tabledisp">
            <fieldset class="tbodyflex">
                <label for="supp_company">Naam leverancier : </label>
                <input type="text" name="supp_company" required >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_streetaddress">Adres leverancier : </label>
                <input type="text" name="supp_streetaddress" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_zipcode">Postcode : </label>
                <input type="text" name="supp_zipcode" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_city">Vestigingsplaats : </label>
                <input type="text" name="supp_city" required >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_country">Land : </label>
                <input type="number" name="supp_country" required >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_email">Email adres : </label>
                <input type="email" name="supp_email" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_domain">Domeinnaam : </label>
                <input type="text" name="supp_domain" >
            </fieldset>
            <fieldset class="tbodyflex">
                <label for="supp_telephone">Telefoonnummer : </label>
                <input type="text" name="supp_telephone" >
            </fieldset>
            <fieldset>
                <input type="reset" value="Maak leeg" >
                <input type="submit" value="Voeg toe" name="crea_nw_suppl">
            </fieldset>
        </form>

</body>
</html>