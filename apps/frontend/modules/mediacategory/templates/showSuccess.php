
				<header>
					<h1><?php include_component('menu','breadcrumb') ?></h1>
				</header>
				<section>
<?php if(isset($items) && count($items)>0):?>
					<ul id="gallery">
<?php foreach($items as $item):?>
          	<li><a class="divbox" href="<?php echo $item->getFileUriWebpath()?>" title="<?php echo $item->getTitle()?> <?php echo ($item->getDescription()) ? ' - ' . $item->getDescription() : ''?>"><img src="<?php echo $item->getThumbUriWebpath()?>" width="90" alt="<?php echo $item->getTitle()?>"></a></li>
<?php endforeach; ?>
          </ul>
          <div class="clear"></div>
					<div class="share"> 
						<!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a> </div>
						<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script> 
						<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4dacf3685373e069"></script> 
						<!-- AddThis Button END --> 
					</div>
<?php endif; ?>
				</section>
