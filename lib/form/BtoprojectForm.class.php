<?php

/**
 * Btoproject form.
 *
 * @package    ISP
 * @subpackage form
 * @author     10ants
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class BtoprojectForm extends BaseBtoprojectForm
{
  protected static $start = array('Selecteer...'=>'Selecteer...', '2012'=>'2012', '2013'=>'2013', '2014'=>'2014', '2015'=>'2015', '2016'=>'2016', '2017'=>'2017', '2018'=>'2018', '2019'=>'2019', '2020'=>'2020');
  protected static $duur = array('Selecteer...'=>'Selecteer...', '3'=>'3 maanden', '4'=>'4 maanden', '5'=>'5 maanden', '6'=>'6 maanden', '12'=>'12 maanden');
  
  
  public function configure()
  {
  	$years = range(2012,2020);
  	$this->widgetSchema['description'] = new sfWidgetFormTextarea(); 
	$this->validatorSchema['description']->setOption('required', false);
	
	$this->widgetSchema['startdate'] = new sfWidgetFormDateTime(array('with_time' => false, 'date' => array('format'=>'%year%','format'=>'%year%','years'=>array_combine($years, $years)))); 
	
	$this->widgetSchema['duration'] = new sfWidgetFormSelect(array('choices'=>self::$duur));
	$this->validatorSchema['duration']->setOption('required', false); 
	
  	$this->setDefault('state', 'A'); 
  	$this->offsetUnset('state');
	$this->offsetUnset('created_at');
	$this->offsetUnset('updated_at');
  }
}
