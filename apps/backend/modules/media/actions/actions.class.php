<?php

/**
 * media actions.
 *
 * @package    muzelinck
 * @subpackage media
 * @author     Okhi Oktanio
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mediaActions extends taActionsBackend
{
  protected function getClassname()
  {
  	return MediaPeer::OM_CLASS;
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
  	return in_array($column, BasePeer::getFieldnames(MediacategoryPeer::OM_CLASS, BasePeer::TYPE_FIELDNAME));
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
		$column = call_user_func_array(MediacategoryPeer::OM_CLASS.'Peer::translateFieldName', array($field[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME)); 
		$criteria->addJoin(MediaPeer::MEDIACATEGORY_ID, MediacategoryPeer::ID);
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
	$filters = array("mediacategory_id"=>$request->getParameter("category_id"));
	$this->getUser()->setAttribute('category_id',$request->getParameter("category_id",null));
	$this->setSort(array('ordering', 'asc'));
	$this->setFilters($filters);
	$this->setPage(1);
	$this->getUser()->setAttribute('redirectto','@media');
	$this->getUser()->setAttribute('redirecttomenu','yes');
	$this->redirect('@media');	
  }
	
  public function executeReset(sfWebRequest $request)
  {	
	$filters = array();
	$this->setFilters($filters);
	$this->setPage(1);
	$this->getUser()->setAttribute('category_id',null);
	$this->getUser()->setAttribute('redirectto','@media');
	$this->getUser()->setAttribute('redirecttomenu','no');
	$this->redirect('@media');	
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
		$defaultCriteria->add(MediaPeer::STATE, array('A', 'I'), Criteria::IN);
		$defaultCriteria->addAscendingOrderByColumn(MediaPeer::ORDERING);
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
	  
	  $defaultCriteria->add(MediaPeer::STATE, "X", Criteria::EQUAL);	
  }
  
  public function executeFilter(sfWebRequest $request)
  {
  	if ($request->hasParameter('_reset'))
    {
		$this->setFilters(array());
		$this->setPage(1);
		$this->redirect('@media');
    }

    $this->filters = new MediaFormFilter($this->getFilters());
	$data = $request->getParameter($this->filters->getName());
    $this->filters->bind($data);
    if ($this->filters->isValid())
    {   
		$this->setFilters($this->filters->getValues());
		$this->setPage(1);
		$this->redirect('@media');
    }

    $this->pager = $this->getPager("setAdditionalCriteriaIndex");
    $this->sort = $this->getSort();
    $this->displayNumber = $this->getMaxPerPage();

    $this->setTemplate('index');	
  }
  
  public function executeMultiple(sfWebRequest $request)
  {
    $this->form = new MediaForm();
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new MediaForm();
    $this->item = $this->form->getObject();
    
    $this->getResponse()->addJavascript('phpjs-part',"last");
    $this->setTemplate('edit');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
    $this->form = new MediaForm($this->item);
    
    $this->getResponse()->addJavascript('phpjs-part',"last");
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new MediaForm();
	$this->item = $this->form->getObject();
	
    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }
  
  public function executeRedirectMultiple(sfWebRequest $request)
  {
  	$message = $request->getParameter('messages');
  	$this->getUser()->setFlash('notice', $message);
	
	$this->redirect('@media');
  }
  
  public function executeCreateMultiple(sfWebRequest $request)
  {
    $this->form = new MediaForm();
	$this->index = $request->getParameter('upload_index');
	
    $this->processForm($request, $this->form);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
    $this->form = new MediaForm($this->item);

    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }
  
  public function executeUpdateVideo(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isMethod('get'));
  	
  	$this->item = MediaPeer::retrieveByPK($request->getParameter('media_id'));
    $this->form = new MediaForm($this->item, array('is_youtube' => true));
    
  	$this->index = $request->getParameter('upload_index');
  	$status = $request->getParameter('status');
  	$error = $request->getParameter('error');
  	$id = $request->getParameter('id');
  	
  	$media = array();
  	$media['_csrf_token'] = $request->getParameter($this->form['_csrf_token']->renderId());
  	$media['id'] = $request->getParameter($this->form['id']->renderId());
  	$media['state'] = $request->getParameter($this->form['state']->renderId());
  	$media['title'] = $request->getParameter($this->form['title']->renderId());
  	$media['description'] = $request->getParameter($this->form['description']->renderId());
  	$media['params'] = $request->getParameter($this->form['params']->renderId());
  	$media['mediacategory_id'] = $request->getParameter($this->form['mediacategory_id']->renderId());
  	$media['mimetype'] = 'video';
  	$media['file_uri'] = $id;
  	$media['thumb_uri'] = "http://img.youtube.com/vi/".$id."/2.jpg";

  	$this->form->bind($media, null);
    if ($this->form->isValid())
    {
      $notice = $this->form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      $item = $this->form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $item)));

      $this->getUser()->setFlash('notice', $notice);

      if(is_null($this->index))
	  	$this->redirect('@media');
	  else
		$this->setTemplate('createMultiple');
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
    
    if(!is_null($this->index))
		$this->setTemplate('edit');
	else
		$this->setTemplate('createMultiple');
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('D');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@media');
  }
  
  public function executeUnarchive(sfWebRequest $request)
  {

    $this->dispatcher->notify(new sfEvent($this, 'admin.unarchive_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('A');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was unarchived successfully.');

    $this->redirect('media/indexArchive');
  }

  public function executePublish(sfWebRequest $request)
  {
    $this->dispatcher->notify(new sfEvent($this, 'admin.publish_object', array('object' => $this->getRoute()->getObject())));

	$publish = $request->getParameter('publish')=='1'?'A':'I';
    $this->getRoute()->getObject()->setState($publish);
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was published/unpublished successfully.');

    $this->redirect('@media');
  }  
  
  public function executeGetYoutubeToken(sfWebRequest $request)
  {
	//forward404Unless($this->getRequest()->isXmlHttpRequest());
	$index = $request->getParameter('upload_index', '0');
	
	//video
	$video = new taYoutube();
	$tokenArray = $video->getUploadToken('muzelinck', 'media');
	
	$this->getResponse()->setContentType("application/json;charset=utf-8");
	$tokenArray['upload_index'] = $index;
	if( $tokenArray )
	{
		$tokenArray['error'] = '';
		$this->renderText(json_encode($tokenArray));
	}	
	else
		$this->renderText(json_encode(array('error'=>$video->getError())));
	
	return sfView::NONE;
  }
  
  public function executePreview(sfWebRequest $request)
  {
  	$this->item = MediaPeer::retrieveByPK($request->getParameter('id'));
  	
  	$this->renderPartial('preview');
    return sfView::NONE;
  }
  
  public function executeSortup($request)
  {
  	$item = MediaPeer::retrieveByPk($this->getRequestParameter('id'));
	$this->forward404Unless($item);
	$previous_item = MediaPeer::retrieveByOrdering($item->getMediacategoryId(), $item->getOrdering());
	$this->forward404Unless($previous_item);
	$item->swapWith($previous_item);
	
	$this->redirect('@media');
  }
  
  public function executeSortdown($request)
  {
	$item = MediaPeer::retrieveByPk($this->getRequestParameter('id'));
	$this->forward404Unless($item);
	$next_item = MediaPeer::retrieveByOrdering($item->getMediacategoryId(), $item->getOrdering(), false);
	$this->forward404Unless($next_item);
	$item->swapWith($next_item);
	
	$this->redirect('@media');
  }
  
  /** *******************   Batch Action   ********************************************/
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@media');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@media');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    $validator = new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'media'));
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

    $this->redirect('@media');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (MediaPeer::retrieveByPks($ids) as $object)
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

    $this->redirect('@media');
  }
  
  protected function executeBatchArchive(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (MediaPeer::retrieveByPks($ids) as $object)
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

    $this->redirect('@media');
  }
  
  protected function executeBatchUnarchive(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (MediaPeer::retrieveByPks($ids) as $object)
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

    $this->redirect('media/indexArchive');
  }
  
  protected function executeBatchPublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
	$publish = $request->getParameter('publish');
	
    $count = 0;
    foreach (MediaPeer::retrieveByPks($ids) as $object)
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

    $this->redirect('@media');
  }
	
  public function executeInlineNew(sfWebRequest $request)
  {
		sfConfig::set('sf_web_debug', false);
		$this->form = new MediaForm();
		$this->renderPartial('inlineForm');
		return sfView::NONE;
	}
	
}