<?php

/**
 * company actions.
 *
 * @package    ISP
 * @subpackage company
 * @author     10ants
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class companyActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $list = CompanyPeer::retrieveAlsoInactive();
	
	$this->companies = $list;
  }
  
  public function executeNew(sfWebRequest $request)
  {
		$this->form = new CompanyForm();
    	$this->item = $this->form->getObject();
		$this->formProfile = new sfGuardUserProfileForm();
    	$this->isEdit = false;
    	$this->setTemplate('edit');
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $companyform = new CompanyForm();
	$profileForm = new sfGuardUserProfileForm();
	
	$companyform->bind($request->getParameter($companyform->getName()));
	$profileForm->bind($request->getParameter($profileForm->getName()));
	
	if ($companyform->isValid() && $profileForm->isValid()){
		$companyform->save();
		$profileForm->save();
	
		$this->companyitem = $companyform->getObject();
		$this->profileitem = $profileForm->getObject();
		
		$username = $request->getParameter("email");
		$password = $request->getParameter("password");
		
		$newUser = new sfGuardUser();
		$newUser->setUsername($username);
		$newUser->setPassword($password);
		$newUser->setIsActive(true);
		$newUser->save();
		
		$this->profileitem->setUserId($newUser->getId());
		$this->profileitem->setIsSupervisor(1);
		$this->profileitem->setCompanyId($this->companyitem->getId());
		$this->profileitem->save();
		
		
		$this->redirect('@company');
	}
    
	$this->form = $companyform;
    $this->item = $this->form->getObject();
	$this->formProfile = $profileForm;
	$this->isEdit = false;
    $this->setTemplate('edit');
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
  
    $this->companyitem = $this->getRoute()->getObject();
	$profileReqVar = $request->getParameter("sf_guard_user_profile");
	$this->profileitem = sfGuardUserProfilePeer::retrieveByPK($profileReqVar['id']);
	$sfGuardUserId = $this->profileitem->getUserId();
	
    $companyform = new CompanyForm($this->companyitem);
	$profileForm = new sfGuardUserProfileForm($this->profileitem);
	
	$companyform->bind($request->getParameter($companyform->getName()));
	$profileForm->bind($request->getParameter($profileForm->getName()));
	
	if ($companyform->isValid() && $profileForm->isValid()){
	
		$companyform->save();
		$profileForm->save();

		$password = $request->getParameter("password1");
		
		$newUser = sfGuardUserPeer::retrieveByPK($sfGuardUserId);
		
		if(strlen(trim($password)) > 0)
			$newUser->setPassword($password);
		
		$newUser->save();
		$this->redirect('@company');
	}
    
	$this->form = $companyform;
    $this->item = $this->form->getObject();
	$this->formProfile = $profileForm;
	$this->isEdit = true;
    $this->setTemplate('edit');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
	$this->profile = $this->item->retrieveSupervisorProfile();
	$this->isEdit = true;

    $this->form = new CompanyForm($this->item);
	$this->formProfile = new sfGuardUserProfileForm($this->profile );
	$this->sfgUser = sfGuardUserPeer::retrieveByPK($this->profile->getUserId());
    
    
  
  }
  
  public function executeDelete(sfWebRequest $request)
  {
  	 $this->company = $this->getRoute()->getObject();
	 $this->company->setState("I");
	 $this->company->save();
	 
	 $this->company->suspendAllProjects();
	 $this->company->suspendAllUsers();
	 $this->redirect('@company');
	 
  	
  }
}
