<?php

namespace nuvalis\Tags;
 
/**
 * Model for Tags.
 *
 */
class Tags extends \Anax\MVC\BaseModel
{

	public function popularTags($limit = 100)
	{

	 	$sql = "SELECT t.*, COUNT(t.tag_id) AS count
	 			FROM tags AS t 
	 				LEFT JOIN questions_tag_ref AS qtr ON t.tag_id = qtr.tag_id 
	 				GROUP BY t.tag_id
	 				ORDER BY COUNT(t.tag_id) DESC
	 				LIMIT $limit";

		$this->db->execute($sql);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();

	}

	public function searchTag($query)
	{

		$query = $query.'%';

		$sql = "SELECT tag_name AS value
					FROM tags
					WHERE tag_name
					LIKE ?
	 				LIMIT 5";

		$this->db->execute($sql, [$query]);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();

	}

 
}