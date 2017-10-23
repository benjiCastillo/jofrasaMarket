<?php 

namespace App\Model;

use App\Lib\Response,
	App\Lib\Security;

/**
* Modelo usuario
*/
class  ProviderModel
{
	private $db;
	private $table = 'provider';
	private $response;



	public function __CONSTRUCT($db_pdo){
		$this->db_pdo   = $db_pdo;
		$this->response = new Response();
		$this->security = new Security();
	}

	//getOne
    public function getProvider($id){
        $res = $this->db_pdo->query("SELECT * FROM  products_provider($id)")
                                   ->fetchAll();				 
        if($res == [])
            $res = array("data"=>0,"response"=>true,"message"=>"not exist products of provider");
        else
            $res = array("data"=>$res,"response"=>true);                 
                              
        return $res;
    }
    
    //listALL
	public function listProviders(){
		$res = $this->db_pdo->query("SELECT * FROM  providers()")
                            ->fetchAll();
        if($res == [])
            $res = array("data"=>0,"response"=>true,"message"=>"not exist providers");
        else
        $res = array("data"=>$res,"response"=>true);                 
       
        return $res;
    }



}


 ?>