<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Xhr extends MX_Controller {
    public function __construct() 
    {
        parent::__construct();
        setlocale(LC_TIME, 'id_ID');
        setlocale(LC_TIME, 'INDONESIA');
        setlocale(LC_TIME, 'id_ID.utf8');
    }

    public function index() 
    {
        redirect('','refresh');
    }

    /**
     * category ajax list for datatable
     * @return json
     */
    public function category_ajax_list()
    {
        if ( @$_SERVER['REQUEST_METHOD'] !== 'POST' && !$this->input->is_ajax_request() && !$this->ion_auth->logged_in() ) {
            die("method not allowed");
        }

        // load datatable model
        $this->load->model('datatable/category_model','dt');

        // get data
        $no = $_POST['start'];
        $list = $this->dt->get_datatables();

        // set array
        $data = array();

        foreach ($list as $item) {
            $row = array();

            $option = '<div class="btn-group" role="group" style="display:flex;float:right">
                            <a data-original-title="Edit" href="#" class="btn btn-primary waves-effect edit-category" data-id="'.$item->id.'">Edit</a>
                            <a href="#" data-original-title="Hapus" class="btn btn-pink waves-effect del-category" data-id="'.$item->id.'" data-name="'.htmlspecialchars($item->name).'">Hapus</a>
                        </div>';
            $row[] = $item->name;
            $row[] = date("Y-m-d H:i",strtotime($item->created));
            $row[] = empty($item->modified) ? '-' : date("Y-m-d H:i",strtotime($item->modified));
            $row[] = $option;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dt->count_all(),
            "recordsFiltered" => $this->dt->count_filtered(),
            "data" => $data,
        );

        // output to json format
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($output));
    }

    /**
     * category popular ajax list for datatable
     * @return json
     */
    public function category_pop_ajax_list()
    {
        if ( @$_SERVER['REQUEST_METHOD'] !== 'POST' && !$this->input->is_ajax_request() && !$this->ion_auth->logged_in() ) {
            die("method not allowed");
        }

        // load datatable model
        $this->load->model('datatable/category_popular_model','dt');

        // get data
        $no = $_POST['start'];
        $list = $this->dt->get_datatables();

        // set array
        $data = array();

        foreach ($list as $item) {
            $row = array();

            $row[] = $item->name;
            $row[] = $item->total;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dt->count_all(),
            "recordsFiltered" => $this->dt->count_filtered(),
            "data" => $data,
        );

        // output to json format
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($output));
    }

    /**
     * edit view for category - ajax
     * @return json
     */
    public function view_edit_category() 
    {
        if ( @$_SERVER['REQUEST_METHOD'] !== 'POST' && !$this->input->is_ajax_request() ) {
            die("method not allowed");
        }

        // set rules
        $this->form_validation->set_rules('id', 'ID Kategori', 'required|trim|is_natural_no_zero');
    
        // validate
        if ($this->form_validation->run() === true) {
            // load model
            $this->load->model('category_model');

            // get data
            $id = $this->input->post('id');
            $data = $this->category_model->selectById($id);

            if(!empty($data)) {
                $view = '<div class="form-group form-float">
                            <label class="form-label">Nama</label>
                            <div class="form-line">
                                <input type="text" class="form-control" data-target=".slug-edit" name="name" value="'.$data->name.'" required>
                                <input type="hidden" name="id" value="'.$data->id.'" required readonly>
                            </div>
                        </div>

                        <label class="form-label">Slug</label>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control slug-edit" name="slug" value="'.$data->slug.'" required>
                            </div>
                        </div>';

                $result = array(
                    'status' => true,
                    'data' => $view,
                    'message' => 'loaded'
                );
            } else {
                $result = array(
                    'status' => false,
                    'message' => '<div class="alert alert-danger alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Kategori tidak ditemukan. (ER: '.$this->router->fetch_method().' - cek data kategori)</div>'
                );
            }
        } else {
            $result = array(
                'status' => false,
                'message' => '<div class="alert alert-danger alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>'.validation_errors().'</div>'
            );
        }
        
        // output to json format    
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($result));
    }

    /**
     * function to handle insert or update on category
     * @return json
     */
    public function category_save()
    {
        if ( @$_SERVER['REQUEST_METHOD'] !== 'POST' && !$this->input->is_ajax_request() ) {
            die("method not allowed");
        }

        // set rules
        $this->form_validation->set_rules('id', 'ID Kategori', 'required|is_natural');
        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('slug', 'Slug', 'required|min_length[3]|max_length[50]');
    
        // validate
        if ($this->form_validation->run() === true) {
            // load model
            $this->load->model('category_model');

            // get id
            $id = $this->input->post('id');

            // get other datas
            $raw = array(
                'name' => $this->input->post('name'),
                'slug' => url_title($this->input->post('slug'),'-',true)
            );

            if(empty($id)) {
                $category = false;
            } else {
                // check id on database
                $category = $this->category_model->selectById($id);
            }
    
            // new
            if(empty($category)) {
                // set other datas
                $raw['created'] = date('Y-m-d H:i:s');

                // begin insert data to database
                $id = $this->category_model->insert($raw);

                // if success
                if(!empty($id)) {
                    $result = array(
                        'status' => true,
                        'message' => '<div class="alert alert-success alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Kategori baru berhasil disimpan.</div>'
                    );
                } else {
                    $result = array(
                        'status' => false,
                        'message' => '<div class="alert alert-danger alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Gagal menyimpan ke basis data. (ER: '.$this->router->fetch_method().' - baru ke basis data)</div>'
                    );
                }
            } else { // edit
                $raw['modified'] = date('Y-m-d H:i:s');

                // begin update to database
                $update = $this->category_model->update($id,$raw);

                if(!empty($update)) {
                    $result = array(
                        'status' => true,
                        'message' => '<div class="alert alert-success alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Kategori berhasil diperbarui.</div>'
                    );
                } else {
                    $result = array(
                        'status' => false,
                        'message' => '<div class="alert alert-danger alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Gagal menyimpan ke basis data. (ER: '.$this->router->fetch_method().' - edit ke basis data)</div>'
                    );
                }
            }
        } else {
            $result = array(
                'status' => false,
                'message' => '<div class="alert alert-danger alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>'.validation_errors().'</div>'
            );
        }

        // output to json format
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($result));
    }

    /**
     * function to handle delete category request
     * @return json
     */
    public function category_delete()
    {
        if ( @$_SERVER['REQUEST_METHOD'] !== 'POST' && !$this->input->is_ajax_request() ) {
            die("method not allowed");
        }

        // set rules
        $this->form_validation->set_rules('id', 'ID Kategori', 'required|is_natural_no_zero');
    
        // validate
        if ($this->form_validation->run() === true) {
            // load model
            $this->load->model('category_model');

            // get id
            $id = $this->input->post('id');

            // check id on database
            $category = $this->category_model->selectById($id);
            
            // if data not found
            if(empty($category)) {
                $result = array(
                    'status' => false,
                    'message' => 'Data tidak ditemukan. (ER: '.$this->router->fetch_method().')'
                );
            } else { // data found
                // begin delete data on database
                $delete = $this->category_model->delete($id);

                // if success
                if(!empty($delete)) {
                    $result = array(
                        'status' => true,
                        'message' => 'Data berhasil dihapus.'
                    );
                } else {
                    $result = array(
                        'status' => false,
                        'message' => 'Gagal menghapus data di basis data. (ER: '.$this->router->fetch_method().')'
                    );
                }
            }
        } else {
            $result = array(
                'status' => false,
                'message' => validation_errors()
            );
        }

        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($result));
    }
}