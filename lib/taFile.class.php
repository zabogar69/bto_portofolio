<?php
/**
 * Ten Ants taFile.
 *
 * @package    Ten Ants Library
 * @subpackage File Process
 * @author     Okhi Oktanio (okhi.oktanio@gmail.com)
 * @version    1.0
 */
class taFile
{
	/**
	* clean path from non operating system directory separator
	* @param path
	* @return system path
	**/
	public static function cleanForLocalSystemPath($path)
	{
		return str_replace('/', DIRECTORY_SEPARATOR, $path);
	}
	
	/**
	* clean path from non web address directory separator
	* @param path
	* @return web path
	**/
	public static function cleanForWebSystemPath($path)
	{
		return str_replace('\\', '/', $path);
	}
	
	/**
	* Move Uploaded file from temporary to specific destination (create destination folder if necessary)
	* @param Full address temporary file path
	* @param Full address destination file 
	* @param file mode (by default 0666)
	* @param create folder if doesn't exist ?
	* @param folder mode (by default 0777)
	* @return Full address destination file
	**/
	public static function moveUploadedFile($fileSourcePath, $fileDestPath, $fileMode = 0666, $create = true, $dirMode = 0777)
	{
		// get our directory path from the destination filename
		$directory = dirname($fileDestPath);
		
		if (!is_readable($directory))
		{
		  if ($create)
		  {
		    if(!mkdir($directory, $dirMode, true))
		    {
				// failed to create the directory
		    	throw new Exception(sprintf('Failed to create file upload directory "%s".', $directory));
			}
		  }
		  else
		  {
			if(!file_exists($directory))
				throw new Exception(sprintf('There is no "%s" directory.', $directory));
		  }
		
		  // chmod the directory since it doesn't seem to work on recursive paths
		  chmod($directory, $dirMode);
		}
		
		if (!is_dir($directory))
		{
		  // the directory path exists but it's not a directory
		  throw new Exception(sprintf('File upload path "%s" exists, but is not a directory.', $directory));
		}
		
		if (!is_writable($directory))
		{
		  // the directory isn't writable
		  throw new Exception(sprintf('File upload path "%s" is not writable.', $directory));
		}
		
		// copy the temp file to the destination file
		move_uploaded_file($fileSourcePath, $fileDestPath);
		
		// chmod our file
		chmod($fileDestPath, $fileMode);
		
		return $fileDestPath;
	}
	
	/**
	* Create Directory
	* @param Directory path
	* @param Error directory path (will be thrown using this address)
	* @param Directory mode (by default 0777)
	* @param prefix filename for thumbnail 
	**/
	public static function createDirectory($dirPath, $errorDirPath=null, $dirMode=0777, $isRecursive=true )
	{
		if(empty($errorDirPath))
			$errorDirPath = $dirPath;
			
		if(!file_exists($dirPath))
		{
			if(!(mkdir($dirPath, $dirMode, $isRecursive)))
			  throw new Exception(sprintf('Failed to create file directory "%s".', $errorDirPath));
	    }
	    else
	    	throw new Exception(sprintf('directory "%s" already exists.', $errorDirPath));
	}
	
	/**
	* Create thumbnail from specific image file
	* @param full address image file
	* @param prefix filename for thumbnail 
	* @return full address thumbnailfile
	**/
	public static function createThumbnail($filesourcePath, $mimeType, $thumbSize=60, $prefixThumbnail='tn2_')
	{
		$filename = basename($filesourcePath);
		$dirName = dirname($filesourcePath);
		
		switch($mimeType)
		{
			case "image/jpeg":
			case "image/pjpeg":
				$src_img = imagecreatefromjpeg($filesourcePath);
				break;
			case "image/gif":
				$src_img = imagecreatefromgif($filesourcePath);
				break;
			case "image/png":
			case "image/x-png":
				$src_img = imagecreatefrompng($filesourcePath);
				break;
			case "image/bmp":
				$src_img = imagecreatefromwbmp($filesourcePath);
				break;
			default:
				throw new Exception(sprintf('"%s" is not an image file', $filesourcePath));
				break;
		}
		
		// display file
		$imginfo = getimagesize( $filesourcePath );
		
		$destWidth = $thumbSize;
		$destHeight = $imginfo[1]/$imginfo[0]*$thumbSize;
		
		$dst_img = imagecreatetruecolor($destWidth, $destHeight);
				
		$cropHeight = $thumbSize;
		$yAxis = ($destHeight-$cropHeight)/2;
		$dst_img2 = imagecreatetruecolor($destWidth, $cropHeight);
		$newFilePath= $dirName.DIRECTORY_SEPARATOR.$prefixThumbnail.$filename;
				
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $destWidth, $destHeight, $imginfo[0], $imginfo[1]);
		imagecopyresampled($dst_img2, $dst_img, 0, 0, 0, $yAxis, $destWidth, $cropHeight, $destWidth, $cropHeight);
		imagejpeg($dst_img2, $newFilePath, 85);
		imagedestroy($src_img);
		imagedestroy($dst_img);
		imagedestroy($dst_img2);
		
		return $newFilePath;
	} 
	
	 /**
	 * Copy a file, or recursively copy a folder and its contents
	 *
	 * @author      Aidan Lister <aidan@php.net>
	 * @version     1.0.1
	 * @link        http://aidanlister.com/repos/v/function.copyr.php
	 * @param       string   $source    Source path
	 * @param       string   $dest      Destination path
	 * @return      bool     Returns TRUE on success, FALSE on failure
	 */
	public static function copyr($source, $dest, $mode=0777)
	{
	    // Simple copy for a file
	    if (is_file($source)) {
	        return copy($source, $dest);
	    }
	 
	    // Make destination directory
	    if (!is_dir($dest)) {
	        if(!mkdir($dest, $mode, true))
	        	return false;
	    }
	    
	    // If the source is a symlink
	    if (is_link($source)) {
	        $link_dest = readlink($source);
	        return symlink($link_dest, $dest);
	    }
	 
	    // Loop through the folder
	    $dir = dir($source);
	    while (false !== $entry = $dir->read()) {
	        // Skip pointers
	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }
	 
	        // Deep copy directories
	        if ($dest !== "$source/$entry") {
	            if(!self::copyr("$source/$entry", "$dest/$entry"))
	            	return false;
	        }
	    }
	 
	    // Clean up
	    $dir->close();
	    return true;
	}
	
	/**
	* Delete file
	* @param Full address file path
	* @param Error file path (will be thrown using this address)
	**/
	public static function deleteFile($filePath, $errorFilePath=null)
	{
		if(empty($errorFilePath))
			$errorFilePath = $filePath;
			
		if(file_exists($filePath))
		{
			if(!is_writable($filePath))
				throw new Exception( sprintf('Permission denied in %s.', $errorFilePath));
			if(!unlink($filePath))
				throw new Exception( sprintf('%s file can not be deleted.', $errorFilePath));
		}
	}
	
	// ------------ lixlpixel recursive PHP functions -------------
	// recursive_remove_directory( directory to delete, empty )
	// expects path to directory and optional TRUE / FALSE to empty
	// of course PHP has to have the rights to delete the directory
	// you specify and all files and folders inside the directory
	// ------------------------------------------------------------
	
	// to use this function to totally remove a directory, write:
	// recursive_remove_directory('path/to/directory/to/delete');
	
	// to use this function to empty a directory, write:
	// recursive_remove_directory('path/to/full_directory',TRUE);
	public static function recursive_remove_directory($directory, $empty=FALSE)
	{
	    // if the path has a slash at the end we remove it here
	    if(substr($directory,-1) == '/')
	    {
	       $directory = substr($directory,0,-1);
	    }
	  
	    // if the path is not valid or is not a directory ...
	    if(!file_exists($directory) || !is_dir($directory))
	    {
	        // ... we return false and exit the function
	        return FALSE;
	 
	   	// ... if the path is not readable
	    }elseif(!is_readable($directory))
	    {
	        // ... we return false and exit the function
	        return FALSE;
	 
	    // ... else if the path is readable
	    }else{
	 
	        // we open the directory
	        $handle = opendir($directory);
	 
	        // and scan through the items inside
	        while (FALSE !== ($item = readdir($handle)))
	        {
	            // if the filepointer is not the current directory
	            // or the parent directory
	            if($item != '.' && $item != '..')
	            {
	                // we build the new path to delete
	                $path = $directory.'/'.$item;
	 
	                // if the new path is a directory
	                if(is_dir($path)) 
	                {
	                    // we call this function with the new path
	                    self::recursive_remove_directory($path);
	 
	                // if the new path is a file
	                }else{
	                    // try to remove the file
			            if(!unlink($path))
			            {
			                // return false if not possible
			                return FALSE;
			            }
	                    
	                }
	            }
	        }
	        // close the directory
	        closedir($handle);
	 
	        // if the option to empty is not set to true
	        if($empty == FALSE)
	        {
	            // try to delete the now empty directory
	            if(!rmdir($directory))
	            {
	                // return false if not possible
	                return FALSE;
	            }
	        }
	        // return success
	        return TRUE;
	    }
	}
	
	/**
	* Rename directory
	* @param Old directory path
	* @param New directory path
	* @param Error directory path (will be thrown using this address)
	**/
	public static function renameDirectory($oldDirPath, $newDirPath, $errorDirPath=null)
	{
		if(empty($errorDirPath))
			$errorDirPath = $oldDirPath;
		
		if(file_exists($oldDirPath))
		{
			if(!is_writable($oldDirPath))
				throw new Exception(sprintf('Doesn\'t have permission to rename directory "%s".', $errorDirPath));
			
			if(!rename($oldDirPath, $newDirPath))
				throw new Exception(sprintf('Failed to rename file directory "%s".', $errorDirPath));
	    }
	    else
			throw new Exception(sprintf('There is no file directory "%s".', $errorDirPath));
	}
	
	/**
	* Move directory
	* @param Old directory path
	* @param New directory path
	* @param Error directory path (will be thrown using this address)
	* @param Directory mode (by default 0777)
	**/
	public static function moveDirectory($oldDirPath, $newDirPath, $errorDirPath=null, $mode=0777)
	{
		if(empty($errorDirPath))
			$errorDirPath = $oldDirPath;
		
		if(file_exists($oldDirPath))
		{
			if(!self::copyr($oldDirPath, $newDirPath, $mode))
				throw new Exception(sprintf('Failed to move file directory "%s".', $errorDirPath));
	    	
			if(!is_writable($oldDirPath))
				throw new Exception( sprintf('Permission denied in %s.', $errorDirPath));
			
			if(!self::recursive_remove_directory($oldDirPath))
				throw new Exception( sprintf('%s directory can not be deleted.', $localOldDirPath));
		}
	    else
	    {
			// could not found old directory
			throw new Exception(sprintf('There is no file directory "%s".', $localOldDirPath));
		}
	}
}
?>