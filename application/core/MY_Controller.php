<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{
	protected $notifications = null;
	protected $data = array();

	function __construct()
	{
		parent::__construct();

    	if (!$this->ion_auth->logged_in()) {

			/*$uri = uri_string();
			if($uri !== "dasbor") {
				$this->data['message'] = '<div class="alert alert-warning alert-dismissible" role="alert"><span class="close" data-dismiss="alert">&times;</span>Anda harus masuk terlebih dahulu untuk mengakses laman ini</div>';
			}
			
			$this->data['title'] = 'Masuk - Dasbor KB';
	        $this->data['meta_description'] = 'Laman untuk masuk ke Dasbor Keluarga Indonesia - BKKBN';*/
	        $result = array(
	        	'message_type' => 'warning',
	        	'message_content' => 'Anda harus masuk terlebih dahulu untuk mengakses laman tersebut'
	        );

			$this->session->set_flashdata($result);
			$this->session->set_userdata( array('referrer_url' => current_url()) );

			redirect('masuk','refresh');
        	// $this->load->view('auth/login',$this->data);
    	}

    	$this->data['datatable'] = false;
    	$this->data['content_type'] = 'list';
		$this->data['title_desc'] = 'it all starts here';
		$this->theme();
		setlocale(LC_TIME, 'id_ID');
        setlocale(LC_TIME, 'INDONESIA');
        setlocale(LC_TIME, 'id_ID.utf8');
    }

    public function theme()
  	{
	    /************************************************
	     * Set the template view to use
	     *************************************************/

	    // set the theme 'default_theme' is a dir name where you put your theme file
		$this->template->set_theme('dashboard');

		// set parser off, because there is an error when pass object data with this on
	    $this->template->enable_parser(false);

	    // set the layout 'backend' is the file name resided in application/themes/default_theme/views/layouts/
	    $this->template->set_layout('frontend' . '/default');

	    // load the header blocks
	    $this->template->set_partial('navigation','partials/dashboard/navigation');

	    // load the header blocks
	    $this->template->set_partial('header','partials/dashboard/header');

	    // load the footer blocks
	    $this->template->set_partial('footer','partials/dashboard/footer');

	    return $this;
  	}

}
