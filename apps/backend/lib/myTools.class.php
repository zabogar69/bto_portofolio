<?php 
class myTools
{
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
	
	public static function generateToken($length=6, $strength=0) {
		
		$vowels = 'AEUY';
		$consonants = 'BDGHJLMNPQRSTVWXZ';
		$consonants .= '23456789';
		
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	
	
	public static function getWeekStartDate($wk_num, $yr, $first = 1, $format = 'd-m-Y')
	{
	    $wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
	    $mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
	    return date($format, $mon_ts);
	}
	
	public static function getWeekDates($year, $week, $start=true)
	{
	    $from = date("D d-m-Y", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
	    $to = date("D d-m-Y", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week
	 
	    if($start) {
	        return $from;
	    } else {
	        return $to;
	    }
	    //return "Week {$week} in {$year} is from {$from} to {$to}.";
	}


}
	
?>