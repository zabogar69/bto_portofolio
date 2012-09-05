<?php

/**
 * browsemedia actions.
 *
 * @package    muzelinck
 * @subpackage browsemedia
 * @author     Okhi Oktanio
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class browsemediaActions extends taActionsBackend
{
  protected function getClassname()
  {
  	return MediaPeer::OM_CLASS;
  }
  
  protected function getDefaultSort()
  {
  	return array(null, null);
  }
  
  public function executeIndex(sfWebRequest $request)
  {
  	$textareaId = $request->getParameter('textareaId');
    
	
	$this->textareaId = $textareaId;
	
	
	if ($request->getParameter('maxPerPage'))
    {
      $this->setMaxPerPage($request->getParameter('maxPerPage'));
    }
	
	// sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager("setAdditionalCriteriaIndex");
    $this->sort = $this->getSort();
    $this->displayNumber = $this->getMaxPerPage();
	
	$this->renderPartial('browse');
    return sfView::NONE;
  }
  
  protected function setAdditionalCriteriaBrowse($defaultCriteria, $filters)
  {
	//set additional criteria to append to filter-based default criteria applied to pager object
	$defaultCriteria->add(MediaPeer::STATE, "A", Criteria::EQUAL);
	$defaultCriteria->addAscendingOrderByColumn(MediaPeer::ORDERING);
  }
  
  
  protected function setAdditionalCriteriaIndex($defaultCriteria, $filters)
  {
	//set additional criteria to append to filter-based default criteria applied to pager object
	if(!$this->hasFilterValues() || (isset($filters['state']) && empty($filters['state'])))
	{
		$defaultCriteria->add(MediaPeer::STATE, array('A', 'I'), Criteria::IN);
		$defaultCriteria->addAscendingOrderByColumn(MediaPeer::ORDERING);
	}	
  }
  
  public function executeFilter(sfWebRequest $request)
  {
  	if ($request->hasParameter('_reset'))
    {
		$this->setFilters(array());
		$this->setPage(1);
		//$this->redirect('@media');
    }

    $this->filters = new MediaFormFilter($this->getFilters());
	$data = $request->getParameter($this->filters->getName());
    $this->filters->bind($data);
    if ($this->filters->isValid())
    {   
		$this->setFilters($this->filters->getValues());
		$this->setPage(1);
		//$this->redirect('@media');
    }

    $this->pager = $this->getPager("setAdditionalCriteriaIndex");
    $this->sort = $this->getSort();
    $this->displayNumber = $this->getMaxPerPage();

    $this->renderPartial('browse');
    return sfView::NONE;	
  }
}