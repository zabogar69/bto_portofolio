<?php
/**
 * sfWidgetFormPropelChoice represents a choice widget for a model.
 *
 * @package    10ants
 * @subpackage widget
 * @author     Okhi Oktanio
 * @version    SVN: $Id: sfWidgetFormPropelChoice.class.php 22261 2009-09-23 05:31:39Z fabien $
 */
class taWidgetFormPropelChoiceTree extends sfWidgetFormPropelChoice
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('child_method');
    
    parent::configure($options, $attributes);
  }
  
  /**
   * Returns the choices associated to the model.
   *
   * @return array An array of choices
   */
  public function getChoices()
  {
    $choices = array();
    if (false !== $this->getOption('add_empty'))
    {
      $choices[''] = true === $this->getOption('add_empty') ? '' : $this->getOption('add_empty');
    }

    $class = constant($this->getOption('model').'::PEER');

    $criteria = null === $this->getOption('criteria') ? new Criteria() : clone $this->getOption('criteria');
    
	if ($order = $this->getOption('order_by'))
    {
      $method = sprintf('add%sOrderByColumn', 0 === strpos(strtoupper($order[1]), 'ASC') ? 'Ascending' : 'Descending');
      $criteria->$method(call_user_func(array($class, 'translateFieldName'), $order[0], BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME));
    }
    $objects = call_user_func(array($class, $this->getOption('peer_method')), $criteria, $this->getOption('connection'));

    $methodKey = $this->getOption('key_method');
    if (!method_exists($this->getOption('model'), $methodKey))
    {
      throw new RuntimeException(sprintf('Class "%s" must implement a "%s" method to be rendered in a "%s" widget', $this->getOption('model'), $methodKey, __CLASS__));
    }

    $methodValue = $this->getOption('method');
    if (!method_exists($this->getOption('model'), $methodValue))
    {
      throw new RuntimeException(sprintf('Class "%s" must implement a "%s" method to be rendered in a "%s" widget', $this->getOption('model'), $methodValue, __CLASS__));
    }

	$methodGetChildren = $this->getOption('child_method');
    foreach ($objects as $object)
    {
      $choices[$object->$methodKey()] = $object->$methodValue();
      $this->getChildrenChoices($choices, $object, $criteria, $methodKey, $methodValue, $methodGetChildren);
    }

    return $choices;
  }
  
  protected function getChildrenChoices(array &$choices, $object, Criteria $criteria, $methodKey, $methodValue, $methodGetChildren, $spaces='|_&nbsp;')
  {
  	$children = $object->$methodGetChildren($criteria);
	if(count($children) == 0)
		return;
	
	foreach($children as $child)
	{
		$choices[$child->$methodKey()] = $spaces.$child->$methodValue();
		$this->getChildrenChoices($choices, $child, $criteria, $methodKey, $methodValue, $methodGetChildren, "&nbsp;&nbsp;&nbsp;&nbsp;".$spaces);
	}
	//print_r($choices);exit;
  }
}
