<?php use_helper('I18N') ?>
<html>
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/forms.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/jquery-ui.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/inlinemedia.css" />
<script type="text/javascript" src="/js/backend/jquery-1.5.min.js"></script>
<script type="text/javascript" src="/js/backend/jquery.livequery.js"></script>
<body style="background-image:none; margin:5px 5px">
<div id="mf" style="margin:0px;">
	<iframe name="media_frame" style="display:none"></iframe>
	<div id="mf-form">
		<form id="media-upload" target="media_frame" action="<?php echo url_for('browsemedia/create') ?>" method="post" enctype="multipart/form-data">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%"><?php if (!$form->getObject()->isNew()): ?>
						<input type="hidden" name="sf_method" value="put" />
						<?php endif; ?>
						<?php echo $form->renderHiddenFields(false) ?>
						<input type="hidden" name="token" id="token" />
						<div class="mf-form"><?php echo __("Voeg uw file's toe") ?></div>
						<div class="mf-form"><?php echo $form['file_uri']->render(array('size'=>40)) ?></div>
						<div class="ajax-loader hidden"><span id="uploadStatus"><?php echo __('Bezig met uploaden')?></span></div></td>
					<td width="50%" valign="top"  align="right" style="vertical-align:top;"><div><?php echo __("Select / filter by category")?></div>
						<div>
							<select name="mediacategory_id" id="mediacategory_id">
								<option value=""><?php echo __("All")?></option>
								<?php foreach($mediacategories as $category):?>
								<option value="<?php echo $category->getId()?>"><?php echo $category->getTitle()?></option>
								<?php endforeach; ?>
							</select>
						</div></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script>
$(document).ready(function() {
	
	$("#media_file_uri").change(function(){
		startUpload();
		var filename = $('#<?php echo $form['file_uri']->renderId()?>').attr("value");
		var extPos = filename.lastIndexOf(".")+1;
		var filetype = filename.substr(extPos).toLowerCase();
		var video = {"wmv":1, "avi":1, "mov":1, "mpg":1, "mpeg":1, "flv":1};
		
		if( video[filetype]==1 )
		{
			$('#uploadStatus').html('<?php echo __('Getting upload token...') ?>');
			$.getJSON('<?php echo url_for('browsemedia/getYoutubeToken') ?>', submitVideo);
		}
		else
		{
			$('#media-upload').attr("action", "<?php echo url_for('browsemedia/create') ?>");
			$("#media-upload").submit();
		}		
	});
	
	function startUpload()
	{
		$("#mf .ajax-loader").show();
	}
	
	$("#mediacategory_id").change(function(){
		window.parent.window.loadMediaByCategory($(this).val());
	});
});

function stopUpload()
{
	postUpload();
	$("#media_file_uri").removeAttr("disabled");
	window.parent.window.loadMedia($("#mediacategory_id").val());
}

function postUpload()
{
	$("#mf .ajax-loader").hide();
	$("#media_file_uri").val("");
}

function errorUpload(str)
{
	postUpload();
	window.parent.window.alert('ERROR: ' + str);
}

		
function submitVideo(json)
{
	if(json.error == '')
	{
		$('#uploadStatus').html('<?php echo __('Uploading file...') ?>');
		var completeUrl = json.url;
		completeUrl += '?nexturl=' + '<?php echo url_for('browsemedia/createYoutube',true)?>/csrftoken/'+$('#media__csrf_token').val()+'/title/'+$("#media_file_uri").val()+'/catid/'+$("#mediacategory_id").val();
		$('#token').attr("value", json.token);
		$('#media-upload').attr("action", completeUrl);
		$("#media-upload").submit();
	}
	else
	{
		errorUpload('<?php echo __('Creating token for uploading a video to youtube failed, please try again', array(), 'messages') ?> \n('+json.error+')');
	}
}
</script>
</body>
</html>