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
	public function listProduct($data){
		$res = $this->db_pdo->query("SELECT * FROM products_provider(".$data.")")
                         ->fetchAll();
        $res = array("data"=>$res,"response"=>true);
        return $res;
	}
	
	public function listShopping($data){
		$res = $this->db_pdo->query("SELECT * FROM list_shopping('".$data."')")
                         ->fetchAll();
        $res = array("data"=>$res,"response"=>true);
        return $res;
	}

	public function countProducts($data){
		$res = $this->db_pdo->query("SELECT * FROM count_products('".$data."')")
		->fetchAll();
		if($res[0]->count_products==0){
			$res = array("data"=>"Carrito vacío", "error"=>"not", "response"=>true);
		}else
		{
			if($res[0]->count_products==-1){
				$res = array("data"=>"Error, usuario no registrado", "error"=>"yes", "response"=>true);
			}
			else
				$res = array("data"=>$res[0]->count_products, "error"=>"yes", "response"=>true);
		}	
		return $res;
	}
}


 ?>