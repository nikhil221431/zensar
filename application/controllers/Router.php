<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/router
	 *	- or -
	 * 		http://example.com/index.php/router/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/router/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('form_validation');

		$this->load->model('router_model');

		$this->validateLogin();
    }

	public function index()
	{
		redirect("Router/routerInfo");
	}

	public function validateLogin(){

		$this->load->model('validate_model');
		$result = $this->validate_model->validate();
		
		if($result->output == "FALSE"){

			redirect("login");
		}
	}

	public function routerInfo(){

		$data['routerInfo'] = $this->router_model->routerInfo();

		$this->load->view('header');
		$this->load->view('routerInfo', $data);
		$this->load->view('footer');
	}

	public function createRouter(){

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

      if(isset($_FILES["routersDetails"])){

				$filename=$_FILES["routersDetails"]["tmp_name"];

				if($_FILES["routersDetails"]["size"] > 0){

					$routersDetails = array();
					$file = fopen($filename, "r");

					while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

						if($getData[0] == "Sapid"){

							continue;
						}

						$routerDetail = array(
								                    'sapid'       => $getData[0],
								                    'hostname'    => $getData[1],
								                    'loopback'    => $getData[2],
								                    'mac_address' => $getData[3],
								                    'created_by'  => $this->session->userdata('userid')
									                );
						array_push($routersDetails, $routerDetail);
					}
					fclose($file);
				  
				  if(!empty($routersDetails)){

				  	$result = $this->router_model->createRouterSave($routersDetails);
				  	if($result->output == "FALSE"){

				  		$data['error'] = $result->message;
							$this->load->view('header');
							$this->load->view('createrouter', $data);
							$this->load->view('footer');
				  	}
				  	else {

				  		redirect('Router/confirmation');	
				  	}
				  }
				  else {

				  	$data['error'] = "Please Enter Details";
						$this->load->view('header');
						$this->load->view('createrouter', $data);
						$this->load->view('footer');				  	
				  }
				}
			}   
		} 
		else {

			$this->load->view('header');
			$this->load->view('createrouter');
			$this->load->view('footer');
		}

	}

  public function confirmation(){

  	if ($this->input->server('REQUEST_METHOD') === 'POST') {

  		$result = $this->router_model->confirmationSave($_POST);
	  	if($result->output == "FALSE"){

	  		$data['error'] = $result->message;
				$this->load->view('header');
				$this->load->view('confirmRouterDetails', $data);
				$this->load->view('footer');
	  	}
	  	else {

	  		redirect('Router/routerInfo');	
	  	}
  	}
  	else {

			$data['routerInfo'] = $this->router_model->confirmation();
			$this->load->view('header');
			$this->load->view('confirmRouterDetails', $data);
			$this->load->view('footer');
  	}
	}

	public function deleteRouterData() {

		$routerDetailId  = $this->input->get_post("routerDetailId");
		$result  = $this->router_model->deleteRouterData($routerDetailId);

		echo json_encode($result);
	}

	public function logoutuser(){

		$this->session->sess_destroy();
		redirect("login");
	}
}
