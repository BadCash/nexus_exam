<?php if( $result == true ): ?>
	<p>
		Congratulations, the installation went well! Click the button below to continue to the next step where you can change some basic settings for the site.
	</p>
<?php else: ?>
	<p>
		Oops, the installation failed! Review the problems below.
	</p>
<?php endif; ?>
		
<?php if( !empty($moduleResults) ): ?>
	<h3>Modules</h3>
	
	<?php foreach( $moduleResults as $install ): ?>
		<p class="<?=$install[0];?>"><?=$install[1];?></p>
	<?php endforeach; ?>
<?php endif; ?>


<?php if( !empty($filesystemResults) ): ?>
	<h3>Filesystem</h3>
	
	<?php foreach( $filesystemResults as $filesystem ): ?>
		<p class="<?=$filesystem[0];?>"><?=$filesystem[1];?></p>
	<?php endforeach; ?>
<?php endif; ?>

