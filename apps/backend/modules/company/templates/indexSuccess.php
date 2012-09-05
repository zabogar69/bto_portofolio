<a class="add" href="<?php echo url_for("company/new");?>"><span class="icon">]</span> Nieuw bedrijf</a>
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
						<?php foreach ($companies as $company):?>
							<?php $supervisor = $company->retrieveSupervisorProfile(); 	?>
							<tr> 
								<td><?php echo $company->getName(); ?>&nbsp;<?php echo $company->getState()=="I"?"<em style=\"color:red;\">(deleted)</em>":""?></td> 
								<td> <?php echo $supervisor->getInitials()." ".$supervisor->getLastname();?></td> 
								<td><?php echo $company->getCity(); ?></td> 
								<?php if($company->getState() == "A"):?>
									<td><a href="<?php echo url_for("company/edit?id=".$company->getId());?>"><span class="icon">&amp;</span></a></td> 
									<td>
									
										<?php echo link_to('<span class="icon">X</span>', 'company_delete', $company, array('class' => 'del','method' => 'delete', 'confirm' =>'Are you sure?'))?>
									
									</td> 
								<?php endif;?>
							</tr> 
						<?php endforeach;?>
							
						</tbody> 
					</table> 
					<p class="paging"><a class="first" href="#"><span class="icon">Ç</span></a> <a class="prev" href="#"><span class="icon">Å</span></a> <a class="next" href="#"><span class="icon">Ä</span></a> <a class="last" href="#"><span class="icon">É</span></a>1 van 35</p>