<?php

class taActionsBackend extends sfActions
{
  protected $maxPerPage = null;
  
  protected function getClassname()
  {
  	return '';
  }
  
  protected function getDefaultSort()
  {
  	return array(null, null);
  }
  
  protected function getMaxPerPage($name='indexPage')
  {
  	return $this->getUser()->getAttribute($name.'.maxPerPage', sfConfig::get('app_maxPerPage'), 'admin_module');
  }
  
  protected function setMaxPerPage($value, $name='indexPage')
  {
  	return $this->getUser()->setAttribute($name.'.maxPerPage', $value, 'admin_module');
  }
  
  protected function getPager($additionalCriteriaCallback=null, $name='indexPage')
  {
    $pager = new sfPropelPager($this->getClassname(), $this->getMaxPerPage($name));
    
    $pager->setCriteria($this->buildCriteria($additionalCriteriaCallback, $name));
	    
    $pager->setPage($this->getPage());
    $pager->init();

    return $pager;
  }
  
  protected function buildCriteria($additionalCriteriaCallback=null, $name='indexPage')
  {
    if (null === $this->filters)
    {
      $classFormFilter = $this->getClassname().'FormFilter';	
      $this->filters = new $classFormFilter($this->getFilters($name), array());
	}

    $criteria = $this->filters->buildCriteria($this->getFilters($name));

    $this->addSortCriteria($criteria);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
    $criteria = $event->getReturnValue();

    if(!empty($additionalCriteriaCallback))
		$this->$additionalCriteriaCallback($criteria, $this->getFilters($name));
    
    return $criteria;
  }

  protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

    $column = call_user_func_array($this->getClassname().'Peer::translateFieldName', array($sort[0], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME)); 
	if ('asc' == $sort[1])
    {
      $criteria->addAscendingOrderByColumn($column);
    }
    else
    {
      $criteria->addDescendingOrderByColumn($column);
    }
  }
  
  protected function hasFilterValues($name='indexPage')
  {
  	$classFormFilter = $this->getClassname().'FormFilter';	
    $formFilter = new $classFormFilter($this->getFilters($name), array());
	$fields = $formFilter->getFields(); 
	$hasFilterValues = false;
  	
  	foreach($fields as $field => $type)
    {
    	$value = $formFilter->getDefault($field);
    	if(!empty($value))
    	{
    		$hasFilterValues = true;
    		break;
    	}	
   	}
  	
	return $hasFilterValues;
  }
  
  protected function getFilters($name='indexPage')
  {
    return $this->getUser()->getAttribute($this->getModuleName().'.'.$name.'.filters', array(), 'admin_module');
  }

  protected function setFilters(array $filters, $name='indexPage')
  {
    return $this->getUser()->setAttribute($this->getModuleName().'.'.$name.'.filters', $filters, 'admin_module');
  }
  
  protected function setPage($page, $action=null)
  {
    $this->getUser()->setAttribute($this->getModuleName().'.'.$this->getActionName().'.page', $page, 'admin_module');
  }

  protected function getPage($action=null)
  {
	return $this->getUser()->getAttribute($this->getModuleName().'.'.$this->getActionName().'.page', 1, 'admin_module');
  }
  
  protected function getSort($action=null)
  {
  	$sort = $this->getUser()->getAttribute($this->getModuleName().'.'.$this->getActionName().'.sort', null, 'admin_module');
    if (null !== $sort && !empty($sort[0]))
    {
      return $sort;
    }

    $this->setSort($this->getDefaultSort());

    return $this->getUser()->getAttribute($this->getModuleName().'.'.$this->getActionName().'.sort', null, 'admin_module');
  }

  protected function setSort(array $sort, $action=null)
  {
    if (null !== $sort[0] && null === $sort[1])
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute($this->getModuleName().'.'.$this->getActionName().'.sort', $sort, 'admin_module');
  }

  protected function isValidSortColumn($column)
  {
    return in_array($column, BasePeer::getFieldnames($this->getClassname(), BasePeer::TYPE_FIELDNAME));
  }
  
  /** *******************   Generic Action   ********************************************/
  public function executeIndexTrashBin(sfWebRequest $request)
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

    $this->pager = $this->getPager("setAdditionalCriteriaIndexTrashBin");
    $this->sort = $this->getSort();
    $this->displayNumber = $this->getMaxPerPage();
    $this->trashbinSelectorHTML = $this->renderTrashbinSelector($request);
  }
  
  protected function setAdditionalCriteriaIndexTrashBin(Criteria $defaultCriteria, $filters)
  {
	//set additional criteria to append to filter-based default criteria applied to pager object
	$defaultCriteria->add(constant($this->getClassname().'Peer::STATE'), 'D', Criteria::EQUAL);
  }
  
  
  protected function renderTrashbinSelector(sfWebRequest $request)
  {
  	$currentHost =   $request->getUriPrefix().$request->getRelativeUrlRoot().$request->getPathInfoPrefix()."/";
  	
	$htmlString  =	" <select id=\"trashbinSwitcher\" onchange=\"window.location=this.value\"> ";
	$htmlString .=	" 		<option value=\"\">Kies prullenbak</option>";
	$htmlString .=	" 		<option value=\"".$currentHost. 'projectencategory/indexTrashBin'."\">Projecten Categorie</option>";
	$htmlString .=	" 		<option value=\"".$currentHost. 'projecten/indexTrashBin'."\">Projecten</option>";	
	$htmlString .=	" 		<option value=\"".$currentHost. 'category/indexTrashBin'."\">Categorie</option>";
	$htmlString .=	" 		<option value=\"".$currentHost. 'article/indexTrashBin' ."\">Artikel</option>";
	$htmlString .=	" 		<option value=\"".$currentHost. 'menu/indexTrashBin'."\">Menu</option>";
	$htmlString .=	" 		<option value=\"".$currentHost. 'mediacategory/indexTrashBin' ."\">Mediacategorie</option>";
	$htmlString .=	" 		<option value=\"".$currentHost. 'media/indexTrashBin' ."\">Media</option>";
	$htmlString .=	"	</select>";
	
	return $htmlString;
			    
	
  }
  
  /** *******************   Generic simple CRUD Action   ********************************************/
  static public function afterObjectSaved(sfEvent $event)
  {
  	$item = $event->offsetGet('object');
    $module = $event->offsetGet('moduleName'); 
	
	switch($module)
	{
		case "microsite":
			$indexFiles = $item->writeIndexToFile();	 
			$item->saveToFTP($indexFiles); 	
			break;
		
		case "content":
			$microsites = MicrositePeer::retrieveByContent($item->getId());
			foreach($microsites as $microsite)
			{
				$indexFiles = $microsite->writeIndexToFile();	 
				$microsite->saveToFTP($indexFiles);
			}
			break;
		
		case "template":
			$microsites = MicrositePeer::retrieveByTemplate($item->getId());
			/*foreach($microsites as $microsite)
			{
				$indexFiles = $microsite->writeIndexToFile();	 
				$microsite->saveToFTP($indexFiles);
			}*/
			break;
		
		default:
			break;
	}
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {

  	$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      $item = $form->save();

      $this->doAdditionalProcess($form);
      
	  $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $item, 'moduleName'=>$this->getModuleName())));

      $this->getUser()->setFlash('notice', $notice);
      
			if($request->getParameter("saveType")=='save'){
				
				if($this->getModuleName()=='article'){
					$this->redirect($this->getUser()->getAttribute('redirectto','@article'));
				}else{
					$this->redirect('@'.$this->getModuleName());
				}

			}else if ($request->getParameter("saveType")=='apply'){
				$this->redirect($this->getModuleName().'_edit', $item);
			}
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
  
  protected function doAdditionalProcess(sfForm $form){}
  
  public function executeDestroy(sfWebRequest $request)
  {
    $this->dispatcher->notify(new sfEvent($this, 'admin.destroy_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();
	
    $this->getUser()->setFlash('notice', 'The item was destroyed successfully.');

    $this->redirect($this->getModuleName().'/indexTrashBin');
  }
  
  public function executeRestore(sfWebRequest $request)
  {
    $this->dispatcher->notify(new sfEvent($this, 'admin.restore_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->setState('A');
	$this->getRoute()->getObject()->save();

    $this->getUser()->setFlash('notice', 'The item was restored successfully.');

    $this->redirect($this->getModuleName().'/indexTrashBin');
  }
  
 
  
  /** *******************   Generic Batch Action   ********************************************/
  protected function executeBatchDestroy(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (call_user_func_array($this->getClassname().'Peer::retrieveByPks', array($ids)) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.destroy_object', array('object' => $object)));

      try
	  {
	  	$object->delete();
        $count++;
	  }
	  catch (Exception $e)
      {}
    }

    if ($count >= count($ids))
    {
      $this->getUser()->setFlash('notice', 'The selected items have been destroyed successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when destroying the selected items.');
    }

    $this->redirect($this->getModuleName().'/indexTrashBin');
  }
  
  protected function executeBatchRestore(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (call_user_func_array($this->getClassname().'Peer::retrieveByPks', array($ids)) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.restore_object', array('object' => $object)));

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
      $this->getUser()->setFlash('notice', 'The selected items have been restored successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when restoring the selected items.');
    }

    $this->redirect($this->getModuleName().'/indexTrashBin');
  }
  
  protected function composeAndSend($from, $to, $subject, $body)
  {
  	$mail = Swift_Message::newInstance();
	$mail->setFrom($from);
	$mail->setTo($to);
	$mail->setSubject($subject);
	$mail->setBody($body, 'text/html');
	
	$this->getMailer()->send($mail);
  }
}
