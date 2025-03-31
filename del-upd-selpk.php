<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css">
	<title>Toon Leveranciers</title>
</head>

<body>
	<?php
	require_once "dbconnect.php";
	include "header.php";
	try {
		$sQuery = "SELECT * FROM supplier";
		$oStmt = $db->prepare($sQuery);
		$oStmt->execute();

		echo "<h2 class='centering'>Overzicht leveranciers</h2>";
		if ($oStmt->rowCount() > 0) {
			echo '<table class="tabledisp2">';
			echo '<thead>';
			echo '<td>Lev.nr.</td>';
			echo '<td>Lev.naam</td>';
			echo '<td>Adres</td>';
			echo '<td>Woonplaats</td>';
			echo '<td>Website</td>';
            echo '<td>Actieknop</td>';
			echo '</thead>';
			while ($aRow = $oStmt->fetch(PDO::FETCH_ASSOC)) {
				echo '<tr><form action="upd_checkpk.php" method="POST">';
				echo '<td><input type="number" readonly name="sel-supp-pk" value="' . $aRow['id'] . '"></td>';
				echo '<td>' . $aRow['company'] . '</td>';
				echo '<td>' . $aRow['streetaddress'] . '</td>';
				echo '<td>' . $aRow['city'] . '</td>';
				echo '<td>' . $aRow['domain'] . '</td>';
				echo '<td><input type="submit" value="Wijzig" name="submt-sel-supp">';
				echo '<button type="submit" formaction="del_checkpk.php">Verwijder</button></td>';
				echo '</form></tr>';
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
	}
	$db = null;
	?>


</body>
</html>