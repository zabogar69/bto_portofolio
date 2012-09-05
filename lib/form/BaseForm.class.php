<?php

/**
 * Base project form.
 * 
 * @package    muzelinck
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
  protected static $states = array('A'=>'Ja','I'=>'Nee');
  protected static $gender = array('man'=>'Dhr.', 'vrouw'=>'Mevr.');
	protected static $appnames = array('marriage'=>'Marriage', 'loverscounter'=>'Loverscounter');
  protected static $emptyTextLevel = 'Top niveau';
  
  protected function canCreateThumbnail(sfValidatedFile $file = null)
  {
  	if(null === $file)
  		return false;
	
	$savedName = $file->getSavedName();
	if(empty($savedName))
		return false;
	
	return in_array($file->getType(), array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/bmp'))?true:false;
  }
  
  protected function createThumbnail(sfValidatedFile $file = null, $maxThumbSize=60, $prefixThumbnail='tn2_')
  {
	if(empty($file))
		return null;
	
	$filename = str_replace($file->getPath().DIRECTORY_SEPARATOR,'', $file->getSavedName());
	$thumbname = $prefixThumbnail.$filename;
	
	if(!$this->resizeImage($file, $file->getPath().DIRECTORY_SEPARATOR.$thumbname, $maxThumbSize, $maxThumbSize))
		return null;
	
	return $thumbname;
  } 
	
  protected function resizeImage(sfValidatedFile $file, $filedestPath, $maxWidth, $maxHeight)
  {
	if(empty($file) || empty($filedestPath) || empty($maxWidth) || empty($maxHeight))
		return false;
	
	switch($file->getType())
	{
		case "image/jpeg":
		case "image/pjpeg":
			$src_img = imagecreatefromjpeg($file->getSavedName());
			break;
		case "image/gif":
			$src_img = imagecreatefromgif($file->getSavedName());
			break;
		case "image/png":
		case "image/x-png":
			$src_img = imagecreatefrompng($file->getSavedName());
			break;
		case "image/bmp":
			$src_img = imagecreatefromwbmp($file->getSavedName());
			break;
		default:
			throw new Exception(sprintf('"%s" is not an image file', $file->getSavedName()));
			break;
	}
	
	// display file
	$imginfo = getimagesize( $file->getSavedName() );
	if($imginfo[0]>=$imginfo[1])
	{//width is greater than height
		$destWidth = $imginfo[0] > $maxWidth ? $maxWidth : $imginfo[0];
		$destHeight = $imginfo[1]/$imginfo[0]*$destWidth;
	}
	else
	{
		$destHeight = $imginfo[1] > $maxHeight ? $maxHeight : $imginfo[1];
		$destWidth = $imginfo[0]/$imginfo[1]*$destHeight;
	}
	
	$dst_img = imagecreatetruecolor($destWidth, $destHeight);
		
	imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $destWidth, $destHeight, $imginfo[0], $imginfo[1]);
	imagejpeg($dst_img, $filedestPath, 85);
	imagedestroy($src_img);
	imagedestroy($dst_img);
	
	return true;
  }
}