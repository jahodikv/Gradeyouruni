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
		if (isset($_POST["next"])) {



			foreach ($_POST as $key => $value) {

				$_SESSION["dotaznik"][$key] = $value;
			}


			$keys = array_keys($_SESSION["dotaznik"]);
			if (in_array("next", $keys)) {

				unset($_SESSION["dotaznik"]["next"]);
			}


			//----------validace start-----------------------------------------------------------
			$jmeno = $_SESSION["dotaznik"]["jmeno"];
			$prijmeni = $_SESSION["dotaznik"]["prijmeni"];
			$mail = $_SESSION["dotaznik"]["mail"];



			/////////////////////////////////jmeno//////////////////////////////////////////////////////////////////////////////////////////

			$validjmeno = true;

			if ($jmeno == "") {

				print("<style> #jmeno {background-color:#B82B2D;  }        </style>");
				$validjmeno = false;
			} else {


				//pozadovana delka prijmeni je 2-64 znaku.
				if ((!strlen($jmeno) >= 2) && (!strlen($jmeno) <= 64)) { //delka jmena 2-64
					print("<style> #jmeno {background-color:#B82B2D;  }        </style>");
					$validjmeno = false;
				}
				for ($i = 0; $i < strlen($jmeno); $i++) { //projedu všechna místa
					if (is_numeric($jmeno[$i])) {
						$validjmeno = false;
						print("<style> #jmeno {background-color:#B82B2D;  }        </style>");
					}
				}

				$povoleneznaky = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZěščřžýáíéĚŠČŘŽÝÁÍÉŤĎ";
				$velkapismena = "ABCDEFGHIJKLMNOPQRSTUVWXYZŠČŘŽÝÁÍÉŤĎ";
				for ($i = 0; $i < mb_strlen($jmeno); $i++) { //projedu vsechna mista

					if (strpos($povoleneznaky, $jmeno[$i]) === false) {
						$validjmeno = false;
						print("<style> #jmeno {background-color:#B82B2D;  }        </style>");
					}
				}
				if (strpos($velkapismena, $jmeno[0]) === false) {
					$validjmeno = false;
					print("<style> #jmeno {background-color:#B82B2D;  }        </style>");
				}
			}
			///////////////////////////////////////////////////////////////////////////////////////////////////////////

			//---------------------------prijmeni---------------------------------------------
			$validprijmeni = true;


			if ($prijmeni == "") {

				print("<style> #prijmeni {background-color:#B82B2D;  }        </style>");
				$validprijmeni = false;
			} else {
				$velkapismena = "ABCDEFGHIJKLMNOPQRSTUVWXYZŠČŘŽÝÁÍÉŤĎ";


				//pozadovana delka prijmeni je 2-64 znaku.
				if ((!strlen($prijmeni) >= 2) && (!strlen($prijmeni) <= 64)) { //delka jmena 2-64
					print("<style> #prijmeni {background-color:#B82B2D;  }        </style>");
					$validprijmeni = false;
				}
				for ($i = 0; $i < strlen($prijmeni); $i++) { //projedu všechna místa
					if (is_numeric($prijmeni[$i])) {

						$validprijmeni = false;
						print("<style> #prijmeni {background-color:#B82B2D;  }        </style>");
					}
				}
				$jsoutampovoleneznaky1 = false;
				$povoleneznaky = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZěščřžýáíéŠČŘŽÝÁÍÉŤĎ";

				for ($i = 0; $i < mb_strlen($prijmeni); $i++) { //projedu vsechna mista

					if (strpos($povoleneznaky, $prijmeni[$i]) === false) {
						$validprijmeni = false;
						print("<style> #prijmeni {background-color:#B82B2D;  }        </style>");
					}
				}
				if (strpos($velkapismena, $prijmeni[0]) === false) {
					$validprijmeni = false;
					print("<style> #prijmeni {background-color:#B82B2D;  }        </style>");
				}
			}


			//----------------------------------------------------------------------------------------------

			//´´´´´´´´´´´´´´´´´´´´´mail´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´		


			$validmail = true;
			if ($mail == "") {

				print("<style> #mail {background-color:#B82B2D;  }        </style>");
				$validmail = false;
			}

			// Remove all illegal characters from email
			$mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

			// Validate e-mail
			if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			} else {
				$validmail = false;
				print("<style> #mail {background-color:#B82B2D;  }        </style>");
			}
			$povoleneznaky1 = "@_-.abcdefghijklmnopqrstuvwxyz";

			for ($i = 0; $i < mb_strlen($mail); $i++) { //projedu vsechna mista

				if (strpos($povoleneznaky1, $mail[$i]) === false) {
					$validmail = false;
					print("<p>Email obsahuje nepovolene znaky.</p>");
				}
			}
			$sql = "SELECT `iduzivatele` FROM uzivatele WHERE `email` = '$mail' ";

			$result = mysqli_query($conn, $sql);

			//   Kontrola jestli je hodnota z políčka shodná s databází´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
			if (mysqli_num_rows($result) == 1) {
				$validmail = false;
				print("<style> #mail {background-color:#B82B2D;  }        </style>");
			}

			if ($validjmeno == true && $validprijmeni == true && $validmail == true) {
				header("Location: dotaznik1.php ");
			}
		}

		//-------------------------------------------------------------------------------------

		?>
		<div id="box3">
			<h1>Uděl hodnocení tvé univerzitě</h1>
		</div>
		<div id="box2">
			<form method="post" action="<?php print(basename($_SERVER['PHP_SELF'])); ?>">
				<fieldset>
					<h1 id="step">Krok 1:</h1>

					<p for="jmeno" id="popis">Jméno</p>

					<input type="text" name="jmeno" id="jmeno" value="<?= isset($_SESSION["dotaznik"]["jmeno"]) ? $_SESSION["dotaznik"]['jmeno'] : '' ?>"><input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('jmeno').value = ''">
					<p for="prijmeni" id="popis1">Přijmení</p>

					<input type="text" name="prijmeni" id="prijmeni" value="<?= isset($_SESSION["dotaznik"]["prijmeni"]) ? $_SESSION["dotaznik"]['prijmeni'] : '' ?>"><input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('prijmeni').value = ''">
					<p for="skoly" id="popis1">E-mail</p>

					<input type="text" name="mail" id="mail" value="<?= isset($_SESSION["dotaznik"]["mail"]) ? $_SESSION["dotaznik"]['mail'] : '' ?>"><input type="button" class="material-icons" id="reset" value="&#xe5cd;" onclick="document.getElementById('mail').value = ''">
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