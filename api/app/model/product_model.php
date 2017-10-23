<?php 

namespace App\Model;

use App\Lib\Response,
	App\Lib\Security;

/**
* Modelo usuario
*/
class  ProductModel
{
	private $db;
	private $table = 'product';
	private $response;



	public function __CONSTRUCT($db_pdo){
		$this->db_pdo   = $db_pdo;
		$this->response = new Response();
		$this->security = new Security();
	}

	//getOne
    public function get($id){
        return $data = $this->db->from($this->table, $id)
                            ->fetch();  						 
    }
    
    //listALL
	public function listProduct(){
		$res = $this->db_pdo->query("SELECT * FROM ")
                         ->fetchAll();
        $res = array("message"=>$res,"response"=>true);
        return $res;
    }



}


 ?>