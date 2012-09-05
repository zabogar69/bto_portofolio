<?php use_helper('I18N', 'Date', 'JavascriptBase', 'Javascript' ,'Object') ?>


<div id="contentRight">
	<div class="form-container">
		<?php echo form_tag_for($form, '@menu', array('name'=>'editForm')) ?>
		<p>
		  	<strong>Note:</strong> 
			<?php echo __('Required fields are marked with an asterisk ( <em>*</em> )') ?>
	  	</p> 
	  	<fieldset>
			<legend><?php echo $form->isNew()?__('New Menu'):__('Edit Menu') ?></legend>
			
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
		  			<th><?php echo $form['type']->renderLabel(__('Type')) ?></th>
		  			<td><?php echo $form['type']->render(($form['type']->hasError())?array('class' => 'validation-failed'):array()) ?>&nbsp;<em>*</em></td>
		  			<td class='validation-failed'><?php echo $form['type']->renderError() ?></td>
		  		</tr>
  		<tr>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
		  			<th><?php echo $form['link']->renderLabel(__('Link')) ?></th>
		  			<td colspan="3">
					  <div id="articleLink">
						  <?php $formType = $form['type']->getValue() ?>
						  <?php if(!empty($formType))
						  		{
							  		switch($formType)
							  		{
										case 'Article':
											$object = ArticlePeer::retrieveByUrl($form['link']->getValue());										    
											echo object_select_tag($object->getCategoryId(), '',
																array('related_class' => 'Category',
																	'peer_method' => 'getAllItems',
																	'peer_method_parameter' => 'true',
																	'control_name' => 'category',
																	'text_method' => 'getTitle',
																	'key_method'=>'getPrimaryKey',
																	'onchange'=>remote_function(array('update' => 'articleLink2',
																						'url' => 'menu/getMenuLinkArticle',
																						'with' => "'category=' + this.value",))));
										    echo "<div id='articleLink2'>";
											echo object_select_tag($form['link']->getValue(), '',
																array('related_class' => 'Article',
																	'peer_method' => 'retrieveByCategory',
																	'peer_method_parameter' => $object->getCategoryId(),
																	'control_name' => 'menu[link]',
																	'text_method' => 'getTitle',
																	'key_method'=>'getUrl',));
											echo "</div>";
											break;
											
										case 'Category':
											echo object_select_tag($form['link']->getValue(), '',
																array('related_class' => 'Category',
																	'peer_method' => 'getAllItems',
																	'control_name' => 'menu[link]',
																	'text_method' => 'getTitle',
																	'key_method'=>'getUrl',));
											break;
										
										case 'Link':
											echo input_tag("menu[link]",$form['link']->getValue());
											break;
										
										case 'Gallery':
											echo object_select_tag($form['link']->getValue(), '',
																array('related_class' => 'Mediacategory',
																	'peer_method' => 'getAllItems',
																	'control_name' => 'menu[link]',
																	'text_method' => 'getTitle',
																	'key_method'=>'getUrl',));
											break;
											
										case 'Archive':
											echo object_select_tag($form['link']->getValue(), '',
																array('related_class' => 'Category',
																	'peer_method' => 'getAllItems',
																	'control_name' => 'menu[link]',
																	'text_method' => 'getTitle',
																	'key_method'=>'getUrlArchive',));
											break;
											
										case 'Geen':
											default:
											echo "<i>n/a</i>";
											break;
									}
								}
								else
									echo "<i>Kies eerst link type</i>";
						  ?>
					  </div>
					</td>
		  		</tr>
  			    	<?php 
					  echo observe_field('menu_type', array('update' => 'articleLink',
													'url' => 'menu/getMenuLink',
													'with' => "'menutype=' + $('menu_type').value",)); 
					?>
				
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['super_menu']->renderLabel() ?></th>
					<td><?php echo $form['super_menu']->render(array('size'=>'10', 'style'=>'width: 150px;')) ?></td>
					<td class='validation-failed'><?php echo $form['super_menu']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo __("Manage Foto's") ?></th>
					<td><?php include_partial('menumedia/frame', array('form' => $form, 'formMedia' => $formMedia)) ?></td>
					<td class='validation-failed'></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['params']->renderLabel() ?></th>
					<td>
						<?php echo $form['params'] ?>
					</td>
					<td class='validation-failed'><?php echo $form['params']->renderError() ?></td>
				</tr>
			</table>
			<div align='right'>
				<?php echo button_to(__('Back to list'), '@menu')?>
				<?php 
					if(!$form->isNew())
						echo link_to(__('Delete', array(), 'sf_admin'), 'menu_delete', $form->getObject(), array('method' => 'delete', 'confirm' => __('Are you sure?')))
				?>
				<input type="hidden" name="saveType" value="save" />
				<input type="button" value="<?php echo __('Apply') ?>" onclick="saveType.value='apply'; editForm.submit();" />
				<input type="button" value="<?php echo __('Save', array(), 'sf_admin') ?>" onclick="saveType.value='save'; editForm.submit();" />
			</div>
		</fieldset>
	</form>
	</div>
</div>