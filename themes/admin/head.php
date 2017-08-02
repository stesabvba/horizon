<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php
		echo $meta_tags;
	?>
	
	<meta name="description" content="<?php echo $active_pagemeta->description; ?>">
    <meta name="author" content="<?php echo $site_config['site_author']->value; ?>">
	
	
    <title><?php echo $active_pagemeta->title; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $theme_basepath; ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $theme_basepath; ?>/js/jquery-ui.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $theme_basepath; ?>/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo $theme_basepath; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="<?php echo $site_config['site_url']->value; ?>css/select2.min.css">
	<link rel="stylesheet" href="<?php echo $site_config['site_url']->value; ?>css/select2-bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $theme_basepath; ?>/css/style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo $theme_basepath; ?>/js/modal/modal.css">

	<?php 
		echo $customcss;
	?>

	<?php
	$html_helper->writeCss();
	?>
	
	
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>