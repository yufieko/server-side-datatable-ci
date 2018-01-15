<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Controller extends MX_Controller
{
	protected $notifications = null;
	protected $data = array();

	function __construct()
	{
		parent::__construct();

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