<?php

/**
 * sfValidatorPropelChoice validates that the value is one of the rows of a table.
 *
 * @package    10ants
 * @subpackage validator
 * @author     Okhi Oktanio
 * @version    SVN: $Id: sfValidatorPropelChoice.class.php 22299 2009-09-23 18:32:54Z fabien $
 */
class taValidatorPropelChoiceMenu extends sfValidatorPropelChoice
{
  protected static $permanentMenu = array(1,2,3,4,5); 
		
  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {print "aaaa";exit;
    $value = parent::doClean($value);
	if(empty($value) && !in_array($value, self::$permanentMenu))
		throw new sfValidatorError($this, 'required');

    return $value;
  }
}
