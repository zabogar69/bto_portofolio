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
					<a class="add" href="nieuw-bedrijf.php"><span class="icon">]</span> Nieuw bedrijf</a>
					<h1>Bedrijven beheren</h1>
					<hr>
					<p class="paging"><a class="first" href="#"><span class="icon">Ç</span></a> <a class="prev" href="#"><span class="icon">Å</span></a> <a class="next" href="#"><span class="icon">Ä</span></a> <a class="last" href="#"><span class="icon">É</span></a>1 van 35</p>
					<table id="companies" class="tablesorter"> 
						<thead> 
							<tr> 
								<th>Berijfsnaam</th> 
								<th>Supervisor</th> 
								<th>Vestigingsplaats</th> 
								<th style="width: 20px;"></th> 
								<th style="width: 20px;"></th> 
							</tr> 
						</thead> 
						<tbody> 
							<tr> 
								<td>BTO Zaanstad</td> 
								<td>Henk Smit</td> 
								<td>Zaandam</td> 
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="BTO Zaanstad" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>Bedrijfsnaam</td> 
								<td>IEmand</td> 
								<td>Wormerveer</td> 
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="Bedrijfsnaam" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>Webcontent</td> 
								<td>Nikaj Eijk</td> 
								<td>Zaandam</td> 
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="Webcontent" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>BTO Zaanstad</td> 
								<td>Henk Smit</td> 
								<td>Zaandam</td> 
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="BTO Zaanstad" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>Bedrijfsnaam</td> 
								<td>IEmand</td> 
								<td>Wormerveer</td> 
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="Bedrijfsnaam" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>Webcontent</td> 
								<td>Nikaj Eijk</td> 
								<td>Zaandam</td> 
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="Webcontent" href="#"><span class="icon">X</span></a></td> 
							</tr>  
							<tr> 
								<td>BTO Zaanstad</td> 
								<td>Henk Smit</td> 
								<td>Zaandam</td> 
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="BTO Zaanstad" href="#"><span class="icon">X</span></a></td> 
							</tr> 
						</tbody> 
					</table> 
					<p class="paging"><a class="first" href="#"><span class="icon">Ç</span></a> <a class="prev" href="#"><span class="icon">Å</span></a> <a class="next" href="#"><span class="icon">Ä</span></a> <a class="last" href="#"><span class="icon">É</span></a>1 van 35</p>
				</div>
			</div>
			<br class="close">
			<div id="footerspace"><!-- --></div>
		</div>
	</div>
<? include("footer.php"); ?>