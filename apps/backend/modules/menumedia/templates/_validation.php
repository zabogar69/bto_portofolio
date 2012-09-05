<?php if ($sf_user->hasFlash('error')): ?>
	<script>window.parent.window.errorUpload('<?php echo $form['file_uri']->getError()?><?php if ($form->hasGlobalErrors()): echo $form->getGlobalErrors(); endif; ?>')</script>
<?php else: ?>
	<script>window.parent.window.stopUpload()</script>
<?php endif; ?>