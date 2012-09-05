<?php

/**
 * category actions.
 *
 * @package    tec
 * @subpackage category
 * @author     Andar Harsono
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends taActionsFrontend
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
	
  public function executeShow(sfWebRequest $request)
  {
		$id = $request->getParameter('id');
		$menu1 = $request->getParameter('menu1');
		$menu2 = $request->getParameter('menu2');
		
		$this->menu = MenuPeer::retrieveBySlug($menu1);
		$this->forward404Unless($this->menu);
		
		$this->category = CategoryPeer::retrieveByPk($id);
		$this->forward404Unless($this->category);
		
		$this->parentcategory = $this->category;
		
		$this->items = ArticlePeer::retrieveByCategory($id);
		$this->forward404Unless($this->items);
		
		if($menu2)
		{
			$metatitles = array($this->menu->getTitle(),$this->category->getTitle());
			$metadescriptions = array();
			$metakeywords = array($this->menu->getTitle(),$this->category->getTitle());
		}
		else
		{
			$metatitles = array($this->menu->getTitle());
			$metadescriptions = array();
			$metakeywords = array($this->menu->getTitle());
		}

		$this->setMetas($metatitles,$metadescriptions,$metakeywords);
		
		$this->setLayout('layout');
  }
}