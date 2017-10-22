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
    
    // public function idMiembro($data){
	// 	$this->mysqli->multi_query(" CALL idMiembro(".$data.")");
	// 		$res = $this->db_pdo->store_result();
	// 		$res = $res->fetch_array();
	// 		mysqli_close($this->mysqli);
	// 		$res = array("message"=>$res[0],"response"=>true);
	// 		return $res;
	// }

	public function listClients(){
		$res = $this->db_pdo->query("SELECT * FROM show_me_clients()")
                         ->fetchAll();
        $res = array("message"=>$res,"response"=>true);
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