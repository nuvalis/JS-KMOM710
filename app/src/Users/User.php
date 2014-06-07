<?php

namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\BaseModel
{

	/**
	 * Find and return specific.
	 *
	 * @return this
	 */
	public function findByUsername($username)
	{
	    $this->db->select()
	             ->from($this->getSource())
	             ->where("username = ?")->limit(1);
	 
	    $this->db->execute([$username]);
	    return $this->db->fetchInto($this);
	}

	public function latestAnswers($uid)
	{

		$this->db->select()
	        ->from("answers")
	        ->where("user_id = ?")->orderby("created DESC")->limit(5);
	 
	    $this->db->execute([$uid]);
	    return $this->db->fetchAll();

	}

	public function latestQuestions($uid)
	{

		$this->db->select()
	        ->from("questions")
	        ->where("user_id = ?")->orderby("created DESC")->limit(5);
	 
	    $this->db->execute([$uid]);
	    return $this->db->fetchAll();
		
	}

	public function latestComments($uid)
	{

		$this->db->select()
	        ->from("comments")
	        ->where("user_id = ?")->orderby("created DESC")->limit(5);
	 
	    $this->db->execute([$uid]);
	    return $this->db->fetchAll();
		
	}

	public function topUsers()
	{
		$sql = "SELECT u.username, u.id,
				(SELECT COUNT(*) FROM answers a WHERE u.id = a.user_id) +
				(SELECT COUNT(*) FROM comments c WHERE u.id = c.user_id) +
				(SELECT COUNT(*) FROM questions q WHERE u.id = q.user_id) +
				(SELECT COUNT(*) FROM votes v WHERE u.id = v.user_id) AS points
				FROM user u
				ORDER BY points DESC
				LIMIT 5";
		$this->db->execute($sql);
	    return $this->db->fetchAll();

	}

	public function userPoints($id)
	{
		$sql = "SELECT u.username, u.id,
				(SELECT COUNT(*) FROM answers a WHERE u.id = a.user_id) +
				(SELECT COUNT(*) FROM comments c WHERE u.id = c.user_id) +
				(SELECT COUNT(*) FROM questions q WHERE u.id = q.user_id) +
				(SELECT COUNT(*) FROM votes v WHERE u.id = v.user_id) AS points,
				(SELECT COUNT(*) FROM answers a WHERE u.id = a.user_id) AS answers,
				(SELECT COUNT(*) FROM comments c WHERE u.id = c.user_id) AS comments,
				(SELECT COUNT(*) FROM questions q WHERE u.id = q.user_id) AS questions,
				(SELECT COUNT(*) FROM votes v WHERE u.id = v.user_id) AS votes
				FROM user u
				WHERE id = ?
				ORDER BY points DESC
				LIMIT 1";
		$this->db->execute($sql, [$id]);
	    return $this->db->fetchOne();

	}

 
}