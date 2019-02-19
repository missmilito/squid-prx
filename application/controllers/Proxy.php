<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proxy extends CI_Controller {

	public function __construct()
	{	/*header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}*/
		parent::__construct();

		$this->load->model('Proxy_model');
	}

	public function index()
	{
		$this->load->view('proxyview.php');
	}

	public function post(){

		if($_POST['dominio'])
		{
			$dominio = $_POST['dominio'];
			$dominios = $this->Proxy_model->post($dominio);
			return print json_encode($dominios);
			
		}
		else {
			return false;
		}

	}
	public function get(){

		$dominios = $this->Proxy_model->get();
		if($dominios){

			return print json_encode($dominios);
		}
		else {
			return false;
		}
	}

	

	public function updateSite(){

		$uid = 'f1921-17d2fd-1721';
		if(isset($_POST['itemid'])&&isset($_POST['edit-name'])&&isset($_POST['edit-status']))
		{

			$dominio = $_POST['edit-name'];
			$status = $_POST['edit-status'];
			$id = $_POST['itemid']; 

			$data = array("uid"=> $uid, "id"=> $id , "site"=>$dominio, "is_enabled" => $status);
			$result = $this->Proxy_model->put($data);

			if($result){
				$result = array('resultado' => TRUE );
			}
			else {
				$result = array('resultado' => FALSE );		
			}
			return print json_encode($result);
			
		}
	}

	public function deleteSite()
	{
		if(isset($_POST['itemidDelete'])){

			$id = $_POST['itemidDelete'];

			$result = $this->Proxy_model->delete($id);

			if($result){
				$result = array('resultado' => TRUE );
			}
			else {
				$result = array('resultado' => FALSE );		
			}
			return print json_encode($result);
			
		}			
	}

	public function getById($id){

		$dominios = $this->Proxy_model->getById($id);
		if($dominios){
			return print json_encode($dominios);
		}
		else {
			return false;
		}
	}


	
}
