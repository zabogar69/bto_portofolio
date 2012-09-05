<?php

class backendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
  	// Register our listeners
    $this->dispatcher->connect('admin.save_object', array('taActionsBackend', 'afterObjectSaved'));
  }
}
