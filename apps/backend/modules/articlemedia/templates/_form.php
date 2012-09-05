<?php use_helper('I18N') ?>
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/layout.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/menuHeader.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/menuLeft.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/style.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/tables.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/forms.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/tabber.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/jquery-ui.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/jscal/jscal2.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/jscal/border-radius.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/jscal/steel/steel.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/backend/inlinemedia.css" />
<script type="text/javascript" src="/js/backend/jquery-1.5.min.js"></script>
<script type="text/javascript" src="/js/backend/jquery.livequery.js"></script>
<body style="background-image:none">
	<div id="mf"><iframe name="media_frame" style="display:none"></iframe>	
		<div id="mf-form">
			<form id="media-upload" target="media_frame" action="<?php echo url_for('articlemedia/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" enctype="multipart/form-data">
			<?php if (!$form->getObject()->isNew()): ?><input type="hidden" name="sf_method" value="put" /><?php endif; ?>
			<?php echo $form->renderHiddenFields(false) ?>
			<div class="mf-form"><?php echo __("Voeg uw foto's  toe die u bij dit project getoond wilt hebben") ?></div>
			<div class="mf-form-info"><?php echo __('Maximale grote: 10 MB, toegestane file types: jpg, png, gif, pdf')?></div>
			<div class="mf-form"><?php echo $form['file_uri']->render(array('size'=>40)) ?></div>
			<div class="ajax-loader hidden"><span><?php echo __('Bezig met uploaden')?></span></div>
			</form>
		</div>
</div>
<script>
  jQuery(document).ready(function($) {
	
	jQuery("#media_file_uri").change(function(){
		startUpload();
		jQuery("#media-upload").submit();
	});
	
	
	function startUpload()
	{
		jQuery("#mf .ajax-loader").show();
	}
});

function stopUpload()
{
	postUpload();
	window.parent.window.loadMedia();
}

function postUpload()
{
	jQuery("#mf .ajax-loader").hide();
	jQuery("#media_file_uri").val("");
	jQuery("#media_title").val("");	
}

function errorUpload(str)
{
	postUpload();
	window.parent.window.alert('ERROR: ' + str);
}

</script>
</body>