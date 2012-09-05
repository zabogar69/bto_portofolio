<div id="contentRight">
	<h1>Welkom</h1>
	<p>
		U bent nu ingelogd in het Webcontent Content Management Systeem 2.1.<br />Hier kunt u uw site beheren, gebruik hiervoor het menu links om de verschillende onderdelen binnen de site te kunnen beheren.</b>
	</p>
	U bent ingelogd met de gebruiker: <b><?php echo $sf_user->getUsername(); ?></b>.<br>
	Deze gebruiker behoort tot de groep: 
	<b>
		<?php foreach($sf_user->getGroupNames() as $group): echo $group; endforeach;?>
	</b>.
</div>