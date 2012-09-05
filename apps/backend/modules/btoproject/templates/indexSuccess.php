<a class="add" href="<?php echo url_for("btoproject/new");?>"><span class="icon">]</span> Nieuw project</a>
					<h1>Projecten beheren</h1>
					<hr>
					<?php $totalPage = count($pager->getLinks());?>
					<p class="paging"><a class="first" href="<?php echo '?page='.$pager->getFirstPage();?>"><span class="icon">Ç</span></a> <a class="prev" href="<?php echo '?page='.$pager->getPreviousPage();?>"><span class="icon">Å</span></a> <a class="next" href="<?php echo '?page='.$pager->getNextPage();?>"><span class="icon">Ä</span></a> <a class="last" href="<?php echo '?page='.$pager->getLastPage();?>"><span class="icon">É</span></a><?php echo $pager->getPage();?> van <?php echo $totalPage;?></p>
					<table id="projects" class="tablesorter"> 
						<thead> 
							<tr> 
								<th>Projectnaam</th> 
								<th>WBSO uren</th> 
								<th>Start</th> 
								<th>Aanvraagperiode</th> 
								<th style="width: 20px;"></th> 
								<th style="width: 20px;"></th> 
							</tr> 
						</thead> 
						<tbody> 
						<?php foreach ($pager->getResults() as $project):?>
							<tr> 
								<td><?php echo $project->getName(); ?> &nbsp;<?php echo $project->getState()!="A"?"<em style='color:red'>(deleted)</em>":"";?></td> 
								<td><?php echo $project->getHours(); ?></td> 
								<td><?php echo date("Y", strtotime($project->getStartdate())); ?></td> 
								<td><?php echo $project->getDuration(); ?> maanden</td> 
								<td><a href="<?php echo url_for("btoproject/edit?id=".$project->getId());?>"><span class="icon">&amp;</span></a></td> 
								<td>
									<?php $form = new BaseForm(); if ($form->isCSRFProtected()): ?>
								    	<input type="hidden" name="<?php echo $form->getCSRFFieldName() ?>" value="<?php echo $form->getCSRFToken() ?>" />
								  	<?php endif; ?>
									
									<?php if($project->getState()=="A"):?>
										<?php echo link_to('<span class="icon">X</span>', 'btoproject_delete', $project, array('class' => 'del','method' => 'delete', 'confirm' =>'Are you sure?'))?>
									<?php endif;?>
								</td> 
							</tr> 
						<?php endforeach;?>
							
						</tbody> 
					</table> 
					<p class="paging"><a class="first" href="<?php echo '?page='.$pager->getFirstPage();?>"><span class="icon">Ç</span></a> <a class="prev" href="<?php echo '?page='.$pager->getPreviousPage();?>"><span class="icon">Å</span></a> <a class="next" href="<?php echo '?page='.$pager->getNextPage();?>"><span class="icon">Ä</span></a> <a class="last" href="<?php echo '?page='.$pager->getLastPage();?>"><span class="icon">É</span></a><?php echo $pager->getPage();?> van <?php echo $totalPage;?></p>