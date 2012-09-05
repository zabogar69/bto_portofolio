
			<!-- slider -->
<?php if($medias && count($medias)): ?>
			<div class="flexslider">
				<ul class="slides">
<?php foreach($medias as $media):?>
					<li>
<?php if(myTools::isUrl(trim(strip_tags($media->getDescription())))):?>
						<a href="<?php echo trim(strip_tags($media->getDescription()))?>" target="_blank">
<?php endif; ?>
							<img src="<?php echo $media->getFileUriWebpath()?>" alt="<?php echo $media->getTitle()?>" width="987" height="300">
<?php if(myTools::isUrl(trim(strip_tags($media->getDescription())))):?>
						</a>
<?php endif; ?>
<?php if(strlen($media->getTitle())>0):?>
						<p class="flex-caption"><?php echo $media->getTitle()?></p>
<?php endif; ?>
					</li>
<?php endforeach; ?>
				</ul>
			</div>
			<!-- end slider -->
			<div class="clearfix"></div>
<?php endif; ?>
