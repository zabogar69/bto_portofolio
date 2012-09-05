<?php

/**
 * contact actions.
 *
 * @package    tec
 * @subpackage article
 * @author     Andar Harsono
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactActions extends taActionsFrontend
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
	
  public function executeForm(sfWebRequest $request)
  {
		$menu1 = $request->getParameter('menu1');
		$this->menu = MenuPeer::retrieveBySlug($menu1);
		
		$this->item = ArticlePeer::retrieveByPk(14);
		
		if($this->item){
			$metatitles = array($this->item->getTitle());
			$metadescriptions = array($this->item->getMetadesc());
			$metakeywords = array($this->item->getMetatags());
		}else{
			$metatitles = array();
			$metadescriptions = array();
			$metakeywords = array();
		}

		$this->setMetas($metatitles,$metadescriptions,$metakeywords);
  }
	
}