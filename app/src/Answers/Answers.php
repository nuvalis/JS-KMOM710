<?php

namespace nuvalis\Answers;

class Answers extends \Anax\MVC\BaseModel
{
 	public function voteUpAnswer($answersID) 
 	{
 		
 	}

 	public function voteDownAnswer($answersID) 
 	{
 		
 	}

 	public function findAnswers($questionID, $order) 
 	{

 	 	switch ($order) {
 			case 'created':
 				$order = 'created';
 				break;
 			 case 'votes':
 				$order = 'votes';
 				break;
 			default:
 				$order = 'created';
 				break;
 		}

	 $sql = "SELECT *,
	 		(SELECT SUM(v.vote_value) FROM votes v WHERE a.id = v.answers_id) AS votes
	 		FROM answers a
	 		WHERE questions_id = ?
	 		ORDER BY $order DESC";

	$this->db->execute($sql,[$questionID]);
	$this->db->setFetchModeClass(__CLASS__);
	return $this->db->fetchAll();

 	}

 	public function getAnswerParent($id)
 	{

 	$this->db->select()
	    ->from('answers')
	    ->where("id = ?");

	$this->db->execute([$id]);
	$res = $this->db->fetchOne();

	return $res->questions_id;

 	}

 	public function getAnswersComments($id)
 	{

		// $this->db->select("c.content, c.created, u.username, u.email, u.id AS user_id")
		//     ->from("comments AS c")
		//    	->where("answers_id = ?")
		//   	->join("user AS u", "u.id = c.user_id");

		$sql = "SELECT c.id, c.content, c.created, u.email, u.username, u.id AS user_id,
	 		(SELECT SUM(v.vote_value) FROM votes v WHERE c.id = v.comments_id) AS votes
	 		FROM comments c
	 			INNER JOIN user u ON u.id = c.user_id
	 		WHERE answers_id = ?";

		$this->db->execute($sql, [$id]);
		return $this->db->fetchAll();
 	}



}