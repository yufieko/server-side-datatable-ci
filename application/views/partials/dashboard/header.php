    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?=htmlspecialchars($template['title'])?></title>
    <meta name="description" content="<?=strip_tags($meta_description)?>">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?=assets_url('favicon.ico')?>" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?=assets_url('apple-touch-icon.png')?>" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?=assets_url('apple-touch-icon-57x57.png')?>" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?=assets_url('apple-touch-icon-72x72.png')?>" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?=assets_url('apple-touch-icon-76x76.png')?>" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?=assets_url('apple-touch-icon-114x114.png')?>" />
    <link rel="apple-touch-icon" sizes="120x120" href="<?=assets_url('apple-touch-icon-120x120.png')?>" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?=assets_url('apple-touch-icon-144x144.png')?>" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?=assets_url('apple-touch-icon-152x152.png')?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?=assets_url('apple-touch-icon-180x180.png')?>" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?=plugin_url('bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?=plugin_url('node-waves/waves.css')?>" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="<?=plugin_url('animate-css/animate.css')?>" rel="stylesheet" />
    <!-- WaitMe Css -->
    <link href="<?=plugin_url('waitme/waitMe.css')?>" rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href="<?=plugin_url('bootstrap-select/css/bootstrap-select.css')?>" rel="stylesheet" />
    <?php if( $datatable ): ?>
    <!-- JQuery DataTable Css -->
    <link href="<?=plugin_url('jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?=plugin_url('jquery-datatable/extensions/Responsive/css/responsive.bootstrap.min.css')?>" rel="stylesheet" >
    <?php endif; ?>
    <link href="<?=plugin_url('sweetalert2/sweetalert2.min.css')?>" rel="stylesheet">
    <!-- Custom Css -->
    <link href="<?=back_url('css/style.css')?>" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?=back_url('css/themes/theme-blue-grey.min.css')?>" rel="stylesheet" />