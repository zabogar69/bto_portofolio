<?php

/**
 * media actions.
 *
 * @package    isp
 * @subpackage media
 * @author     Andar Harsono
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mediaActions extends taActionsFrontend
{
	protected function getClassname()
	{
		return MediaPeer::OM_CLASS;
	}
	
	public function executeIndex(sfWebRequest $request)
	{

	}
}
