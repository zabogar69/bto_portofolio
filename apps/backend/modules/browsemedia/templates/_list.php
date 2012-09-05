<?php use_helper('I18N', 'Text') ?>
<?php foreach($items as $key=>$item):?>
			<div class="mf-item" id="mf-item-<?php echo $item->getId()?>">
				<div class="mf-content"><?php echo $item->getTextareaContent()?></div>
				<div class="mf-image"><a class="mf-select" rel="<?php echo $item->getId()?>"><img src="<?php echo $item->getThumbUriWebpath()?>" alt="<?php echo $item->getTitle()?>" width="100" /></a></div>
				<div class="mf-title"><a title="<?php echo $item->getTitle()?>"><?php echo truncate_text($item->getTitle(),20)?></a></div>
				<div class="mf-desc"><?php echo $item->getFileUriWebpath()?></div>
				<div class="mf-tool"><a class="mf-sort" rel="<?php echo $item->getId()?>">sort</a> <a rel="<?php echo $item->getId()?>" class="mf-delete">delete</a></div>
			</div>
<?php endforeach;?>
<script>

$(document).ready(function() {

	$(".mf-sort").live('hover',function(){
		$(this).css('cursor','move')
	});
	
	$(".mf-select").click(function(){
		content = $('.mf-content',$(this).parent().parent());
		window.parent.putMedia('<?php echo $textareaId;?>',content.html());
		window.parent.closeDialog();
		
	});
	
	$("#mf-items").sortable({handle: '.mf-sort', update: function() {
		var items = $(this).sortable("serialize");
			$.post("<?php echo url_for('browsemedia/ajaxSort')?>?"+items);
		}
	});		
});
</script>