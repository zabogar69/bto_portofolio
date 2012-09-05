<?php 
/** 
* Youtube jsonc Class 
* 
* Class to retrieve youtube jsonc item(s)
*
* @category	Libraries
* @subpackage Custom Libraries
* @author Andar Harsono
*/

class taYoutubeJsonc{

	private $username;
	private $orderby;
	private $startIndex;
	private $maxResults;
	private $currentPage;
	private $totalItems;
	private $pageItems;
	private $pageRange;
	public  $isError;
	private $errorMessage;
	private $json;
	private $jsonOutput;
	
	public function __construct($username,$orderby="published",$maxResults=4,$page=1) {
		
		$this->username = $username;
		$this->orderby = $orderby;
		$this->maxResults = $maxResults;
		$this->currentPage = $page;
		$this->setStartIndex($page);
		$this->pageRange = 5;
				
		$this->url = $this->buildUrl();

		$this->errorMessage = "";
		
		set_error_handler(
				create_function(
						'$severity, $message, $file, $line',
						'throw new ErrorException($message, $severity, $severity, $file, $line);'
				)
		);

		try{
			$this->json = file_get_contents($this->url,0,null,null);
			$this->isError = false;
		}catch(Exception $e){
			$this->errorMessage = $e->getMessage();
			$this->isError = true;
		}
		
		restore_error_handler();
	}
	
	private function buildUrl(){
		return "http://gdata.youtube.com/feeds/api/users/".$this->username."/uploads?v=2&alt=jsonc&orderby=".$this->orderby."&start-index=".$this->startIndex."&max-results=".$this->maxResults;
	}
	
	public function setStartIndex($page){
		$this->startIndex = ($page>0)?($this->maxResults*$page)-($this->maxResults-1):1;
	}
	
	public function getJsonOutput(){
		return json_decode($this->json);
	}
	
	public function getErrorMessage(){
		return $this->errorMessage;
	}
	
	public function getItems(){
		$this->jsonOutput = $this->getJsonOutput();
		$this->items = $this->jsonOutput->data->items;
		$this->totalItems = $this->jsonOutput->data->totalItems;
		$this->pageItems = ceil($this->totalItems/$this->maxResults);
		return $this->items;
	}
	
	public function getPager(){
		
		$pages = array(
			"hasNext"=>$this->isPagerNext(),
			"hasPrev"=>$this->isPagerPrev(),
			"currentNav"=>$this->currentPage,
			"navs"=>$this->getPagerNavs() 
		);
		return $pages;
	}
	
	private function isPagerPrev(){
		return ($this->currentPage>1)?true:false;
	}
	
	private function isPagerNext(){
		return ($this->currentPage<$this->pageItems)?true:false;
	}
	
	private function getPagerNavs(){
		$navs = array();
		
		if($this->currentPage<(ceil($this->pageRange/2))){
			$pageRange = $this->pageRange-$this->currentPage;
		}else{
			$pageRange = $this->pageRange/2;
		}
		
		for($page = 1; $page <= $this->pageItems; $page++){
			 if ((($page >= $this->currentPage - $pageRange) && ($page <= $this->currentPage + $pageRange))){
				 $navs[]=$page;
			 }
		}
		
		return $navs;
	}
	
}