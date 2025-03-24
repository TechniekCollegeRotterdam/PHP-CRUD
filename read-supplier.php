<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css">
	<title>Read Supplier</title>
</head>

<body>
	<?php
	include "header.php";
	require_once "dbconnect.php";
	try {
		$sQuery = "SELECT * FROM supplier";
		$oStmt = $db->prepare($sQuery);
		$oStmt->execute();

		if ($oStmt->rowCount() > 0) {
			echo '<table>';
			echo '<thead>';
			echo '<td>Lev.nr.</td>';
			echo '<td>Bedrijfnaam</td>';
			echo '<td>Adres</td>';
			echo '<td>Postcode</td>';
			echo '<td>Woonplaats</td>';
			echo '<td>Land</td>';
			echo '<td>Email</td>';
			echo '<td>Domein</td>';
			echo '<td>Telefoon</td>';
			echo '</thead>';
			while ($aRow = $oStmt->fetch(PDO::FETCH_ASSOC)) {
				echo '<tr>';
				echo '<td>' . $aRow['id'] . '</td>';
				echo '<td>' . $aRow['company'] . '</td>';
				echo '<td>' . $aRow['streetaddress'] . '</td>';
				echo '<td>' . $aRow['zipcode'] . '</td>';
				echo '<td>' . $aRow['city'] . '</td>';
				echo '<td>' . $aRow['country'] . '</td>';
				echo '<td>' . $aRow['emailaddress'] . '</td>';
				echo '<td>' . $aRow['domain'] . '</td>';
				echo '<td>' . $aRow['telephonenumber'] . '</td>';
				echo '</tr>';
			}
			echo '</table>';
		} else {
			echo 'Helaas, geen gegevens bekend';
		}
	} catch (PDOException $e) {
		$sMsg = '<p> 
					Regelnummer: ' . $e->getLine() . '<br /> 
					Bestand: ' . $e->getFile() . '<br /> 
					Foutmelding: ' . $e->getMessage() . ' 
				</p>';

		trigger_error($sMsg);
		die();
	}
	$db = null;
	?>

</body>
</html>