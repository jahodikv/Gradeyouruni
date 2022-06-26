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
		<div id="box3">
			<h1>Uděl hodnocení tvé univerzitě</h1>
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


		if (!isset($_SESSION["dotaznik"]["jmeno"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["dotaznik"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["dotaznik"]["prijmeni"])) {
			header('Location: index.php');
		}


		if (!isset($_SESSION["dotaznik"]["mail"])) {
			header('Location: index.php');
		}

		if (!isset($_SESSION["dotaznik"]["nazev"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["dotaznik"]["nazevfakulty"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["dotaznik"]["nazevprogramu"])) {
			header('Location: index.php');
		}

		/*
		if($_SESSION["dotaznik"]["nazevprogramu"]||$_SESSION["dotaznik"]["nazevfakulty"]|| $_SESSION["dotaznik"]["nazev"]||$_SESSION["dotaznik"]["jmeno"]||$_SESSION["dotaznik"]["prijmeni"]|| $_SESSION["dotaznik"]["mail"]==""){
		
		
		header("Location: dotaznik4.php ");
		
	}
	*/
		if (isset($_SESSION["dotaznik"])) {

			extract($_SESSION["dotaznik"]);

			$sql = mysqli_query($conn, "INSERT INTO uzivatele (jmeno, prijmeni, email, idskoly, idfakulty, idprogramu) VALUES ('$jmeno','$prijmeni','$mail','$idskoly','$idfakulty','$idprogramu')");


			$sql =  "SELECT `iduzivatele` FROM uzivatele  WHERE `email`= '$mail'";

			$result = mysqli_query($conn, $sql);


			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$iduzivatele = $row["iduzivatele"];
				}
			}

			$sql = mysqli_query($conn, "INSERT INTO hodnoceni (iduzivatele, idskoly, idfakulty, hfakulty, hmesta, hzazemi, idprogramu, hvyuzitelnosti, hobtiznosti, popis, idmesta) VALUES ('$iduzivatele','$idskoly','$idfakulty','$hfakulty','$hmesta','$hzazemi','$idprogramu','$hvyuzitelnosti','$hobtiznosti', NULLIF('$text', ''),'$idmesta')");


			if ($sql) {

				//unset($_SESSION["dotaznik"]);

				print("<div id='box2'><p>Vaše hodnocení bylo úspěšně uloženo. Děkujeme </p></div>");

				unset($_SESSION["dotaznik"]);
			} else {

				print("<div id='box2'><p>Bohužel se někde stala chyba, zkuste to znovu :( </p></div>");

				unset($_SESSION["dotaznik"]);
			}
		}

		//-------------------------------------------------------------------------------------

		?>

		<br>
		<div id='box4'>
			<p><a href=index.php>Zpět na hlavní stránku</a></p>
		</div>

		<div id="footer">
			<footer>

				<p id="footertxt">Created by Viktor Jahodík</p>

			</footer>
		</div>
	</div>
</body>

</html>