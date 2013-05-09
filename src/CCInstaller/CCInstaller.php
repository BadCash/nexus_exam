<?php
/**
 * A controller to manage automatic installation of the Nexus MVC
 * 
 * @package NexusCore
 */
class CCInstaller extends CObject implements IController {

  /**
   * Properties
   */
  public $model = null;

	/**
	* Constructor
	*/
	public function __construct() { 
		parent::__construct(); 
		$this->model = new CMInstaller($this);
		$this->views->SetTitle('Nexus Installer');
		$this->config['theme']['template_file'] = 'installer.tpl.php';
	}

  

	/**
	* Check the requirements for installing Nexus, and display the results
	* 
	* If Nexus is already installed, display instructions for re-installing.
	* 
	*/
	public function Index() {	
		if( isset($this->config['installer']['installed']) && ($this->config['installer']['installed'] == 'true') ){
			$this->views->AddString("<p>This system has already been installed.</p>".
									"<p>If you need to reinstall Nexus, you must first change the setting <code>config['installer']['installed']</code> ".
									"to the value <code>'false'</code> in the <code>/site/config.php</code> file.</p>");
			return;
		}
		
		// Make sure it's possible to install Nexus
		$arrRequirementTest = $this->model->CheckInstallationRequirements();
		$this->views->AddInclude(__DIR__ . '/testresults.tpl.php', array('testResults'=>$arrRequirementTest) );

		// Intallation requirement test failed
		if( !$arrRequirementTest['result'] ){
			return;
		}
		
		$this->DisplayInstallForm();
	}

	
	
	/**
	* Display the main install form
	*
	* Currently this only consists of an "Install"-button to start the installation process
	*/
	  public function DisplayInstallForm(){
		$form = new CForm( array( 'action' => $this->request->CreateUrl('', 'ExecInstallForm') ), 
						   array( new CFormElementSubmit('ExecInstallForm', array('value' => 'Install')) ) );
		$this->views->AddString($form->GetHTML());
	  }

	
	
	/**
	* Execute the install form
	* 
	* Attempts to install Nexus, and displays the results of the operation. 
	*/
	  public function ExecInstallForm() {		
		// Perform install
		$installResults = $this->model->Install();
		
		// Display results
		$this->views->AddInclude(__DIR__ . '/installresults.tpl.php', array('result'=>$installResults['result'], 'moduleResults'=>$installResults['installs'] ) );
		
		// If all went OK display Next-button
		
		if( $installResults['result'] ){
			$form = new CForm( array( 'action' => $this->request->CreateUrl('', 'DisplayConfigForm') ), 
							   array( new CFormElementSubmit('DisplayConfigForm', array('value' => 'Next>>')) ) );
			$this->views->AddString($form->GetHTML());
		}
		
		
	  }

	  
	  /**
	  * Display form for letting the user customize some settings in the config.php -file directly
	  *
	  **/
	  public function DisplayConfigForm(){
		$form = new CConfigForm( array( 'action' => $this->request->CreateUrl('', 'ExecConfigForm') ), array() );
		$form->elements['header']['value'] = isset($_POST['header']) ? $_POST['header'] : $this->config['theme']['data']['header'];
		$form->elements['slogan']['value'] = isset($_POST['slogan']) ? $_POST['slogan'] : $this->config['theme']['data']['slogan'];
		$form->elements['footer']['value'] = isset($_POST['footer']) ? $_POST['footer'] : $this->config['theme']['data']['footer'];
		$form->elements['menuxml']['value'] = isset($_POST['menuxml']) ? $_POST['menuxml'] : $this->model->Array2XML($this->config['menus'], $this->config['theme']['menu_to_region']);

		$this->views->AddString($form->GetHTML());
	  }
	  

    /**
	* Execute the configuration form
	*
	**/
	public function ExecConfigForm(){
		$configResult = false;
		
		// The empty() -check is a workaround for the problem with the page being
		// loaded two times, with an empty $_POST the second time
		if( !empty($_POST) ){
			$configResult = $this->model->Config( $_POST );
		}
		else{
			return;
		}
		
		
		// If all went OK display success-message, else return to form
		if( $configResult ){
			$this->views->AddInclude(__DIR__ . '/configresults.tpl.php', array('result'=>$configResult) );
		}
		else{
			$this->DisplayConfigForm();
		}
		
	}
	  
}












/**
 * Form for letting user enter custom information for configuration file
 */
class CConfigForm extends CForm {

  /**
   * Constructor
   */
  public function __construct($form=array(), $elements=array()) {
    parent::__construct($form, $elements);
	
	$this->AddElement(new CFormElementText('header'));
	$this->AddElement(new CFormElementText('slogan'));
	$this->AddElement(new CFormElementTextArea('footer'));
	$this->AddElement(new CFormElementTextArea('menuxml'));
	$this->AddElement(new CFormElementSubmit('doExecConfigForm', array('value' => 'Save and finish installation')) );
  }
   
}


