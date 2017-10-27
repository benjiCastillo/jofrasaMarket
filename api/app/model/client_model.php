<?php 

namespace App\Model;

use App\Lib\Response,
	App\Lib\Security;

/**
* Modelo usuario
*/
class  ClientModel
{
	private $db;
	private $table = 'client';
	private $response;



	public function __CONSTRUCT($db_pdo){
		$this->db_pdo   = $db_pdo;
		$this->response = new Response();
		$this->security = new Security();
	}

	//var $l => 'limit', $p => 'pagina'

	//lista_total
	public function listar(){

		return $data = $this->db->from($this->table)
						 ->orderBy('id DESC')
						 ->fetchAll();
	//  return $data = $this->mysqli->query('select * from '.$this->table)
	// 					 			->fetchAll();				   						 
    }
    
    public function getClient($id){
        
                return $data = $this->db->from($this->table, $id)
                                        ->fetch();  						 
            }
	//listar paginado
	//parametros de limite, pagina
	public function paginated($l, $p){	
		$p = $p*$l;
		$data = $this->db->from($this->table)
						 ->limit($l)
						 ->offset($p)
						 ->orderBy('id desc')
						 ->fetchAll();

		$total = $this->db->from($this->table)
						  ->select('COUNT(*) Total')
						  ->fetch()
						  ->Total;

		return [
			'data'	=>   $data,
			'total' =>   $total

		];				  						 
    }

	public function listClients(){
		$res = $this->db_pdo->query("SELECT * FROM client")
                         ->fetchAll();
        $res = array("data"=>$res,"response"=>true);
        return $res;
	}

	public function insertClient($data){
		$res = $this->db_pdo->query("SELECT * FROM insert_client('".$data['_name']."',
													'".$data['_surname']."',
													'".$data['_nit']."',
													'".$data['_email']."',
													'".$data['_adress']."',	
													'".$data['_cell_number']."',
													'".$data['_phone_number']."')")
		->fetchAll();
		if($res[0]->insert_client==1){
			$res = array("data"=>"Usuario insertado correctamente", "error"=>"not", "response"=>true);
		}
		if($res[0]->insert_client==2){
			$res = array("data"=>"El usuario ya existe", "error"=>"yes", "response"=>true);
		}
		return $res;
	}

	public function insertShopping($data){
		$res = $this->db_pdo->query("SELECT * FROM insert_shopping_cart('".$data['_id_product']."',
													'".$data['_nit']."',
													'".$data['_quantity']."')")
		->fetchAll();
		if($res[0]->insert_shopping_cart==1){
			$res = array("data"=>"Producto añadido al carrito correctamente", "error"=>"not", "response"=>true);
		}
		if($res[0]->insert_shopping_cart==2){
			$res = array("data"=>"Cantidad de producto aumentada correctamente", "error"=>"not", "response"=>true);
		}
		if($res[0]->insert_shopping_cart==3){
			$res = array("data"=>"El producto no existe", "error"=>"yes", "response"=>true);
		}
		if($res[0]->insert_shopping_cart==4){
			$res = array("data"=>"El usuario no existe", "error"=>"yes", "response"=>true);
		}
		return $res;
	}

	//actualizar
	public function update($data, $id){

		$this->db->update($this->table, $data, $id)	
				 ->execute();

		return $this->response->setResponse(true);		 
	}
	//eliminar
	public function delete($id){

		$this->db->deleteFrom($this->table, $id)	
				 ->execute();

		return $this->response->setResponse(true);		 
	}


}


 ?>