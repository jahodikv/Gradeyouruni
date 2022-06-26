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

		if (isset($_POST["next"])) {


			foreach ($_POST as $key => $value) {

				$_SESSION["dotaznik"][$key] = $value;
			}

			$keys = array_keys($_SESSION["dotaznik"]);
			if (in_array("next", $keys)) {

				unset($_SESSION["dotaznik"]["next"]);
			}

			/*	
		if( $_SESSION["dotaznik"]["nazev"]||$_SESSION["dotaznik"]["jmeno"]||$_SESSION["dotaznik"]["prijmeni"]|| $_SESSION["dotaznik"]["mail"]==""){
		
		
		header("Location: dotaznik1.php ");
		
	}
		*/
			//----------validace start-----------------------
			$nazev = $_SESSION["dotaznik"]["nazev"];
			$nazevfakulty = $_SESSION["dotaznik"]["nazevfakulty"];
			//Kontrola prázdnoty políčka//////////////////////////////
			if ($nazevfakulty == "") {

				print("<style> #nazevfakulty {background-color:#B82B2D;  }        </style>");
			}
			//////////////////////////////////////////////////////////


			$sql = "SELECT `fakulty`.`idfakulty` FROM skoly LEFT JOIN `fakulty` ON `fakulty`.`idskoly` = `skoly`.`idskoly` WHERE `fakulty`.`nazevfakulty`= '$nazevfakulty' AND `skoly`.`nazevskoly` = '$nazev' ";

			$result = mysqli_query($conn, $sql);


			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idfakulty = $row["idfakulty"];
				}
				$_SESSION["dotaznik"]["idfakulty"] = $idfakulty;
				header("Location: dotaznik3.php ");
			} else {
				print("<style> #nazevfakulty {background-color:#B82B2D;  }        </style>");
			}

			//´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´

		}

		//-------------------------------------------------------------------------------------

		$nazev = $_SESSION["dotaznik"]["nazev"];


		$sql =  "SELECT `fakulty`.`nazevfakulty` FROM skoly LEFT JOIN `fakulty` ON `fakulty`.`idskoly` = `skoly`.`idskoly` WHERE `skoly`.`nazevskoly`= '$nazev'";

		$result = mysqli_query($conn, $sql);
		?>


		<div id="box3">
			<h1>Uděl hodnocení tvé univerzitě</h1>
		</div>
		<div id="box2">
			<form method="post" action="<?php print(basename($_SERVER['PHP_SELF'])); ?>">
				<fieldset>
					<h1 id="step">Krok 3:</h1>


					<p id="popis">Zadej fakultu</p>

					<input list="fakulty" name="nazevfakulty" id="nazevfakulty" value="<?= isset($_SESSION["dotaznik"]["nazevfakulty"]) ? $_SESSION["dotaznik"]['nazevfakulty'] : '' ?>"><input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('nazevfakulty').value = ''">
					<datalist id="fakulty">

						<?php
						if (mysqli_num_rows($result) > 0) {

							while ($row = mysqli_fetch_assoc($result)) {
								print("<option value='" . $row["nazevfakulty"] . "'></option>"); //Výpis fakult z databáze do políček pro výběr

							}
							print("</datalist>");
						}

						?>

						<br>
						<input type="button" onclick="window.location.href='dotaznik1.php'" name="back" value="ZPĚT" id="back">
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