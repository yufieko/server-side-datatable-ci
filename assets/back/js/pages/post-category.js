(function($) {
    "use strict"; // Start of use strict
    var form_edit = $("#form-edit");
    var form_create = $("#form-create");

    function slugify (text) {
        const a = 'àáäâèéëêìíïîòóöôùúüûñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;'
        const b = 'aaaaeeeeiiiioooouuuuncsyoarsnpwgnmuxzh------'
        const p = new RegExp(a.split('').join('|'), 'g')

        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(p, c =>
                b.charAt(a.indexOf(c)))     // Replace special chars
            .replace(/&/g, '-dan-')         // Replace & with 'and'
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '')             // Trim - from end of text
    }

    function save_edit(){
        var effect = form_edit.data('loadingEffect');
        var $loading = form_edit.parents('.modal-content').waitMe({
            effect: effect,
            text: 'Memproses...',
            bg: 'rgba(255,255,255,0.90)',
            color: '#555'
        });

        $.ajax({
            method : 'POST',
            dataType: 'json',
            url : 'index.php/xhr/category_save',
            data : form_edit.serialize()
        })
        .done(function(response){
            form_edit.find('.form-message').html(response.message);
            form_edit.find('.form-message').fadeIn();

            $loading.waitMe('hide');
            
            if(response.status == true){
                setTimeout(function () { 
                    $('#modal-edit').modal('hide')
                    $('.btn-refresh').trigger('click');
                    form_edit.find('.form-message').empty();
                }, 2000);
            }
        })
        .fail(function(response){
            // login_button.button('reset');
            $loading.waitMe('hide');
            message_container.html('<div class="alert alert-warning alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Ada yang salah, silakan muat ulang laman ini :(</div>');
        });
    }

    function save_create(){
        var effect = form_create.data('loadingEffect');
        var $loading = form_create.parents('.modal-content').waitMe({
            effect: effect,
            text: 'Memproses...',
            bg: 'rgba(255,255,255,0.90)',
            color: '#555'
        });

        $.ajax({
            method : 'POST',
            dataType: 'json',
            url : 'index.php/xhr/category_save',
            data : form_create.serialize()
        })
        .done(function(response){
            form_create.find('.form-message').html(response.message);
            form_create.find('.form-message').fadeIn();

            $loading.waitMe('hide');
            
            if(response.status == true){
                setTimeout(function () { 
                    $('#modal-create').modal('hide')
                    $('.btn-refresh').trigger('click');
                    form_create.find('.form-message').empty();
                    form_create.trigger("reset");
                }, 2000);
            }
        })
        .fail(function(response){
            // login_button.button('reset');
            $loading.waitMe('hide');
            message_container.html('<div class="alert alert-warning alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Ada yang salah, silakan muat ulang laman ini :(</div>');
        });
    }

    form_edit.validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        },
        messages: {
            name: "Nama harus diisi",
            slug: "Slug harus diisi"
        },
        submitHandler: function(form) {
            save_edit();
            return false;
        }
    });

    form_create.validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        },
        messages: {
            name: "Nama harus diisi",
            slug: "Slug harus diisi"
        },
        submitHandler: function(form) {
            save_create();
            return false;
        }
    });

    var table = $('#category-table').DataTable({
        paging: true,
        info: true,
        lengthChange: true,
        autoWidth: true,
        responsive: true,
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        // Load data for the table's content from an Ajax source
        ajax: {
            url: "index.php/xhr/category_ajax_list",
            data: {csrf_kb_name:csrf_kb_name},
            type: "POST"
        },
        //Set column definition initialisation properties.
        columnDefs: [
            {
                targets: [ 3 ], // index column
                orderable: false, //set not orderable
            },
            /*{ targets: [ 4 ], width: "15%"},
            { targets: [ 3 ], width: "5%"},
            { targets: [ 1,2 ], width: "15%"},
            { targets: [ 0 ], width: "50%"},*/
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -2 },
            { responsivePriority: 3, targets: -3 },
            { responsivePriority: 0, targets: -4 }
        ],
        language: {
            zeroRecords: "Belum ada kategori"
        }
    });

    var table_popular = $('#category-popular-table').DataTable({
        paging: true,
        info: false,
        pagingType: "simple",
        pageLength: 5,
        lengthChange: false,
        autoWidth: true,
        responsive: true,
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        // Load data for the table's content from an Ajax source
        ajax: {
            url: "index.php/xhr/category_pop_ajax_list",
            data: {csrf_kb_name:csrf_kb_name},
            type: "POST"
        },
        //Set column definition initialisation properties.
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 0, targets: 1 }
        ],
        language: {
            zeroRecords: "Belum ada kategori"
        }
    });

    $('.btn-refresh').on('click', function () {
        var effect = $(this).data('loadingEffect');
        var color = $.AdminBSB.options.colors[$(this).data('loadingColor')];

        var $loading = $(this).parents('.row').find('.card').waitMe({
            effect: effect,
            text: 'Mengambil data...',
            bg: 'rgba(255,255,255,0.90)',
            color: color
        });

        setTimeout(function () {
            //Loading hide
            $loading.waitMe('hide');
        }, 3200);

        table.ajax.reload();
        table_popular.ajax.reload();
        return false;
    });

    $('#category-popular-table_wrapper').find('.row:nth-child(1)').find('.col-sm-6:nth-child(1)').remove();

    $(document).on('keyup', '.name', function(e) {
        var target = $(this).data('target');
        var slug = slugify($(this).val());
        $(target).val(slug);
    })

    $(document).on('blur', '.slug-edit', function(e) {
        const t = $(this);
        setTimeout(function(){
            var slug = slugify(t.val());
            t.val(slug);
        }, 500);
    })

    $(document).on('click', '.edit-category', function(e) {
        e.preventDefault();
        var btn = $(this);
        var form = $('#form-edit');
        var id = btn.data('id');

        $.ajax({
            method: "POST",
            dataType: "json",
            url : 'index.php/xhr/view_edit_category',
            data :{id:id,csrf_kb_name:csrf_kb_name},
        })
        .done(function(response) {
            form.find('.container-edit').empty().append(response.data);
            $('#modal-edit').modal('show')

            if (response.status == false) {
                form.find('.form-message').html( response.message );
                form.find('.form-message').fadeIn();
            }
        })
        .fail(function(response){
            form.find('.form-message').html( '<div class="alert alert-danger alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Gagal memuat :(</div>');
            form.find('.form-message').fadeIn();
        });
    });


    $(document).on('click', '.del-category', function(e) {
        e.preventDefault();
        var t = $(this);
        var id = t.data('id');

        swal({
            title: 'Hapus Kategori',
            text: "Anda akan menghapus '" + t.data('name') + "' ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then(function(isConfirm) {
            if (isConfirm === true) {
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url : 'index.php/xhr/category_delete',
                    data : {id:id,csrf_kb_name:csrf_kb_name},
                })
                .done(function(response) {
                    // console.log(response.message);
                    if (response.status == true) {
                        swal('Terhapus!', response.message, 'success');
                        setTimeout(function(){
                            $('.btn-refresh').trigger('click');
                        }, 1000);
                    }else{
                        swal('Uppss!', response.message, 'error');
                    }
                })
                .fail(function(response){
                    swal('Uppss!', 'Terjadi sesuatu, muat ulang :(', 'error');
                });
            } 
        }).catch(swal.noop)
    });
    
})(jQuery); // End of use strict