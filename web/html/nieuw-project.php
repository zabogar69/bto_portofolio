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
					<h1>Nieuw project</h1>
					<hr>
					<form id="add-project" action="projecten-beheren.php" method="post">
						<div class="formrow">
							<label for="project">Naam project *</label>
							<input type="text" value="" name="project" id="project" required>
						</div>
						<div class="formrow">
							<label for="description">Korte omschrijving</label>
							<textarea name="description" id="description"></textarea>
						</div>
						<div class="formrow">
							<label for="time">Toegekend WSBO uren</label>
							<input type="time" value="" name="time" id="time" required>
						</div>
						<div class="formrow">
							<label for="start">Start project</label>
							<select id="start" name="start" required>
								<option value="">Selecteer...</option>
								<option value="1 januari">1 januari</option>
								<option value="1 februari">1 februari</option>
								<option value="1 maart">1 maart</option>
								<option value="1 april">1 april</option>
								<option value="1 mei">1 mei</option>
								<option value="1 juni">1 juni</option>
								<option value="1 juli">1 juli</option>
								<option value="1 augustus">1 augustus</option>
								<option value="1 september">1 september</option>
								<option value="1 oktober">1 oktober</option>
								<option value="1 november">1 november</option>
								<option value="1 december">1 december</option>
							</select>
						</div>
						<div class="formrow">
							<label for="length">Duur project</label>
							<select id="length" name="length" required>
								<option value="">Selecteer...</option>
								<option value="3 maanden">3 maanden</option>
								<option value="4 maanden">4 maanden</option>
								<option value="5 maanden">5 maanden</option>
								<option value="12 maanden">12 maanden</option>
							</select>
						</div>
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