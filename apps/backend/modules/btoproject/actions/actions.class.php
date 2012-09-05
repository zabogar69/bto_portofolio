<?php

/**
 * btoproject actions.
 *
 * @package    ISP
 * @subpackage btoproject
 * @author     10ants
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class btoprojectActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
	$c = new Criteria();
	$c->add(BtoprojectPeer::STATE, 'A');

  	$this->isSuperAdmin = $this->getUser()->isSuperAdmin();
	if(!$this->isSuperAdmin):
		$userProfile = sfGuardUserProfilePeer::retrieveByUserId($this->getUser()->getGuardUser()->getId());
		$c->add(BtoprojectPeer::COMPANY_ID, $userProfile->getCompanyId());
	endif;
	
	$c->addAscendingOrderByColumn(BtoprojectPeer::NAME);	
	$pager = new sfPropelPager('Btoproject', 10);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
	if ($this->getRequestParameter('maxperpage'))
    {
      $pager->setMaxPerPage($this->getRequestParameter('maxperpage'));
    }
    $pager->init();
    $this->pager = $pager;
  }
  
  public function executeNew(sfWebRequest $request)
  {
		$this->form = new BtoprojectForm();
    	$this->item = $this->form->getObject();
		
		$this->isSuperAdmin = $this->getUser()->isSuperAdmin();
		if(!$this->isSuperAdmin):
			$this->userProfile = sfGuardUserProfilePeer::retrieveByUserId($this->getUser()->getGuardUser()->getId());
		endif;
    	$this->setTemplate('edit');
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $form = new BtoprojectForm($this->item);
	
	$this->item = $form->getObject();	
	
	$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

	if ($form->isValid()){
		$form->save();			
		
		$this->redirect('@btoproject');
	}
    
	$this->form = $form;
    $this->item = $this->form->getObject();
    $this->setTemplate('edit');
  }
  
    public function executeUpdate(sfWebRequest $request)
  	{
	    $this->item = $this->getRoute()->getObject();
	    $this->form = new BtoprojectForm($this->item);
	
	    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

		if ($this->form->isValid()){
			$this->form->save();			
			
			$this->redirect('@btoproject');
		}
	    
	    $this->setTemplate('edit');
  	}
  
  public function executeEdit(sfWebRequest $request)
  {
  	$this->item = $this->getRoute()->getObject();
	$this->form = new BtoprojectForm($this->item);
	
	$this->isSuperAdmin = $this->getUser()->isSuperAdmin();
		if(!$this->isSuperAdmin):
			$this->userProfile = sfGuardUserProfilePeer::retrieveByUserId($this->getUser()->getGuardUser()->getId());
		endif;
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('I');
	$this->getRoute()->getObject()->save();
	
	$this->getRoute()->getObject()->suspendAllComponents();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@btoproject');
  }
}
