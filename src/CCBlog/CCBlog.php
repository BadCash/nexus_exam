<?php
/**
 * A blog controller to display a blog-like list of all content labelled as "post".
 * 
 * @package NexusCore
 */
class CCBlog extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }


  /**
   * Display all content of the type "post".
   */
  public function Index() {
    $content = new CMContent();
    $this->views->SetTitle('Blog')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),
                ));
  }

  /**
   * Display content created by one particular user
   * 
   * $args string Specifies either a user ID or "me" for currently logged in user
   */
  public function User($args = null) {
	if( is_numeric($args) ){
		$idUser = $args;		
	}
	else{
		die( 'Invalid user ID!' );
	}
  
    $content = new CMContent();
    $this->views->SetTitle('User content')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $content->ListAll(array('idUser'=>$idUser, 'type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),
                ));
  }

} 