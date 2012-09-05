<!-- Menu Left -->

<?php if ($sf_user->isAuthenticated()): ?>
	<?php $activeAction = $sf_params->get('action'); ?>
	<?php $activeModule = $sf_params->get('module'); ?>	
	<div id="menuLeft">
		
		<?php if ($sf_user->hascredential('menu_crud')): ?>
			<h1 <?php echo ($activeModule=='menu' AND $activeAction != "indexTrashBin")?'class="active"':'' ?>>
				<?php echo link_to(image_tag('dummy-icon2.png', 'size=16x16').'Menu', 'menu/index') ?>
			</h1>
			<ul>
				<?php if ($sf_user->hascredential('menu_crud')): ?>
					<li <?php echo ($activeModule=='menu' AND $activeAction != "indexTrashBin")?'class="active"':'' ?>><?php echo link_to('Beheer menu', 'menu/index') ?></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
		
		<?php if ($sf_user->hascredential('article_crud')): ?>
			<h1 <?php echo (($activeModule=='article' OR $activeModule=='category' OR $activeModule=='comment') AND 
							$activeAction != "indexArchive" AND $activeAction != "indexTrashBin")?'class="active"':'' ?>>
				<?php echo link_to(image_tag('dummy-icon1.png', 'size=16x16').'Artikelen', 'article/index') ?>
			</h1>
			<ul>
				<?php if ($sf_user->hascredential('article_crud')): ?>
					<li <?php echo ($activeModule=='article' AND $activeAction != 'indexArchive' AND $activeAction != "indexTrashBin")?'class="active"':'' ?>><?php echo link_to('Beheer artikelen', 'article/reset') ?></li>				<?php endif; ?>
					<li <?php echo ($activeModule=='category' AND $activeAction != "indexTrashBin")?'class="active"':'' ?>><?php echo link_to('Beheer categorieen', 'category/index') ?></li>
			</ul>
		<?php endif; ?>
		
		<?php if ($sf_user->hascredential('media_crud')): ?>
			<h1 <?php echo (($activeModule=='media' OR $activeModule=='mediacategory') AND 
							$activeAction != "indexArchive" AND $activeAction != "indexTrashBin")?'class="active"':'' ?>>
				<?php echo link_to(image_tag('dummy-icon3.png', 'size=16x16').'Media', 'media/index') ?>
			</h1>
			<ul>
				<li <?php echo ($activeModule=='mediacategory' AND $activeAction != 'indexArchive' AND $activeAction != "indexTrashBin")?'class="active"':'' ?>><?php echo link_to('Beheer media categorieen', 'mediacategory/index') ?></li>
				<li <?php echo ($activeModule=='media' AND $activeAction != 'indexArchive' AND $activeAction != "indexTrashBin")?'class="active"':'' ?>><?php echo link_to('Beheer media', 'media/reset') ?></li>
			</ul>
		<?php endif; ?>
		
		<?php if ($sf_user->hascredential('subscriber_crud')): ?>
			<h1 <?php echo (($activeModule=='subscriber' AND $activeAction=='index') ?'class="active"':'') ?>>
				<?php echo link_to(image_tag('dummy-icon2.png', 'size=16x16').'Subscriber', 'subscriber/index') ?>
			</h1>
		<?php endif; ?>
		
		<?php if ($sf_user->hascredential('archive_crud')): ?>
			<h1 <?php echo (($activeModule=='article' AND $activeAction=='indexArchive') OR 
							($activeModule=='mediacategory' AND $activeAction=='indexArchive') OR 
							($activeModule=='media' AND $activeAction=='indexArchive'))?'class="active"':'' ?>>
				<?php echo link_to(image_tag('dummy-icon2.png', 'size=16x16').'Archief', 'article/indexArchive') ?>
			</h1>
			<ul>
				<li <?php echo ($activeModule=='article' AND $activeAction=='indexArchive')?'class="active"':'' ?>><?php echo link_to('Artikelen', 'article/indexArchive') ?></li>
				<li <?php echo ($activeModule=='mediacategory' AND $activeAction=='indexArchive')?'class="active"':'' ?>><?php echo link_to('Media categorieen', 'mediacategory/indexArchive') ?></li>
				<li <?php echo ($activeModule=='media' AND $activeAction=='indexArchive')?'class="active"':'' ?>><?php echo link_to('Media', 'media/indexArchive') ?></li>
			</ul>
		<?php endif; ?>

		
		<?php if ($sf_user->hascredential('trashbin_crud')): ?>
			<h1 <?php echo (($activeModule=='category' AND $activeAction=='indexTrashBin') OR 
							($activeModule=='article' AND $activeAction=='indexTrashBin') OR
							($activeModule=='menu' AND $activeAction=='indexTrashBin') OR
							($activeModule=='mediacategory' AND $activeAction=='indexTrashBin') OR
							($activeModule=='media' AND $activeAction=='indexTrashBin'))?'class="active"':'' ?>>
				<?php echo link_to(image_tag('dummy-icon2.png', 'size=16x16').'Trash Bin', 'category/indexTrashBin') ?>
			</h1>
			
		<?php endif; ?>
	</div>
<?php else: ?>
	<div class='backendLogin'>
		Login om toegang te krijgen.
	</div>
<?php endif; ?>

<!-- End Menu Left -->
