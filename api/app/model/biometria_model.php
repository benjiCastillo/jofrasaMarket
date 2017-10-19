<?php 

namespace App\Model;

use App\Lib\Response,
	App\Lib\Security;

/**
* Modelo usuario
*/
class  BiometriaModel
{
	private $db;
	private $table = 'biometria';
	private $response;



	public function __CONSTRUCT($db, $db_pdo){
		$this->db 		= $db;
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
	//  return $data = $this->db_pdo->query('select * from '.$this->table)
	//					 			->fetchAll();				   						 
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
	//obtener
	public function getBiometria($id){

		return $data = $this->db->from($this->table, $id)
								->fetch();  						 
	}
	//registrar

	public function insert($data){
		// $data['password'] = md5($data['password']);

		$this->db_pdo->insertInto($this->table, $data)
				 ->execute();

		return $this->response->setResponse(true);
		}

		public function insertBio($data){

		//$this->db->insertInto($this->table, $data)
		//		 ->execute();
		$this->db_pdo->multi_query(" CALL insertarBiometria('".$data['_hematies']."',
														'".$data['_hematocrito']."',
														'".$data['_hemoglobina']."',
														'".$data['_leucocitos']."',
														'".$data['_vsg']."',
														'".$data['_vcm']."',
														'".$data['_hbcm']."',
														'".$data['_chbcm']."',
														'".$data['_comentario_hema']."',
														'".$data['_cayados']."',
														'".$data['_neutrofilos']."',
														'".$data['_basofilo']."',
														'".$data['_eosinofilo']."',
														'".$data['_linfocito']."',
														'".$data['_monocito']."',
														'".$data['_prolinfocito']."',
														'".$data['_cel_inmaduras']."',
														'".$data['_comentario_leuco']."')");
			$res = $this->db_pdo->store_result();
			$res = $res->fetch_array();
			mysqli_close($this->db_pdo);
			$res = array("message"=>$res[0],"response"=>true);
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

			$this->db_pdo->multi_query(" CALL eliminarBiometria('".$id."')");
			$res = $this->db_pdo->store_result();
			$res = $res->fetch_array();
			mysqli_close($this->db_pdo);
			$res = array("message"=>$res[0],"response"=>true);
			return $res;	 	 
	}


}


 ?>