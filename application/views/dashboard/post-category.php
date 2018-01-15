            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <a href="#" class="btn bg-teal waves-effect" data-toggle="modal" data-target="#modal-create">Kategori Baru</a>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li>
                                    <a href="javascript:void(0);" class="btn-refresh" data-toggle="cardloading" data-loading-effect="rotation" data-loading-color="lightGreen">
                                        <i class="material-icons">loop</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="msg"><?=@$message?></div>
                            <table id="category-table" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Dibuat</th>
                                        <th>Dimodifikasi</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Dibuat</th>
                                        <th>Dimodifikasi</th>
                                        <th>Opsi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-teal">
                            <h2>
                                Kategori Populer
                            </h2>
                        </div>
                        <div class="body">
                            <table id="category-popular-table" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
            <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-cyan">
                            <h4 class="modal-title" id="defaultModalLabel">Edit Kategori</h4>
                        </div>
                        <?php echo form_open('#',array('id' => 'form-edit','data-loading-effect' => 'pulse','novalidate' => 'novalidate')); ?>
                        <div class="modal-body">
                            <div class="form-message" style="display:none"></div>
                            <div class="container-edit"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-green waves-effect">SIMPAN</button>
                            <button type="button" class="btn bg-gray waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-create" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-cyan">
                            <h4 class="modal-title" id="defaultModalLabel">Kategori Baru</h4>
                        </div>
                        <?php echo form_open('#',array('id' => 'form-create','data-loading-effect' => 'pulse','novalidate' => 'novalidate')); ?>
                        <div class="modal-body">
                            <div class="form-message" style="display:none"></div>
                            <div class="form-group form-float">
                                <label class="form-label">Nama</label>
                                <div class="form-line">
                                    <input type="text" class="form-control name" data-target=".slug-create" name="name" required>
                                    <input type="hidden" name="id" value="0" required readonly>
                                </div>
                            </div>

                            <label class="form-label">Slug</label>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control slug-create" name="slug" required>
                                </div>
                            </div>

                            <label class="form-label">Status</label>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick" name="status" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="1">Publish</option>
                                        <option value="4">Trash</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-green waves-effect">SIMPAN</button>
                            <button type="button" class="btn bg-gray waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
