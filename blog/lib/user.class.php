<?php
    class User {
		  public $id;
		  public $email;
		  public $pass;
		
  		public function getBlog($App,$id) {
  			$user_id = $this->id;
  			$blog_sql = $App->db->select(array("id","title"),"blogs","user_id = $user_id AND id = $id LIMIT 1");
  			$blog = new Blog();
  			$App->db->query($blog_sql,function($data) use (&$blog) {
  				$blog["id"] = $data["id"];
  				$blog["user_id"] = $data["data_id"];
  				$blog["title"] = $data["title"];
  				$blog["content"] = $data["content"];
  			});
  			return $blog;
  		}
		
  		public function getBlogs($App) {
  			$user_id = $this->id;
  			$blogs_sql = $App->db->select(array("id","user_id","title","content"),"blogs","user_id = $user_id");
  			$blogs = array();
  			$App->db->query($blogs_sql,function($data) use (&$blogs) {
  				$blog = new Blog();
  				$blog["id"] = $data["id"];
  				$blog["user_id"] = $data["data_id"];
  				$blog["title"] = $data["title"];
  				$blog["content"] = $data["content"];
  				$blogs[] = $blog;
  			});
  			return $blogs;
  		}
	}
?>
