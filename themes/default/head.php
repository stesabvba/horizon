<?php
if (!is_null($html_helper->getMetaTitle())) {
	$meta_title = $html_helper->getMetaTitle();
} else {
	$meta_title = $active_pagemeta->title;
}

if (!is_null($html_helper->getMetaDescription())) {
	$meta_description = $html_helper->getMetaDescription();
} else {
	$meta_description = $active_pagemeta->description;
}

if (!is_null($html_helper->getMetaKeywords())) {
	$meta_keywords = $html_helper->getMetaKeywords();
} else {
	$meta_keywords = $active_pagemeta->keywords;
}
?>
<head>
	
	<meta charset="utf-8"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo $meta_title; ?></title>

	<meta name="description" content="<?php echo $meta_description; ?>">
	<meta name="keywords" content="<?php echo $meta_keywords;  ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php
	$html_helper->writeMetas();
	?>

	<link href="<?php echo $theme_basepath; ?>/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $theme_basepath; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<link href="<?php echo $theme_basepath; ?>/css/style.css" rel="stylesheet" />
	<link href="<?php echo $theme_basepath; ?>/css/select2.min.css" rel="stylesheet" />
	<link href="<?php echo $theme_basepath; ?>/css/select2-bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $theme_basepath; ?>/css/datatables.min.css" rel="stylesheet" />

	
	<link href="<?php echo $theme_basepath; ?>/js/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet" type="text/css">

	<?php
	$html_helper->writeCss();
	?>

	<link rel="icon" href="<?php echo $theme_basepath; ?>/img/favicon.ico" />

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>