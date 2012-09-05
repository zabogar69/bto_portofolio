<?php

/**
 * Company form.
 *
 * @package    ISP
 * @subpackage form
 * @author     10ants
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CompanyForm extends BaseCompanyForm
{
  public function configure()
  {
  	$this->setDefault('state', 'A'); 
	$this->offsetUnset('state');
	$this->offsetUnset('created_at');
	$this->offsetUnset('updated_at');
  }
}
