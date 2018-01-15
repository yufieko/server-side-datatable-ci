    <script>
        var current_url = "<?=site_url('goodadmin/'.( $this->uri->slash_segment(2) == '/' ? '' :  $this->uri->slash_segment(2) ) )?>";
        var site_url = "<?=site_url()?>";
        var csrf_kb_name = "<?=$this->security->get_csrf_hash()?>";
        var fm_key = "<?=$this->session->uploadkey?>";
    </script>
    <!-- Jquery Core Js -->
    <script src="<?=plugin_url('jquery/jquery.min.js')?>"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?=plugin_url('bootstrap/js/bootstrap.min.js')?>"></script>
    <!-- Select Plugin Js -->
    <script src="<?=plugin_url('bootstrap-select/js/bootstrap-select.js')?>"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?=plugin_url('jquery-slimscroll/jquery.slimscroll.js')?>"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?=plugin_url('node-waves/waves.js')?>"></script>
    <!-- Wait Me Plugin Js -->
    <script src="<?=plugin_url('waitme/waitMe.js')?>"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?=plugin_url('jquery-countto/jquery.countTo.js')?>"></script>
    <!-- Moment Plugin Js -->
    <script src="<?=plugin_url('momentjs/moment.js')?>"></script>
    <!-- Validation Plugin Js -->
    <script src="<?=plugin_url('jquery-validation/jquery.validate.js')?>"></script>
    <?php if( $datatable ): ?>
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?=plugin_url('jquery-datatable/jquery.dataTables.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.min.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/extensions/Responsive/js/dataTables.responsive.min.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/extensions/Responsive/js/responsive.bootstrap.min.js')?>"></script>

    <script src="<?=plugin_url('jquery-datatable/extensions/export/dataTables.buttons.min.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/extensions/export/buttons.flash.min.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/extensions/export/jszip.min.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/extensions/export/pdfmake.min.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/extensions/export/vfs_fonts.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/extensions/export/buttons.html5.min.js')?>"></script>
    <script src="<?=plugin_url('jquery-datatable/extensions/export/buttons.print.min.js')?>"></script>
    <?php endif; ?>
    <!-- SweetAlert2 -->
    <script src="<?=plugin_url('sweetalert2/sweetalert2.min.js')?>"></script>
    <!-- Custom Js -->
    <script src="<?=back_url('js/admin.js')?>"></script>
    <!-- Demo Js -->
    <script src="<?=back_url('js/demo.js')?>"></script>
    <script src="<?=back_url('js/pages/post-category.js')?>"></script>
    <script>
        $(function () {
            $('.count-to').countTo();

            var parent = "<?='#'.$menu['parent']?>";
            var child = "<?='#'.str_replace('-form', '', $menu['child'])?>";
            var extra = "<?='#'.str_replace('-form', '', @$menu['extra'])?>";

            $('li').removeClass("active");
            $(parent).addClass("active").find('.a-<?=$menu['parent']?>').addClass('toggled');
            $(parent).addClass("active").find('.ml-menu').first().show();
            $(child).addClass("active").find('.a-<?=str_replace('-form', '', $menu['child'])?>').first().addClass('toggled').parents().find('.ml-menu').first().show();
            <?php if(!empty($menu['extra'])): ?>
            $(child).addClass("active").find('.a-<?=str_replace('-form', '', $menu['child'])?>').addClass('toggled');
            $(child).find('.ml-menu').first().show();
            $(extra).addClass("active").find('.a-<?=str_replace('-form', '', $menu['extra'])?>').first().addClass('toggled');

            <?php else: ?>
            $(child).addClass("active").find('.a-<?=str_replace('-form', '', $menu['child'])?>').first().addClass('toggled');
            <?php endif; ?>
        });
    </script>