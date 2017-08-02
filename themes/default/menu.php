<?php
$search_term = isset($_SESSION['search_term'])?$_SESSION['search_term']:'';
?>
<div class="row" id="header_row_top">
	<div class="col-md-4 col-md-offset-6 header_col_search">
		<form action="<?php echo actionlink("HomeController@search"); ?>" method="post" class="zoeken" id="site_zoeken">
			<div class="input-group">
				<input type="text" class="form-control" name="search_term" id="header_search_term" value="<?php echo e($search_term); ?>" placeholder="<?php echo ucfirst(translate("search_on_this_website")); ?>" required>
				<span class="input-group-btn">
					<button type="submit" class="btn btn-default" id="header_btn_search">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
			</div>
		</form>
	</div>
	<div class="col-md-2 text-right">
		<ul class="languagemenu">
			<?php echo buildLanguageMenu(); ?>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<nav class='navbar navbar-default' id="header_menu_navbar">
			<div class="container-fluid" id="header_menu_container">
				<div class="navbar-header">
					<button id="main_menu_button_collapse" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" id="header_logo" href="<?php echo pagelink("home",$language_id); ?>">
					<img src="<?php echo $theme_basepath; ?>/img/logo.png" title="" desc="" alt=""/>
					</a>
				</div>
				<div class='navbar-collapse collapse' id="col_main_menu">
					<ul class="nav navbar-nav" id="main_menu">
					<?php echo buildThemeMenu(1,0); ?>
					</ul>
				</div>
				
			</div>
		  
			
		</nav>


	</div>
</div>