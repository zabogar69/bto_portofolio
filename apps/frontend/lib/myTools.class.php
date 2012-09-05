<?php
class myTools {	
	public static function sefText($str, $separator = 'dash', $lowercase = TRUE)
	{
		$str = self::normalizeText($str);
		
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}
		
		$str = str_replace('-','_',$str);
		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						'[\/]'		=> '-',
						'[^a-z0-9\-\._]'		=> '',
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					  );

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}	
		
		return trim(stripslashes($str),'-');
	}
	
	public static function normalizeText($string) {
		$table = array(
				'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
				'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
				'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
				'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
				'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
				'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
				'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
				'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
		);
		return strtr($string, $table);
	}	
	
	public static function isImageExist($paramfilename,$filename='')
	{
		$folder = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.sfConfig::get('app_media_folder').DIRECTORY_SEPARATOR;
		if(trim($paramfilename<>'') || trim($filename<>''))
		{
			if (is_file($folder.$paramfilename))
			{
				return true;
			} 
			else
			{
				if (is_file($folder.'text-'.$filename.'.png'))
				{
					return true;
				} 
				else
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}
	}
	
	public static function getImageFile($paramfilename,$filename,$state='',$isfrontend=false)
	{
		$webfolder = '/'.basename(sfConfig::get('sf_upload_dir'))."/".sfConfig::get('app_media_folder').'/';
		if($paramfilename <> '')
		{
			$ext = '.' . self::findExts($paramfilename);
			$filenamenoext = str_replace($ext,'',$paramfilename);
			$path = $webfolder.$paramfilename;
			
			if($state<>'')
			{
				if(self::isImageExist($filenamenoext.$state.$ext))
				{
					$path = $webfolder.$filenamenoext.$state.$ext;
				}
			}			
		}
		else
		{
			$path = $webfolder.'text-'.$filename.$state.'.png';
			if($isfrontend)
			{
				if(self::isImageExist('text-'.$filename.'-big'.$state.'.png'))
				{
					$path = $webfolder.'text-'.$filename.'-big'.$state.'.png';
				}
			}
			else
			{
				if($state<>'')
				{
					if(!self::isImageExist('text-'.$filename.$state.'.png'))
					{
						$path = $webfolder.'text-'.$filename.'.png';
					}
				}	
			}
		}
		
		return $path;
	}
	
	private static function findExts($filename) 
	{ 
		 $filename = strtolower($filename) ; 
		 $exts = split("[/\\.]", $filename) ; 
		 $n = count($exts)-1; 
		 $exts = $exts[$n]; 
		 return $exts; 
	} 
	
	public static function secToTime($time){
		if(is_numeric($time)){
			$value = array(
				"minutes" => 0, "seconds" => 0,
			);

			$value["minutes"] = floor($time/60);
			$time = ($time%60);
			$value["seconds"] = floor($time);
			return (array) $value;
		}else{
			return (bool) FALSE;
		}
	}
	
	public static function formatYoutubeDate($dt){
		$ts = strtotime($dt);
    return date("d/m/Y H:i:s", $ts);
	}

	public static function isUrl($string){
		return filter_var($string, FILTER_VALIDATE_URL);
	}
}
?>