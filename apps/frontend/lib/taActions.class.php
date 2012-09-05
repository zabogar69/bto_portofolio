<?php

class taActionsFrontend extends sfActions
{
  protected $maxPerPage = null;
  
  public function preExecute()
  {
		sfProjectConfiguration::getActive()->loadHelpers(array('Date','Number','I18N','Url'));
  }
  
  protected function getClassname()
  {
  	return '';
  }
  
  protected function getDefaultSort()
  {
  	return array(null, null);
  }
  
  protected function getMaxPerPage()
  {
  	return empty($this->maxPerPage)?sfConfig::get('app_maxPerPage'):$this->maxPerPage;
  }
  
  protected function setMaxPerPage($value=null)
  {
  	$this->maxPerPage = $value;
  }
  
  protected function getPager($additionalCriteriaCallback=null, $request=null)
  {
    $pager = new sfPropelPager($this->getClassname(), $this->getMaxPerPage());
    
	$defaultCriteria = $this->buildCriteria();
    if(!empty($additionalCriteriaCallback))
		$this->$additionalCriteriaCallback($defaultCriteria, $request);
    
    $pager->setCriteria($defaultCriteria);
	    
    $pager->setPage($this->getPage());
    $pager->init();

    return $pager;
  }
  
  protected function buildCriteria()
  {
    if (null === $this->filters)
    {
      $classFormFilter = $this->getClassname().'FormFilter';	
      $this->filters = new $classFormFilter($this->getFilters(), array());
	}

    $criteria = $this->filters->buildCriteria($this->getFilters());

    $this->addSortCriteria($criteria);

	//use this event instead of "$additionalCriteriaCallback"
    $event = $this->dispatcher->filter(new sfEvent($this, 'front.build_criteria'), $criteria);
    $criteria = $event->getReturnValue();

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
  
  protected function getFilters()
  {
    return $this->getUser()->getAttribute($this->getModuleName().'.filters', array(), 'front_module');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute($this->getModuleName().'.filters', $filters, 'front_module');
  }
  
  protected function setPage($page)
  {
    $this->getUser()->setAttribute($this->getModuleName().'.'.$this->getActionName().'.page', $page, 'front_module');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute($this->getModuleName().'.'.$this->getActionName().'.page', 1, 'front_module');
  }
  
  protected function getSort()
  {
	$sort = $this->getUser()->getAttribute($this->getModuleName().'.sort', null, 'front_module');
    if (null !== $sort && !empty($sort[0]))
    {
      return $sort;
    }

    $this->setSort($this->getDefaultSort());

    return $this->getUser()->getAttribute($this->getModuleName().'.sort', null, 'front_module');
  }

  protected function setSort(array $sort)
  {
	if (null !== $sort[0] && null === $sort[1])
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute($this->getModuleName().'.sort', $sort, 'front_module');
  }

  protected function isValidSortColumn($column)
  {
    return in_array($column, BasePeer::getFieldnames($this->getClassname(), BasePeer::TYPE_FIELDNAME));
  }
  
  protected function composeAndSend($from, $to, $subject, $body)
  {
  	/**
  	$mail = Swift_Message::newInstance();
	$mail->setFrom($from);
	$mail->setTo($to);
	$mail->setSubject($subject);
	$mail->setBody($body, 'text/html');
	
	$this->getMailer()->send($mail);
	**/
	$toAddress = "";
	if(is_array($to))
	{
		foreach($to as $email)
		{
			if(strlen($toAddress)>0)
				$toAddress += ", ";
			$toAddress += $email;
		}
	}
	else
	{
		$toAddress = $to;
	}
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '. $toAddress . "\r\n";
	$headers .= 'From: '. $from . "\r\n";
	
	//mail($toAddress, $subject, $body, $headers);
  }
	
	public function setMetas($metatitles,$metadescriptions,$metakeywords,$titleseparator=' › ')
	{
		sfProjectConfiguration::getActive()->loadHelpers(array('Text'));
		
		$title = sfConfig::get('app_meta_title');
		foreach($metatitles as $metatitle)
		{
			$title .= $titleseparator . ucwords($metatitle);
		}
		$title = strip_tags($title);
		
		$description =  '';
		foreach($metadescriptions as $metadescription)
		{
			if(strlen(trim(strip_tags($metadescription)))>0){
				$description .= $metadescription . ', ';
			}
		}
		$description .= sfConfig::get('app_meta_description');
		$description = strip_tags(truncate_text($description,200));
		
		$keywords =  '';
		foreach($metakeywords as $metakeyword)
		{
			if(strlen(trim(strip_tags($metakeyword)))>0){
				$keywords .= strtolower(strip_tags($metakeyword)) . ', ';
			}
		}
		$keywords .= sfConfig::get('app_meta_keyword');

		$this->getResponse()->setTitle($title);
		$this->getResponse()->addMeta('description',$description);
		$this->getResponse()->addMeta('keywords',$keywords);	
	}
}
