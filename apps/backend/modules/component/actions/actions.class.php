<?php

/**
 * component actions.
 *
 * @package    ISP
 * @subpackage component
 * @author     10ants
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class componentActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
	$c = new Criteria();
	$c->add(ComponentPeer::STATE, 'A');

  	$this->isSuperAdmin = $this->getUser()->isSuperAdmin();
	if(!$this->isSuperAdmin):
		$userProfile = sfGuardUserProfilePeer::retrieveByUserId($this->getUser()->getGuardUser()->getId());
		$projects = BtoprojectPeer::retrieveByCompany($userProfile->getCompanyId());

		foreach($projects as $project):
			$c->addOr(ComponentPeer::BTOPROJECT_ID, $project->getId());
		endforeach;
	endif;

    $c->addAscendingOrderByColumn(ComponentPeer::NAME);
	$pager = new sfPropelPager('Component', 10);
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
		$this->form = new ComponentForm();
    	$this->item = $this->form->getObject();
		$this->userProfile ='';
		$this->isSuperAdmin = $this->getUser()->isSuperAdmin();
		if(!$this->isSuperAdmin):
			$this->userProfile = sfGuardUserProfilePeer::retrieveByUserId($this->getUser()->getGuardUser()->getId());
		endif;
    
    	$this->setTemplate('edit');
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $componentsform = new ComponentForm();
	
	$componentsform->bind($request->getParameter($componentsform->getName()));
	
	if ($componentsform->isValid()){
		$componentsform->save();
	
		$this->componentsitem = $componentsform->getObject();		
		
		$this->redirect('@component');
	}
    
	$this->form = $componentsform;
    $this->item = $this->form->getObject();
    $this->setTemplate('edit');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
  	$this->item = $this->getRoute()->getObject();
	$this->form = new ComponentForm($this->item);  
	$this->isSuperAdmin = $this->getUser()->isSuperAdmin();
	$this->userProfile ='';
		if(!$this->isSuperAdmin):
			$this->userProfile = sfGuardUserProfilePeer::retrieveByUserId($this->getUser()->getGuardUser()->getId());
		endif;
  }
  
    public function executeUpdate(sfWebRequest $request)
  	{
	    $this->item = $this->getRoute()->getObject();
	    $this->form = new ComponentForm($this->item);
	
	    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

		if ($this->form->isValid()){
			$this->form->save();			
			
			$this->redirect('@component');
		}
	    
	    $this->setTemplate('edit');
  	}
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('I');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@component');
  }
  
  public function executeGetComponentProject($request)
  {
  	print_r('berhasil');exit;
  	$this->company = $request->getParameter("company");
  	return $this->renderPartial('getComponentProject');	
  }
  
  	public function executeGetProject(sfWebRequest $request)
	{
		$this->getResponse()->setContentType('application/json');
		sfConfig::set('sf_web_debug', false);
		$json = array();
	
		$companies = CompanyPeer::retrieveAll();
	
		foreach($companies as $company)
		{
			if($request->getParameter('_value') == $company->getId())
			{
				$btoprojects = BtoprojectPeer::retrieveByCompany($company->getId());
				if(count($btoprojects) > 0)
				{
					foreach($btoprojects as $btoproject)
					{
						$json[] = array($btoproject->getId()=>$btoproject->getName());
					}
				}
				else
				{
					$json[] = array(""=>"Geen subcategorie aanwezig");
				}
	
			}
		}
	
		return $this->renderText(json_encode($json));
	}
}
