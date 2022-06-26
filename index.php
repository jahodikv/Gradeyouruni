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
		<div id="box4">
			<a href="dotaznik.php" id="link">Ohodnoť svou univerzitu</a>
		</div>

		<div id=photo>
			<img src="IMG/image.png" alt="absolventský klobouk">
		</div>
		<?php
		//============== Začátek 1. kroku =================================================

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

		if (isset($_SESSION['dotaznik'])) {
			unset($_SESSION["dotaznik"]);
		}
		if (isset($_SESSION['info'])) {
			unset($_SESSION["info"]);
		}

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
			$nazev = $_SESSION["info"]["nazev"];
			//Kontrola prázdnoty políčka//////////////////////////////
			if ($nazev == "") {

				print("<style> #nazev{ background-color: #B82B2D; }        </style>");
			}
			if ($nazev2 == "") {

				print("<style> #nazev2{ background-color: #B82B2D; }        </style>");
			}
			//////////////////////////////////////////////////////////

			$kontrola == 0;
			$sql = "SELECT idskoly FROM `skoly` WHERE nazevskoly = '$nazev'";

			$result = mysqli_query($conn, $sql);


			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idskoly = $row["idskoly"];
				}
				$_SESSION["info"]["idskoly"] = $idskoly;
				$kontrola = $kontrola + 1;
			} else {
				print("<style> #nazev{background-color:#B82B2D;  }        </style>");
			}

			//´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			$sql = "SELECT idskoly FROM `skoly` WHERE nazevskoly = '$nazev2'";

			$result = mysqli_query($conn, $sql);


			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idskoly2 = $row["idskoly"];
				}
				$_SESSION["info"]["idskoly2"] = $idskoly2;

				$kontrola = $kontrola + 1;
			} else {
				print("<style> #nazev2{background-color:#B82B2D;  }        </style>");
			}


			if ($kontrola == 2) {
				header("Location: pageone.php ");
			}
		}


		//-------------------------------------------------------------------------------------

		$sql = "SELECT idskoly, nazevskoly FROM skoly ";
		$result = mysqli_query($conn, $sql);
		?>
		<div id="box3">
			<h1>Podívej se na <span>hodnocení</span> tvé univerzity</h1>
		</div>



		<div id="box2">
			<form method="post" action="<?php print(basename($_SERVER['PHP_SELF'])); ?>">

				<fieldset>
					<h1 id="step">Krok 1:</h1>


					<p id="popis">Zadej univerzity k porovnání</p>

					<input list="skoly" name="nazev" id="nazev" value="<?= isset($_SESSION["info"]["nazev"]) ? $_SESSION["info"]['nazev'] : '' ?>">

					<input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('nazev').value = ''">
					<datalist id="skoly">

						<?php
						if (mysqli_num_rows($result) > 0) {

							while ($row = mysqli_fetch_assoc($result)) {
								print("<option value='" . $row["nazevskoly"] . "'></option>");
							}
							print("</datalist>");
						};

						?>

						<input list="skoly" name="nazev2" id="nazev2" value="<?= isset($_SESSION["info"]["nazev2"]) ? $_SESSION["info"]['nazev2'] : '' ?>">

						<input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('nazev2').value = ''">
						<datalist id="skoly">

							<?php
							if (mysqli_num_rows($result) > 0) {

								while ($row = mysqli_fetch_assoc($result)) {
									print("<option value='" . $row["nazevskoly"] . "'></option>");
								}
								print("</datalist>");
							}
							?>
							<br>

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