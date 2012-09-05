<?php

/**
 * article actions.
 *
 * @package    muzelinck
 * @subpackage article
 * @author     Okhi Oktanio
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleActions extends taActionsBackend
{
  protected function getClassname()
  {
  	return ArticlePeer::OM_CLASS;
  }
  
  protected function getDefaultSort()
  {
  	return array(null, null);
  }
  
  protected function isValidSortColumn($column)
  {
  	$valid = parent::isValidSortColumn($column); 
	if(!$valid)
    {
    	$field = explode("_", $column);
		if(isset($field[1]))
		{
			$column = $field[1];
			$valid = $this->isValidSortForeignColumn($column);
		}	
    }	
  	
  	return $valid;
  }
  
  protected function isValidSortForeignColumn($column)
  {
  	return in_array($column, BasePeer::getFieldnames(CategoryPeer::OM_CLASS, BasePeer::TYPE_FIELDNAME));
  }
  
  protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

	if(parent::isValidSortColumn($sort[0]))
	{
	    $column = call_user_func_array($this->getClassname().'Peer::translateFieldName', array($sort[0], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME)); 
	}
	else
	{
	    $field = explode("_", $sort[0]);
		$column = call_user_func_array(CategoryPeer::OM_CLASS.'Peer::translateFieldName', array($field[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME)); 
		$criteria->addJoin(ArticlePeer::CATEGORY_ID, CategoryPeer::ID);
	}

	if ('asc' == $sort[1])
    {
      $criteria->addAscendingOrderByColumn($column);
    }
    else
    {
      $criteria->addDescendingOrderByColumn($column);
    }
  }
	
  public function executeCategory(sfWebRequest $request)
  {	
		$filters = array("category_id"=>$request->getParameter("category_id"));
		$this->getUser()->setAttribute('category_id',$request->getParameter("category_id",null));
		$this->setSort(array('created_at', 'desc'));
		$this->setFilters($filters);
		$this->setPage(1);
		$this->getUser()->setAttribute('redirectto','@article');
		$this->getUser()->setAttribute('redirecttomenu','yes');
		$this->redirect('@article');	
  }
	
  public function executeReset(sfWebRequest $request)
  {	
		$filters = array();
		$this->setFilters($filters);
		$this->setPage(1);
		$this->getUser()->setAttribute('category_id',null);
		$this->getUser()->setAttribute('redirectto','@article');
		$this->getUser()->setAttribute('redirecttomenu','no');
		$this->redirect('@article');	
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
		//if(!$this->hasFilterValues() || (isset($filters['state']) && empty($filters['state'])))
		//{
			$defaultCriteria->add(ArticlePeer::STATE, array("A", "I"), Criteria::IN);
			$defaultCriteria->addJoin(ArticlePeer::CATEGORY_ID, CategoryPeer::ID, Criteria::LEFT_JOIN);
			$defaultCriteria->addAscendingOrderByColumn(CategoryPeer::TITLE);
			$defaultCriteria->addAscendingOrderByColumn(ArticlePeer::ORDERING);
	//	}
			
  }
	
  protected function setAdditionalCriteriaIndexByCategory($defaultCriteria, $filters)
  {
		//set additional criteria to append to filter-based default criteria applied to pager object
		$request = sfContext::getInstance()->getRequest();
		if(!$this->hasFilterValues() || (isset($filters['state']) && empty($filters['state'])))
		{
			$defaultCriteria->add(ArticlePeer::STATE, array("A", "I"), Criteria::IN);
			$defaultCriteria->add(ArticlePeer::CATEGORY_ID, $request->getParameter('category_id',0));
			$defaultCriteria->addDescendingOrderByColumn(ArticlePeer::ORDERING);
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
  
  protected function setAdditionalCriteriaIndexArchive($defaultCriteria, $filters)
  {
	  //set additional criteria to append to filter-based default criteria applied to pager object
	  $defaultCriteria->add(ArticlePeer::STATE, "X", Criteria::EQUAL);	
  }

  public function executeFilter(sfWebRequest $request)
  {
  	if ($request->hasParameter('_reset'))
    {
		$this->setFilters(array());
		$this->setPage(1);
		$this->redirect('@article');
    }

    $this->filters = new ArticleFormFilter($this->getFilters());
		$data = $request->getParameter($this->filters->getName());
    $this->filters->bind($data);
    if ($this->filters->isValid())
    {   
		$this->setFilters($this->filters->getValues());
		$this->setPage(1);
		$this->redirect('@article');
    }

    $this->pager = $this->getPager("setAdditionalCriteriaIndex");
    $this->sort = $this->getSort();
    $this->displayNumber = $this->getMaxPerPage();

    $this->setTemplate('index');	
  }
    
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ArticleForm();
    $this->item = $this->form->getObject();
		$this->formMedia = new MediaForm();
    
    $this->setTemplate('edit');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
  	$this->item = $this->getRoute()->getObject();
	$userid = sfContext::getInstance()->getUser()->getGuardUser()->getId();
   
	
	if(($this->getUser()->isSuperAdmin()) || ($this->item->getUserId() == $userid))
	{
		$this->form = new ArticleForm($this->item);
		$this->formMedia = new MediaForm();
		$this->getUser()->setAttribute('mediaToken',myTools::generateToken(10));
	}
	else
	{
		$this->redirect('@article');	
	}
  }
  
  protected function doAdditionalProcess(sfForm $form)
  {
	 $form->getObject()->updateArticleMedia();
  }
    
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new ArticleForm($this->item);
	$this->item = $this->form->getObject();
	$this->formMedia = new MediaForm();
	
    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
    $this->form = new ArticleForm($this->item);

    $this->processForm($request, $this->form);
		$this->formMedia = new MediaForm();
    
    $this->setTemplate('edit');
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('D');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@article');
  }

  public function executeArchive(sfWebRequest $request)
  {
    $this->dispatcher->notify(new sfEvent($this, 'admin.archive_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('X');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was archived successfully.');

    $this->redirect('@article');
  }
  
  public function executeUnarchive(sfWebRequest $request)
  {

    $this->dispatcher->notify(new sfEvent($this, 'admin.unarchive_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('A');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was unarchived successfully.');

    $this->redirect('article/indexArchive');
  }

  public function executePublish(sfWebRequest $request)
  {
    $this->dispatcher->notify(new sfEvent($this, 'admin.publish_object', array('object' => $this->getRoute()->getObject())));

	$publish = $request->getParameter('publish')=='1'?'A':'I';
    $this->getRoute()->getObject()->setState($publish);
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was published/unpublished successfully.');

    $this->redirect('@article');
  }  
  
  public function executeSortup($request)
  {
  	$item = ArticlePeer::retrieveByPk($this->getRequestParameter('id'));
	$this->forward404Unless($item);
	$previous_item = ArticlePeer::retrieveByOrdering($item->getCategoryId(), $item->getOrdering());
	$this->forward404Unless($previous_item);
	$item->swapWith($previous_item);
	
	$this->redirect('@article');
  }
  
  public function executeSortdown($request)
  {
	$item = ArticlePeer::retrieveByPk($this->getRequestParameter('id'));
	$this->forward404Unless($item);
	$next_item = ArticlePeer::retrieveByOrdering($item->getCategoryId(), $item->getOrdering(), false);
	$this->forward404Unless($next_item);
	$item->swapWith($next_item);
	
	$this->redirect('@article');
  }
  
  /** *******************   Batch Action   ********************************************/
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@article');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@article');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    $validator = new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'article'));
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

    $this->redirect('@article');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (ArticlePeer::retrieveByPks($ids) as $object)
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

    $this->redirect('@article');
  }
  
  
  protected function executeBatchArchive(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
	
    $count = 0;
    foreach (ArticlePeer::retrieveByPks($ids) as $object)
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

    $this->redirect('@article');
  }
  
  protected function executeBatchUnarchive(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
	
    $count = 0;
    foreach (ArticlePeer::retrieveByPks($ids) as $object)
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

    $this->redirect('article/indexArchive');
  }
  
  protected function executeBatchPublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
	$publish = $request->getParameter('publish');
	
    $count = 0;
    foreach (ArticlePeer::retrieveByPks($ids) as $object)
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

    $this->redirect('@article');
  }
  

}