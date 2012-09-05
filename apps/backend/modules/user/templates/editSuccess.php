<h1>Nieuwe gebruiker</h1>
					<hr>
					<?php echo form_tag_for($formProfile, '@user', array('name'=>'editForm')) ?>
					<?php echo $formProfile->renderHiddenFields(false) ?>
						<div class="formrow">
							<label for="title"><?php echo $formProfile['gender']->renderLabel('Aanhef') ?></label>
							<?php echo $formProfile['gender']->render(array('required'=>'true')) ?>
						</div>
						<div class="formrow">
							<label for="firstletters"><?php echo $formProfile['initials']->renderLabel('Voorletter(s)') ?></label>
							<?php echo $formProfile['initials']->render(array('required'=>'true')) ?>
						</div>
						<div class="formrow">
							<label for="name"><?php echo $formProfile['lastname']->renderLabel('Achternaam') ?></label>
							<?php echo $formProfile['lastname']->render(array('required'=>'true')) ?>
						</div>
						<div class="formrow">
							<label for="name"><?php echo $formProfile['bsn']->renderLabel('bsn') ?></label>
							<?php echo $formProfile['bsn']->render() ?>
						</div>
						<?php if($currentUser->isSuperAdmin()):?>
								<div class="formrow">
									<label for="name"><?php echo $formProfile['company_id']->renderLabel('Bedrijf') ?></label>
									<?php echo $formProfile['company_id']->render() ?>
								</div>
								<?php if($isEdit):?>
									<script>
										$(document).ready(function() {
										
												var curVal;
												
												curVal = $("#sf_guard_user_profile_company_id option:selected").val();
												var projString;
												$("#user_project_container").html("");
												
												$.getJSON('<?php echo url_for("user/getJsonProject")?>?cid='+curVal+'&uid=<?php echo $sfgUser->getId();?>', function(data) {
													
													$.each(data, function() {
														projString =  "<input type='checkbox' name='user_project[]' id='project"+ this.id+"' value='"+ this.id+"' "+this.checked+" ><label class='nofloat' for='"+ this.id+"'>"+ this.name+"</label><br />";
														
														$("#user_project_container").append(projString);
													});
												});
										});
									</script>
								
								<?php else: ?>
									<script>
										$(document).ready(function() {
										
											$("#sf_guard_user_profile_company_id").change(function() {
												var curVal;
												
												curVal = $("#sf_guard_user_profile_company_id option:selected").val();
												var projString;
												$("#user_project_container").html("");
												
												$.getJSON('<?php echo url_for("user/getJsonProject")?>?cid='+curVal, function(data) {
													
													$.each(data, function() {
														projString =  "<input type='checkbox' name='user_project[]' id='project"+ this.id+"' value='"+ this.id+"'><label class='nofloat' for='"+ this.id+"'>"+ this.name+"</label><br />";
														
														$("#user_project_container").append(projString);
													});
												});
											});
										});
									</script>
							<?php endif;?>
						
						<?php else: ?>
							<input type="hidden" id="sf_guard_user_profile_company_id" name="sf_guard_user_profile[company_id]" value="<?php echo $currentUser->getProfile()->getCompanyId();?>" />
							<?php if($isEdit):?>
								<script>
									$(document).ready(function() {
										var curVal;
										curVal = $("#sf_guard_user_profile_company_id").val();
										var projString;
										$("#user_project_container").html("");
										$.getJSON('<?php echo url_for("user/getJsonProject")?>?cid='+curVal+'&uid=<?php echo $sfgUser->getId();?>', function(data) {
											$.each(data, function() {
												projString =  "<input type='checkbox' name='user_project[]' id='project"+ this.id+"' value='"+ this.id+"' "+this.checked+" ><label class='nofloat' for='"+ this.id+"'>"+ this.name+"</label><br />";
												$("#user_project_container").append(projString);
											});
										});
									});
								</script>
							<?php else: ?>
								<script>
									$(document).ready(function() {
										var curVal;
										curVal = $("#sf_guard_user_profile_company_id").val();
										var projString;
										$("#user_project_container").html("");
										$.getJSON('<?php echo url_for("user/getJsonProject")?>?cid='+curVal, function(data) {
											$.each(data, function() {
												projString =  "<input type='checkbox' name='user_project[]' id='project"+ this.id+"' value='"+ this.id+"' "+this.checked+" ><label class='nofloat' for='"+ this.id+"'>"+ this.name+"</label><br />";
												$("#user_project_container").append(projString);
											});
										});
									});
								</script>
							<?php endif;?>
							
						<?php endif;?>
						<hr />
						
						<?php if($isEdit):?>
							<div class="formrow">
								<label for="email">E-mailadres *</label>
								<?php echo $sfgUser->getUsername(); ?>
							</div>
							<div class="formrow">
								<label for="password">Wachtwoord *</label>
								<input type="password" value="" id="password1" name="password1" >
							</div>
							<div class="formrow">
									<label for="confirm_password">Wachtwoord herhalen *</label>
									<input type="password" value="" name="password2" id="password2" >
							</div>
						<?php else: ?>
							<div class="formrow">
								<label for="email">E-mailadres *</label>
								<input type="email" value="" name="email" id="email" class="email" required >
							</div>
							<div class="formrow">
								<label for="password">Wachtwoord *</label>
								<input type="password" value="" id="password" name="password" class="password" >
							</div>
							<div class="formrow">
									<label for="confirm_password">Wachtwoord herhalen *</label>
									<input type="password" value="" id="confirm_password" name="confirm_password" class="confirm_password" >
							</div>
							
						<?php endif; ?>
						
						
						
						
						
						
						<hr>
						<p>Maakt WBSO uren voor:</p>
						<div class="formrow" id="user_project_container">
							
						</div>
						<hr>
						<div class="formrow">
							<label>&nbsp;</label>
							<button type="submit">Opslaan</button> <button type="submit">Opslaan en direct project aanmaken</button> <a class="cancel" href="home.php">Annuleren</a>
							<br class="close">
						</div>
					</form>