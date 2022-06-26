<!doctype html>
<html lang="cs">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@600&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


	<meta charset="utf-8">
	<title>gradeyouruni</title>

	<link href="CSS/css-reset-meyer.css" rel="stylesheet" type="text/css">


	<link rel="stylesheet" href="CSS/style.css">

</head>

<body>
	<div id="wrapper">
		<div id="box1">
			<header>
				<a href="index.php">gradeyouruni</a>

			</header>
		</div>

		<div id=photo>
			<img src="IMG/image.png" alt="absolventský klobouk">
		</div>
		<?php

		//________________________________Připojení do databáze___________________________________
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "databazeskol";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		//echo "Connected successfully";
		mysqli_query($conn, "set names 'utf8'");

		//________________________________________________________________________________________


		//------------------------------Session-----------------------------------------------------


		session_start();

		/*
	
echo "<pre>" ;
	print_r ($_SESSION["info"]);
	echo "</pre>";	
		*/

		if (!isset($_SESSION["info"]["idskoly"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["info"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["info"]["nazevfakulty"])) {
			header('Location: index.php');
		}

		if (!isset($_SESSION["info"]["nazevprogramu"])) {
			header('Location: index.php');
		}

		if (!isset($_SESSION["info"]["nazevprogramu2"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["info"]["nazevfakulty2"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["info"]["idskoly2"])) {
			header('Location: index.php');
		}
		if (isset($_POST["next"])) {



			foreach ($_POST as $key => $value) {

				$_SESSION["info"][$key] = $value;
				echo "<pre>";
			}

			$keys = array_keys($_SESSION["info"]);
			if (in_array("next", $keys)) {

				unset($_SESSION["info"]["next"]);
			}

			header("Location: index.php ");
		}


		//-------------------------------------------------------------------------------------
		$idfakulty = $_SESSION["info"]["idfakulty"];
		$idfakulty2 = $_SESSION["info"]["idfakulty2"];
		$idskoly = $_SESSION["info"]["idskoly"];
		$idskoly2 = $_SESSION["info"]["idskoly2"];
		$idprogramu = $_SESSION["info"]["idprogramu"];
		$idprogramu2 = $_SESSION["info"]["idprogramu2"];
		$nazevprogramu2 = $_SESSION["info"]["nazevprogramu2"];
		$nazevprogramu = $_SESSION["info"]["nazevprogramu"];
		$nazevfakulty = $_SESSION["info"]["nazevfakulty"];
		$nazevfakulty2 = $_SESSION["info"]["nazevfakulty2"];
		$nazev = $_SESSION["info"]["nazev"];
		$nazev2 = $_SESSION["info"]["nazev2"];

		?>


		<div id="box3">
			<h1>Podívej se na <span>hodnocení</span> tvé univerzity</h1>
		</div>


		<?php

		print("<div id='table'><table>");
		print("<tr><th></th><th>" . $nazev . " – " . $nazevfakulty . " – " . $nazevprogramu . "</th>");
		print("<th>" . $nazev2 . " – " . $nazevfakulty2 . " – " . $nazevprogramu2 . "</th></tr>");
		print("<tr><td>Celkové hodnocení fakulty</td><td>");

		//--------------------------------------------------------------------------------------------------------------------------------------------------------


		$sql =  "SELECT CAST(AVG(hfakulty) AS DECIMAL(3,2)), CAST(AVG(hzazemi) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` WHERE `bcprogramy`.`idprogramu`= '$idprogramu'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {

			while ($row = mysqli_fetch_assoc($result)) {


				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] < 0.3) {
					print("</td>");
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 0.6) {
					print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 1.3) {
					print('<img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 1.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 2.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 2.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 3.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 3.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 4.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
			}
		}



		//-----------------------------------------------------------------------------------------------------------------------------------------

		print("<td>");


		$sql =  "SELECT CAST(AVG(hfakulty) AS DECIMAL(3,2)), CAST(AVG(hzazemi) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` WHERE `bcprogramy`.`idprogramu`= '$idprogramu2'";

		$result = mysqli_query($conn, $sql);




		if (mysqli_num_rows($result) > 0) {

			while ($row = mysqli_fetch_assoc($result)) {




				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] < 0.3) {
					print("</td>");
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 0.6) {
					print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 1.3) {
					print('<img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 1.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 2.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 2.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 3.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 3.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 4.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] <= 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hfakulty) AS DECIMAL(3,2))"] > 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
			}
		}
		print("</tr>");

		//______________________________________________________________________________________________________________________________________________

		print("<tr><td>Hodnocení zázemí</td><td>");

		$sql =  "SELECT CAST(AVG(hzazemi) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` WHERE `bcprogramy`.`idprogramu`= '$idprogramu'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {

			while ($row = mysqli_fetch_assoc($result)) {



				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] < 0.3) {
					print("</td>");
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 0.6) {
					print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 1.3) {
					print('<img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 1.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 2.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 2.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 3.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 3.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 4.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
			}
		}
		//________________________________________________________________________________________________________________________________________________________________

		print("<td>");


		$sql =  "SELECT CAST(AVG(hzazemi) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` WHERE `bcprogramy`.`idprogramu`= '$idprogramu2'";

		$result = mysqli_query($conn, $sql);


		if (mysqli_num_rows($result) > 0) {

			while ($row = mysqli_fetch_assoc($result)) {


				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] < 0.3) {
					print("</td>");
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 0.6) {
					print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 1.3) {
					print('<img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 1.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 2.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 2.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 3.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 3.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 4.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] <= 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hzazemi) AS DECIMAL(3,2))"] > 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
			}
		}
		print("</tr>");
		//_________________________________________________________________________________________________________________________________________________________________


		print("<tr><td>Hodnocení využitelnosti v praxi</td><td>");



		$sql =  "SELECT CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2)), CAST(AVG(hobtiznosti) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idprogramu` = `hodnoceni`.`idprogramu` WHERE `bcprogramy`.`idprogramu`= '$idprogramu'";

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {

				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] < 0.3) {
					print("</td>");
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 0.6) {
					print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 1.3) {
					print('<img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 1.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 2.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 2.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 3.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 3.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 4.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
			}
		}
		print("<td>");
		//_______________________________________________________________________________________________________________________________________


		$sql =  "SELECT CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2)), CAST(AVG(hobtiznosti) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idprogramu` = `hodnoceni`.`idprogramu` WHERE `bcprogramy`.`idprogramu`= '$idprogramu2'";

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {

				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] < 0.3) {
					print("</td>");
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 0.6) {
					print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 1.3) {
					print('<img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 1.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 2.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 2.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 3.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 3.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 4.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] <= 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hvyuzitelnosti) AS DECIMAL(3,2))"] > 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
			}
		}
		print("</tr>");

		//_____________________________________________________________________________________________________________________________________________________________

		print("<tr><td>Hodnocení obtížnosti</td><td>");


		$sql =  "SELECT CAST(AVG(hobtiznosti) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idprogramu` = `hodnoceni`.`idprogramu` WHERE `bcprogramy`.`idprogramu`= '$idprogramu'";

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {


				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] < 0.3) {
					print("</td>");
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 0.6) {
					print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 1.3) {
					print('<img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 1.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 2.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 2.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 3.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 3.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 4.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
			}
		}

		//________________________________________________________________________________________________________________________________________

		print("<td>");

		$sql =  "SELECT CAST(AVG(hobtiznosti) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idprogramu` = `hodnoceni`.`idprogramu` WHERE `bcprogramy`.`idprogramu`= '$idprogramu2'";

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {


				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] < 0.3) {
					print("</td>");
				}

				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 0.6) {
					print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 1.3) {
					print('<img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 1.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 2.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 2.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 3.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 3.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 4.3) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] <= 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
				}
				if ($row["CAST(AVG(hobtiznosti) AS DECIMAL(3,2))"] > 4.6) {
					print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
				}
			}
		}

		print("</tr>");

		//_________________________________________________________________________________________________________________________________

		$sql =  "SELECT `mesta`.`nazevmesta` FROM skoly LEFT JOIN `mesta` ON `mesta`.`idmesta` = `skoly`.`idmesta` WHERE `skoly`.`idskoly`= '$idskoly'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$nazevmesta = $row["nazevmesta"];
			}
		}

		print("<tr><td>Hodnocení města </td><td>");



		$sql =  "SELECT CAST(AVG(hmesta) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` WHERE `bcprogramy`.`idprogramu`= '$idprogramu'";

		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_assoc($result)) {

			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] < 0.3) {
				print("</td>");
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 0.6) {
				print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 1.3) {
				print('<img src="IMG/star.png" alt="hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 1.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 2.3) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 2.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 3.3) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 3.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 4.3) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 4.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 4.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
			}
		}

		//_____________________________________________________________________________________________________________________________________________________

		print("<td>");


		$sql =  "SELECT `mesta`.`nazevmesta` FROM skoly LEFT JOIN `mesta` ON `mesta`.`idmesta` = `skoly`.`idmesta` WHERE `skoly`.`idskoly`= '$idskoly2'";
		$result = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$nazevmesta2 = $row["nazevmesta"];
		}


		$sql =  "SELECT CAST(AVG(hmesta) AS DECIMAL(3,2)) FROM hodnoceni LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` WHERE `bcprogramy`.`idprogramu`= '$idprogramu2'";

		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_assoc($result)) {


			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] < 0.3) {
				print("</td>");
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] >= 0.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 0.6) {
				print('<img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 0.6 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 1.3) {
				print('<img src="IMG/star.png" alt="hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 1.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 1.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 1.6 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 2.3) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 2.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 2.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 2.6 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 3.3) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 3.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 3.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 3.6 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 4.3) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 4.3 && $row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] <= 4.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star-half.png" alt="poloviční hvězda"></td>');
			}
			if ($row["CAST(AVG(hmesta) AS DECIMAL(3,2))"] > 4.6) {
				print('<img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"><img src="IMG/star.png" alt="hvězda"></td>');
			}
		}
		print("</tr>");

		//____________________________________________________________________________________________________________________________________________________________

		print("<tr><td>Zpětná vazba studentů</td><td>");

		$sql =  "SELECT `hodnoceni`.`popis`, `uzivatele`.`jmeno` FROM hodnoceni LEFT JOIN `uzivatele` ON `uzivatele`.`iduzivatele`=`hodnoceni`.`iduzivatele` LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` WHERE `hodnoceni`.`popis` IS NOT NULL AND `bcprogramy`.`idprogramu`= '$idprogramu'";
		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_assoc($result)) {
			print("<p id='paragraf'><a id='jmenotxt'>" . $row["jmeno"] . "</a> – <a id='recenzetxt'>" . $row["popis"] . "</a></p>");
		}
		print("</td>");
		//____________________________________________________________________________________________________________________________________________________	


		print("<td>");


		//print("<h2>".$row["AVG(hfakulty)"]."/5 </h2><br>"); 



		$sql =  "SELECT `hodnoceni`.`popis`, `uzivatele`.`jmeno` FROM hodnoceni LEFT JOIN `uzivatele` ON `uzivatele`.`iduzivatele`=`hodnoceni`.`iduzivatele` LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `hodnoceni`.`idfakulty` WHERE `hodnoceni`.`popis` IS NOT NULL AND `bcprogramy`.`idprogramu`= '$idprogramu2'";
		$result = mysqli_query($conn, $sql);



		while ($row = mysqli_fetch_assoc($result)) {
			print("<p id='paragraf'><a id='jmenotxt'>" . $row["jmeno"] . "</a> – <a id='recenzetxt'>" . $row["popis"] . "</a></p>");
		}

		print("</td>");


		print("</table></div>");

		//________________________________________________________________________________________________________________________________


		print("<div id='box4'><a id='link' href=\"finalpage.php?konec=1\">Zpět na hlavní stránku</a></div>");
		?>


		<?php
		if (isset($_GET['konec'])) {
			session_unset();
			header("Location: index.php ");
		}
		?>

		<div id="footer">
			<footer>
				<p id="footertxt">Created by Viktor Jahodík</p>

			</footer>
		</div>
	</div>
	</div>

	<style>
		#wrapper {
			grid-template-areas: "box1 box1"
				"box4 box4"
				"box3 photo"
				"table table"
				"footer footer";

		}
	</style>

</body>

</html>