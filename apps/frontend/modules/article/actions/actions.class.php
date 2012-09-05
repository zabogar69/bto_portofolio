<?php

/**
 * article actions.
 *
 * @package    tec
 * @subpackage article
 * @author     Andar Harsono
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleActions extends taActionsFrontend
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  protected function getClassname()
  {
  	return ArticlePeer::OM_CLASS;
  }
	
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('frontpage', 'index');
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
		
		$this->item = ArticlePeer::retrieveByPk($id);
		$this->forward404Unless($this->item);
		
		$metatitles = $metatitle;
		$metadescriptions = array($this->item->getMetadesc());
		$metakeywords = array($this->item->getMetatags());
		$this->setMetas($metatitles,$metadescriptions,$metakeywords);
  }
	
	public function executeSearch(sfWebRequest $request){

	}
	
}