<?php
/**
 * A Me-page controller
 * 
 * @package NexusMe
 */
class CCMe extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
    //$this->guestbookModel = new CMGuestbook();
  }


  /**
   * Implementing interface IController. All controllers must have an index action.
   */
  public function Index() {
	$this->Hem();
  }
  
  
  /**
   * Display Me-page
   */
  public function Hem() {
    $this->views->SetTitle('Om mig - Nexus');
	$content = file_get_contents( __DIR__ . '/hem.md' );
	$content = CTextFilter::Filter($content, array('markdown', 'clickable', 'smartypants'));
    $this->views->AddInclude(__DIR__ . '/hem.tpl.php', array('content' => $content) );
	
	$this->views->AddString(CTextFilter::Filter('<br><br>"MVC" >> ', array('smartypants'))
				            , array(), 'bottom-column-one');	
	$this->views->AddString(CTextFilter::Filter('<br><br>"Model"', array('smartypants'))
				            , array(), 'bottom-column-two');	
	$this->views->AddString(CTextFilter::Filter('<br><br>"View"', array('smartypants'))
				            , array(), 'bottom-column-three');	
	$this->views->AddString(CTextFilter::Filter('<br><br>"Controller"', array('smartypants'))
				            , array(), 'bottom-column-four');	
  }

  /**
   * Display Redovisnings -page
   */
  public function Redovisning() {
    $this->views->SetTitle('Redovisning - Nexus');
	$content = file_get_contents( __DIR__ . '/redovisning.md' );
	$content = CTextFilter::Filter($content, array('markdown', 'clickable', 'smartypants'));
    $this->views->AddInclude(__DIR__ . '/redovisning.tpl.php', array('content' => $content) );
  }

  /**
   * Display Projektdokumentation -page
   */
  public function Projektdokumentation() {
    $this->views->SetTitle('Projektdokumentation - Nexus');
	$content = file_get_contents( __DIR__ . '/projektdokumentation.md' );
	$content = CTextFilter::Filter($content, array('markdown', 'clickable', 'smartypants'));
    $this->views->AddInclude(__DIR__ . '/projektdokumentation.tpl.php', array('content' => $content) );
  }

} 