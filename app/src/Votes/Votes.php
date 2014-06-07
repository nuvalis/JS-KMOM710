<?php

namespace nuvalis\Votes;
 
/**
 * Model for Users.
 *
 */
class Votes extends \Anax\MVC\BaseModel
{

 	public function voteUp($postid, $userId, $target) 
 	{
 		if(!$this->checkVoteExist($postid, $userId, $target)) {return false;}

 		$this->save([
		$target . '_id' 	=> $postid,
		'user_id' 			=> $userId,
		'vote_value'		=> "1",
		'created'			=> time(),
		]);

		return true;

 	}

 	public function voteDown($postid, $userId, $target) 
 	{
 		if(!$this->checkVoteExist($postid, $userId, $target)) {return false;}

 		$this->save([
		$target . '_id' 	=> $postid,
		'user_id' 			=> $userId,
		'vote_value'		=> "-1",
		'created'			=> time(),
		]);

		return true;
 		
 	}

 	public function checkVoteExist($postid, $userId, $target)
 	{

 		$this->checkPostExist($postid, $target);

 		if($userId == false) {
 			$this->flashy->error("You can't vote without a user id.");
 			return false;
 		}

 		$this->db->select()->from($this->getSource())
 		->where($target . "_id = ?")
 		->andWhere("user_id = ?");

 		$this->db->execute([$postid, $userId]);
	    $this->db->setFetchModeClass(__CLASS__);
	    $res = $this->db->fetchAll();

 		if($res) {
 			$this->flashy->warning("You have voted once on this post.");
 			return false;
 		}

 		return true;

 	}

 	public function checkPostExist($postid, $target) 
 	{

 		$this->db->select()->from($target)->where("id = ?");
 		$this->db->execute([$postid]);

 		$res = $this->db->fetchAll();

 		if(!$res) {

 			throw new \Exception("Target $target does not exist, can't vote on that.", 1);

 		}

 	}

 	public function calcVotes($target, $id)
 	{

 		$this->db->select("SUM(vote_value) AS votes_sum")->from("votes")->where($target . "_id = ?");
 		$this->db->execute([$id]);

 		$res = $this->db->fetchOne();

 		return $res->votes_sum;

 	}
 
}