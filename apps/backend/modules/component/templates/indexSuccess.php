<a class="add" href="<?php echo url_for("component/new");?>"><span class="icon">]</span> Nieuw projectonderdeel</a>
					<h1>Projectonderdelen beheren</h1>
					<hr>
					<?php $totalPage = count($pager->getLinks());?>
					<p class="paging"><a class="first" href="<?php echo '?page='.$pager->getFirstPage();?>"><span class="icon">Ç</span></a> <a class="prev" href="<?php echo '?page='.$pager->getPreviousPage();?>"><span class="icon">Å</span></a> <a class="next" href="<?php echo '?page='.$pager->getNextPage();?>"><span class="icon">Ä</span></a> <a class="last" href="<?php echo '?page='.$pager->getLastPage();?>"><span class="icon">É</span></a><?php echo $pager->getPage();?> van <?php echo $totalPage;?></p>
					<table id="projectparts" class="tablesorter"> 
						<thead> 
							<tr> 
								<th>Projectnaam</th> 
								<th>Projectonderdeel</th> 
								<th>Aangemaakt door</th> 
								<th style="width: 20px;"></th> 
								<th style="width: 20px;"></th> 
							</tr> 
						</thead> 
						<tbody> 
						<?php foreach ($pager->getResults() as $projectonderdeel):?>
							<tr> 
								<?php
								$projectId = $projectonderdeel->getBtoprojectId();
								
								$c = new Criteria();
								$c->add(BtoprojectPeer::ID, $projectId);
								
								$project = BtoprojectPeer::doSelectOne($c);
								?>
								
								<td><?php echo $project->getName(); ?></td> 
								<td><?php echo $projectonderdeel->getName(); ?>&nbsp;<?php echo $projectonderdeel->getState()=="I"?"<em style=\"color:red;\">(inactief)</em>":""?></td> 
								
								<?php
								$company = $project->getCompany();
								$supervisor = $company->retrieveSupervisorProfile();
								
								?>
								<td><?php echo $supervisor->getInitials(); ?> <?php echo $supervisor->getMiddlename(); ?> <?php echo $supervisor->getLastname(); ?></td> 
								<td><a href="<?php echo url_for("component/edit?id=".$projectonderdeel->getId());?>"><span class="icon">&amp;</span></a></td> 
								<td>
									<?php $form = new BaseForm(); if ($form->isCSRFProtected()): ?>
								    	<input type="hidden" name="<?php echo $form->getCSRFFieldName() ?>" value="<?php echo $form->getCSRFToken() ?>" />
								  	<?php endif; ?>
									<?php if($projectonderdeel->getState()=="A"):?>
										<?php echo link_to('<span class="icon">X</span>', 'component_delete', $projectonderdeel, array('class' => 'del','method' => 'delete', 'confirm' =>'Are you sure?'))?>
									<?php endif; ?>
								</td> 
							</tr> 
						<?php endforeach;?>
							
						</tbody> 
					</table> 
					<p class="paging"><a class="first" href="<?php echo '?page='.$pager->getFirstPage();?>"><span class="icon">Ç</span></a> <a class="prev" href="<?php echo '?page='.$pager->getPreviousPage();?>"><span class="icon">Å</span></a> <a class="next" href="<?php echo '?page='.$pager->getNextPage();?>"><span class="icon">Ä</span></a> <a class="last" href="<?php echo '?page='.$pager->getLastPage();?>"><span class="icon">É</span></a><?php echo $pager->getPage();?> van <?php echo $totalPage;?></p>