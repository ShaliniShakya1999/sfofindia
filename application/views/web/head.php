<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (!isset($cms) || !is_array($cms)) {
	$cms = array();
}
?>
<head>
    <meta charset="utf-8">
    <title><?php echo html_escape(cms_val($cms, 'meta_title', 'Shaheed Foundation India')); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo html_escape(cms_val($cms, 'meta_keywords', '')); ?>" name="keywords">
    <meta content="<?php echo html_escape(cms_val($cms, 'meta_description', '')); ?>" name="description">

    <!-- Favicon -->
    <link href="<?php echo html_escape(web_asset('img/logo1.png')); ?>" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo html_escape(web_asset('lib/animate/animate.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo html_escape(web_asset('lib/owlcarousel/assets/owl.carousel.min.css')); ?>" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo html_escape(web_asset('css/bootstrap.min.css')); ?>" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo html_escape(web_asset('css/style.css')); ?>" rel="stylesheet">
</head>
