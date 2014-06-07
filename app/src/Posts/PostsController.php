<?php

namespace Anax\Posts;
 
/**
 * A controller for posts and admin related events.
 *
 */
class PostsController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->posts = new \Anax\Posts\Posts();
	    $this->posts->setDI($this->di);
	    $this->theme->setTitle("Posts");
	}

	public function indexAction()
	{

		$all = $this->posts->findAll();
	 
		$this->theme->setTitle("List all posts");
	    $this->views->add('posts/list', [
	        'posts' => $all,
	        'title' => "View all posts",
	    ]);

	}

	public function idAction($id = null)
	{
	 
	    $post = $this->posts->findById($id);
	 
	    $this->theme->setTitle("View user with id");
	    $this->views->add('posts/view', [
	        'post' => $post,
	    ]);
	}

	public function listAction()
	{
	 
	    $all = $this->posts->findByType("question");
	 
	    $this->theme->setTitle("List all posts");
	    $this->views->add('posts/list', [
	        'posts' => $all,
	        'title' => "View all post",
	    ]);
	}
	 
}