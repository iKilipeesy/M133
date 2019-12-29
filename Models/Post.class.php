<?php
/*
 * Author: Kenny Betschart
 * Date: 29.12.2019
 * Project: myBlog
 * Filename: post.class
 * Description: Class for posts 
 */

 class Post {


    private $post_id;
    private $title;
    private $text;
    private $date_author;   
    public $innerhtml;
    private $select_option;

	
	public function __construct($title, $text, $date_author, $post_id) {
        $this->title = $title;
        $this->text = $text;
        $this->post_id = $post_id;
        $this->date_author = $date_author;

        $this->load();
        $this->set_placeholder();
    }
    
	
	public function load() {
        $this->innerhtml = file_get_contents(__DIR__."/../".VIEWS_PATH."postTemplate". ".html");
    }

	public function set_placeholder() {
        $this->innerhtml = preg_replace("/{title}/", $this->title, $this->innerhtml);
        $this->innerhtml = preg_replace("/{post_id}/", $this->post_id, $this->innerhtml);
		$this->innerhtml = preg_replace("/{text}/", $this->text, $this->innerhtml);
        $this->innerhtml = preg_replace("/{date_author}/", $this->date_author, $this->innerhtml);
        $this->innerhtml = preg_replace("/{options}/", $this->select_option,$this->innerhtml );

    }

    public function set_select_option($option){
        $this->select_option = $option;
    }

}
?>