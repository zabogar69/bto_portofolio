<?php use_helper('I18N', 'JavascriptBase') ?>

<div id="contentRight">
	<div class="form-container">
	<script type="text/javascript">
		var indexFile = 0;
		var indexSubmit = 0;
		var success = false;
		
		function preSubmit()
		{ 
			$('#addBtn').attr('disabled', true);
			$('#backBtn').attr('disabled', true);
			$('#resetBtn').attr('disabled', true);
			$('#saveBtn').attr('disabled', true);
			
			submitOne(indexSubmit);
		}
		
		
		function submitOne(index)
		{
			if(index != 0)
				index = "_" + index; 
			else
				index = "";
			
			var form = document.getElementById('upload_form'+index);
			var filename = $('#<?php echo $form['file_uri']->renderId()?>'+index).attr("value");
			var extPos = filename.lastIndexOf(".")+1;
			var filetype = filename.substr(extPos).toLowerCase();
			var video = {"wmv":1, "avi":1, "mov":1, "mpg":1, "mpeg":1, "flv":1};
			
			if(filename == '')
			{
				stopUpload(indexSubmit, '<div class="error">file'+indexSubmit+' :<?php echo __('File is empty', array(), 'messages') ?></div>');
				return;
			}	
			
			if( video[filetype]==1 )
			{
				//TODO:youtube is not working 
				stopUpload(indexSubmit, '<?php echo __('Sorry... video file is not supported on multiple uploads', array(), 'messages') ?>');
				return;
				
				// type=video
				$('#upload_progress' + index).show();
				$('#upload_status' + index).html('<?php echo __('Getting upload token...', array(), 'messages') ?>');
				
				$.getJSON('<?php echo url_for('media') ?>/getYoutubeToken/upload_index/'+indexSubmit, submitVideo);
			}
			else
			{
				$('#upload_progress' + index).show();
				$('#upload_status' + index).html('<?php echo __('Uploading file...', array(), 'messages') ?>');
				//Add State
				var parent = document.getElementById("<?php echo $form['state']->renderId()?>"); 
				var obj = parent.cloneNode(true);
				obj.style.display = 'none';
				obj.selectedIndex = parent.selectedIndex;
				form.appendChild(obj);
				//Add Media Category
				parent = document.getElementById("<?php echo $form['mediacategory_id']->renderId()?>"); 
				obj = parent.cloneNode(true);
				obj.style.display = 'none';
				obj.selectedIndex = parent.selectedIndex;
				form.appendChild(obj);

				form.submit();
			}
		}
		
		function stopUpload(index, message)
		{
			if(index != "" && index != "0" && index != 0)
				index = "_" + index;
			else
		 		index = "";
					
			$('#upload_progress' + index).hide();
			$('#upload_status' + index).html(message);
			
			var messagesValue = $('#messages').attr("value")+message;
			$('#messages').attr("value", messagesValue);
			
			indexSubmit++;
			if(indexSubmit > indexFile)
			{
				//$('#backBtn').attr('disabled', false);
				//$('#resetBtn').attr('disabled', false);
				$('#redirecting_progress').show();
				$('#redirecting_status').html("<?php echo __("redirecting...")?>");
				setTimeout("submitRedirect()",2000);
			}
			else
			{
				submitOne(indexSubmit);
			}
		}
		
		function submitRedirect()
		{
			$('#redirectForm').submit();
		}
		
		function submitVideo(json)
		{
			var index = json.upload_index;
			
			if(index != "" && index != "0" && index != 0)
				index = "_" + index;
			else
		 		index = "";
		 		
			if(json.error == '')
			{
				var parameters = ''; 
				
				$('#upload_status'+index).html('<?php echo __('Uploading file...', array(), 'messages') ?>');
				parameters 	+= '/<?php echo $form['state']->renderId()?>/' 
							+ $('#<?php echo $form['state']->renderId()?>').attr("value"); 
		
				parameters 	+= '/<?php echo $form['mediacategory_id']->renderId()?>/' 
							+ $('#<?php echo $form['mediacategory_id']->renderId()?>').attr("value"); 

				parameters 	+= '/upload_index/' 
							+ json.upload_index; 
		
				parameters 	+= '/<?php echo $form['_csrf_token']->renderId()?>/' 
							+ $('#<?php echo $form['_csrf_token']->renderId()?>'+index).attr("value"); 
				
				var filename = $('#<?php echo $form['file_uri']->renderId()?>'+index).attr("value");
				var extPos = filename.lastIndexOf(".");
				filename = filename.substr(0, extPos);
				
				parameters 	+= '/<?php echo $form['title']->renderId()?>/' 
							+ filename;
				
				var completeUrl = json.url;
				completeUrl += '?nexturl=' + '<?php echo url_for('media/updateVideo', true) ?>/updateVideo' + parameters;
				
				$('#upload_target'+index).attr("action", completeUrl);
				$('#token'+index).attr("value", json.token);
				$('##upload_target'+index).submit();
			}
			else
			{
				stopUpload(json.upload_index, '<?php echo __('Creating token for uploading a video to youtube failed, please try again', array(), 'messages') ?> \n('+json.error+')');
			}
		}
		
		function addFile()
		{
			var tbl = document.getElementById('tableForm');
			var lastRow = tbl.rows.length;
			// if there's no header row in the table, then iteration = lastRow + 1
			var iteration = lastRow;
			var row = tbl.insertRow(lastRow);
			indexFile ++;
			
			// 1st cell
			var cellFirst = row.insertCell(0);
			cellFirst.innerHTML = "&nbsp;";
			
			// 2nd cell
			var cellFirst = row.insertCell(1);
			cellFirst.innerHTML = "&nbsp;";

			// 3rd cell
			var cellSecond = row.insertCell(2);
			var objForm = document.getElementById("upload_form").cloneNode(true);
			objForm.id = objForm.id + "_" + indexFile;
			objForm.target = objForm.target + "_" + indexFile;
			objForm.upload_index.value = indexFile;
			for (var index in objForm.childNodes)
			{
				if(objForm.childNodes[index].id == '<?php echo $form['file_uri']->renderId()?>')
				{
					objForm.childNodes[index].id = objForm.childNodes[index].id + "_" + indexFile;
					objForm.childNodes[index].value = '';
				}	
				
				if(objForm.childNodes[index].id == 'token')
					objForm.childNodes[index].id = objForm.childNodes[index].id + "_" + indexFile;
				
				if(objForm.childNodes[index].id == '<?php echo $form['_csrf_token']->renderId()?>')
					objForm.childNodes[index].id = objForm.childNodes[index].id + "_" + indexFile;
			}
			
			cellSecond.appendChild(objForm);
			
			var obj = document.getElementById("upload_target").cloneNode(true);
			obj.id = obj.id + "_" + indexFile;
			obj.name = obj.id;
			cellSecond.appendChild(obj);
						
			// 4th cell
			var cellThird = row.insertCell(3);
			obj = document.getElementById("upload_status").cloneNode(true);
			obj.id = obj.id + "_" + indexFile;
			cellThird.appendChild(obj);
			
			obj = document.getElementById("upload_progress").cloneNode(true);
			obj.id = obj.id + "_" + indexFile;
			cellThird.appendChild(obj);
		}
	</script>
		<p>
		  	<strong>Note:</strong> 
			<?php echo __('Required fields are marked with an asterisk ( <em>*</em> )') ?>
	  	</p> 
	  	<fieldset>
			<legend><?php echo __('Multiple Media') ?></legend>
			<table id="tableForm" width="100%">
				<tr>
					<th width="110"><?php echo $form['state']->renderLabel(__('Active?')) ?></th>
					<td colspan="2"><?php echo $form['state']->render(array('class' => 'checkboks')) ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['mediacategory_id']->renderLabel(__('Media Category')) ?></th>
					<td colspan="2"><?php echo $form['mediacategory_id']->render(array('size'=>'10', 'style'=>'width: 150px;')) ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th><?php echo $form['file_uri']->renderLabel() ?></th>
					<td width="60">
						<?php echo button_to_function(__('Add File', array(), 'sf_admin'), "addFile()", array('id'=>'addBtn')) ?>
					</td>
					<td width="200" valign="top">
						<?php echo $form->renderFormTag(url_for('media/createMultiple'), array('enctype'=>'multipart/form-data', 'id'=>'upload_form', 'name'=>'upload_form', 'target'=>'upload_target' )) ?>
							<input type="hidden" name="token" id="token" />
							<input type="hidden" name="upload_index" id="upload_index" />
							<input type="hidden" name="saveType" value="multi" />
							<?php echo $form->renderHiddenFields(false) ?>
							<?php echo $form['file_uri']->render(($form['file_uri']->hasError())?array('class' => 'validation-failed'):array()) ?>
						</form>
						<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
					</td>
					<td>
						<?php echo image_tag('/images/progress.gif', array('id'=>'upload_progress', 'style'=>'display:none')); ?>
						<div id="upload_status" style="float:left;"></div>
					</td>
				</tr>
			</table>
			<div align='right'>
				<?php echo image_tag('/images/progress.gif', array('id'=>'redirecting_progress', 'style'=>'display:none')); ?>
				<div id="redirecting_status" style="float:left;"></div>
				<form action="<?php echo url_for('media/redirectMultiple') ?>" method="post" id="redirectForm" name="redirectForm">
					<input type="hidden" name="messages" id="messages" />
				</form>

				<?php echo button_to(__('Back to list'), '@media', array('id' => 'backBtn'))?>
				<?php echo button_to(__('Reset', array(), 'sf_admin'), 'media/multiple', array('id' => 'resetBtn'))?>
				<?php echo button_to_function(__('Save', array(), 'sf_admin'), "preSubmit()", array('id'=>'saveBtn')) ?>
			</div>
		</fieldset>
	</div>
</div>