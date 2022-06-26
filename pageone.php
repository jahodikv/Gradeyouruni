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
		if (!isset($_SESSION["info"]["idskoly"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["info"]["idskoly2"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["info"])) {
			header('Location: index.php');
		}

			/*
	
echo "<pre>" ;
	print_r ($_SESSION["info"]);
	echo "</pre>";	
		*/;

		if (isset($_POST["next"])) {



			foreach ($_POST as $key => $value) {

				$_SESSION["info"][$key] = $value;
			}

			$keys = array_keys($_SESSION["info"]);
			if (in_array("next", $keys)) {

				unset($_SESSION["info"]["next"]);
			}

			//----------validace start-----------------------
			$nazev2 = $_SESSION["info"]["nazev2"];
			$idskoly = $_SESSION["info"]["idskoly"];
			$nazev = $_SESSION["info"]["nazev"];
			$nazevfakulty = $_SESSION["info"]["nazevfakulty"];
			$nazevfakulty2 = $_SESSION["info"]["nazevfakulty2"];
			//Kontrola prázdnoty políčka//////////////////////////////
			if ($nazevfakulty == "") {

				print("<style> #nazevfakulty {background-color:#B82B2D;  }        </style>");
			}
			if ($nazevfakulty2 == "") {

				print("<style> #nazevfakulty2 {background-color:#B82B2D;  }        </style>");
			}
			//////////////////////////////////////////////////////////

			$kontrola = 0;
			$sql = "SELECT `fakulty`.`idfakulty` FROM skoly LEFT JOIN `fakulty` ON `fakulty`.`idskoly` = `skoly`.`idskoly` WHERE `fakulty`.`nazevfakulty`= '$nazevfakulty' AND `skoly`.`nazevskoly` = '$nazev' ";

			$result = mysqli_query($conn, $sql);


			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idfakulty = $row["idfakulty"];
				}
				$_SESSION["info"]["idfakulty"] = $idfakulty;
				$kontrola = $kontrola + 1;
			} else {
				print("<style> #nazevfakulty {background-color:#B82B2D;  }        </style>");
			}


			$sql = "SELECT `fakulty`.`idfakulty` FROM skoly LEFT JOIN `fakulty` ON `fakulty`.`idskoly` = `skoly`.`idskoly` WHERE `fakulty`.`nazevfakulty`= '$nazevfakulty2' AND `skoly`.`nazevskoly` = '$nazev2' ";

			$result = mysqli_query($conn, $sql);


			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idfakulty2 = $row["idfakulty"];
				}
				$_SESSION["info"]["idfakulty2"] = $idfakulty2;
				$kontrola = $kontrola + 1;
			} else {
				print("<style> #nazevfakulty2 {background-color:#B82B2D;  }        </style>");
			}

			//´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´

			if ($kontrola == 2) {


				header('Location: pagetwo.php');
			}
		}

		//-------------------------------------------------------------------------------------

		$nazev = $_SESSION["info"]["nazev"];
		$nazev2 = $_SESSION["info"]["nazev2"];

		$sql =  "SELECT `fakulty`.`nazevfakulty` FROM skoly LEFT JOIN `fakulty` ON `fakulty`.`idskoly` = `skoly`.`idskoly` WHERE `skoly`.`nazevskoly`= '$nazev'";

		$result = mysqli_query($conn, $sql);
		?>
		<div id="box3">
			<h1>Podívej se na <span>hodnocení</span> tvé univerzity</h1>
		</div>
		<div id="box2">
			<form method="post" action="<?php print(basename($_SERVER['PHP_SELF'])); ?>">
				<fieldset>
					<h1 id="step">Krok 2:</h1>


					<p id="popis">Zadej fakulty k porovnání</p>

					<input list="fakulty" name="nazevfakulty" id="nazevfakulty" value="<?= isset($_SESSION["info"]["nazevfakulty"]) ? $_SESSION["info"]['nazevfakulty'] : '' ?>"><input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('nazevfakulty').value = ''">
					<datalist id="fakulty">

						<?php
						if (mysqli_num_rows($result) > 0) {

							while ($row = mysqli_fetch_assoc($result)) {
								print("<option value='" . $row["nazevfakulty"] . "'></option>"); //Výpis fakult z databáze do políček pro výběr

							}
							print("</datalist>");
						}

						?>


						<input list="fakulty2" name="nazevfakulty2" id="nazevfakulty2" value="<?= isset($_SESSION["info"]["nazevfakulty2"]) ? $_SESSION["info"]['nazevfakulty2'] : '' ?>"><input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('nazevfakulty2').value = ''">
						<datalist id="fakulty2">

							<?php
							$sql =  "SELECT `fakulty`.`nazevfakulty` FROM skoly LEFT JOIN `fakulty` ON `fakulty`.`idskoly` = `skoly`.`idskoly` WHERE `skoly`.`nazevskoly`= '$nazev2'";
							$result = mysqli_query($conn, $sql);
							if (mysqli_num_rows($result) > 0) {

								while ($row = mysqli_fetch_assoc($result)) {
									print("<option value='" . $row["nazevfakulty"] . "'></option>"); //Výpis fakult z databáze do políček pro výběr

								}
								print("</datalist>");
							}

							?>

							<br>
							<input type="button" onclick="window.location.href='index.php'" name="back" value="ZPĚT" id="back">
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