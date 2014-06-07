<?php

namespace nuvalis\Comments;

class Comments extends \Anax\MVC\BaseModel
{

	public function listAnswersComments($id)
	{
		$this->db->select()
	        ->from($this->getSource())
	       	->where("answers_id = ?");
	 
	    $this->db->execute([$id]);
	    return $this->db->fetchAll();
	}

	public function latestComments()
	{
		$sql = "SELECT c.id, c.content, c.answers_id, c.questions_id, c.created, u.username, u.id AS user_id
				FROM comments c
					INNER JOIN user u ON c.user_id = u.id
				ORDER BY c.created DESC
				LIMIT 3";

		$this->db->execute($sql);
		return $this->db->fetchAll();
	}

}