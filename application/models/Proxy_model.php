<?php
class Proxy_model extends CI_Model {


	function __construct()
	{
		parent::__construct();
	}

	public function NewId(){
		$query = $this->db->query("SELECT UUID() AS `id`");
		$row = $query->row_array();
		return $row["id"];
	}

	public function rewrite(){

		$uid = 'f1921-17d2fd-1721';
		$dominios = $this->Proxy_model->getEnabled($uid);
		if($dominios){

			$data = null;

			foreach ($dominios as $row) {
				$data.= $row['site']."\r\n";
			}

			$archivo = (fopen('noway.txt', 'w'));

			if($archivo){

				fputs($archivo, $data);
				$this->execSquid(); 
			}

			fclose($archivo);

		}
		else {
			return false;
		}
		
	}
	public function execSquid(){

		//exec('"C:\Windows\system32\notepad.exe" "C:\xampp\htdocs\Squid-proxy\noway.txt"');
		$output = shell_exec ('start "puto" /D "C:/squid/sbin/" /B "squid" -n Squid -k reconfigure');

	}
	public function post($dominio)
	{
		$uid = 'f1921-17d2fd-1721';
		$id = $this->NewId();
		$parameters = array('uid'=> $uid, 'id' => $id, 'site_name'=>$dominio, 'is_enabled'=> 1);
		$this->db->insert('regex_sites', $parameters);

		$rows = $this->db->affected_rows();
			
			if($rows > 0){

				$result = $this->Proxy_model->get();
				return $result;
				$this->rewrite();
			}
			else {
				return false; 
			}
	}

	public function get()
	{
		$uid = 'f1921-17d2fd-1721';
		$query = $this->db->query("SELECT id as `itemid`, `site_name` as `site`, `is_enabled` as `status` FROM regex_sites WHERE UPPER(uid)=UPPER(".$this->db->escape($uid).")");
		
		if($query->num_rows()>0){

			$result = $query->result_array();	
		}
		else {
			$result = false; 
		}
		
		return $result;
	}

	public function put($data) {

		$parameters = array('site_name'=> $data['site'], 'is_enabled'=>$data['is_enabled']);

		$this->db->where('id', $data['id']);
		$this->db->where('uid', $data['uid']);
		$this->db->update('regex_sites', $parameters);
			
			 $e = $this->db->error(); // Gets the last error that has occured
			 $num = $e['code'];

			 if($num ==0)
			 {
			 	$result = TRUE;
			 	$this->rewrite();
			 }
			 else {
			 	$result = FALSE; 
			 }

			 return $result; 
	}
	
	public function delete($id){

		$this->db->where('id', $id);
		$this->db->delete('regex_sites');

		$rows = $this->db->affected_rows();
			
			if($rows > 0){

				return true;
				$this->rewrite();  
			}
			else {
				return false; 
			}


	}
	public function getEnabled($uid)
	{
		$query = $this->db->query("SELECT `site_name` as `site`, `is_enabled` as `status` FROM regex_sites WHERE UPPER(uid)=UPPER(".$this->db->escape($uid).") and `is_enabled`= 1");
		
		if($query->num_rows()>0){

			$result = $query->result_array();	
		}
		else {
			$result = false; 
		}
		
		return $result;
	}

	public function getById($id){

		$uid = 'f1921-17d2fd-1721';
		$query = $this->db->query("SELECT `site_name` as `site`, `is_enabled` as `status` FROM regex_sites WHERE UPPER(uid)=UPPER(".$this->db->escape($uid).") and UPPER(id)=UPPER(".$this->db->escape($id).")");
		
		if($query->num_rows()>0){

			$result = $query->result_array();	
		}
		else {
			$result = false; 
		}
		
		return $result;
	}
	

}
?>
