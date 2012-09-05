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
					<h1>Nieuw projectonderdeel</h1>
					<hr>
					<form id="add-project" action="projectonderdelen-beheren.php" method="post">
						<div class="formrow">
							<label for="company">Bedrijf</label>
							<select id="company" name="company" required>
								<option value="">Selecteer...</option>
								<option value="BTO Zaanstad">BTO Zaanstad</option>
								<option value="Webcontent">Webcontent</option>
								<option value="Bedrijf 3">Bedrijf 3</option>
							</select>
						</div>
						<div class="formrow">
							<label for="project">Project</label>
							<select id="project" name="project" required>
								<option value="">Selecteer...</option>
								<option value="Project 1">Project 1</option>
								<option value="Project 2">Project 2</option>
								<option value="Project 3">Project 3</option>
							</select>
						</div>
						<div class="formrow">
							<label for="projectpart">Naam projectonderdeel *</label>
							<input type="text" value="" name="projectpart" id="projectpart" required>
						</div>
						<div class="formrow">
							<label for="description">Korte omschrijving</label>
							<textarea name="description" id="description"></textarea>
						</div>
						<div class="formrow">
							<label>&nbsp;</label>
							<button type="submit">Opslaan</button> <a class="cancel" href="home.php">Annuleren</a>
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