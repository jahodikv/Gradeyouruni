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
		if (!isset($_SESSION["info"]["nazevfakulty"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["info"]["nazevfakulty2"])) {
			header('Location: index.php');
		}

		/*
	
echo "<pre>" ;
	print_r ($_SESSION["info"]);
	echo "</pre>";	
		*/


		if (isset($_POST["next"])) {



			foreach ($_POST as $key => $value) {

				$_SESSION["info"][$key] = $value;
			}

			$keys = array_keys($_SESSION["info"]);
			if (in_array("next", $keys)) {

				unset($_SESSION["info"]["next"]);
			}


			//----------validace start-----------------------
			$idfakulty2 = $_SESSION["info"]["idfakulty2"];
			$idfakulty = $_SESSION["info"]["idfakulty"];
			$idskoly = $_SESSION["info"]["idskoly"];
			$nazevfakulty2 = $_SESSION["info"]["nazevfakulty2"];
			$nazevfakulty = $_SESSION["info"]["nazevfakulty"];
			$nazevprogramu = $_SESSION["info"]["nazevprogramu"];
			$nazevprogramu2 = $_SESSION["info"]["nazevprogramu2"];
			//Kontrola prázdnoty políčka//////////////////////////////
			if ($nazevprogramu == "") {

				print("<style> #nazevprogramu {background-color:#B82B2D;  }        </style>");
			}
			if ($nazevprogramu2 == "") {

				print("<style> #nazevprogramu2 {background-color:#B82B2D;  }        </style>");
			}
			//////////////////////////////////////////////////////////


			$sql = "SELECT `bcprogramy`.`idprogramu` FROM fakulty LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `fakulty`.`idfakulty` WHERE `bcprogramy`.`nazevprogramu`= '$nazevprogramu' AND `fakulty`.`nazevfakulty` = '$nazevfakulty' ";

			$result = mysqli_query($conn, $sql);

			$kontrola = 0;
			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idprogramu = $row["idprogramu"];
				}
				$_SESSION["info"]["idprogramu"] = $idprogramu;

				$kontrola = $kontrola + 1;
			} else {
				print("<style> #nazevprogramu {background-color:#B82B2D;  }        </style>");
			}

			//´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			$sql = "SELECT `bcprogramy`.`idprogramu` FROM fakulty LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `fakulty`.`idfakulty` WHERE `bcprogramy`.`nazevprogramu`= '$nazevprogramu2' AND `fakulty`.`nazevfakulty` = '$nazevfakulty2' ";

			$result = mysqli_query($conn, $sql);


			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idprogramu2 = $row["idprogramu"];
				}
				$_SESSION["info"]["idprogramu2"] = $idprogramu2;

				$kontrola = $kontrola + 1;
			} else {
				print("<style> #nazevprogramu2 {background-color:#B82B2D;  }        </style>");
			}

			if ($kontrola == 2) {


				header('Location: finalpage.php');
			}
		}

		//-------------------------------------------------------------------------------------

		$idfakulty = $_SESSION["info"]["idfakulty"];
		$idfakulty2 = $_SESSION["info"]["idfakulty2"];
		$sql =  "SELECT `bcprogramy`.`nazevprogramu` FROM fakulty LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `fakulty`.`idfakulty` WHERE `fakulty`.`idfakulty`= '$idfakulty'";

		$result = mysqli_query($conn, $sql);
		?>
		<div id="box3">
			<h1>Podívej se na <span>hodnocení</span> tvé univerzity</h1>
		</div>
		<div id="box2">
			<form method="post" action="<?php print(basename($_SERVER['PHP_SELF'])); ?>">
				<fieldset>
					<h1 id="step">Krok 3:</h1>


					<p id="popis">Zadej studijní programy k porovnání</p>

					<input list="programy" name="nazevprogramu" id="nazevprogramu" value="<?= isset($_SESSION["info"]["nazevprogramu"]) ? $_SESSION["info"]['nazevprogramu'] : '' ?>">
					<input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('nazevprogramu').value = ''">
					<datalist id="programy">

						<?php

						if (mysqli_num_rows($result) > 0) {

							while ($row = mysqli_fetch_assoc($result)) {

								print("<option value='" . $row["nazevprogramu"] . "'></option>"); //Výpis studijních programů z databáze do políček pro výběr

							}

							print("</datalist>");
						}

						?>

						<input list="programy2" name="nazevprogramu2" id="nazevprogramu2" value="<?= isset($_SESSION["info"]["nazevprogramu2"]) ? $_SESSION["info"]['nazevprogramu2'] : '' ?>">
						<input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('nazevprogramu2').value = ''">
						<datalist id="programy2">

							<?php
							$sql =  "SELECT `bcprogramy`.`nazevprogramu` FROM fakulty LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `fakulty`.`idfakulty` WHERE `fakulty`.`idfakulty`= '$idfakulty2'";
							$result = mysqli_query($conn, $sql);
							if (mysqli_num_rows($result) > 0) {

								while ($row = mysqli_fetch_assoc($result)) {

									print("<option value='" . $row["nazevprogramu"] . "'></option>"); //Výpis studijních programů z databáze do políček pro výběr

								}

								print("</datalist>");
							}

							?>

							<br>

							<input type="button" onclick="window.location.href='pageone.php'" name="back" value="ZPĚT" id="back">
							<input type="submit" name="next" value="DALŠÍ" id="next">

							</p>


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