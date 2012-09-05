<?php
/**
 * Ten Ants taFile.
 *
 * @package    Ten Ants Library
 * @subpackage Write to File Process
 * @author     lambekobong (rizqi.noor@gmail.com)
 * @version    1.0
 */
class taFileWrite
{
	/**
	* write to file
	**/
	public static function writeFile($content, $target)
	{
		//$filename = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'xml'.DIRECTORY_SEPARATOR.'globeCache.xml';
		$filename = $target;
	
		if (true) {
		
		    if (!$handle = fopen($filename, 'w+')) {
		         echo "Cannot open file ($filename)";
		         exit;
		    }
		
		    if (fwrite($handle, $content) === FALSE) {
		        echo "Cannot write to file ($filename)";
		        exit;
		    }
		
	
		    fclose($handle);
		
		} else {
		    echo "The file $filename is not writable";
		}
	}
}
?>