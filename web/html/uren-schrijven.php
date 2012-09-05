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
					<h1>Uren schrijven - <strong>Week 27</strong></h1>
					<hr>
					<form id="select-company" action="" method="post">
						<div class="formrow">
							<label for="project">Project</label>
							<select id="project" name="project" required>
								<option value="">Selecteer...</option>
								<option value="Project 1">Project 1</option>
								<option value="Project 2">Project 2</option>
								<option value="Project 3">Project 3</option>
							</select>
						</div>
						<hr>
						<p class="paging"><a class="prev" href="#"><span class="icon">Å</span></a> <a class="next" href="#"><span class="icon">Ä</span></a>Week 27</p>
						<table id="time" class="tablesorter"> 
							<thead> 
								<tr>
									<th>Projectonderdeel</th>
									<th>MA 19-08</th> 
									<th>DI 20-08</th> 
									<th>WO 21-08</th>
									<th>DO 22-08</th> 
									<th>VR 23-08</th> 
									<th>ZA 24-08</th> 
								</tr> 
							</thead> 
							<tbody> 
								<tr> 
									<td>Naam projectonderdeel</td>
									<td>
										<select class="day1" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day2" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day3" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td>
									<td>
										<select class="day4" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day5" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day6" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
								</tr>
								<tr> 
									<td>Naam projectonderdeel</td>
									<td>
										<select class="day1" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day2" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day3" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td>
									<td>
										<select class="day4" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day5" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day6" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
								</tr>
								<tr> 
									<td>Naam projectonderdeel</td>
									<td>
										<select class="day1" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day2" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day3" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td>
									<td>
										<select class="day4" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day5" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day6" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
								</tr>
								<tr> 
									<td>Naam projectonderdeel</td>
									<td>
										<select class="day1" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day2" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day3" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td>
									<td>
										<select class="day4" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day5" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day6" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
								</tr>
								<tr> 
									<td>Naam projectonderdeel</td>
									<td>
										<select class="day1" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day2" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day3" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td>
									<td>
										<select class="day4" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day5" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day6" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
								</tr>
								<tr> 
									<td>Naam projectonderdeel</td>
									<td>
										<select class="day1" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day2" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day3" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td>
									<td>
										<select class="day4" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day5" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
									<td>
										<select class="day6" name="projectpart">
											<option value=0>0</option>
											<option value=1>1</option>
											<option value=2>2</option>
											<option value=3>3</option>
											<option value=4>4</option>
											<option value=5>5</option>
											<option value=6>6</option>
											<option value=7>7</option>
											<option value=8>8</option>
											<option value=9>9</option>
											<option value=10>10</option>
											<option value=11>11</option>
											<option value=12>12</option>
										</select>
									</td> 
								</tr>
								<tr>
									<td colspan="7">&nbsp;</td>
								</tr>
								<tr>
									<td><strong>Subtotaal</strong></td>
									<td><input type="text" id="total_1" name="total_1" value=0 disabled></td>
									<td><input type="text" id="total_2" name="total_2" value=0 disabled></td>
									<td><input type="text" id="total_3" name="total_3" value=0 disabled></td>
									<td><input type="text" id="total_4" name="total_4" value=0 disabled></td>
									<td><input type="text" id="total_5" name="total_5" value=0 disabled></td>
									<td><input type="text" id="total_6" name="total_6" value=0 disabled></td>
								</tr>
								<tr>
									<td><strong>Totaal deze week</strong></td>
									<td colspan="6"><input type="text" id="sum" name="sum" value=0 disabled></td>
								</tr>
							</tbody> 
						</table> 
					</form>
					<p class="paging"><a class="prev" href="#"><span class="icon">Å</span></a> <a class="next" href="#"><span class="icon">Ä</span></a>Week 27</p>
				</div>
			</div>
			<br class="close">
			<div id="footerspace"><!-- --></div>
		</div>
	</div>
<? include("footer.php"); ?>