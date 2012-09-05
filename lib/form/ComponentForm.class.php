<?php

/**
 * Component form.
 *
 * @package    ISP
 * @subpackage form
 * @author     10ants
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ComponentForm extends BaseComponentForm
{
  public function configure()
  {
  	$c = new Criteria();
	$c->add(BtoprojectPeer::STATE, 'A', Criteria::EQUAL);
				
	$CurrentUser = sfGuardUserProfilePeer::retrieveByUserId(sfContext::getInstance()->getUser()->getGuardUser()->getId());
	$Company = $CurrentUser->getCompanyId();
				
	$c->add(BtoprojectPeer::COMPANY_ID, $Company, Criteria::EQUAL);	
	$this->widgetSchema['btoproject_id'] = new sfWidgetFormPropelChoice(array('model' => 'Btoproject','criteria'=>$c));
		
  	$this->setDefault('state', 'A'); 
	$this->offsetUnset('state');
	$this->offsetUnset('created_at');
	$this->offsetUnset('updated_at');
  }
}
