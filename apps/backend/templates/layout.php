<?php
	ini_set('default_charset', 'utf-8');
?>
<!doctype html>
<html>
<head>
	<?php include_http_metas() ?>
	<?php include_title() ?>
	<?php include_metas() ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="Description" content="BTO Zaanstad - WBSO urenregistratie">
	<meta name="Author" content="Webcontent.nl">
	<meta name="Copyright" content="Copyright � <?= date("Y"); ?> BTO Zaanstad. Alle Rechten Voorbehouden.">
	
	<link rel="stylesheet" href="/stylesheet/main.css" type="text/css" media="screen">
	<link rel="stylesheet" href="/stylesheet/jquery.fancybox.css" type="text/css" media="screen">
		
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/javascript/jquery.js"></script>
	<script type="text/javascript" src="/javascript/jquery-ui.custom.min.js"></script>
	<script type="text/javascript" src="/javascript/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="/javascript/jquery.fancybox.js"></script>
	<script type="text/javascript" src="/javascript/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/javascript/jquery.chainedSelects.js"></script>	
	<script type="text/javascript" src="/javascript/jquery.functions.js"></script>	

	<title>WBSO urenregistratie | BTO Zaanstad</title>
	
</head>
<?php 
	$activeModule = $sf_params->get('module');
	$activeAction = $sf_params->get('action');
	setlocale(LC_ALL, 'nl_NL');
?>
<body id="logged">
	<div id="wrapper">
		<div id="header">
			
			<?php if ($sf_user->isAuthenticated()): ?>
					<p class="logged"><span class="icon">U</span>Ingelogd: <?php echo $sf_user->getUsername(); ?> | <a href="<?php echo url_for("sfGuardAuth/signout");?>">Afmelden</a><br>
			
					<span class="icon">K</span><a class="popup fancybox.iframe" href="hulp.html">Hulp</a></p>
			<?php endif; ?>
			<img src="/images/logo-bto.png" alt="BTO Zaanstad | WBSO urenregistratie" height="100" width="680">
		</div>
		<div id="content">
			<div id="left">
				<?php if ($sf_user->isAuthenticated()): ?>
					<?php include_partial('global/navigation') ?>
				<?php endif; ?>
			</div>
			<div id="right">
				<div class="container">
					
					<?php echo $sf_content ?>
					
				</div>
			</div>
			<br class="close">
			<div id="footerspace"><!-- --></div>
		</div>
	</div>
	</div>
	<div id="footer">
		<p>Copyright 2012 BTO Zaanstad - WBSO urenregistratie | <a href="#">Gebruikersvoorwaarden</a> | <a href="#">Privacy Policy</a></p>
	</div>
</div>
</body>
</html>