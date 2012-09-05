<?php use_helper('I18N', 'JavascriptBase') ?>

<div id="contentRight">
	<div class="form-container">
	<script type="text/javascript">
		var message = '';
		<?php if ($sf_user->hasFlash('notice')): ?>
			message = message + '<div class="notice">file<?php echo $index ?> :<?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?>&nbsp;';
		<?php endif; ?>
			
		<?php if ($sf_user->hasFlash('error')): ?>
			message = message + '<div class="error">file<?php echo $index ?> :<?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?>&nbsp;';
		<?php endif; ?>
			 
		<?php if ($form->hasGlobalErrors()): ?>
			message = message + '<?php echo str_replace("\n", "", $form->renderGlobalErrors()) ?>&nbsp;';
		<?php endif; ?>
		
		<?php if ($form['state']->hasError()): ?>
			message = message + '<?php 
									echo '<div class="validation-failed">';
									echo 'file'.$index.' :';
									echo $form['state']->renderLabel();
									echo str_replace("\n", "", $form['state']->renderError());
									echo '</div>'; 
								 ?>&nbsp;';
		<?php endif; ?>
		
		<?php if ($form['title']->hasError()): ?>
			message = message + '<?php 
									echo '<div class="validation-failed">';
									echo 'file'.$index.' :';
									echo $form['title']->renderLabel();
									echo str_replace("\n", "", $form['title']->renderError()); 
									echo '</div>'; 
								 ?>&nbsp;';
		<?php endif; ?>
		
		<?php if ($form['description']->hasError()): ?>
			message = message + '<?php 
									echo '<div class="validation-failed">';
									echo 'file'.$index.' :';
									echo $form['description']->renderLabel();
									echo str_replace("\n", "", $form['description']->renderError());
									echo '</div>';
								 ?>&nbsp;';
		<?php endif; ?>
		<?php if ($form['mediacategory_id']->hasError()): ?>
			message = message + '<?php 
									echo '<div class="validation-failed">';
									echo 'file'.$index.' :';
									echo $form['mediacategory_id']->renderLabel();
									echo str_replace("\n", "", $form['mediacategory_id']->renderError());
									echo '</div>'; 
								 ?>&nbsp;';
		<?php endif; ?>
		<?php if ($form['file_uri']->hasError()): ?>
			message = message + '<?php 
									echo '<div class="validation-failed">';
									echo 'file'.$index.' :';
									echo $form['file_uri']->renderLabel();
									echo str_replace("\n", "", $form['file_uri']->renderError()) ;
									echo '</div>';
								 ?>&nbsp;';
		<?php endif; ?>
		window.top.window.stopUpload('<?php echo $index ?>', message);
	</script>
	</div>
</div>
