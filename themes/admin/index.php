<!DOCTYPE html>
<html lang="en">
<?php include_once("theme_functions.php"); ?>
<?php include_once("head.php"); ?>

<body>
	<div id="wrapper">

        <?php include_once("menu.php"); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $active_pagemeta->name; ?>
                            <small><?php echo $active_pagemeta->description; ?></small>
                        </h1>
					
						<ol class='breadcrumb'>
						<?php 
							echo $breadcrumb;
						?>
						</ol>
					</div>
				</div>
			</div>
			
			<div class="container-fluid" id="content-holder">
				<div class="row">
					<div class="col-lg-12">
						<?php
							echo $content;			
						?>
					</div>
				</div>
			</div>

        </div>

    </div>


	<div class='modal fade' id='modal' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		<div class='modal-dialog modal-lg' id='modal-dialog' role='document'>
			<div class='modal-content'></div>
		</div>
	</div>

    <!-- jQuery -->
    <script src="<?php echo $theme_basepath; ?>/js/jquery.js"></script>
	<script src="<?php echo $theme_basepath; ?>/js/jquery-ui.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $theme_basepath; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $theme_basepath; ?>/js/bootstrap.js"></script>
 	<!-- <script src="<?php //echo $theme_basepath; ?>/js/notification.js"></script> -->
	<script src="<?php echo $site_config['site_url']->value; ?>js/custom/tinymce.min.js"></script>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js'></script>
	
	<!-- <script src="<?php //echo $theme_basepath; ?>/js/modal/modal.js"></script> -->

	<script type="text/javascript">
	var config = {
		globals: {},
		load: function() {
				<?php $html_helper->writeJsVars(); ?>
				console.log('config loaded');
		}			
		
	}
	</script>

	<script src="<?php echo $site_config['site_url']->value; ?>js/select2.min.js"></script>

	<?php
		echo $customjs;	
	?>


	<script>	
	$( document ).ready(function() {
		<?php echo $script; ?>
		tinymce.init({
			selector: '.wysiwyg',
			height:400,
			plugins: "template code",
			relative_urls: false,
			remove_script_host: false,
			menubar: "file edit insert view format table tools",
			toolbar: "template code | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
			templates :site+"modules/tinymce_templates/feed.php",

			force_br_newlines : false,
  			force_p_newlines : false,
  			forced_root_block : '',
		});
	});
	</script>

	<?php
	$html_helper->writeScripts();
	?>


	<script type="text/javascript" src="<?php echo $theme_basepath; ?>/js/app.js"></script>		
</body>

</html>
