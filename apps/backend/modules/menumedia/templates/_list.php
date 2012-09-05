<?php use_helper('I18N', 'Text') ?>
<?php foreach($items as $key=>$item):?>
			<div class="mf-item" id="mf-item-<?php echo $item->getId()?>">
				<div class="mf-image"><a rel="<?php echo $item->getId()?>" class="mf-sort"><img src="<?php echo $item->getThumbUriWebpath()?>" alt="<?php echo $item->getTitle()?>" width="100" /></a></div>
				<div class="mf-title"><?php echo truncate_text($item->getFileUri(),20)?></div>
				<div class="mf-tool"><a rel="<?php echo $item->getId()?>" class="mf-delete">verwijder</a></div>
			</div>
<?php endforeach;?>
<script>
  jQuery(document).ready(function($) {
	jQuery(".mf-sort").live('hover',function(){
		jQuery(this).css('cursor','move')
	});
	
	jQuery("#mf-items").sortable({handle: '.mf-sort', update: function() {
		var items = jQuery(this).sortable("serialize");
			jQuery.post("<?php echo url_for('menumedia/ajaxSort')?>?"+items);
		}
	});		
});
</script>