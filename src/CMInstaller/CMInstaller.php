<?php
/**
 * A model to manage automatic installation of the Nexus MVC
 * 
 * @package NexusCore
 */
class CMInstaller extends CObject {

  /**
   * Properties
   */
   protected $controller = null;


  /**
   * Constructor
   */
  public function __construct($aController) { 
	parent::__construct(); 
	$this->controller = $aController;
  }


	/**
	 * Begin the installation process of Nexus MVC
	 *
	 */
	 public function Install(){
			$result = array('result' => true);
			/*
			// Set file/directory rights
			if( @chmod(NEXUS_INSTALL_PATH.'/site/data', 0777) ){
				$result['filesystem']['datadir'] = array('success', 'Successfully set permissions of directory /site/data.');
			}
			else{
				$result['filesystem']['datadir'] = array('error', "Couldn't set permissions of directory /site/data!");
				$result['result'] = false;
			};

			if( @chmod(NEXUS_INSTALL_PATH.'/site/data/.ht.sqlite', 0777) ){
				$result['filesystem']['dbfile'] = array('success', 'Successfully set permissions of database file /site/data/.ht.sqlite.');
			}
			else{
				$result['filesystem']['dbfile'] = array('error', "Couldn't set permissions of database file /site/data/.ht.sqlite!");
				$result['result'] = false;
			};
			*/
			
			// Install modules
			$moduleManager = new CMModules();
			$installationResult = @$moduleManager->Install();
			
			foreach( $installationResult as $moduleResult ){			
				if( isset($moduleResult['result'][0]) && ($moduleResult['result'][0] == 'success') ){
					$result['installs'][$moduleResult['name']] = array('success', $moduleResult['result'][1]);
				}
				else{
					$result['installs'][$moduleResult['name']] = array('error', "Couldn't install module {$moduleResult['name']}");
					$result['result'] = false;
				}
			}
						
			return $result;
	 }
	 

	/**
	 * Check that the server meets all the requirements for installation of Nexus
	 *
	 */
	 public function CheckInstallationRequirements(){
		$result = array('result' => true);
		
		//  Check PHP Version
		if( $this->config['installer']['minphpversion'] > phpversion() ){
			$result['result'] = false;
			$result['tests']['phpversion'] = array('error', "Your server is running PHP version ".phpversion().". Minimum required version is {$this->config['installer']['minphpversion']}. Please upgrade your installation of PHP!");
		}
		else{
			$result['tests']['phpversion'] = array('success', "Your server is running PHP version ".phpversion().". Minimum required version is {$this->config['installer']['minphpversion']}.");
		}
		
		//  Check for correct DB driver
		foreach( $this->config['installer']['supported_databases'] as $db_driver => $driver_displayname ){
			if( !extension_loaded($db_driver) ){
				$result['result'] = false;
				$result['tests']['dbdriver'] = array('error', "The database driver '{$driver_displayname}' is not installed!");
				
			}
			else{
				$result['tests']['dbdriver'] = array('success', "The database driver '{$driver_displayname}' is installed.");
			}
		}

		//  Check if site/data -directory has write permissions
		if( !is_writable(NEXUS_INSTALL_PATH.'/site/data') ){
			$result['result'] = false;
			$result['tests']['dataperms'] = array('error', "PHP does not have write permissions for the directory '".NEXUS_INSTALL_PATH.'/site/data'."'! Correct this by setting the permissions for this directory to full access." );
		}
		else{
			$result['tests']['dataperms'] = array('success', "PHP has write permissions for the directory '".NEXUS_INSTALL_PATH.'/site/data'."'.");
		}
				

		//  Check if database file has write permissions
		if( !is_writable(NEXUS_INSTALL_PATH.'/site/data/.ht.sqlite') ){
			$result['result'] = false;
			$result['tests']['dbperms'] = array('error', "PHP does not have write permissions for the file '".NEXUS_INSTALL_PATH.'/site/data/.ht.sqlite'."'! Correct this by setting the permissions for this file to full access.");
		}
		else{
			$result['tests']['dbperms'] = array('success', "PHP has write permissions for the directory '".NEXUS_INSTALL_PATH.'/site/data/.ht.sqlite'."'.");
		}
		return $result;
	 }	 
	 
	 
	  /**
	   * Set some settings in the config-php file
	   *
	   * @param data string The POST-data sent by the form
	   * @returns boolean true on success and false on failure
	   **/
	  public function Config($data) {
		try{
			$config = file_get_contents(__DIR__.'/config.php.template');
			$config = str_replace('%%header%%', $data['header'], $config);
			$config = str_replace('%%slogan%%', $data['slogan'], $config);
			$config = str_replace('%%footer%%', $data['footer'], $config);
			
			$menu = $this->XML2Array("<xml>".$data['menuxml']."</xml>");
			$config = str_replace('%%menu%%', $menu['menu'] , $config);
			$config = str_replace('%%menu_to_region%%', $menu['mapping'] , $config);
			$config = str_replace('%%installed%%', 'true', $config);
						
			$configfile = NEXUS_INSTALL_PATH . '/site/config.php';
			file_put_contents( $configfile, $config );
			
			return true;
		}
		catch( Exception $e ){
			return false;
		}
		
		
/*
		if( isset($_SESSION['execs']) ){ 
			$_SESSION['execs'] += 1;
		}
		else{
			$_SESSION['execs'] = 1;
		}
		
		
		$this->views->AddString( print_r($data, true) );
		$this->views->AddString( '<p>Execs: '.$_SESSION['execs'].'</p>' );
*/
	  }
	  
	  	  
	  
	  
	  public function XML2Array($strXML){
		$xml = new SimpleXMLElement( $strXML );
		$result = array('menu' => "array(\n", 'mapping' => "array( ");

		foreach ($xml->menu as $menu) {
			$result['menu'] .= "\t'{$menu['name']}' => array(\n";
			$result['mapping'] .= "'{$menu['name']}' => '{$menu['region']}', ";
			foreach($menu as $item) {
				$result['menu'] .= "\t\t'{$item['name']}' => array( 'label' => '{$item['label']}', 'url' => '{$item['url']}' ),\n";
			}
			$result['menu'] .= "\t),\n";
		}
		$result['menu'] .= ");\n";
		$result['mapping'] .= ' )';
		
		return $result;
	  }
	  
	  
	  public function Array2XML($menu, $mapping){
		$result = '';
		
		foreach( $menu as $menuname => $menu ){
			$result .= "<menu name=\"{$menuname}\" region=\"{$mapping[$menuname]}\">\n";
			foreach( $menu as $itemname => $item ){
				$result .= "\t<item name=\"{$itemname}\" label=\"{$item['label']}\" url=\"{$item['url']}\" />\n";
			}
			$result .= "</menu>\n\n";
		}
		
		return $result;
	  }
	 
	 
	 
}