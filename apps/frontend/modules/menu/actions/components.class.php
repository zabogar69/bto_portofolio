<?php

/**
 * frontpage actions.
 *
 * @package    tec
 * @subpackage menu
 * @author     Andar Harsono
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class menuComponents extends sfComponents
{	

  public function executeMain(sfWebRequest $request)
  {
		$this->menu1 = $request->getParameter('menu1');
		$this->menu2 = $request->getParameter('menu2');
		$this->menu3 = $request->getParameter('menu3');
		$route = $this->getContext()->getRouting();
		
		switch($route->getCurrentRouteName())
		{
			case "homepage":
				$menuactive = MenuPeer::retrieveByLink('frontpage/index'); //home
			break;
			default:
				$menuactive = MenuPeer::retrieveBySlug($this->menu1);
			break;
		}
		
		$this->menuactiveid = ($menuactive) ? $menuactive->getId() : 0;
		$this->menus = MenuPeer::retrieveByParent(1);
  }
}


?>