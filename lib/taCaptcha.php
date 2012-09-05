<?php 
/** 
* Captcha Class 
* 
* Class to generate captcha
*
* @category	Libraries
* @subpackage Custom Libraries
* @author Andar Harsono
*/

class taCaptcha{

	var $CI;
	var $randomed;
	var $img;
	var $img_x = 30;
	var $img_y = 15;
	var $img_background;
	var $img_color;
	var $img_string; 
	
	function taCaptcha()
	{
		$this->setRandom();
	}
	
	function setRandom()
	{
		$random = rand(1000, 9999);
		$this->randomed = $random;
	}
	
	function getRandom()
	{
		return $this->randomed;
	}
	
	function setRandomLine()
	{
		$random = rand(0, 30);
		return $random;
	}
	
	function generateText()
	{
		return $this->randomed;
	}
	
	function generateImage(){
		$this->img = imagecreate($this->img_x,$this->img_y);
		$this->img_background = imagecolorallocate($this->img, 255, 255, 133);
		$this->img_color = imagecolorallocate($this->img, 0, 0, 0);
		$this->img_string = $this->generateText();
		$grey = imagecolorallocate($this->img, 255, 255, 102);
		
		imageline($this->img, $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $grey); 
		imageline($this->img, $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $grey);
		imageline($this->img, $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $grey); 
		imageline($this->img, $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $grey);
		imageline($this->img, $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $grey); 
		imageline($this->img, $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $grey);
		imageline($this->img, $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $grey); 
		imageline($this->img, $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $this->setRandomLine(), $grey);
		
		imagestring($this->img, 2, 2, 4, $this->img_string, $this->img_color);
		 

		header("Content-type: image/png");
		imagepng($this->img);
		imagecolordeallocate($this->img_color);
		imagecolordeallocate($this->img_background);
		imagedestroy($this->img);
	}
	
}

/* End of file Mycaptcha.php */ 
/* Location: ./system/application/libraries/Mycaptcha.php */ 