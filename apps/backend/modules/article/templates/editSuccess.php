<?php use_helper('I18N', 'Date', 'JavascriptBase') ?>

<div id="contentRight">
	<div class="form-container">
		<div class="media-dialog"></div>
		<script>
		
		$(function(){
			$(".media-dialog").dialog({
				title: '<?php echo __('Media Browser'); ?>',
				autoOpen: false,
				modal: true,
				height: 550,
				width: 800
			});
			
		});
		
		function showDialog(textareaId){
			$(".media-dialog").html('<iframe class="media-frame" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto" />').dialog("open");
			$(".media-frame").attr("src","<?php echo url_for('browsemedia/index')?>?textareaId="+textareaId);
			return false;
		}
		
		function closeDialog(){
			$(".media-dialog").dialog('close');
			$(".media-dialog").html('');
		}

			function putMedia(textareaId, content)
			{
				tinyMCE.execInstanceCommand(textareaId, 'mceInsertContent', false, content);
			}
	
	  	function insertReadMore(textareaId)
	  	{
				tinyMCE.execInstanceCommand(textareaId, 'mceInsertContent', false, '[[break]]');
			}
		
		</script>
		<?php echo form_tag_for($form, '@article', array('name'=>'editForm')) ?>
		<p>
		  	<strong>Note:</strong> 
			<?php echo __('Required fields are marked with an asterisk ( <em>*</em> )') ?>
	  	</p> 
	  	<fieldset>
			<legend><?php echo $form->isNew()?__('New Article'):__('Edit Article') ?></legend>
			
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
					<td><?php echo $form['title']->render(($form['title']->hasError())?array('class' => 'validation-failed','style'=>'width:300px'):array('style'=>'width:300px')) ?>&nbsp;<em>*</em></td>
					<td class='validation-failed'><?php echo $form['title']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['content_text']->renderLabel(__('FullText')) ?></th>
					<td>
						<?php echo $form['content_text'] ?>
						<?php echo button_to_function(__("Insert media"),"showDialog('".$form['content_text']->renderId()."')")?>
						<?php echo button_to_function(__("Read more"),"insertReadMore('".$form['content_text']->renderId()."')")?>
					</td>
					<td class='validation-failed'><?php echo $form['content_text']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<th><?php echo $form['metatags']->renderLabel() ?></th>
					<td><?php echo $form['metatags']->render(array('size'=>'50', 'style'=>'width: 400px;')) ?></td>
					<td class='validation-failed'><?php echo $form['metatags']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<th><?php echo $form['metadesc']->renderLabel() ?></th>
					<td><?php echo $form['metadesc']->render(array('size'=>'50', 'style'=>'width: 400px;')) ?></td>
					<td class='validation-failed'><?php echo $form['metadesc']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<th><?php echo $form['category_id']->renderLabel() ?></th>
					<td><?php echo $form['category_id']->render(array('size'=>'10', 'style'=>'width: 150px;')) ?></td>
					<td class='validation-failed'><?php echo $form['category_id']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<th><?php echo $form['pub_date']->renderLabel(__('Publish Date')) ?></th>
					<td><?php echo $form['pub_date'] ?></td>
					<td class='validation-failed'><?php echo $form['pub_date']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['end_date']->renderLabel(__('Unpublish Date')) ?></th>
					<td><?php echo $form['end_date'] ?></td>
					<td class='validation-failed'><?php echo $form['end_date']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo __("Manage Fotos and Brochures ") ?></th>
					<td><?php include_partial('articlemedia/frame', array('form' => $form, 'formMedia' => $formMedia)) ?></td>
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
				<?php echo button_to(__('Back to list'), $sf_user->getAttribute('redirectto','@article'))?>
				<?php 
					if(!$form->isNew())
						echo link_to(__('Delete', array(), 'sf_admin'), 'article_delete', $form->getObject(), array('method' => 'delete', 'confirm' => __('Are you sure?')))
				?>
				<input type="hidden" name="saveType" value="save" />
				<input type="button" value="<?php echo __('Apply') ?>" onclick="saveType.value='apply'; editForm.submit();" />
				<input type="button" value="<?php echo __('Save', array(), 'sf_admin') ?>" onclick="saveType.value='save'; editForm.submit();" />
			</div>
		</fieldset>
	</form>
	</div>
</div>