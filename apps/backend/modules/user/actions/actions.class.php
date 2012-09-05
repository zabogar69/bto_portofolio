<?php

/**
 * user actions.
 *
 * @package    ISP
 * @subpackage user
 * @author     10ants
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->companyId = $request->getParameter('cid',0);
	
	if($this->companyId == 0)
	{
		if($this->getUser()->isSuperAdmin())
			 $list = sfGuardUserProfilePeer::retrieveAll();
		else
			 $list = sfGuardUserProfilePeer::retrieveActiveByCompanyId($this->getUser()->getProfile()->getCompanyId());
	}
	else
	{
		$list = sfGuardUserProfilePeer::retrieveByCompanyId($this->companyId);
	}
	
	$this->companyList = CompanyPeer::retrieveAll();
  	
   
	$this->currentUser = $this->getUser();
	$this->users = $list;
  }
  
  public function executeNew(sfWebRequest $request)
  {
	$this->currentUser = $this->getUser();
   	$this->formProfile = new sfGuardUserProfileNonSupervisorForm();
   	$this->isEdit = false;
   	$this->setTemplate('edit');
  }
  
  
  public function executeEdit(sfWebRequest $request)
  {
	$this->currentUser = $this->getUser();
	$this->isEdit = true;
	$this->item = $this->getRoute()->getObject();
   	$this->formProfile = new sfGuardUserProfileNonSupervisorForm($this->item);
	$this->sfgUser = sfGuardUserPeer::retrieveByPK($this->item->getUserId());

   	$this->setTemplate('edit');
	
	
  }
  
  public function executeGetJsonProject(sfWebRequest $request)
  {
  	$this->companyId = $request->getParameter("cid");
	$this->userId = $request->getParameter("uid",0);
	$projs = BtoprojectPeer::retrieveByCompany($this->companyId);
	$i=0;
	$serArray = Array();
	foreach($projs as $proj)
	{
		$serArray[$i]["id"] = $proj->getId(); 
		$serArray[$i]["name"] = $proj->getName();
		$serArray[$i]["checked"] = $proj->isAssignedTo($this->userId)?"checked":"";
		$i++; 
	}
	$this->getResponse()->setContentType("application/json;charset=utf-8");
	$this->renderText(json_encode($serArray));
	return sfView::NONE;
	
  }
  
  public function executeCreate(sfWebRequest $request)
  {
  	$formProfile = new sfGuardUserProfileNonSupervisorForm();
	$formProfile->bind($request->getParameter("sf_guard_user_profile"));
	
	if ($formProfile->isValid()){
		$formProfile->save();
	
		$this->profileitem = $formProfile->getObject();
		
		$username = $request->getParameter("email");
		$password = $request->getParameter("password");
		
		$newUser = new sfGuardUser();
		$newUser->setUsername($username);
		$newUser->setPassword($password);
		$newUser->setIsActive(true);
		$newUser->save();
		
		$this->profileitem->setUserId($newUser->getId());
		$this->profileitem->setIsSupervisor(0);
		$this->profileitem->save();
		
		$userProjectAssignments = $request->getParameter("user_project");
		$this->profileitem->updateProjectAssignment($userProjectAssignments);
		
		
		$this->redirect('@user');
	}

   	$this->isEdit = false;
	$this->formProfile = $formProfile;
    $this->setTemplate('edit');
	
  }
  
  
  public function executeUpdate(sfWebRequest $request)
  {
 	
	$this->profileitem = $this->getRoute()->getObject();
	$sfGuardUserId = $this->profileitem->getUserId();
	
 	$profileForm = new sfGuardUserProfileNonSupervisorForm($this->profileitem);
	$profileForm->bind($request->getParameter($profileForm->getName()));
	
	
	if ($profileForm->isValid()){
		$profileForm->save();
	
		$this->profileitem = $profileForm->getObject();
		
		$username = $request->getParameter("email");
		$password = $request->getParameter("password");
		
		$password = $request->getParameter("password1");
		
		$newUser = sfGuardUserPeer::retrieveByPK($sfGuardUserId);
		
		if(strlen(trim($password)) > 0)
			$newUser->setPassword($password);
		
		$newUser->save();
		
		$userProjectAssignments = $request->getParameter("user_project");
		
		$this->profileitem->updateProjectAssignment($userProjectAssignments);
		
		
		$this->redirect('@user');
	}

   	$this->isEdit = true;
	$this->formProfile = $profileForm;
    $this->setTemplate('edit');
	
  }
  
  public function executeDelete(sfWebRequest $request)
  {
  	$this->profileitem = $this->getRoute()->getObject();
	$sfGuardUser = sfGuardUserPeer::retrieveByPK($this->profileitem->getUserId());
	$this->profileitem->setState("I");
	$this->profileitem->save();
	
	$sfGuardUser->setIsActive(0);
	$sfGuardUser->save();
	
  	$this->redirect('@user');
  }
  
  
   public function executeUndelete(sfWebRequest $request)
  {
  	$this->profileitem = $this->getRoute()->getObject();
	$sfGuardUser = sfGuardUserPeer::retrieveByPK($this->profileitem->getUserId());
	$this->profileitem->setState("A");
	$this->profileitem->save();
	
	$sfGuardUser->setIsActive(1);
	$sfGuardUser->save();
	
  	$this->redirect('@user');
  }
  
}
