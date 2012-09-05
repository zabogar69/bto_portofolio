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
					<a class="add" href="nieuwe-gebruiker.php"><span class="icon">]</span> Nieuwe gebruiker</a>
					<h1>Gebruikers beheren</h1>
					<hr>
					<form id="select-company" action="" method="post">
						<div class="formrow">
							<label for="company">Bedrijf</label>
							<select id="company" name="company">
								<option value="">Selecteer...</option>
								<option value="BTO Zaanstad">BTO Zaanstad</option>
								<option value="Webcontent">Webcontent</option>
								<option value="Bedrijf 3">Bedrijf 3</option>
							</select>
						</div>
					</form>
					<hr>
					<p class="paging"><a class="first" href="#"><span class="icon">Ç</span></a> <a class="prev" href="#"><span class="icon">Å</span></a> <a class="next" href="#"><span class="icon">Ä</span></a> <a class="last" href="#"><span class="icon">É</span></a>1 van 35</p>
					<table id="projectparts" class="tablesorter"> 
						<thead> 
							<tr> 
								<th>Gebruiker</th> 
								<th>E-mail adres</th> 
								<th>BSN nummer</th>
								<th style="width: 20px;"></th> 
								<th style="width: 20px;"></th> 
							</tr> 
						</thead> 
						<tbody> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
							</tr> 
							<tr> 
								<td>N. Eijk</td> 
								<td>info@webcontent.nl</td> 
								<td>1542.278.268</td>
								<td><a href="bewerken.php"><span class="icon">&amp;</span></a></td> 
								<td><a class="del" rel="N. Eijk" href="#"><span class="icon">X</span></a></td> 
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