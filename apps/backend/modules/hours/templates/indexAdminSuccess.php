<h1>(READ ONLY) Uren schrijven - <strong>Week <?php echo $currentWeek; ?> - <?php echo $projId > 0? $projItem->getName():"";?> </strong></h1>
					<hr>
					
					<?php if ($sf_user->hasFlash('notice')): ?>
						<div class="notice"><?php echo $sf_user->getFlash('notice'); ?></div>
					<?php endif; ?>
					
					<?php if ($sf_user->hasFlash('error')): ?>
						<div class="error"><?php echo $sf_user->getFlash('error'); ?></div>
					<?php endif; ?>
					
					
						<div class="formrow">
							<label for="project">Project</label>
							<select id="select-project" name="project">
								<option value="">Selecteer...</option>
								<?php foreach($projList as $proj):?>
									<option value="<?php echo $proj->getId()?>" <?php echo $projId==$proj->getId()?"selected":""; ?>><?php echo $proj->getName()?>&nbsp;<?php echo $proj->getState()!="A"?"(inactief)":"";?></option>
								<?php endforeach;?>
								
							</select>
							<script>
								$(document).ready(function() {
									$("#select-project").change(function() {
										var curVal;
										curVal = $("#select-project option:selected").val();
										
										window.location = "<?php echo url_for("hours/indexAdmin")?>?w=<?php echo $currentWeek;?>&p="+ curVal;
									
									});
								
								});
							
							</script>
						</div>
						<div class="formrow">
							<label for="project">User</label>
							<select id="select-user" name="project">
								<option value="">Selecteer...</option>
								<?php if($userList):?>
									<?php foreach($userList as $user):?>
										<option value="<?php echo $user->getUserId();?>" <?php echo $userId==$user->getUserId()?"selected":""; ?>><?php echo $user->getInitials()." ".$user->getLastname();?>&nbsp;<?php echo $user->getState()!="A"?"(deleted)":"";?></option>
									<?php endforeach;?>
								<?php endif;?>
								
							</select>
							<script>
								$(document).ready(function() {
									$("#select-user").change(function() {
										var curVal;
										curVal = $("#select-user option:selected").val();
										
										window.location = "<?php echo url_for("hours/indexAdmin")?>?w=<?php echo $currentWeek;?>&p=<?php echo $projId; ?>&u="+ curVal;
									
									});
								
								});
							
							</script>
						</div>
						<hr>
						<?php if($projId > 0 AND $userId > 0):?>
						<p class="paging"><a class="prev" href="<?php echo url_for("hours/indexAdmin?w=".($currentWeek-1)."&p=".$projId."&u=".$userId);?>"><span class="icon">Å</span></a> <a class="next" href="<?php echo url_for("hours/indexAdmin?w=".($currentWeek+1)."&p=".$projId."&u=".$userId);?>"><span class="icon">Ä</span></a>Week <?php echo $currentWeek; ?></p>
						<table id="time" class="tablesorter"> 
							<thead> 
								<tr>
									<th>Projectonderdeel</th>
									<?php for($i=0;$i<=5;$i++):?>
										<th><?php echo date('D d-m-Y', strtotime('+'.$i.' days', strtotime($weekDate1))); ?></th> 
									<?php endfor;?>
									
								</tr> 
							</thead> 
							<tbody> 
							<?php foreach($projItem->getComponents() as $component):?>
								<tr> 
									<td><?php echo $component->getName()?></td>
									
									<?php for($i=0;$i<=5;$i++):?>
										<?php $cdate =  date('Y-m-d', strtotime('+'.$i.' days', strtotime($weekDate1))); ?>
										<td>
											<select class="day<?php echo $i;?>" name="hours[<?php echo $component->getId();?>_<?php echo $cdate;?>]" disabled>
											<?php 
												$curProjHours = HoursPeer::retrieveByDateComponentUser($cdate, $component->getId(), $currentUser->getProfile()->getUserId());
												if($curProjHours)
													$hrAmount = $curProjHours->getAmount();
												else
													$hrAmount = 0;
											
											?>
												<option value=0 <?php echo $hrAmount==0?"selected":"";?> >0</option>
												<option value=1 <?php echo $hrAmount==1?"selected":"";?> >1</option>
												<option value=2 <?php echo $hrAmount==2?"selected":"";?> >2</option>
												<option value=3 <?php echo $hrAmount==3?"selected":"";?> >3</option>
												<option value=4 <?php echo $hrAmount==4?"selected":"";?> >4</option>
												<option value=5 <?php echo $hrAmount==5?"selected":"";?> >5</option>
												<option value=6 <?php echo $hrAmount==6?"selected":"";?> >6</option>
												<option value=7 <?php echo $hrAmount==7?"selected":"";?> >7</option>
												<option value=8 <?php echo $hrAmount==8?"selected":"";?> >8</option>
												<option value=9 <?php echo $hrAmount==9?"selected":"";?> >9</option>
												<option value=10 <?php echo $hrAmount==10?"selected":"";?> >10</option>
												<option value=11 <?php echo $hrAmount==11?"selected":"";?> >11</option>
												<option value=12 <?php echo $hrAmount==12?"selected":"";?> >12</option>
											</select>
										</td>
									<?php endfor;?>
									
									
								</tr>
							<?php endforeach;?>
								
								<tr>
									<td colspan="7">&nbsp;</td>
								</tr>
								<tr>
									<td><strong>Subtotaal</strong></td>
									<td><input type="text" id="total_0" name="total_0" value=0 disabled></td>
									<td><input type="text" id="total_1" name="total_1" value=0 disabled></td>
									<td><input type="text" id="total_2" name="total_2" value=0 disabled></td>
									<td><input type="text" id="total_3" name="total_3" value=0 disabled></td>
									<td><input type="text" id="total_4" name="total_4" value=0 disabled></td>
									<td><input type="text" id="total_5" name="total_5" value=0 disabled></td>
								</tr>
								<tr>
									<td><strong>Totaal deze week</strong></td>
									<td colspan="6"><input type="text" id="sum" name="sum" value=0 disabled></td>
								</tr>
								<tr>
									<td colspan="7">
										<input type="hidden" id="curWeek" name="curWeek" value="<?php echo $currentWeek;?>">
										<input type="hidden" id="curProj" name="curProj" value="<?php echo $projId;?>">
										<input type="hidden" id="curUser" name="curUser" value="<?php echo $userId;?>">
									
									</td>
								</tr>
								
								
							</tbody> 
						</table> 
						<p class="paging"><a class="prev" href="<?php echo url_for("hours/indexAdmin?w=".($currentWeek-1)."&p=".$projId."&u=".$userId);?>"><span class="icon">Å</span></a> <a class="next" href="<?php echo url_for("hours/indexAdmin?w=".($currentWeek+1)."&p=".$projId."&u=".$userId);?>"><span class="icon">Ä</span></a>Week <?php echo $currentWeek; ?></p>
						
					</form>
					<script>
					
						// Sum of time
						$("table#time select").change(function(){
						
						
							$.getJSON('<?php echo url_for("hours/getJsonProjectHours")?>?date='+this.name+'&hourinput='+this.value+'&uid=<?php echo $currentUser->getProfile()->getUserId();?>', function(data) {
								if(data.response == 1)
								{
									alert("Maximaal totaal invoer is 12 uren per dag voor alle projectonderdelen.");	
								}
								
							});
							
							var day0=0,
								day1=0.
								day2=0,
								day3=0,
								day4=0,
								day5=0
								
							$("select.day0").each(function(){
									day0+=parseFloat(this.value);
									$("input#total_0").val(day0);
							});
							$("select.day1").each(function(){
									day1+=parseFloat(this.value);
									$("input#total_1").val(day1);
							});
							$("select.day2").each(function(){
									day2+=parseFloat(this.value);
									$("input#total_2").val(day2);
							});
							$("select.day3").each(function(){
									day3+=parseFloat(this.value);
									$("input#total_3").val(day3);
							});
							$("select.day4").each(function(){
									day4+=parseFloat(this.value);
									$("input#total_4").val(day4);
							});
							$("select.day5").each(function(){
									day5+=parseFloat(this.value);
									$("input#total_5").val(day5);
							});
							
							var sum0=parseFloat($("input#total_0").val()),
								sum1=parseFloat($("input#total_1").val()),
								sum2=parseFloat($("input#total_2").val()),
								sum3=parseFloat($("input#total_3").val()),
								sum4=parseFloat($("input#total_4").val()),
								sum5=parseFloat($("input#total_5").val()),
								sum=sum0+sum1+sum2+sum3+sum4+sum5
							$("input#sum").val(sum);
							if(day0==this.value || day1==this.value || day2==this.value || day3==this.value || day4==this.value || day5==this.value){
								return true;
							}
							return false;
							
						});
						
						
						$(document).ready(function() {	
							var day0=0,
								day1=0.
								day2=0,
								day3=0,
								day4=0,
								day5=0
								
							$("select.day0").each(function(){
									day0+=parseFloat(this.value);
									$("input#total_0").val(day0);
							});
							$("select.day1").each(function(){
									day1+=parseFloat(this.value);
									$("input#total_1").val(day1);
							});
							$("select.day2").each(function(){
									day2+=parseFloat(this.value);
									$("input#total_2").val(day2);
							});
							$("select.day3").each(function(){
									day3+=parseFloat(this.value);
									$("input#total_3").val(day3);
							});
							$("select.day4").each(function(){
									day4+=parseFloat(this.value);
									$("input#total_4").val(day4);
							});
							$("select.day5").each(function(){
									day5+=parseFloat(this.value);
									$("input#total_5").val(day5);
							});
							
							var sum0=parseFloat($("input#total_0").val()),
								sum1=parseFloat($("input#total_1").val()),
								sum2=parseFloat($("input#total_2").val()),
								sum3=parseFloat($("input#total_3").val()),
								sum4=parseFloat($("input#total_4").val()),
								sum5=parseFloat($("input#total_5").val()),
								sum=sum0+sum1+sum2+sum3+sum4+sum5
							$("input#sum").val(sum);
							if(day0==this.value || day1==this.value || day2==this.value || day3==this.value || day4==this.value || day5==this.value){
								return true;
							}
							return false;
							
						});
					
					</script>
					<?php endif;?>