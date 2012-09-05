<?php

/**
 * sfGuardUserProfile form.
 *
 * @package    ISP
 * @subpackage form
 * @author     10ants
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfGuardUserProfileForm extends BasesfGuardUserProfileForm
{
  public function configure()
  {
	$this->widgetSchema['gender'] = new sfWidgetFormSelect(array('choices'=>self::$gender)); 
  	$this->setDefault('state', 'Dhr.'); 
	
	$this->widgetSchema['company_id'] =  new sfWidgetFormInputHidden();
	$this->widgetSchema['user_id'] =  new sfWidgetFormInputHidden();
	$this->widgetSchema['is_supervisor'] =  new sfWidgetFormInputHidden();
  
	$this->offsetUnset('state');
	$this->offsetUnset('created_at');
	$this->offsetUnset('updated_at');
  }
}
