<!-- Header menu -->

<?php $activeAction = $sf_params->get('action'); ?>
<?php $activeModule = $sf_params->get('module'); ?>

<ul>
 	<li <?php echo ($activeModule == 'dashboard')?'class="active"':'' ?>><?php echo link_to('Home', 'dashboard/index'); ?>
 	</li>
 	<li class="last"><?php echo link_to('Uitloggen', 'sfGuardAuth/signout') ?></li>
</ul>

<!-- End Header menu -->