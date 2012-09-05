<?php

class taFtp {
	
	protected $serverAddress;
	protected $ftpUsername;
	protected $ftpPassword;
	protected $ftpDirectory;
	private $thisConn;
	private $loginResult;
	private $errors;
	
	public function __construct($serverAddress, $ftpUsername, $ftpPassword, $ftpDirectory="")
	{
		$this->serverAddress = $serverAddress;
		$this->ftpUsername = $ftpUsername;
		$this->ftpPassword = $ftpPassword;
		$this->ftpDirectory = $ftpDirectory;
		
		// set up basic connection
		$this->thisConn = ftp_connect($this->serverAddress); 
		
		// login with username and password
		$this->loginResult = ftp_login($this->thisConn, $this->ftpUsername, $this->ftpPassword); 
		
		ftp_pasv($this->thisConn, true);
		
		// check connection
		if ((!$this->thisConn) || (!$this->loginResult)) 
		{ 
			$this->errors[] = "FTP connection has failed! (user: ".$this->ftpUsername.", pass: ".$this->ftpPassword.")";
		    return false; 
		} 
		else 
		{
		    return true;
		}
	}
	
	public function uploadFile($localPath, $remotePath)
	{
		
		$upload = ftp_put($this->thisConn, $remotePath, $localPath, FTP_BINARY); 
		
		if (!$upload) 
		{ 
		    $this->errors[] = "FTP upload has failed! (local: ".$localPath.", remote: ".$remotePath.")";
		    return false; 
		}
		else 
		{
		    return true;
		}
		
		
		
	}
	
	public function createDirectory ($remotePath)
	{
		if (!ftp_chdir($this->thisConn, $remotePath))
	    {
	        // try to create the directory $dir
			if (ftp_mkdir($this->thisConn, $remotePath)) 
			{
			 	echo "successfully created $remotePath\n";
			 	return true;
			} 
			else 
			{
				$errors[] = "There was a problem while creating $remotePath\n";
				return false;
			}
	    }
	    
	    return true;
	}
	
	public function hasErrors()
	{
		if(count($this->errors) > 1)
			return true;
		else
			return false;
	}
	
	public function getErrors()
	{
		print_r($this->errors);
	}
	
	public function closeConn()
	{
		ftp_close($this->thisConn);
	}
}

?>