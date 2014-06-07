<?php

namespace Anax\Posts;
 
/**
 * Model for Posts.
 *
 */
class Posts extends \Anax\MVC\BaseModel
{
 	public function voteUpAnswer($postid) 
 	{
 		
 	}

 	public function voteDownAnswer($postid) 
 	{
 		
 	}

 	public function findByType($type) 
 	{

	$this->db->select()
	    ->from($this->getSource())
	    ->where("type = ?");
	 
	$this->db->execute([$type]);
	$this->db->setFetchModeClass(__CLASS__);
	return $this->db->fetchAll();

 	}

 	public function linkAnswer($qid, $aid) 
 	{
 		$this->db->insert('quest_answers_ref', ['quest_parent_id', 'answer_id']);
		$this->db->execute([$qid, $aid]);
 	}

 	public function findAnswers($questionID) 
 	{

 	$this->db->select()
	    ->from('posts AS p')
	    ->join("quest_answers_ref AS anw", "anw.quest_parent_id = ?");

		echo $this->db->getSQL();
	    exit;

	$this->db->execute([$questionID]);
	$this->db->setFetchModeClass(__CLASS__);
	return $this->db->fetchAll();

 	}



}