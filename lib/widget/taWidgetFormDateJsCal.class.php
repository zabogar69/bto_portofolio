<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * taWidgetFormDateJsCal represents a date widget.
 *
 * @package    Ten Antz
 * @subpackage widget
 * @author     Okhi Oktanio
 * @version    SVN: $Id: taWidgetFormDateJsCal.class.php 24605 2009-12-29 21:20:19Z Okhi Oktanio $
 */
class taWidgetFormDateJsCal extends sfWidgetForm
{
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   *  * format:       The date format string (%d-%m-%Y %H:%M by default)
   *  * inputFieldId: Input tag Id
   *  * triggerId:    Trigger Id
   *  * language: 	  Language (nl by default)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('format', '%d/%m/%Y %H:%M');
    $this->addOption('language', 'nl');
    $this->addOption('text_size', '17');
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
  	$dt = new DateTime($value);
  	$value = strftime($this->getOption('format'), $dt->format('U'));
  	
	$rederedTag = $this->renderTag('input', array('type' => 'text', 'name'=>$name, 'id' => $inputFieldId = $this->generateId($name), 'value' => $value, 'size' => $this->getOption('text_size')))." ";
  	$rederedTag .= $this->renderTag('input', array('type' => 'button', 'value' => '...', 'id' => $triggerId = $this->generateId($name)."_button"));
    $rederedTag .= "<script type='text/javascript'>
                  var cal = new Calendar({
                          inputField: '$inputFieldId',
                          dateFormat: '".$this->getOption('format')."',
                          trigger: '$triggerId',
                          showTime: true,
                          max: null,
                          onSelect: function() { this.hide(); }
                  });
                  cal.setLanguage('".$this->getOption('language')."');
                </script>";
    
	return $rederedTag;
  }
}