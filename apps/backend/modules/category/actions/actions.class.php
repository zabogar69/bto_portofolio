<?php

/**
 * category actions.
 *
 * @package    sprayit
 * @subpackage category
 * @author     Okhi Oktanio
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends taActionsBackend
{
  protected function getClassname()
  {
  	return CategoryPeer::OM_CLASS;
  }
  
  protected function getDefaultSort()
  {
  	return array(null, null);
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    // maxPerPage
    if ($request->getParameter('maxPerPage'))
    {
      $this->setMaxPerPage($request->getParameter('maxPerPage'));
    }

	//set Filter
    // See taAction->buildCriteria()
    
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
    $this->hasFilterValues = $this->hasFilterValues();
    $this->criteria = $this->buildCriteria("setAdditionalCriteriaIndex");
  }
  
  protected function setAdditionalCriteriaIndex(Criteria $defaultCriteria, $filters)
  {
	//set additional criteria to append to filter-based default criteria applied to pager object
	if(!$this->hasFilterValues())
	{
		$defaultCriteria->add(CategoryPeer::STATE, array('A', 'I'), Criteria::IN);
	  	$defaultCriteria->add(CategoryPeer::SUPER_CAT, null, Criteria::ISNULL);
	}
	
	if(isset($filters['state']) && empty($filters['state']))
	{
		$defaultCriteria->add(CategoryPeer::STATE, array('A', 'I'), Criteria::IN);
	}
  }
  
  public function executeFilter(sfWebRequest $request)
  {
  	if ($request->hasParameter('_reset'))
    {
		$this->setFilters(array());
		$this->setPage(1);
		$this->redirect('@category');
    }

    $this->filters = new CategoryFormFilter($this->getFilters());
	$data = $request->getParameter($this->filters->getName());
    $this->filters->bind($data);
    if ($this->filters->isValid())
    {   
		$this->setFilters($this->filters->getValues());
		$this->setPage(1);
		$this->redirect('@category');
    }

    $this->pager = $this->getPager("setAdditionalCriteriaIndex");
    $this->sort = $this->getSort();
    $this->displayNumber = $this->getMaxPerPage();
    $this->hasFilterValues = $this->hasFilterValues();
    $this->criteria = $this->buildCriteria("setAdditionalCriteriaIndex");

    $this->setTemplate('index');	
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CategoryForm();
    $this->item = $this->form->getObject();
    
    $this->setTemplate('edit');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
    $this->form = new CategoryForm($this->item);
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new CategoryForm($this->item);
	$this->item = $this->form->getObject();
	
    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
    $this->form = new CategoryForm($this->item);

    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('D');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@category');
  }

  public function executePublish(sfWebRequest $request)
  {
    $this->dispatcher->notify(new sfEvent($this, 'admin.publish_object', array('object' => $this->getRoute()->getObject())));

	$publish = $request->getParameter('publish')=='1'?'A':'I';
    $this->getRoute()->getObject()->setState($publish);
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was published/unpublished successfully.');

    $this->redirect('@category');
  }  
  
  /** *******************   Batch Action   ********************************************/
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@category');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@category');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    $validator = new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'category'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('@category');
  }
  
  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (CategoryPeer::retrieveByPks($ids) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $object)));

      $object->setState('D');
	  try
	  {
	  	$object->save();
        $count++;
	  }
	  catch (Exception $e)
      {}
    }

    if ($count >= count($ids))
    {
      $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items.');
    }

    $this->redirect('@category');
  }
  
  protected function executeBatchPublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
	$publish = $request->getParameter('publish');
	
    $count = 0;
    foreach (CategoryPeer::retrieveByPks($ids) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.publish_object', array('object' => $object)));

      $object->setState($publish=='1'?'A':'I');
	  try
	  {
	  	$object->save();
        $count++;
	  }
	  catch (Exception $e)
      {}
    }

    if ($count >= count($ids))
    {
      $this->getUser()->setFlash('notice', 'The selected items have been published/unpublished successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when publishing the selected items.');
    }

    $this->redirect('@category');
  }
}