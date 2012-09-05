<?php

/**
 * media actions.
 *
 * @package    isp
 * @subpackage media
 * @author     Andar Harsono
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mediaComponents extends sfComponents
{	

  public function executeBanner(sfWebRequest $request)
  {
		$this->medias = MediaPeer::getAllItemsOrderByOrdering(4);
  }
	
  public function executePartner(sfWebRequest $request)
  {
		$this->medias = MediaPeer::getAllItemsOrderByOrdering(3);
  }

}


?>