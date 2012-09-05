<?php use_helper('I18N') ?>
<html>
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/forms.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/jquery-ui.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/inlinemedia.css" />
<script type="text/javascript" src="/js/backend/jquery-1.5.min.js"></script>
<script type="text/javascript" src="/js/backend/jquery.livequery.js"></script>
<script type="text/javascript" src="/js/backend/jquery-ui.custom.min.js"></script>

<body style="background-image:none;">
<div id="mf">
<script>
$(document).ready(function() {
	loadMediaInit();
	
	$(".mf-delete").live('click',function(){
		var r=confirm("<?php echo __('delete this item?')?>");
		if (r==true){
			postDeleteMedia($(this).attr("rel"))
		}
	});
	
	function loadMediaInit()
	{
		$("#mf-items").load("<?php echo url_for('browsemedia/list')?>?textareaId=<?php echo $textareaId;?>");
	}
});

function postDeleteMedia(id)
{
	$.post('<?php echo url_for('browsemedia/ajaxDelete')?>',{mediaId:id},function(success){
				$("#mf-item-"+id).fadeOut('fast',function(){$(this).remove()});
		}
	);
}

function loadMediaByCategory(catid)
{
	$("#mf-items").html('<div class="ajax-loader"></div>').load("<?php echo url_for('browsemedia/list')?>?textareaId=<?php echo $textareaId;?>&catid="+catid+"&rand="+Math.random()*99999);
}


function loadMedia(catid)
{
	$("#mf-items").load("<?php echo url_for('browsemedia/list')?>?textareaId=<?php echo $textareaId;?>&catid="+catid+"&rand="+Math.random()*99999);
}

</script>
	<div id="mf-title"><?php __('Medias') ?></div>
	<div class="wrap">	
		<iframe src="<?php echo url_for('browsemedia/new')?>" width="100%" height="80" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" style="overflow:hidden"></iframe>
		<div class="clear"></div>
		<div id="mf-items"><div class="ajax-loader"></div></div>
		<div class="clear"></div>
		<div class="mf-form-info" style="text-align:right"><?php echo __('Sleep uw bestanden in de goede volgorde')?></div>
		<div class="clear"></div>
	</div>
</div>
</body>
</html>