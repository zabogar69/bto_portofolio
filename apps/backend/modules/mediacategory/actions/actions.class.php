<?php

/**
 * mediacategory actions.
 *
 * @package    muzelinck
 * @subpackage mediacategory
 * @author     Okhi Oktanio
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mediacategoryActions extends taActionsBackend
{
  protected function getClassname()
  {
  	return MediaCategoryPeer::OM_CLASS;
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
  }

  protected function setAdditionalCriteriaIndex($defaultCriteria, $filters)
  {
	//set additional criteria to append to filter-based default criteria applied to pager object
	if(!$this->hasFilterValues() || (isset($filters['state']) && empty($filters['state'])))
	{
		$defaultCriteria->add(MediaCategoryPeer::STATE, array('A', 'I'), Criteria::IN);
	}	
  }
  
  public function executeIndexArchive(sfWebRequest $request)
  {
    // maxPerPage
    if ($request->getParameter('maxPerPage'))
    {
      $this->setMaxPerPage($request->getParameter('maxPerPage'));
    }

	//clear Filter
    $this->setFilters(array());
    
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

    $this->pager = $this->getPager("setAdditionalCriteriaIndexArchive");
    $this->sort = $this->getSort();
    $this->displayNumber = $this->getMaxPerPage();
  }
  
  protected function setAdditionalCriteriaIndexArchive($defaultCriteria)
  {
	  //set additional criteria to append to filter-based default criteria applied to pager object
	  $defaultCriteria->add(MediaCategoryPeer::STATE, "X", Criteria::EQUAL);	
  }
  
  public function executeFilter(sfWebRequest $request)
  {
  	if ($request->hasParameter('_reset'))
    {
		$this->setFilters(array());
		$this->setPage(1);
		$this->redirect('@mediacategory');
    }

    $this->filters = new MediacategoryFormFilter($this->getFilters());
	$data = $request->getParameter($this->filters->getName());
    $this->filters->bind($data);
    if ($this->filters->isValid())
    {   
		$this->setFilters($this->filters->getValues());
		$this->setPage(1);
		$this->redirect('@mediacategory');
    }

    $this->pager = $this->getPager("setAdditionalCriteriaIndex");
    $this->sort = $this->getSort();
    $this->displayNumber = $this->getMaxPerPage();

    $this->setTemplate('index');	
  }
    
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new MediaCategoryForm();
    $this->item = $this->form->getObject();
    
    $this->setTemplate('edit');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
    $this->form = new MediaCategoryForm($this->item);
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new MediaCategoryForm($this->item);
	$this->item = $this->form->getObject();
	
    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
    $this->form = new MediaCategoryForm($this->item);

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

    $this->redirect('@mediacategory');
  }
  
  public function executeArchive(sfWebRequest $request)
  {
    
    $this->dispatcher->notify(new sfEvent($this, 'admin.archive_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('X');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was archived successfully.');

    $this->redirect('@mediacategory');
  }

  public function executeUnarchive(sfWebRequest $request)
  {
  
    $this->dispatcher->notify(new sfEvent($this, 'admin.unarchive_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('A');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was unarchived successfully.');

    $this->redirect('mediacategory/indexArchive');
  }

  public function executePublish(sfWebRequest $request)
  {
    $this->dispatcher->notify(new sfEvent($this, 'admin.publish_object', array('object' => $this->getRoute()->getObject())));

	$publish = $request->getParameter('publish')=='1'?'A':'I';
    $this->getRoute()->getObject()->setState($publish);
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was published/unpublished successfully.');

    $this->redirect('@mediacategory');
  }  
  
  /** *******************   Batch Action   ********************************************/
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@mediacategory');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@mediacategory');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    $validator = new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'mediacategory'));
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

    $this->redirect('@mediacategory');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (MediaCategoryPeer::retrieveByPks($ids) as $object)
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

    $this->redirect('@mediacategory');
  }
  
  protected function executeBatchArchive(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (MediaCategoryPeer::retrieveByPks($ids) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.archive_object', array('object' => $object)));

      $object->setState('X');
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
      $this->getUser()->setFlash('notice', 'The selected items have been archived successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when archiving the selected items.');
    }

    $this->redirect('@mediacategory');
  }
  
  protected function executeBatchUnarchive(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (MediaCategoryPeer::retrieveByPks($ids) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.unarchive_object', array('object' => $object)));

      $object->setState('A');
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
      $this->getUser()->setFlash('notice', 'The selected items have been unarchived successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when unarchiving the selected items.');
    }

    $this->redirect('mediacategory/indexArchive');
  }
  
  protected function executeBatchPublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
	$publish = $request->getParameter('publish');
	
    $count = 0;
    foreach (MediaCategoryPeer::retrieveByPks($ids) as $object)
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

    $this->redirect('@mediacategory');
  }
}