<?php

$errors = array();
if('POST' == $_SERVER['REQUEST_METHOD']) {

    if (empty($_POST['bedrijfsnaam'])) {
        $errors[] = 'Er is geeen bedrijfsnaam ingevuld';
    }
    if (empty($_POST['contactpersoon'])) {
        $errors[] = 'Er is geen contactpersoon ingevuld';
    }
    if (empty($_POST['telefoonnummer'])) {
        $errors[] = 'Er is geen telefoonnummer ingevuld';
    }
    if (empty($_POST['email'])) {
        $errors[] = 'Er is geen e-mail adres ingevuld';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Het ingevulde e-mail adres is incorrect';
    }

    if (0 == count($errors)) {

        $data = filter_input_array(INPUT_POST, array(
            'bedrijfsnaam'      => FILTER_SANITIZE_STRING,
            'contactpersoon'    => FILTER_SANITIZE_STRING,
            'straat'            => FILTER_SANITIZE_STRING,
            'postcode'          => FILTER_SANITIZE_STRING,
            'woonplaats'        => FILTER_SANITIZE_STRING,
            'sector'            => FILTER_SANITIZE_STRING,
            'aantalwerknemers'  => FILTER_SANITIZE_STRING,
            'kvknummer'         => FILTER_SANITIZE_STRING,
            'telefoonnummer'    => FILTER_SANITIZE_STRING,
            'faxnummer'         => FILTER_SANITIZE_STRING,
            'email'             => FILTER_SANITIZE_EMAIL,
            'website'           => FILTER_SANITIZE_URL,
            'bericht'           => FILTER_SANITIZE_STRING
        ));

        $to      = 'info@incotex.nl';
//        $to      = 'rocco.bruyn@webcontent.nl';   // uncomment for testing
        $subject = 'Ingevuld contactformulier';
        $message = '';
        $headers = 'From: no-reply@incotex.nl';

        foreach ($data as $field => $value) {
            $message .= vsprintf('%s: %s', array(
                ucfirst($field),
                $value . PHP_EOL
            ));
        }

        if (true === mail($to, $subject, $message, $headers)) {
            $_POST = array();

        } else {
            $errors[] = 'Kan het formulier niet versturen, probeer het later nog eens';
        }


		$uTo = $data['email'];
		$uSubject = 'Bevestiging Contactformulier Incotex';
		$uMessage = "Beste ". $data['contactpersoon'].",\r\nBedankt voor uw reactie. \r\nWij nemen spoedig contact met u op. \r\n\r\nU heeft de volgende gegevens verstuurd: \r\n\r\n".$message."\r\n\r\nMet vriendelijke groet,\r\nIncotex";
		$uHeaders = 'From: no-reply@incotex.nl';


		if (true === mail($uTo, $uSubject, $uMessage, $uHeaders)) {
            $_POST = array();
        } else {
            $errors[] = 'Kan het formulier niet versturen, probeer het later nog eens';
        }

    }
}
?>


			<div id="top">
				<h1><?php echo $item->getTitle()?></h1>
			</div>
			<div id="left">
                <? if (0 < count($errors)) : ?>
                <ul class="errors">
                    <? foreach ($errors as $error) : ?>
                    <li><?= $error; ?></li>
                    <? endforeach; ?>
                </ul>
                <? endif; ?>
				<form name="contactform" method="post" action="<?php echo url_for('contact/form')?>">
					<fieldset>
						<legend></legend>
						<input type="hidden" name="action" value="submit">
						
						<?php if('POST' == $_SERVER['REQUEST_METHOD']) :?>
							<div class="formrow">
								<span style="color: green;">Bedankt voor uw reactie. <br />Wij nemen spoedig contact met u op.</span>
							</div>
							<br />
						<?php endif;?>
						
						<div class="formrow">
							<label for="bedrijfsnaam">Bedrijfsnaam *</label>
                            <input name="bedrijfsnaam" type="text" maxlength="50" id="bedrijfsnaam" value="<?= (isset($_POST['bedrijfsnaam'])) ? htmlspecialchars($_POST['bedrijfsnaam']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="contactpersoon">Contactpersoon *</label>
							<input name="contactpersoon" type="text" maxlength="50" id="contactpersoon" value="<?= (isset($_POST['contactpersoon'])) ? htmlspecialchars($_POST['contactpersoon']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="straat">Straat</label>
							<input name="straat" type="text" maxlength="50" id="straat" value="<?= (isset($_POST['straat'])) ? htmlspecialchars($_POST['straat']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="postcode">Postcode</label>
							<input class="small" name="postcode" type="text" maxlength="6" id="postcode" value="<?= (isset($_POST['postcode'])) ? htmlspecialchars($_POST['postcode']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="woonplaats">Woonplaats</label>
							<input name="woonplaats" type="text" maxlength="50" id="woonplaats" value="<?= (isset($_POST['woonplaats'])) ? htmlspecialchars($_POST['woonplaats']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="sector">Sector</label>
							<input name="sector" type="text" maxlength="50" id="sector" value="<?= (isset($_POST['sector'])) ? htmlspecialchars($_POST['sector']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="aantalwerknemers">Aantal werknemers</label>
							<input class="small" name="aantalwerknemers" type="text" maxlength="4" id="aantalwerknemers" value="<?= (isset($_POST['aantalwerknemers'])) ? htmlspecialchars($_POST['aantalwerknemers']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="kvknummer">KvK nummer</label>
							<input name="kvknummer" type="text" maxlength="11" id="kvknummer" value="<?= (isset($_POST['kvknummer'])) ? htmlspecialchars($_POST['kvknummer']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="telefoonnummer">Telefoonnummer *</label>
							<input name="telefoonnummer" type="text" maxlength="10" id="faxnummer" value="<?= (isset($_POST['faxnummer'])) ? htmlspecialchars($_POST['faxnummer']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="faxnummer">Faxnummer</label>
							<input name="faxnummer" type="text" maxlength="10" id="faxnummer" value="<?= (isset($_POST['faxnummer'])) ? htmlspecialchars($_POST['faxnummer']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="email">Email *</label>
							<input name="email" type="text" maxlength="50" id="email" value="<?= (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="website">Website</label>
							<input name="website" type="text" id="website" value="<?= (isset($_POST['website'])) ? htmlspecialchars($_POST['website']) : ''; ?>">
						</div>
						<div class="formrow">
							<label for="bericht">Ik wil graag</label>
							<textarea name="bericht" rows="10" cols="10" id="bericht"></textarea>
						</div>
						<div class="formrow">
							<label>&nbsp;</label>
							<input id="submit" type="submit" value="Verzenden">
						</div>
						<p class="nb">* Verplicht</p>
					</fieldset>
				</form>
			</div>
			<div id="right">
<?php echo $item->getFulltextFrontend()?>
			</div>
			<br class="close">
