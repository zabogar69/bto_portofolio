<a class="add" href="<?php echo url_for("user/new");?>"><span class="icon">]</span> Nieuwe gebruiker</a>
					<h1>Gebruikers beheren</h1>
					<hr>
					<?php if($currentUser->isSuperAdmin()):?>
						<form id="select-company" action="" method="post">
							<div class="formrow">
								<label for="company">Bedrijf</label>
								<select id="company" name="company">
									<option value="0">Alle</option>
									<?php foreach($companyList as $company):?>
										<option value="<?php echo $company->getId();?>"><?php echo $company->getName();?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</form>
						
						<script>
						$(document).ready(function() {
							$("#select-company").change(function() {
								var curVal;
								curVal = $("#select-company option:selected").val();
								
								window.location = "<?php echo url_for("user/index")?>?cid="+ curVal;
							
							});
						
						});
						
						</script>
					<?php endif;?>
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
							<?php foreach($users as $user):?>
								<tr> 
									<td><?php echo $user->getInitials().". ".$user->getLastname()?> <?php echo $user->getState()=="I"?"<em style=\"color:red;\">(deleted)</em>":""?> </td> 
									<td><?php echo $user->getInitials().". ".$user->getLastname()?></td> 
									<td><?php echo $user->getBsn()?></td>
									<td><a href="<?php echo url_for("user/edit?id=".$user->getId());?>"><span class="icon">&amp;</span></a></td> 
									<td>
										<a href="<?php echo url_for("user/delete?id=".$user->getId());?>">
											<?php echo link_to('<span class="icon">X</span>', 'user_delete', $user, array('class' => 'del','method' => 'delete', 'confirm' =>'Are you sure?'))?>			</a>
									</td> 
								</tr> 
							<?php endforeach; ?>
							
						</tbody> 
					</table> 
					<p class="paging"><a class="first" href="#"><span class="icon">Ç</span></a> <a class="prev" href="#"><span class="icon">Å</span></a> <a class="next" href="#"><span class="icon">Ä</span></a> <a class="last" href="#"><span class="icon">É</span></a>1 van 35</p>