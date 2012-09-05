<?php

/**
 * sfGuardUserProfile form.
 *
 * @package    ISP
 * @subpackage form
 * @author     10ants
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfGuardUserProfileNonSupervisorForm extends BasesfGuardUserProfileForm
{
  public function configure()
  {
	$this->widgetSchema['gender'] = new sfWidgetFormSelect(array('choices'=>self::$gender)); 
  	$this->setDefault('state', 'Dhr.'); 
	
	$c = new Criteria();
	$c->add(CompanyPeer::STATE, "A", Criteria::EQUAL);
	$this->widgetSchema['company_id'] = new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true, 'criteria'=>$c)); 
	
	$this->widgetSchema['user_id'] =  new sfWidgetFormInputHidden();
  
	$this->offsetUnset('state');
	$this->offsetUnset('created_at');
	$this->offsetUnset('updated_at');
  }
}
