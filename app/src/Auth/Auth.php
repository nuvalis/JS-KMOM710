<?php

namespace nuvalis\Auth;
 
class Auth implements \Anax\DI\IInjectionAware
{

    use \Anax\DI\TInjectable,
    	\Anax\MVC\TRedirectHelpers;

	public function userMatch($id)
	{
		if($this->userId() == $id){ return true; } else { return false; }
	}

	public function isLoggedIn() 
	{

		if(isset($_SESSION["auth"]["username"]) 
		&& isset($_SESSION["auth"]["userid"])) 
		{
			return true;
		} else {
			return false;
		}

	}

	public function username() 
	{

		if(!isset($_SESSION["auth"]["username"])) {
			return false;
		} else {
			return $_SESSION["auth"]["username"];
		}

	}

	public function userId() 
	{

		if(!isset($_SESSION["auth"]["userid"])) {
			return false;
		} else {
			return $_SESSION["auth"]["userid"];
		}

	}
	
}