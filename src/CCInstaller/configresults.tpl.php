<?php if( $result == true ): ?>
	<p>
		Congratulations, the installation went well! 
		To get you started with Nexus, please take a moment to read the <a href="<?=base_url()?>readme.md">README file</a> displayed below.
	</p>
	<p>
		Or go directly to <a href="<?=base_url()?>">the main page</a>.
	</p>
	
	<?=CTextFilter::Filter( file_get_contents(NEXUS_INSTALL_PATH.'/readme.md'), array('htmlentities', 'markdown') )?>
<?php else: ?>
	<p>
		Oops, the operation failed! <a href="<?=base_url()?>installer">Try running the installer again</a>
	</p>
<?php endif; ?>