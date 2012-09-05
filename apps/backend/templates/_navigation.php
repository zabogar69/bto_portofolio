<ul id="nav">
	<?php if ($sf_user->isSuperAdmin()): ?>
		<li><a href="#"><span class="icon">ï</span>Bedrijven</a>
			<ul>
				<li><a href="<?php echo url_for("company/new");?>"><span class="icon">]</span>Nieuw bedrijf</a></li>
				<li><a href="<?php echo url_for("company/index");?>"><span class="icon">k</span>Overzicht bedrijven</a></li>
			</ul>
		</li>
	<?php endif;?>
	<?php if ($sf_user->isSuperAdmin() OR $sf_user->getProfile()->getIsSupervisor()): ?>
	<li><a href="#"><span class="icon">?</span>Projecten</a>
		<ul>
			<li><a href="<?php echo url_for("btoproject/new");?>"><span class="icon">]</span>Nieuw project</a></li>
			<li><a href="<?php echo url_for("btoproject/index");?>"><span class="icon">k</span>Overzicht projecten</a></li>
		</ul>
	</li>
	<li><a href="#"><span class="icon">s</span>Projectonderdelen</a>
		<ul>
			<li><a href="<?php echo url_for("component/new");?>"><span class="icon">]</span>Nieuw projectonderdeel</a></li>
			<li><a href="<?php echo url_for("component/index");?>"><span class="icon">k</span>Overzicht projectonderdelen</a></li>
		</ul>
	</li>
	<li><a href="#"><span class="icon">+</span>Gebruikersbeheer</a>
		<ul>
			<li><a href="<?php echo url_for("user/new");?>"><span class="icon">-</span>Nieuwe gebruiker</a></li>
			<li><a href="<?php echo url_for("user/index");?>"><span class="icon">@</span>Gebruikers beheren</a></li>
		</ul>
	</li>
	<?php endif;?>
	<?php if (!$sf_user->isSuperAdmin()): ?>
		<li><a href="#"><span class="icon">N</span>Urenregistratie</a>
			<ul>
				<li><a href="<?php echo $sf_user->getProfile()->getIsSupervisor()?url_for("hours/indexSupervisor"):url_for("hours/index");?>"><span class="icon">&amp;</span>Uren schrijven</a></li>
				<!-- li><a href="#"><span class="icon">k</span>Overzicht uren</a></li -->
			</ul>
		</li>
	<?php else: ?>
		<li><a href="#"><span class="icon">N</span>Urenregistratie</a>
			<ul>
				<!-- li><a href="<?php echo $sf_user->getProfile()->getIsSupervisor()?url_for("hours/indexSupervisor"):url_for("hours/index");?>"><span class="icon">&amp;</span>Uren schrijven</a></li -->
				<li><a href="<?php echo url_for("hours/indexAdmin");?>"><span class="icon">k</span>Overzicht uren</a></li>
			</ul>
		</li>
	<?php endif;?>
	<!-- li><a href="#"><span class="icon">@</span>Beheer</a>
		<ul>
			<li><a href="#"><span class="icon">l</span>Rapportages</a></li>
			<li><a href="#"><span class="icon">/</span>Exporteren gegevens</a></li>
		</ul>
	</li -->
</ul>