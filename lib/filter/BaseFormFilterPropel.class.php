<?php

/**
 * Project filter form base class.
 *
 * @package    muzelinck
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterBaseTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
abstract class BaseFormFilterPropel extends sfFormFilterPropel
{
  protected static $statesFilter = array(''=>'Alle');
	protected static $appnamesFilter = array(''=>'Alle');
  
  public function setup()
  {
  	self::$statesFilter = array_merge(self::$statesFilter, self::$states);
  }
  
  protected function convertStateValue($value)
  {
  	if(!empty($value))
  		$value = array('text'=>$value);
  	
  	return $value;
  }
  
  public function getMaxPerPageHtml($label, $homeAction, $defaultValue=null)
  {
  	$html = "<form name='displayFrom' id='displayFrom' action='$homeAction'>
  			$label :
			<select name='maxPerPage' onchange='displayFrom.submit();'>
				<option value='10' ".($defaultValue==10?"selected='selected'":"").">10</option>
				<option value='25' ".($defaultValue==25?"selected='selected'":"").">25</option>
				<option value='50' ".($defaultValue==50?"selected='selected'":"").">50</option>
			</select>
			</form>";
  	
	return $html;
  }
  
  /**
  protected function addStateColumnCriteria($criteria, $field, $value)
  {
  	$colname = $this->getColname($field);
	//value can not be empty, not set and '' 
    if(strlen($value) == 1)
    {
      $criteria->add($colname, '%'.$value.'%', Criteria::LIKE);
    }
    else
    {
   	  $value = explode(";", $value);
      $criteria->add($colname, $value, Criteria::IN);
    }
  }
  **/
}