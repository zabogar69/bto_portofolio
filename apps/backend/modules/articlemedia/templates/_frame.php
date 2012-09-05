<div id="mf">
<script>
 
  jQuery(document).ready(function($) {
	loadMediaInit();
	
	jQuery(".mf-delete").live('click',function(){
		var r=confirm("<?php echo __('wilt u dit item verwijderen ?')?>");
		if (r==true){
			postDeleteMedia(jQuery(this).attr("rel"))
		}
	});
	
	function loadMediaInit()
	{
		jQuery("#mf-items").load("<?php echo url_for('articlemedia/mediaByTokenAndArticleId?id='.$form->getObject()->getId())?>");
	}
});

function postDeleteMedia(id)
{
	jQuery.post('<?php echo url_for('articlemedia/ajaxDelete')?>',{mediaId:id, relId:<?php echo ($form->getObject()->getId())? $form->getObject()->getId() : 0 ;?>},function(success){
				jQuery("#mf-item-"+id).fadeOut('fast',function(){jQuery(this).remove()});
		}
	);
}

function loadMedia()
{
	jQuery("#mf-items").load("<?php echo url_for('articlemedia/mediaByTokenAndArticleId?id='.$form->getObject()->getId())?>&rand="+Math.random()*99999);
}

</script>
<?php //echo $formMedia->renderHiddenFields(false) ?>
	<div id="mf-title"><?php __('Fotos') ?></div>
	<div class="wrap">	
		<iframe src="<?php echo url_for('articlemedia/new')?>" width="100%" scrolling="no" height="120" frameborder="0" marginheight="0" marginwidth="0" style="overflow:hidden"></iframe>
		<div class="clear"></div>
		<div id="mf-items"><div class="ajax-loader"></div></div>
		<div class="clear"></div>
		<div class="mf-form-info" style="text-align:right"><?php echo __('Sleep uw bestanden in de goede volgorde')?></div>
		<div class="clear"></div>
		
	</div>
</div>