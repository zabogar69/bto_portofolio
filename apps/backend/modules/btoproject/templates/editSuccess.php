<?php use_helper('I18N', 'Date', 'JavascriptBase', 'Javascript' ,'Object') ?>
<h1>Nieuw project</h1>
					<hr>
					
					<?php echo form_tag_for($form, '@btoproject', array('name'=>'editForm')) ?>
						<?php echo $form->renderHiddenFields(false) ?>
						<?php if($isSuperAdmin):?>
							<div class="formrow">
								<label for="company"><?php echo $form['company_id']->renderLabel('Bedrijf') ?></label>
								<?php
							  		echo object_select_tag($form['company_id']->getValue(), '',
														array('related_class' => 'Company',
															'peer_method' => 'getAllItems',
															'peer_method_parameter' => 'true',
															'control_name' => 'btoproject[company_id]',
															'text_method' => 'getName',
															'key_method'=>'getPrimaryKey',
															'onchange'=>remote_function(array('update' => 'componentProject',
																				'url' => 'component/getComponentProject',
																				'with' => "'company=' + this.value",))));
								?>
							</div>
						<?php else:?>
							<input type='hidden' name='btoproject[company_id]' id='btoproject_company_id' value='<?php echo $userProfile->getCompanyId();?>'>
						<?php endif;?>
						<div class="formrow">
							<label for="project"><?php echo $form['name']->renderLabel('Naam project *') ?></label>
							<?php echo $form['name']->render(array('required'=>'true')); ?>
						</div>
						<div class="formrow">
							<label for="description"><?php echo $form['description']->renderLabel('Korte Omschrijving') ?></label>
							<?php echo $form['description']->render(array('required'=>'true')); ?>
						</div>
						<div class="formrow">
							<label for="hours"><?php echo $form['hours']->renderLabel('Toegekend WSBO uren') ?></label>
							<?php echo $form['hours']->render(); ?>
						</div>
						<div class="formrow">
							<label for="startdate"><?php echo $form['startdate']->renderLabel('Start project') ?></label>
							<?php echo $form['startdate']->render(); ?>
							<input type='hidden' name='btoproject[startdate][day]' id='btoproject_startdate_day' value='1'>
							<input type='hidden' name='btoproject[startdate][month]' id='btoproject_startdate_month' value='1'>
						</div>
						<div class="formrow">
							<label for="duration"><?php echo $form['duration']->renderLabel('Aanvraagperiode') ?></label>
							<?php echo $form['duration']->render(); ?>
						</div>
						<div class="formrow">
							<label>&nbsp;</label>
							<button type="submit">Opslaan</button><a class="cancel" href="home.php">Annuleren</a>
							<br class="close">
						</div>
					</form>