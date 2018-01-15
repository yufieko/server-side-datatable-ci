<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Dashboard_Controller {
	protected $menu = array();
  	private $module = null;
  	private $model = null;

    public function __construct() 
    {
        parent::__construct();

        $this->module = 'post';
    	$this->title = 'Artikel';
    	$this->model = $this->module.'_model';
		$this->menu['parent'] = $this->module;
        $this->menu['child'] = '';
    	$this->menu['extra'] = '';
    }

    /**
     * category index page
     * @return view
     */
    public function index() 
    {
        $this->menu['child'] = $this->module.'-category';
        $this->data['menu'] = $this->menu;
        $this->data['title'] = 'Kategori';
        $this->data['title_desc'] = 'Laman manajemen kategori';
        $this->data['meta_description'] = 'Laman manajemen kategori';  
        $this->data['datatable'] = true;

        web_title('Goodadmin / Kategori');
        web_build('dashboard/post-category', $this->data);
    }
}