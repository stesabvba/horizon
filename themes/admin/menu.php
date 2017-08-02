<!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo pagelink("manage",$language_id); ?>"><img src="<?php echo $theme_basepath; ?>/img/horizon_logo.png" height="50px" title="Horizon CMS" alt="Horizon CMS logo" /></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
       
				
              
				
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo($active_user->firstname . " " . $active_user->lastname); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo(pagelink('user_profile',$language_id)); ?>"><i class="fa fa-fw fa-user"></i> Profiel</a>
                        </li>
                        <li>
                            <a href="<?php echo(pagelink('messages',$language_id)); ?>"><i class="fa fa-fw fa-envelope"></i> <?php echo(ucfirst(translate("inbox"))); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo(pagelink('settings',$language_id)); ?>"><i class="fa fa-fw fa-gear"></i> Instellingen</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo pagelink("logout",$language_id); ?>"><i class="fa fa-fw fa-power-off"></i> Uitloggen</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <?php echo buildThemeMenu(2,0); ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>