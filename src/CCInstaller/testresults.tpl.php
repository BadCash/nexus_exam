<?php if( !$testResults['result'] ){ ?>
	<p>Your server does not meet all the requirements for installting Nexus. Please review the results below and make the necessary adjustments, then run the installer again.</p>
<?php } ?>

<?php foreach( $testResults['tests'] as $testResult ): ?>
	<p class="<?=$testResult[0];?>"><?=$testResult[1];?></p>
<?php endforeach; ?>
