
<?php $medias = $item->getArticleMediasOrdering() ?>
			<div id="top">
				<h1><?php echo $item->getTitle()?></h1>
			</div>
			<div id="left">
<?php if($medias):?>
				<img id="SwitchImage" src="<?php echo $medias[0]->getMedia()->getFileUriWebpath()?>" alt="<?php echo $medias[0]->getMedia()->getTitle()?>" height="415" width="415">
<?php endif; ?>
			</div>
			<div id="<?php echo ($item->getParamValue("onecol") == 1)? "rightFull" : "right"; ?>"<?php if(!$medias):?> class="no-image"<?php endif;?>>
<?php if($medias && count($medias)>1):?>
<?php foreach($medias as $media):?>
				<a href="<?php echo $media->getMedia()->getFileUriWebpath()?>" onMouseOver="switchImage(this);" onClick="return false"><img src="<?php echo $media->getMedia()->getThumbUriWebpath()?>" alt="Product image" height="135" width="135"></a>
<?php endforeach ?>
				<br class="close">
<?php endif; ?>
				<div class="textblock">
				<?php echo $item->getFulltextFrontend()?>
			  </div>
			</div>
			<br class="close">
