<?php

/**
 * hours actions.
 *
 * @package    ISP
 * @subpackage hours
 * @author     10ants
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class hoursActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $curWeek = intval($request->getParameter("w"));
	if($curWeek == 0 OR $curWeek > 53)
		$curWeek = date("W");
		
	$this->projId = intval($request->getParameter("p"));
	$this->projItem = BtoprojectPeer::retrieveByPK($this->projId);

	$this->currentWeek = $curWeek;
	$this->currentUser = $this->getUser();
	
	$this->projList = $this->currentUser->getProfile()->retrieveActiveProjectAssignments();
	
	if($this->currentUser->isSuperAdmin())
		$this->projList = BtoprojectPeer::retrieveAll();
	if($this->currentUser->getProfile()->getIsSupervisor())
		$this->projList = BtoprojectPeer::retrieveByCompany($this->currentUser->getProfile()->getCompanyId());
	
	

	$this->weekDate1 = myTools::getWeekDates(date("Y"), $curWeek, true);
	$this->weekDate2 = date('D d-m-Y', strtotime('+1 days', strtotime($this->weekDate1)));
	$this->weekDate3 = date('D d-m-Y', strtotime('+2 days', strtotime($this->weekDate1)));
	$this->weekDate4 = date('D d-m-Y', strtotime('+3 days', strtotime($this->weekDate1)));
	$this->weekDate5 = date('D d-m-Y', strtotime('+4 days', strtotime($this->weekDate1)));
	$this->weekDate6 = date('D d-m-Y', strtotime('+5 days', strtotime($this->weekDate1)));
	
  }
  
  
  public function executeIndexSupervisor(sfWebRequest $request)
  {
    $curWeek = intval($request->getParameter("w"));
	if($curWeek == 0 OR $curWeek > 53)
		$curWeek = date("W");
		
	$this->projId = intval($request->getParameter("p"));
	$this->projItem = BtoprojectPeer::retrieveByPK($this->projId);
	$this->userId = intval($request->getParameter("u"));

	$this->currentWeek = $curWeek;
	$this->currentUser = sfGuardUserPeer::retrieveByPK($this->userId);
	
	$this->projList = BtoprojectPeer::retrieveAlsoInactiveByCompany($this->getUser()->getProfile()->getCompanyId());
	
	$this->currentProj = BtoprojectPeer::retrieveByPK($this->projId);
	
	if($this->currentProj)
		$this->userList = $this->currentProj->getAllEmployees();
	
		

	$this->weekDate1 = myTools::getWeekDates(date("Y"), $curWeek, true);
	$this->weekDate2 = date('D d-m-Y', strtotime('+1 days', strtotime($this->weekDate1)));
	$this->weekDate3 = date('D d-m-Y', strtotime('+2 days', strtotime($this->weekDate1)));
	$this->weekDate4 = date('D d-m-Y', strtotime('+3 days', strtotime($this->weekDate1)));
	$this->weekDate5 = date('D d-m-Y', strtotime('+4 days', strtotime($this->weekDate1)));
	$this->weekDate6 = date('D d-m-Y', strtotime('+5 days', strtotime($this->weekDate1)));
	
  }
  
  
  public function executeIndexAdmin(sfWebRequest $request)
  {
    $curWeek = intval($request->getParameter("w"));
	if($curWeek == 0 OR $curWeek > 53)
		$curWeek = date("W");
		
	$this->projId = intval($request->getParameter("p"));
	$this->projItem = BtoprojectPeer::retrieveByPK($this->projId);
	$this->userId = intval($request->getParameter("u"));

	$this->currentWeek = $curWeek;
	$this->currentUser = sfGuardUserPeer::retrieveByPK($this->userId);
	
	$this->projList = BtoprojectPeer::retrieveAll();
	
	$this->currentProj = BtoprojectPeer::retrieveByPK($this->projId);
	
	if($this->currentProj)
		$this->userList = $this->currentProj->getAllEmployees();
	
	$this->weekDate1 = myTools::getWeekDates(date("Y"), $curWeek, true);
	$this->weekDate2 = date('D d-m-Y', strtotime('+1 days', strtotime($this->weekDate1)));
	$this->weekDate3 = date('D d-m-Y', strtotime('+2 days', strtotime($this->weekDate1)));
	$this->weekDate4 = date('D d-m-Y', strtotime('+3 days', strtotime($this->weekDate1)));
	$this->weekDate5 = date('D d-m-Y', strtotime('+4 days', strtotime($this->weekDate1)));
	$this->weekDate6 = date('D d-m-Y', strtotime('+5 days', strtotime($this->weekDate1)));
	
  }
  
  
  public function executeSave(sfWebRequest $request)
  {
  	$hours = $request->getParameter("hours");
	$curWeek = $request->getParameter("curWeek");
	$curProj = $request->getParameter("curProj");
	
	foreach($hours as $key => $val)
	{
		$keyArr = explode("_",$key);
		
		$curUserProfile = $this->getUser()->getProfile();
		$curUserProfile->cleanupHours($keyArr[1], $keyArr[0]);
		
		if(!$curUserProfile->isOver12hours($keyArr[1], $val))
		{
					
			$newProjHours = new Hours();
			$newProjHours->setState("A");
			$newProjHours->setComponentId($keyArr[0]);
			$newProjHours->setHourdate($keyArr[1]);
			$newProjHours->setUserId($curUserProfile->getUserId());
			$newProjHours->setAmount($val);
			$newProjHours->save();
		}
		else
		{
			$this->getUser()->setFlash('error', 'Your input on date '.$keyArr[1].' exceeds the maximum 12 hours!');
			$this->redirect("hours/index?w=".$curWeek."&p=".$curProj);
		}
		
		
		
	}
	$this->getUser()->setFlash('notice', 'Hours saved!');
	$this->redirect("hours/index?w=".$curWeek."&p=".$curProj);
  }
  
  
  public function executeSaveSupervisor(sfWebRequest $request)
  {
  	$hours = $request->getParameter("hours");
	$curWeek = $request->getParameter("curWeek");
	$curProj = $request->getParameter("curProj");
	$curUser = $request->getParameter("curUser");
	
	foreach($hours as $key => $val)
	{
		$keyArr = explode("_",$key);
		
		$curUserProfile = sfGuardUserProfilePeer::retrieveByUserId($curUser);
		$curUserProfile->cleanupHours($keyArr[1], $keyArr[0]);
		
		if(!$curUserProfile->isOver12hours($keyArr[1], $val))
		{
					
			$newProjHours = new Hours();
			$newProjHours->setState("A");
			$newProjHours->setComponentId($keyArr[0]);
			$newProjHours->setHourdate($keyArr[1]);
			$newProjHours->setUserId($curUserProfile->getUserId());
			$newProjHours->setAmount($val);
			$newProjHours->save();
		}
		else
		{
			$this->getUser()->setFlash('error', 'Your input on date '.$keyArr[1].' exceeds the maximum 12 hours!');
			$this->redirect("hours/indexSupervisor?w=".$curWeek."&p=".$curProj."&u=".$curUser);
		}
		
		
		
	}
	$this->getUser()->setFlash('notice', 'Hours saved!');
	$this->redirect("hours/indexSupervisor?w=".$curWeek."&p=".$curProj."&u=".$curUser);
  }
  
  
  
  public function executeGetJsonProjectHours(sfWebRequest $request)
  {
  	$dateParam = $request->getParameter("date"); //hours[8_2012-08-27]
	$date = explode("_",$dateParam);
	$date = str_replace("]","",$date[1]);
	$this->date = $date;
	$this->userId = $request->getParameter("uid",0);
	$this->hourinput = $request->getParameter("hourinput");
	
	$curUser = sfGuardUserPeer::retrieveByPK($this->userId);
	$curUserProfile = $curUser->getProfile();
	
	$response["response"] = 0;
	
	if($curUserProfile->isOver12hours($this->date, $this->hourinput))
		$response["response"] = 1;
	
	
	$this->getResponse()->setContentType("application/json;charset=utf-8");
	$this->renderText(json_encode($response));
	return sfView::NONE;
	
	
	
  }
}
