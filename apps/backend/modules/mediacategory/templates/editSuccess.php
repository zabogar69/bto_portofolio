<?php use_helper('I18N', 'Date') ?>

<div id="contentRight">
	<div class="form-container">
		<?php echo form_tag_for($form, '@mediacategory', array('name'=>'editForm')) ?>
		<p>
		  	<strong>Note:</strong> 
			<?php echo __('Required fields are marked with an asterisk ( <em>*</em> )') ?>
	  	</p> 
	  	<fieldset>
			<legend><?php echo $form->isNew()?__('New Media Category'):__('Edit Media Category') ?></legend>
			
			<?php if ($sf_user->hasFlash('notice')): ?>
				<div class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></div>
			<?php endif; ?>
			
			<?php if ($sf_user->hasFlash('error')): ?>
				<div class="error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></div>
			<?php endif; ?>
			
			
				<?php echo $form->renderHiddenFields(false) ?>
				
				<?php if ($form->hasGlobalErrors()): ?>
				  <?php echo $form->renderGlobalErrors() ?>
				<?php endif; ?>
				
			<table>
				<tr>
					<th><?php echo $form['state']->renderLabel(__('Active?')) ?></th>
					<td><?php echo $form['state']->render(array('class' => 'checkboks')) ?></td>
					<td class='validation-failed'><?php echo $form['state']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['title']->renderLabel(__('Title')) ?></th>
					<td><?php echo $form['title']->render(($form['title']->hasError())?array('class' => 'validation-failed'):array()) ?>&nbsp;<em>*</em></td>
					<td class='validation-failed'><?php echo $form['title']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['params']->renderLabel() ?></th>
					<td><?php echo $form['params']->render(($form['params']->hasError())?array('class' => 'validation-failed'):array()) ?></td>
					<td class='validation-failed'><?php echo $form['params']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div align='right'>
				<?php echo button_to(__('Back to list'), '@mediacategory')?>
				<?php 
					if(!$form->isNew())
						echo link_to(__('Delete', array(), 'sf_admin'), 'mediacategory_delete', $form->getObject(), array('method' => 'delete', 'confirm' => __('Are you sure?')))
				?>
				<input type="hidden" name="saveType" value="save" />
				<input type="button" value="<?php echo __('Apply') ?>" onclick="saveType.value='apply'; editForm.submit();" />
				<input type="button" value="<?php echo __('Save', array(), 'sf_admin') ?>" onclick="saveType.value='save'; editForm.submit();" />
			</div>
		</fieldset>
	</form>
	</div>
</div>