<?php

/**
 * media actions.
 *
 * @package    isp
 * @subpackage mediacategory
 * @author     Andar Harsono
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mediacategoryActions extends taActionsFrontend
{
	protected function getClassname()
	{
		return MediacategoryPeer::OM_CLASS;
	}
	
	public function executeShow(sfWebRequest $request)
	{
		$id = $request->getParameter('id');
		
		$menu1 = $request->getParameter('menu1');
		$menu2 = $request->getParameter('menu2');
		$menu3 = $request->getParameter('menu3');
	
		$metatitle = array();
		
		if($menu1) { $menu = $menu1; $this->menu1 = MenuPeer::retrieveBySlug($menu); $metatitle[]=$this->menu1->getTitle();}
		if($menu2) { $menu = $menu2; $this->menu2 = MenuPeer::retrieveBySlug($menu); $metatitle[]=$this->menu2->getTitle();}
		if($menu3) { $menu = $menu3; $this->menu3 = MenuPeer::retrieveBySlug($menu); $metatitle[]=$this->menu3->getTitle();}
		
		$this->Mediacategory = MediacategoryPeer::retrieveByPk($id);
		$this->forward404Unless($this->Mediacategory);
		
		$this->items = MediaPeer::getAllItemsOrderByOrdering($this->Mediacategory->getId());
		
		$metatitles = $metatitle;
		$metadescriptions = array();
		$metakeywords = array();
		$this->setMetas($metatitles,$metadescriptions,$metakeywords); 
	}
}
