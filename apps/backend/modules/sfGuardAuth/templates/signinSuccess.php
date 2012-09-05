			<h1>Aanmelden</h1>
				<hr>
				<!-- p class="error">Deze combinatie is onjuist!<br>Probeer het nog een keer of neem contact op met de beheerder.</p-->
				<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
					<div class="formrow">
						<?php echo $form->renderHiddenFields(false) ?>
						<label for="firstletters"><?php echo $form['username']->renderLabel('E-mailadres') ?></label>
						<?php echo $form['username']->render(array('required'=>'true')) ?>
						
						
					</div>
					<div class="formrow">
						<label for="firstletters"><?php echo $form['password']->renderLabel('Wachtwoord') ?></label>
						<?php echo $form['password']->render(array('required'=>'true')) ?>
						
					</div>
					<div class="formrow">
						<label>&nbsp;</label>
						<button type="submit" id="submit">Aanmelden</button>
						<br class="close">
					</div>
				</form>
				<p><a href="#">Wachtwoord vergeten</a></p>