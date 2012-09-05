<?php

/**
 * browsemedia actions.
 *
 * @package    muzelinck
 * @subpackage browsemedia
 * @author     Okhi Oktanio
 * @modified   Andar Harsono
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class browsemediaActions extends taActionsBackend
{
	
	public function executeIndex(sfWebRequest $request)
	{
		sfConfig::set('sf_web_debug', false);
  	$this->textareaId = $request->getParameter('textareaId');
		$this->renderPartial('index');
		return sfView::NONE;
	}

	public function executeList(sfWebRequest $request)
	{
		sfConfig::set('sf_web_debug', false);
  	$this->textareaId = $request->getParameter('textareaId');
		$catid = $request->getParameter("catid","");
		$this->items = MediaPeer::getAllItemsOrderByOrdering($catid);
		$this->renderPartial('list');
		return sfView::NONE;
	}
	
  public function executeNew(sfWebRequest $request)
  {
		sfConfig::set('sf_web_debug', false);
		$this->form = new BrowsemediaForm();
		$this->mediacategories = MediacategoryPeer::getAllItems();
		$this->renderPartial('form');
		return sfView::NONE;
	}
	
  public function executeGetYoutubeToken(sfWebRequest $request)
  {
		$index = $request->getParameter('upload_index', '0');
		$video = new taYoutube();
		$tokenArray = $video->getUploadToken('PLR', 'media');
		
		$this->getResponse()->setContentType("application/json;charset=utf-8");
		$tokenArray['upload_index'] = $index;
		if( $tokenArray )
		{
			$tokenArray['error'] = '';
			$this->renderText(json_encode($tokenArray));
		}	
		else
			$this->renderText(json_encode(array('error'=>$video->getError())));
		
		return sfView::NONE;
  }  
	
  public function executeCreateYoutube(sfWebRequest $request)
  {
		sfConfig::set('sf_web_debug', false);
		$this->item = MediaPeer::retrieveByPK($request->getParameter('media_id'));
		$this->form = new BrowsemediaForm($this->item, array('is_youtube' => true));
		$id = $request->getParameter('id');
  	$media['_csrf_token'] = $request->getParameter('csrftoken');
		$media['title'] = $request->getParameter('title');
		$media['file_uri'] = $request->getParameter('id');
  	$media['mimetype'] = 'video';
  	$media['thumb_uri'] = "http://img.youtube.com/vi/".$id."/2.jpg";
		if($request->getParameter('catid')<>'') $media['mediacategory_id'] = $request->getParameter('catid');
  	$this->form->bind($media, null);
		
		if ($this->form->isValid())
    {
			$media = $this->form->save();
			$media->setOrdering(0);
			$media->save();
		} 
		else
		{
			$this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
		}
		$this->renderPartial('validation');
		return sfView::NONE;
  }
	
  public function executeCreate(sfWebRequest $request)
  {
		sfConfig::set('sf_web_debug', false);
    $this->form = new BrowsemediaForm();
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
			$catid = $request->getParameter("mediacategory_id");
			if($catid <> "") $media->setMediacategoryId($catid);
			$media->setOrdering(0);
			$media->save();
		} 
		else
		{
			$this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
		}
  }
	
  public function executeAjaxDelete(sfWebRequest $request)
  {
		sfConfig::set('sf_web_debug', false);
		
		$this->getResponse()->setContentType('application/json');
		
		$json = array();
		$Media = MediaPeer::retrieveByPk($request->getParameter('mediaId'));

		try
		{
			$Media->setState('D');
			$Media->save();
			$json['success'] = 'true';
			$json['message'] = '';
		}
		catch (Exception $e)
		{
			$error =  $e->getMessage();	
			$json['success'] = 'false';
			$json['message'] = $error;
		}

		return $this->renderText(json_encode($json));	
  }
}