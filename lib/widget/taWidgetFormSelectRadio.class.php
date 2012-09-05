<?php
/**
 * Ten Ants WidgetFormSelectRadio.
 *
 * @package    WidgetForm
 * @subpackage SelectRadio
 * @version    1.0
 */
class taWidgetFormSelectRadio extends sfWidgetFormSelectRadio
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('choices');

    $this->addOption('label_separator', '&nbsp;');
    $this->addOption('separator', "\n");
    $this->addOption('formatter', array($this, 'taFormatter'));
  }
  
  public function taFormatter($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
    {
      $rows[] = $input['input'].$input['label'].$this->getOption('label_separator');
    }

    return implode($this->getOption('separator'), $rows);
  }
}
