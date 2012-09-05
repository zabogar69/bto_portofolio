<?php if($menus): ?>
		<ul id="nav" class="sf-menu">
<?php foreach($menus as $menu): ?>
<?php if($menu->getLink()=="frontpage/index"):?>
			<li><a href="<?php echo url_for('@homepage')?>"><?php echo $menu->getTitle()?></a></li>
<?php else: ?>
			<li><a href="<?php echo ($menu->getLink()) ? url_for($menu->getLink()) : '#'?>"><?php echo $menu->getTitle()?></a>
<?php if($menu->getChildMenus() && count($menu->getChildMenus())>0):?>
<ul>
<?php foreach($menu->getChildMenus() as $submenu): ?>
		<li><a href="<?php echo url_for($submenu->getLink())?>"><?php echo $submenu->getTitle()?></a></li>
<?php endforeach; ?>
</ul>
<?php endif;?>
			</li>
<?php endif; ?>
<?php endforeach; ?>
		</ul>
<?php endif; ?>