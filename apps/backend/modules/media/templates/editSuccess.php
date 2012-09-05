<?php use_helper('I18N', 'JavascriptBase') ?>

<div id="contentRight">
	<div class="form-container">
	<script type="text/javascript">
		function preSubmit()
		{ 
			var filename = $('#<?php echo $form['file_uri']->renderId()?>').attr("value");
			var extPos = filename.lastIndexOf(".")+1;
			var filetype = filename.substr(extPos).toLowerCase();
			var video = {"wmv":1, "avi":1, "mov":1, "mpg":1, "mpeg":1, "flv":1};
			
			$('#backBtn').attr('disabled', true);
			$('#applyBtn').attr('disabled', true);
			$('#saveBtn').attr('disabled', true);
			
			if( video[filetype]==1 )
			{
				// type=video
				$('#progress').show();
				$('#uploadStatus').html('<?php echo __('Getting upload token...') ?>');
				$.getJSON('<?php echo url_for('media') ?>/getYoutubeToken', submitVideo);
			}
			else
			{
				$('#editForm').submit();
			}
		}
		
		function submitVideo(json)
		{
			if(json.error == '')
			{
				var parameters = ''; 
				
				$('#uploadStatus').html('<?php echo __('Uploading file...') ?>');
				parameters 	+= '/<?php echo $form['state']->renderId()?>/' 
							+ $('#<?php echo $form['state']->renderId()?>').attr("value"); 
		
				parameters 	+= '/<?php echo $form['_csrf_token']->renderId()?>/' 
							+ $('#<?php echo $form['_csrf_token']->renderId()?>').attr("value"); 
				
				if($('#<?php echo $form['id']->renderId()?>').attr("value").length > 0)
				{
					parameters 	+= '/<?php echo $form['id']->renderId()?>/' 
								+ $('#<?php echo $form['id']->renderId()?>').attr("value");
				}	
				
				if($('#<?php echo $form['title']->renderId()?>').attr("value").length > 0)
				{
					parameters 	+= '/<?php echo $form['title']->renderId()?>/' 
								+ $('#<?php echo $form['title']->renderId()?>').attr("value");
				}	
				
				if($('#<?php echo $form['description']->renderId()?>').attr("value").length > 0)
				{
					parameters 	+= '/<?php echo $form['description']->renderId()?>/' 
								+ $('#<?php echo $form['description']->renderId()?>').attr("value");
				}	
				
				if($('#<?php echo $form['params']->renderId()?>').attr("value").length > 0)
				{
					parameters 	+= '/<?php echo $form['params']->renderId()?>/' 
								+ htmlentities($('#<?php echo $form['params']->renderId()?>').attr("value"));
				}	
				
				if($('#<?php echo $form['mediacategory_id']->renderId()?>').attr("value").length > 0)
				{
					parameters 	+= '/<?php echo $form['mediacategory_id']->renderId()?>/' 
								+ $('#<?php echo $form['mediacategory_id']->renderId()?>').attr("value");
				}	
				
				
				var completeUrl = json.url;
				completeUrl += '?nexturl=' + '<?php echo url_for('media/updateVideo', true) ?>/updateVideo' + parameters;
				//alert(completeUrl);return;
				$('#editForm').attr("action", completeUrl);
				$('#token').attr("value", json.token);
				$('#editForm').submit();
			}
			else
			{
				alert('<?php echo __('Creating token for uploading a video to youtube failed, please try again', array(), 'messages') ?> \n('+json.error+')');
				$('#uploadStatus').html('');
				$('#progress').hide();
				$('#backBtn').attr('disabled', false);
				$('#applyBtn').attr('disabled', false);	
				$('#saveBtn').attr('disabled', false);	
			}
		}
	</script>		
	<?php echo form_tag_for($form, '@media', array('enctype'=>'multipart/form-data', 'id'=>'editForm', 'name'=>'editForm')) ?>
		<p>
		  	<strong>Note:</strong> 
			<?php echo __('Required fields are marked with an asterisk ( <em>*</em> )') ?>
	  	</p> 
	  	<fieldset>
			<legend><?php echo $form->isNew()?__('New Media'):__('Edit Media') ?></legend>
			
			<?php if ($sf_user->hasFlash('notice')): ?>
				<div class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></div>
			<?php endif; ?>
			
			<?php if ($sf_user->hasFlash('error')): ?>
				<div class="error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></div>
			<?php endif; ?>
			
			
				<?php echo $form->renderHiddenFields(false) ?>
				<input type="hidden" name="token" id="token" />
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
					<th><?php echo $form['description']->renderLabel(__('Description')) ?></th>
					<td><?php echo $form['description']->render(($form['description']->hasError())?array('class' => 'validation-failed'):array()) ?></td>
					<td class='validation-failed'><?php echo $form['description']->renderError() ?></td>
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
				<tr>
					<th><?php echo $form['mediacategory_id']->renderLabel(__('Media Category')) ?></th>
					<td><?php echo $form['mediacategory_id']->render(array('size'=>'10', 'style'=>'width: 150px;')) ?></td>
					<td class='validation-failed'><?php echo $form['mediacategory_id']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['file_uri']->renderLabel() ?></th>
					<td><?php echo $form['file_uri']->render(($form['file_uri']->hasError())?array('class' => 'validation-failed'):array()) ?></td>
					<td class='validation-failed'><?php echo $form['file_uri']->renderError() ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div align='right'>
				<div id="uploadStatus"></div>
				<?php echo image_tag('/images/progress.gif', array('id'=>'progress', 'style'=>'display:none')); ?>
		    	<?php echo button_to(__('Back to list'), '@media', array('id' => 'backBtn'))?>
				<?php 
					if(!$form->isNew())
						echo link_to(__('Delete', array(), 'sf_admin'), 'media_delete', $form->getObject(), array('method' => 'delete', 'confirm' => __('Are you sure?')))
				?>
				<input type="hidden" name="saveType" value="save" />
				<input type="button" value="<?php echo __('Apply') ?>" onclick="saveType.value='apply'; preSubmit();" id="applyBtn" />
				<input type="button" value="<?php echo __('Save', array(), 'sf_admin') ?>" onclick="saveType.value='save'; preSubmit();" id="saveBtn" />
			</div>
		</fieldset>
	</form>
	</div>
</div>