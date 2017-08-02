      <nav class="navbar navbar-default ">
        <div class="container-fluid">
          <div class="navbar-header ">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $site.$taal; ?>"><?php echo $site_config['site_titel']; ?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
		  		<ul class='main_menu nav navbar-nav'>
					<?php 
						echo $main_menu;
					?>
				</ul>
			<ul class='lang_menu nav navbar-nav navbar-right'>
				<?php
					echo $lang_menu;
				?>	
			</ul>
          </div>
        </div>
      </nav>