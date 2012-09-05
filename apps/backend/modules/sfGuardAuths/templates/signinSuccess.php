<h1>Aanmelden</h1>
				<hr>
				<p class="error">Deze combinatie is onjuist!<br>Probeer het nog een keer of neem contact op met de beheerder.</p>
				<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
					<div class="formrow">
						<label for="useremail">E-mailadres</label>
						<input value="" name="signin[username]" id="signin_username">
					</div>
					<div class="formrow">
						<label for="password">Wachtwoord</label>
						<input type="password" value="" id="signin_password" name="signin[password]" class="password" required>
					</div>
					<div class="formrow">
						<label>&nbsp;</label>
						<button type="submit" id="submit">Aanmelden</button>
						<br class="close">
					</div>
				</form>
				<p><a href="wachtwoord-vergeten.php">Wachtwoord vergeten</a></p>