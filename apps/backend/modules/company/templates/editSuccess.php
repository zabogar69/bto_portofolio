<h1>Nieuw bedrijf</h1>
					<hr>
					<h2>Algemene bedrijfsgegevens</h2>
					<br>
					<?php echo form_tag_for($form, '@company', array('name'=>'editForm')) ?>
						<?php echo $form->renderHiddenFields(false) ?>
						<div class="formrow">
							<label for="company"><?php echo $form['name']->renderLabel('Bedrijfsnaam') ?></label>
							<?php echo $form['name']->render(array('required'=>'true')); ?>
						</div>
						<div class="formrow">
							<label for="description"><?php echo $form['description']->renderLabel('Korte Omschrijving') ?></label>
							<?php echo $form['description']->render(array('required'=>'true')); ?>
						</div>
						<div class="formrow">
							<label for="city"><?php echo $form['city']->renderLabel('Vestigingsplaats') ?></label>
							<?php echo $form['city']->render(array('required'=>'true')); ?>
						</div>
						<div class="formrow">
							<label for="phone"><?php echo $form['phone']->renderLabel('Telefoon') ?></label>
							<?php echo $form['phone']->render(); ?>
						</div>
						<br>
						<h2>Gegevens contactpersoon (supervisor):</h2>
						<br>
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
						
						<div class="formrow">
							<label>&nbsp;</label>
							<button type="submit">Opslaan</button> <button type="submit">Opslaan en direct project aanmaken</button> <a class="cancel" href="home.php">Annuleren</a>
							<br class="close">
						</div>
					</form>