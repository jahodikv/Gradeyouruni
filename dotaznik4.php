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
		if (!isset($_SESSION["dotaznik"]["nazevfakulty"])) {
			header('Location: index.php');
		}
		if (!isset($_SESSION["dotaznik"]["nazevprogramu"])) {
			header('Location: index.php');
		}




		if (isset($_POST["next"])) {



			foreach ($_POST as $key => $value) {

				$_SESSION["dotaznik"][$key] = $value;
				echo "<pre>";
			}

			$keys = array_keys($_SESSION["dotaznik"]);
			if (in_array("next", $keys)) {

				unset($_SESSION["dotaznik"]["next"]);
			}
		}
		/*
	if($_SESSION["dotaznik"]["nazevprogramu"]||$_SESSION["dotaznik"]["nazevfakulty"]|| $_SESSION["dotaznik"]["nazev"]||$_SESSION["dotaznik"]["jmeno"]||$_SESSION["dotaznik"]["prijmeni"]|| $_SESSION["dotaznik"]["mail"]==""){
		
		
		header("Location: dotaznik3.php ");
		
	}
	
	*/

		//-------------------------------------------------------------------------------------
		$nazevprogramu = $_SESSION["dotaznik"]["nazevprogramu"];
		$nazevfakulty = $_SESSION["dotaznik"]["nazevfakulty"];
		$nazev = $_SESSION["dotaznik"]["nazev"];


		if (isset($_POST["next"])) {


			$sql =  "SELECT `mesta`.`idmesta` FROM skoly LEFT JOIN `mesta` ON `mesta`.`idmesta` = `skoly`.`idmesta` WHERE `skoly`.`nazevskoly`= '$nazev'";

			$result = mysqli_query($conn, $sql);


			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idmesta = $row["idmesta"];
				}

				$_SESSION["dotaznik"]["idmesta"] = $idmesta;
			}


			$sql =  "SELECT `idskoly` FROM skoly  WHERE `nazevskoly`= '$nazev'";

			$result = mysqli_query($conn, $sql);


			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idskoly = $row["idskoly"];
				}

				$_SESSION["dotaznik"]["idskoly"] = $idskoly;
			}

			$sql = "SELECT `fakulty`.`idfakulty` FROM skoly LEFT JOIN `fakulty` ON `fakulty`.`idskoly` = `skoly`.`idskoly` WHERE `fakulty`.`nazevfakulty`= '$nazevfakulty' AND `skoly`.`nazevskoly` = '$nazev' ";

			$result = mysqli_query($conn, $sql);


			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idfakulty = $row["idfakulty"];
				}

				$_SESSION["dotaznik"]["idfakulty"] = $idfakulty;
			}


			$sql = "SELECT `bcprogramy`.`idprogramu` FROM fakulty LEFT JOIN `bcprogramy` ON `bcprogramy`.`idfakulty` = `fakulty`.`idfakulty` WHERE `bcprogramy`.`nazevprogramu`= '$nazevprogramu' AND `fakulty`.`nazevfakulty` = '$nazevfakulty' ";

			$result = mysqli_query($conn, $sql);


			if (mysqli_num_rows($result) == 1) {

				while ($row = mysqli_fetch_assoc($result)) {
					$idprogramu = $row["idprogramu"];
				}

				$_SESSION["dotaznik"]["idprogramu"] = $idprogramu;
			}
			header("Location: dotaznik5.php ");
		}


		?>

		<div id="box3">
			<h1>Uděl hodnocení tvé univerzitě</h1>
		</div>


		<?php

		/*
	echo "<pre>" ;
	print_r ($_SESSION["dotaznik"]);
	echo "</pre>";	
	
	*/

		$sql =  "SELECT `mesta`.`nazevmesta` FROM skoly LEFT JOIN `mesta` ON `mesta`.`idmesta` = `skoly`.`idmesta` WHERE `skoly`.`nazevskoly`= '$nazev'";

		$result = mysqli_query($conn, $sql);


		if (mysqli_num_rows($result) == 1) {

			while ($row = mysqli_fetch_assoc($result)) {
				$nazevmesta = $row["nazevmesta"];
			}
		}

		?>

		<div id="box2">

			<form id="form1" method="post" action="<?php print(basename($_SERVER['PHP_SELF'])); ?>">

				<h1 id="step">Krok 5:</h1>

				<br><a id="help">*1 – nejhorší, 5 – nejlepší</a><br>

				<a id="popis">Jak se ti líbí <?php print($nazevmesta) ?>?</a>

				<select id="hmesta" name="hmesta">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>

				<br>
				<a id="popis">Jak se ti líbí <?php print($nazevfakulty) ?>? Co říkáš na její zázemí?</a>
				<select id="hzazemi" name="hzazemi">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<br>
				<a id="popis">Je po studentech poptávka ve firmách?</a>
				<select id="hvyuzitelnosti" name="hvyuzitelnosti">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<br>

				<a id="popis">Jak moc obtížné bylo studium?</a>
				<select id="hobtiznosti" name="hobtiznosti">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<br>

				<a id="popis">Jak celkově hodnotíš své studium na fakultě?</a>

				<select id="hfakulty" name="hfakulty">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>

				<br>

				<p id="popis">Chceš sdělit další poznatky? Sem s nimi.</p>
				<textarea id="text" name="text" maxlength="4000"></textarea>

				<br>

				<input type="button" onclick="window.location.href='dotaznik3.php'" name="back" value="ZPĚT" id="back">
				<input type="submit" name="next" value="DALŠÍ" id="next">

			</form>
		</div>

		<div id="footer">
			<footer>

				<p id="footertxt">Created by Viktor Jahodík</p>


			</footer>
		</div>
	</div>
	<style>
		#wrapper {

			grid-template-areas: "box1 box1"
				"box4 box4"
				"box3 photo"
				"box2 box2"
				"footer footer";

		}
	</style>
</body>

</html>