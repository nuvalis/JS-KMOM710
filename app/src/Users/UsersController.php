<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController extends \nuvalis\Base\ApplicationController
{

	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
	    $this->users = new \Anax\Users\User();
	    $this->users->setDI($this->di);
	    $this->theme->setTitle("User");
	}

    /**
	 * List all users.
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$this->listAction();
	}

	/**
	 * List user with id.
	 *
	 * @param int $id of user to display
	 *
	 * @return void
	 */
	public function idAction($id = null)
	{
	 
		if($id === $this->auth->userId()){

			$this->privateAction($id);

		} else {

			$this->publicAction($id);

		}

	}

	public function privateAction($id)
	{
		if (!$this->auth->userId() == $id){ $id = $this->auth->userId(); }
	 
	    $user = $this->users->findById($id);

	    $user->latestComments = $this->users->latestComments($id);
	    $user->latestAnswers = $this->users->latestAnswers($id);
	    $user->latestQuestions = $this->users->latestQuestions($id);
	   	$user->points = $this->users->userPoints($id);

	    $this->theme->setTitle("Your private profile");
	    $this->views->add('users/public', [
	        'user' => $user,
	    ]);
	}

	public function publicAction($id)
	{
	 
	    $user = $this->users->findById($id);
	    
	    $user->latestComments = $this->users->latestComments($id);
	    $user->latestAnswers = $this->users->latestAnswers($id);
	    $user->latestQuestions = $this->users->latestQuestions($id);
	    $user->points = $this->users->userPoints($id);

	    $this->theme->setTitle("Public Profile");
	    $this->views->add('users/public', [
	        'user' => $user,
	    ]);

	}

    /**
	 * List all users.
	 *
	 * @return void
	 */
	public function listAction()
	{
	    $this->users = new \Anax\Users\User();
	    $this->users->setDI($this->di);
	 
	    $all = $this->users->findAll();
	 
	    $this->theme->setTitle("List all users");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "View all users",
	    ]);
	}

	/**
	 * Add new user.
	 *
	 * 
	 *
	 * @return void
	 */
	public function registerAction()
	{

		$form = $this->form;

		$form = $form->create([], [
			'username' => [
				'type'        => 'text',
				'label'       => 'Username',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'password' => [
				'type'        => 'password',
				'label'       => 'Password',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'password_confirm' => [
				'type'        => 'password',
				'label'       => 'Password Confirm',
				'required'    => true,
				'validation'  => ['not_empty', 'custom_test' => array('message' => 'The password does not match.',
				'test' => 'return $form->Value("password") == $form->Value("password_confirm");')],
			],
			'name' => [
				'type'        => 'text',
				'label'       => 'Name of contact person:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'email' => [
				'type'        => 'text',
				'required'    => true,
				'validation'  => ['not_empty', 'email_adress'],
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) {
			 
				    $this->users->save([
				        'username' 	=> $form->Value('username'),
				        'email' 	=> $form->Value('email'),
				        'name' 		=> $form->Value('name'),
				        'password' 	=> password_hash($form->Value('password'), PASSWORD_BCRYPT),
				        'created' 	=> $this->mzHelpers->now(),
				        'active' 	=> $this->mzHelpers->now(),
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 
		    $url = $this->url->create('users/id/' . $this->db->lastInsertId());
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		$this->theme->setTitle("Add user");
		$this->views->add('nuva/test', [
			'title' => "Try out a form using CForm",
			'form' => $form->getHTML()
		]);
	 

	}


	/**
	 * Edit user.
	 *
	 * @param int id of user.
	 *
	 * @return void
	 */
	public function updateAction($id)
	{

		$this->isLoggedIn();

		if (!$this->auth->userMatch($id)){
			$this->flashy->error('You don\'t have permission to change this account.');
			$this->redirectTo('');
		};

		$form = $this->form;

		$user = $this->users->findById($id);

		$form = $form->create([], [
			'name' => [
				'type'        => 'text',
				'label'       => 'Name of contact person:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value' => $user->name,
			],
			'email' => [
				'type'        => 'text',
				'required'    => true,
				'validation'  => ['not_empty', 'email_adress'],
				'value' => $user->email,
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) {

				    $this->users->save([
				    	'id'		=> $this->auth->userId(),
				        'username' 	=> $form->Value('username'),
				        'email' 	=> $form->Value('email'),
				        'name' 		=> $form->Value('name'),
				        'updated' 	=> $this->mzHelpers->now(),
				        'active' 	=> $this->mzHelpers->now(),
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 	$this->flash->success("Changes has been saved!");
		    $url = $this->url->create('users/id/' . $this->auth->userId());
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			$this->flash->error("Something went wrong in the saving process.");
			header("Location: " . $_SERVER['PHP_SELF']);
			exit;
		}

		$this->theme->setTitle("Edit user");
		$this->views->add('nuva/test', [
			'title' => "Try out a form using CForm",
			'form' => $form->getHTML()
		]);
	 

	}

	/**
	 * Change password for user.
	 *
	 * @param int id of user.
	 *
	 * @return void
	 */
	public function changePasswordAction($id)
	{

		$this->isLoggedIn();
		
		if (!$this->auth->userMatch($id)){
			$this->flashy->error('You don\'t have permission to change this account.');
			$this->redirectTo('');
		};

		$form = $this->form;

		$form = $form->create([], [

			'password' => [
				'type'        => 'password',
				'label'       => 'Password',
				'required'    => true,
				'validation'  => ['not_empty'],
				'placeholder' => 'New Password',
			],
			'password_confirm' => [
				'type'        => 'password',
				'label'       => 'Password Confirm',
				'required'    => true,
				'validation'  => ['not_empty', 'custom_test' => array('message' => 'The password does not match.',
				'test' => 'return $form->Value("password") == $form->Value("password_confirm");')],
				'placeholder' => 'Confirm Password',
			],

			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) {

				    $this->users->save([
				    	'id'		=> $this->auth->userId(),
				        'password' 	=> password_hash($form->Value('password'), PASSWORD_BCRYPT),
				        'updated' 	=> $this->mzHelpers->now(),
				        'active' 	=> $this->mzHelpers->now(),
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 	
		 	$this->flash->success("New password has been saved!");
		    $url = $this->url->create('users/id/' . $this->auth->userId());
		    $this->response->redirect($url);
		
		} else if ($status === false) {

			$this->flash->error("Something went wrong in the saving process.");
			header("Location: " . $_SERVER['PHP_SELF']);
			exit;

		}

		$this->theme->setTitle("Change Password");
		$this->views->add('nuva/test', [
			'title' => "Try out a form using CForm",
			'form' => $form->getHTML()
		]);
	 

	}



	/**
	 * Delete user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function deleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	    $res = $this->users->delete($id);
	 
	    $url = $this->url->create('users/list');

	    $this->flash->success("Perma Deleted User");
	    $this->response->redirect($url);
	}

	/**
	 * Delete (soft) user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function softDeleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	    $user = $this->users->find($id);
	 
	    $user->deleted = $this->mzHelpers->now();
	    $user->save();

	    $this->flash->success("Soft Deleted User");
	 
	    $url = $this->url->create('users/id/' . $id);
	    $this->response->redirect($url);
	}


	/**
	 * Undo Delete (soft) user.
	 *
	 * @param integer $id of user to undo delete.
	 *
	 * @return void
	 */
	public function undoSoftDeleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 	 
	    $user = $this->users->find($id);
	 
	    $user->deleted = null;
	    $user->save();

	 	$this->flash->success("Reanimated user is a Success");

	    $url = $this->url->create('users/id/' . $id);
	    $this->response->redirect($url);
	}

	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function activeAction()
	{
	    $all = $this->users->query()
	        ->where('active IS NOT NULL')
	        ->andWhere('deleted is NULL')
	        ->execute();
	 
	    $this->theme->setTitle("Users that are active");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Users that are active",
	    ]);
	}


	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function inactiveAction()
	{
	    $all = $this->users->query()
	        ->where('deleted IS NOT NULL')
	        ->execute();
	 
	    $this->theme->setTitle("Users that are inactive");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Users that are inactive/Deleted",
	    ]);
	}

	public function loginAction($type = 'standard') 
	{

		$form = $this->form;

		$form = $form->create([], [
			'username' => [
				'type'        => 'text',
				'label'       => 'Username',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'password' => [
				'type'        => 'password',
				'label'       => 'Password',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) {

					$user = $this->users->findByUsername($form->Value('username'));

					$hash = $user->password;

					$check = password_verify($form->Value('password'), $hash);

					if($check === true) {
						 
						$this->users->save([
							'id'		=> $user->id,
							'active' 	=> $this->mzHelpers->now(),
						]);
						
						$_SESSION["auth"]["username"] = $user->username;
						$_SESSION["auth"]["userid"] = $user->id;
						$this->flashy->success("You are now logged in");

						return true;

					}

					return false;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 
		    $url = $this->url->create('users/id/' . $this->auth->userId());
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Username or Password is wrong. Try again.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		if($this->auth->userId()){

			$this->flashy->warning('You are already logged in.');

		}

		if($type === 'json'){
			$this->json->render(['title' => 'Login', 'content' => $form->getHTML()]);
		}

		$this->theme->setTitle("Login");
		$this->views->add('nuva/test', [
			'title' => "Login",
			'form' => $form->getHTML()
		]);

	}

	public function logoutAction() 
	{
		$this->users->save([
				'id'		=> $this->auth->userid(),
				'active' 	=> $this->mzHelpers->now(),
		]);

		session_destroy();
		unset($_SESSION);

		session_start();

		$this->flashy->error("Logged Out");
		$this->response->redirect("login");

		return true;
		
	}

	public function statusAction() 
	{
		if($this->auth->userId()){

			$this->flashy->success("Status: Logged In as " . $this->auth->username());
			$this->redirectTo("");


		} else {

			$this->flashy->warning("Status: Logged Out");
			$this->redirectTo("");

		}

	}

	public function topUsersAction()
	{
		$user = $this->users->topUsers();

		$this->views->add('users/toplist', [
	        'users' => $user,
	    ], 'sidebar');

	}
	 
}