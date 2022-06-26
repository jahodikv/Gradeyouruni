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


	<link rel="stylesheet" href="style.css">
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


		if (isset($_POST["next"])) {


			foreach ($_POST as $key => $value) {

				$_SESSION["dotaznik"][$key] = $value;
			}
			$keys = array_keys($_SESSION["dotaznik"]);
			if (in_array("next", $keys)) {

				unset($_SESSION["dotaznik"]["next"]);
			}


			/*
		
		if($_SESSION["dotaznik"]["nazevfakulty"]||$_SESSION["dotaznik"]["jmeno"]||$_SESSION["dotaznik"]["prijmeni"]|| $_SESSION["dotaznik"]["mail"]|| $_SESSION["dotaznik"]["nazev"]==""){
		
		
		header("Location: dotaznik2.php ");
		
	}
		*/

			//----------validace start-----------------------
			$nazevfakulty = $_SESSION["dotaznik"]["nazevfakulty"];
			$nazevprogramu = $_SESSION["dotaznik"]["nazevprogramu"];
			//Kontrola prázdnoty políčka//////////////////////////////
			if ($nazevprogramu == "") {

				print("<style> #nazevprogramu {background-color:#B82B2D;  }        </style>");
			}
			//////////////////////////////////////////////////////////


			$sql = "SELECT `bcprogramy`.`idprogramu` FROM fakulty LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `fakulty`.`idfakulty` WHERE `bcprogramy`.`nazevprogramu`= '$nazevprogramu' AND `fakulty`.`nazevfakulty` = '$nazevfakulty' ";

			$result = mysqli_query($conn, $sql);


			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idprogramu = $row["idprogramu"];
				}
				$_SESSION["dotaznik"]["idprogramu"] = $idprogramu;

				header("Location: dotaznik4.php ");
			} else {
				print("<style> #nazevprogramu {background-color:#B82B2D;  }        </style>");
			}

			//´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´

		}

		//-------------------------------------------------------------------------------------
		$nazevfakulty = $_SESSION["dotaznik"]["nazevfakulty"];

		$sql =  "SELECT `bcprogramy`.`nazevprogramu` FROM fakulty LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `fakulty`.`idfakulty` WHERE `fakulty`.`nazevfakulty`= '$nazevfakulty'";

		$result = mysqli_query($conn, $sql);
		?>


		<div id="box3">
			<h1>Uděl hodnocení tvé univerzitě</h1>
		</div>
		<div id="box2">
			<form method="post" action="<?php print(basename($_SERVER['PHP_SELF'])); ?>">
				<fieldset>
					<h1 id="step">Krok 4:</h1>


					<p id="popis">Zadej studijní program</p>

					<input list="programy" name="nazevprogramu" id="nazevprogramu" value="<?= isset($_SESSION["dotaznik"]["nazevprogramu"]) ? $_SESSION["dotaznik"]['nazevprogramu'] : '' ?>"><input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('nazevprogramu').value = ''">
					<datalist id="programy">

						<?php

						if (mysqli_num_rows($result) > 0) {

							while ($row = mysqli_fetch_assoc($result)) {

								print("<option value='" . $row["nazevprogramu"] . "'></option>"); //Výpis studijních programů z databáze do políček pro výběr

							}

							print("</datalist>");
						}

						?>
						<br>
						<input type="button" onclick="window.location.href='dotaznik2.php'" name="back" value="ZPĚT" id="back">
						<input type="submit" name="next" value="DALŠÍ" id="next">

				</fieldset>

			</form>
		</div>

		<div id="footer">
			<footer>

				<p id="footertxt">Created by Viktor Jahodík</p>

			</footer>
		</div>
	</div>
</body>

</html>