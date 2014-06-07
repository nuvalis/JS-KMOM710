<?php

namespace nuvalis\Base;
 
/**
 * A controller for posts and admin related events.
 *
 */
class ApplicationController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
    	\Anax\MVC\TRedirectHelpers;

	public function initialize()
	{
	    $this->theme->setTitle("Application");
	}

	protected function isLoggedIn() {

		$sql = "SELECT id FROM user WHERE id = ? AND username = ?";
 		$this->db->execute($sql,[$this->auth->userId(), $this->auth->username()]);
		$this->db->setFetchModeClass(__CLASS__);
		$res = $this->db->fetchOne();

		if(!isset($res->id)) {

			$this->redirectTo("users/login");
		}
	}

}