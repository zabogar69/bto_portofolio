<? include("header.php"); ?>
<body id="login">
	<div id="wrapper">
		<div id="header">
			<img src="images/logo-bto.png" alt="BTO Zaanstad | WBSO urenregistratie" height="100" width="680">
		</div>
		<div id="content">
			<div class="container" style="width: 560px; margin: 0 auto;">
				<h1>Wachtwoord vergeten</h1>
				<hr>
				<p>Vul hier uw e-mailadres in dat bij ons bekend is. Er wordt dan een nieuw wachtwoord naar het desbetreffende e-mailadres gestuurd.</p>
				<br>
				<p class="error">Dit mailadres is in ons systeem niet bekend.<br>Probeer het nog een keer of neem contact op met de beheerder.</p>
				<form id="forgot-password" action="home.php" method="post">
					<div class="formrow">
						<label for="useremail">E-mailadres</label>
						<input type="email" value="" name="useremail" id="useremail" class="email" required>
					</div>
					<div class="formrow">
						<label>&nbsp;</label>
						<button type="submit" id="submit">Verzenden</button> <a class="cancel" href="index.php">Annuleren</a>
						<br class="close">
					</div>
				</form>
			</div>
		</div>
<? include("footer.php"); ?>