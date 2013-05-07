<?php
/**
 * Holding a instance of CNexus to enable use of $this in subclasses and provide some helpers.
 *
 * @package NexusCore
 */
class CObject {

	/**
	 * Members
	 */
	protected $nx;
	protected $config;
	protected $request;
	protected $data;
	protected $db;
	protected $views;
	protected $session;
	protected $user;


	/**
	 * Constructor, can be instantiated by sending in the $nx reference.
	 */
	protected function __construct($nx=null) {
	  if(!$nx) {
	    $nx = CNexus::Instance();
	  }
	  $this->ly       = &$nx;
    $this->config   = &$nx->config;
    $this->request  = &$nx->request;
    $this->data     = &$nx->data;
    $this->db       = &$nx->db;
    $this->views    = &$nx->views;
    $this->session  = &$nx->session;
    $this->user     = &$nx->user;
	}


	/**
	 * Wrapper for same method in CNexus. See there for documentation.
	 */
	protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
    $this->ly->RedirectTo($urlOrController, $method, $arguments);
  }


	/**
	 * Wrapper for same method in CNexus. See there for documentation.
	 */
	protected function RedirectToController($method=null, $arguments=null) {
    $this->ly->RedirectToController($method, $arguments);
  }


	/**
	 * Wrapper for same method in CNexus. See there for documentation.
	 */
	protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $this->ly->RedirectToControllerMethod($controller, $method, $arguments);
  }


	/**
	 * Wrapper for same method in CNexus. See there for documentation.
	 */
  protected function AddMessage($type, $message, $alternative=null) {
    return $this->ly->AddMessage($type, $message, $alternative);
  }


	/**
	 * Wrapper for same method in CNexus. See there for documentation.
	 */
	protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    return $this->ly->CreateUrl($urlOrController, $method, $arguments);
  }


}
  