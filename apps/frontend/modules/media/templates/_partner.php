
<?php if($medias && count($medias)): ?>
					<h4 class="title">Kwaliteit</h4>
					<ul id="logopartner">
<?php foreach($medias as $media):?>
						<li>
<?php if(myTools::isUrl(trim(strip_tags($media->getDescription())))):?>
							<a href="<?php echo trim(strip_tags($media->getDescription()))?>" target="_blank">
<?php endif; ?>
								<img src="<?php echo $media->getFileUriWebpath()?>" width="90" height="90">
<?php if(myTools::isUrl(trim(strip_tags($media->getDescription())))):?>
							</a>
<?php endif; ?>
						</li>
<?php endforeach;?>
					</ul>
<?php endif; ?>
