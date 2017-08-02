<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		echo $meta_tags;
	?>
    <meta name="description" content="<?php echo $omschrijving; ?>">
    <meta name="author" content="<?php echo $site_config['site_author']; ?>">

    <link rel="icon" href="/img/favicon.ico">

    <title><?php echo $titel; ?></title>


   
	<?php 
		echo $customcss;
	?>


    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>