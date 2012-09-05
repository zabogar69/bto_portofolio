<? include("header.php"); ?>
<body id="login">
	<div id="wrapper">
		<div id="header">
			<img src="images/logo-bto.png" alt="BTO Zaanstad | WBSO urenregistratie" height="100" width="680">
		</div>
		<div id="content">
			<div class="container" style="width: 560px; margin: 0 auto;">
				<h1>Aanmelden</h1>
				<hr>
				<p class="error">Deze combinatie is onjuist!<br>Probeer het nog een keer of neem contact op met de beheerder.</p>
				<form id="login" action="home.php" method="post">
					<div class="formrow">
						<label for="useremail">E-mailadres</label>
						<input type="email" value="" name="useremail" id="useremail" class="email" required>
					</div>
					<div class="formrow">
						<label for="password">Wachtwoord</label>
						<input type="password" value="" id="password" name="password" class="password" required>
					</div>
					<div class="formrow">
						<label>&nbsp;</label>
						<button type="submit" id="submit">Aanmelden</button>
						<br class="close">
					</div>
				</form>
				<p><a href="wachtwoord-vergeten.php">Wachtwoord vergeten</a></p>
			</div>
		</div>
<? include("footer.php"); ?>