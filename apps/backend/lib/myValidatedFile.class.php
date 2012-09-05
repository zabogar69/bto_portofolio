<?php

class myValidatedFile extends sfValidatedFile{
	
  public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
	{
		$saved = parent::save($file, $fileMode, $create, $dirMode);
						
		if(substr($this->getType(), 0, 5) == 'image')
		{ 
		
			$folder = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.sfConfig::get('app_media_folder').DIRECTORY_SEPARATOR;
			$srcFile = $folder.$saved;
			$resizePath = $folder;
			 
			//resize
			$resizeName = sfConfig::get('app_prefixResize').$saved;
			$theResize = $resizePath.$resizeName;
			$resize= new Thumbnail($srcFile);
			if($resize->getMyWidth()>=sfConfig::get('app_resizeWidth') || $resize->getMyHeight()>=sfConfig::get('app_resizeHeight'))
			{
				$resize->resize(sfConfig::get('app_resizeWidth'),sfConfig::get('app_resizeHeight'));
			}
			$resize->save($theResize,100);
			
		}
		
    return $saved;
  }
}
