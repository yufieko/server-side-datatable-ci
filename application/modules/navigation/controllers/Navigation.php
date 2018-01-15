<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation extends MX_Controller {

	function __construct()
    {
        parent::__construct();
    }

    /**
     * index function
     * @return none
     */
	public function index()
	{
		
	}

	public function dashboard() 
	{
		// load model
		$this->load->model('dashboard_nav_model');
		// set an array variable
		$menus = array();

		// get parent menu 
		$parents = $this->dashboard_nav_model->getAllWithCondition(
			array(
				'active' => 1,
				'parent_id' => NULL
			)
		);

		$i = 0;

		foreach ($parents as $parent) {
			$childs = $this->dashboard_nav_model->getAllWithCondition(
				array(
					'active' => 1,
					'parent_id' => $parent->id
				)
			);

			$isEligible = empty($parent->access_id) ? true : $this->common_model->isEligibleID($this->session->user_id,$parent->access_id,'read')->status;
    		if (!$isEligible) {
    			continue;
    		}

			$menus[$i] = array(
				'name' => $parent->name,
				'alias' => $parent->alias,
				'slug' => $parent->slug,
				'is_link' => $parent->is_link == 1 ? true : false,
				'icon' => $parent->icon,
				'have_child' => false
			);

			if(!empty($childs)) {
				$j = 0;
				$cc = array();
				foreach ($childs as $child) {
					$extra_childs = $this->dashboard_nav_model->getAllWithCondition(
						array(
							'active' => 1,
							'parent_id' => $child->id
						)
					);

					$isEligible = empty($child->access_id) ? true : $this->common_model->isEligibleID($this->session->user_id,$child->access_id,'read')->status;
		    		if (!$isEligible) {
		    			$cc[] = false;
		    			continue;
		    		}

		    		$cc[] = true;
					$menus[$i]['childs'][$j] = array(
						'name' => $child->name,
						'alias' => $child->alias,
						'slug' => $child->slug,
						'is_link' => $child->is_link == 1 ? true : false,
						'have_child' => false
					);

					if(!empty($extra_childs)) {
						$k = 0;
						unset($cc);
						$cc = array();
						foreach ($extra_childs as $extra) {
							$isEligible = empty($extra->access_id) ? true : $this->common_model->isEligibleID($this->session->user_id,$extra->access_id,'read')->status;
				    		if (!$isEligible) {
				    			$cc[] = false;
				    			continue;
				    		}

				    		$cc[] = true;
							$menus[$i]['childs'][$j]['extra_childs'][$k++] = array(
								'name' => $extra->name,
								'alias' => $extra->alias,
								'slug' => $extra->slug,
								'is_link' => $extra->is_link == 1 ? true : false
							);
						}

						if(in_array(true, $cc)) {
							$menus[$i]['childs'][$j]['have_child'] = true;
						}
					}
					$j++;
				}

				if(in_array(true, $cc)) {
					$menus[$i]['have_child'] = true;
				}
			}

			$i++;
		}

		$data['menus'] = $menus;

		$this->load->view('dashboard_nav', $data);
	}
}
