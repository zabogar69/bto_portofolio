<? include("header.php"); ?>
<body id="logged">
	<div id="wrapper">
		<div id="header">
			<p class="logged"><span class="icon">U</span>Ingelogd: Nikaj Eijk | <a href="index.php">Afmelden</a><br>
			<span class="icon">K</span><a class="popup fancybox.iframe" href="hulp.html">Hulp</a></p>
			<img src="images/logo-bto.png" alt="BTO Zaanstad | WBSO urenregistratie" height="100" width="680">
		</div>
		<div id="content">
			<div id="left">
				<? include("navigation.php"); ?>
			</div>
			<div id="right">
				<div class="container">
					<h1>Nieuwe gebruiker</h1>
					<hr>
					<form id="add-company" action="gebruikers-beheren.php" method="post">
						<div class="formrow">
							<label for="title">Aanhef</label>
							<select id="title" name="title">
								<option value="dhr">Dhr.</option>
								<option value="mevr">Mevr.</option>
							</select>
						</div>
						<div class="formrow">
							<label for="firstletters">Voorletter(s)</label>
							<input type="text" value="" name="firstletters" id="firstletters" required>
						</div>
						<div class="formrow">
							<label for="name">Naam</label>
							<input type="text" value="" name="name" id="name" required>
						</div>
						<div class="formrow">
							<label for="bsn">BSN Nummer</label>
							<input type="text" value="" name="bsn" id="bsn" required>
						</div>
						<hr>
						<div class="formrow">
							<label for="email">E-mailadres *</label>
							<input type="email" value="" name="email" id="email" class="email" required>
						</div>
						<div class="formrow">
							<label for="password">Wachtwoord *</label>
							<input type="password" value="" id="password" name="password" class="password" required>
						</div>
						<div class="formrow">
							<label for="confirm_password">Wachtwoord herhalen *</label>
							<input type="password" value="" id="confirm_password" name="confirm_password" class="confirm_password" required>
						</div>
						<hr>
						<p>Maakt WBSO uren voor:</p>
						<div class="formrow">
							<input type="checkbox" name="project1" id="project1"><label class="nofloat" for="project1">Project 1</label><br>
							<input type="checkbox" name="project2" id="project2"><label class="nofloat" for="project2">Project 2</label><br>
							<input type="checkbox" name="project3" id="project3"><label class="nofloat" for="project3">Project 3</label><br>
						</div>
						<hr>
						<div class="formrow">
							<label>&nbsp;</label>
							<button type="submit">Opslaan</button> <button type="submit">Opslaan en direct project aanmaken</button> <a class="cancel" href="home.php">Annuleren</a>
							<br class="close">
						</div>
					</form>
				</div>
			</div>
			<br class="close">
			<div id="footerspace"><!-- --></div>
		</div>
	</div>
<? include("footer.php"); ?>