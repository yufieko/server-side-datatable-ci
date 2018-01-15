<!DOCTYPE html>
<html>
<head>
	<?php echo $template['partials']['header']; ?>
</head>

<body class="theme-blue-grey">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Mohon tunggu...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <?php echo $template['partials']['navigation']; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2><?php echo strtoupper($title); ?>
                <small><?php echo $title_desc; ?></small>
                </h2>
            </div>
            <?php echo $template['body']; ?>

        </div>
    </section>
    <?php echo $template['partials']['footer']; ?>
</body>
</html>