<!DOCTYPE html>
<html lang='en'> 
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title><?=$title?></title>
	<link rel='shortcut icon' href='<?=$favicon?>'/>
  <link rel='stylesheet' href='<?=theme_url($stylesheet)?>'/>
  <?php if(isset($inline_style)): ?><style><?=$inline_style?></style><?php endif; ?>
</head>
<body>


		<div id="outer-wrap-page">
		  <div id="inner-wrap-page">
				<div id="page">

					<header>
						<div id="logocontainer">
							<div id="logo">
								<a href='<?=base_url()?>'><img src="<?=theme_url($logo)?>" width="<?=$logo_width?>" height="<?=$logo_height?>"></a>
							</div>
							<div id="header">
								<a href='<?=base_url()?>'><?=$header?></a>
							</div>
							<div id="slogan">
								<?=$slogan?>
							</div>
						</div>
					</header>
					
					<div id="pagecontent">
							<div id="main" role="main">
								<h1>Install Nexus</h1>
								
								<?php if( region_has_content('check_results') ): ?>
									<h2>Requirements</h2>
									<?=render_views('check_results');?>
								<?php endif; ?>
								
								<?php if( region_has_content('install_results') ): ?>
									<h2>Installation results</h2>
									<?=render_views('install_results');?>
								<?php endif; ?>

								<?=get_messages_from_session()?>
							  <?=@$main?>
							  							  
							  <?=render_views()?>
							</div>
					</div>
				</div>
				
		  </div>
		</div>

		<div id="outer-wrap-bottom">
		  <?php if(region_has_content('bottom-column-one', 'bottom-column-two', 'bottom-column-three', 'bottom-column-four')): ?>
		  <div id="inner-wrap-bottom-column">
			<div id="bottom-column-one"><?=render_views('bottom-column-one')?></div>
			<div id="bottom-column-two"><?=render_views('bottom-column-two')?></div>
			<div id="bottom-column-three"><?=render_views('bottom-column-three')?></div>
			<div id="bottom-column-four"><?=render_views('bottom-column-four')?></div>
		  </div>
		  <?php endif; ?>
		</div>
		
		<div id="outer-wrap-footer">
		  <div id="inner-wrap-footer">
			  <footer>
				  <?=$footer?>
				  <?=get_tools();?>
				  <div id='debug'>
					<?=get_debug()?>
				  </div>
			  </footer>
		  </div>
		</div>

</body>
</html>