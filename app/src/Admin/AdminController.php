<?php

namespace nuvalis\Admin;
 
/**
 * A controller for admin related events.
 *
 */
class AdminController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->theme->setTitle("Admin");
	}
	 
}