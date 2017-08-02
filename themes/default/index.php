<!DOCTYPE html>
<html>
	
	<?php
	include_once("head.php");
	include_once("theme_functions.php");

	?>

   <body>
	   <!-- Google Tag Manager (noscript) -->
		<noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TFJBGG" height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript>
		<!-- END Google Tag Manager (noscript) -->
		<!-- Google Tag Manager -->
		<script>
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-TFJBGG');
		</script>
		<!-- End Google Tag Manager -->
		
   		<div id="wrap">
			<section id="header">
				<div class="container">
					<?php include("menu.php");	?>
				</div>
			</section>

			<section id="breadcrumbs">
				<?php echo($context); ?>
				<div class="container">
					<?php include("breadcrumbs.php"); ?>
				</div>
			</section>

			<section id='content'>
				<div class="container">
					<?php echo($content); ?>
				</div>
			</section>

			<div class='modal fade' id='modal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
				<div class='modal-dialog modal-lg' id='modal-dialog' role='document'>
					<div class='modal-content'></div>
				</div>
			</div>
			<div id="push"></div>
		</div>

	  	<section id='footer'>
			<div class="container-fluid">
				<?php include("footer.php"); ?>
				
			</div>
		</section>
		
		<a href="#header" class="scrollup"><span class="glyphicon glyphicon-chevron-up"></span></a>

		<!-- javascript -->

		<script src="<?php echo $theme_basepath; ?>/js/jquery.min.js"></script>
		<script src="<?php echo $site_config['site_url']->value; ?>js/custom/tinymce.min.js"></script>
		<script src="<?php echo $theme_basepath; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo($theme_basepath); ?>/js/jquery.bootstrap.wizard.min.js"></script>
		<script src="<?php echo($theme_basepath); ?>/js/jquery.validate.min.js"></script>
		<script src="<?php echo($theme_basepath); ?>/js/select2.min.js"></script>
		<script src="<?php echo $theme_basepath; ?>/js/fancybox/dist/jquery.fancybox.min.js"></script>
		<script src="<?php echo $site_config['site_url']->value; ?>js/custom/jquery-match-height/dist/jquery.matchHeight-min.js"></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js'></script>

		<?php
			$html_helper->writeScripts();
		?>
		<script type="text/javascript">
			var config = {
				globals: {},
				url_get: '<?php echo $site_config['site_url']->value.$globals['language']->shortname.'/js_config_get'; ?>',
				load: function() {
					var self = this;
					var deferred = new $.Deferred();
					$.ajax({
						url: self.url_get,
						method:'POST',
						dataType: 'json',
						cache: false,				
					}).done(function(json_data) {
						config.globals = json_data;
						<?php $html_helper->writeJsVars(); ?>
						deferred.resolve("config load Completed");	
					});
					return deferred.promise();
				}			
			}
		</script>
		<script><?php echo($script); ?></script>
		<script src="<?php echo $theme_basepath; ?>/js/app.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-21260179-1', 'auto');
		  ga('send', 'pageview');

		</script>
		
   </body>
</html>