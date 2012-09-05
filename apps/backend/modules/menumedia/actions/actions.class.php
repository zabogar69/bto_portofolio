<?php

/**
 * inlinemedia actions.
 *
 * @package    Quinta
 * @subpackage media
 * @author     Andar Harsono
 */
class menumediaActions extends taActionsBackend
{
  protected function getClassname()
  {
  	return MediaPeer::OM_CLASS;
  }
		
  public function executeNew(sfWebRequest $request)
  {
		sfConfig::set('sf_web_debug', false);
		$this->form = new MediaInlineForm();
		$this->renderPartial('form');
		return sfView::NONE;
  }
	
  public function executeCreate(sfWebRequest $request)
  {
		sfConfig::set('sf_web_debug', false);
		$this->form = new MediaInlineForm();
		$this->processForm($request, $this->form);
		$this->renderPartial('validation');
		return sfView::NONE;
  }
	
	public function executeAjaxSort(sfWebRequest $request)
	{
		sfConfig::set('sf_web_debug', false);
		$items = $request->getParameter('mf-item');
		$n=1;
		foreach($items as $item)
		{
			$Media = MediaPeer::retrieveByPk($item);
			$Media->setOrdering($n);
			$Media->save();
			$n++;
		}
		return sfView::NONE;
		
	}
	
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
  	$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
		if ($form->isValid())
    {
			
			$media = $form->save();
			$media->setMediacategoryId("2");
			$media->setParams("token=".$this->getUser()->getAttribute("mediaToken"));
			$media->setOrdering(0);
			$media->save();
		} 
		else
		{
			
			$this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
		}
  }
	
	public function executeMediaByTokenAndMenuId(sfWebRequest $request)
	{
		
		sfConfig::set('sf_web_debug', false);
		if($request->getParameter("id")=="")
		{
			$this->items = MediaPeer::retrieveMediaByToken();
		}
		else
		{
			$this->items = MenuMediaPeer::retrieveMediasByMenuId($request->getParameter("id"));	
		}
		
		if($request->getParameter("preview")=="true")
		{
			$this->renderPartial('preview');
		}
		else
		{
			$this->renderPartial('list');
		}
		return sfView::NONE;
	}

	
  public function executeAjaxDelete(sfWebRequest $request)
  {
		sfConfig::set('sf_web_debug', false);
		
		$this->getResponse()->setContentType('application/json');
		
		$json = array();
		
		if($request->getParameter('relId')>0)
		{
			$Menumedia = MenuMediaPeer::retrieveByMediaId($request->getParameter('mediaId'));
			$Media = MediaPeer::retrieveByPk($request->getParameter('mediaId'));
			
			try
			{
				if($Menumedia) $Menumedia->delete();
				$Media->delete();
				$json['success'] = 'true';
				$json['message'] = '';
			}
			catch (Exception $e)
			{
				$error =  $e->getMessage();	
				$json['success'] = 'false';
				$json['message'] = $error;
			}

		}
		else
		{
			$Media = MediaPeer::retrieveByPk($request->getParameter('mediaId'));

			try
			{
				$Media->delete();
				$json['success'] = 'true';
				$json['message'] = '';
			}
			catch (Exception $e)
			{
				$error =  $e->getMessage();	
				$json['success'] = 'false';
				$json['message'] = $error;
			}

		}
		return $this->renderText(json_encode($json));	
  }

}
