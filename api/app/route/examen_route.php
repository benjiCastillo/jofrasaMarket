<?php 
use App\Lib\Response;

	$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
$app->group('/examen',function(){

	$this->get('/',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Examen->listar())
				   	);	
	});

	$this->get('/testList/',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Examen->listarExamenes())
				   	);	
	});

	$this->get('/{id}',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Examen->getExamen($args['id']))
				   		
				   	);
	});
	$this->get('/listalltest/',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Examen->listAllTest())
				   		
				   	);
	});

	$this->get('/testListPac/{id}',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Examen->listarExamenesPac($args['id']))
				   		
				   	);
	});
	/* Listar examenes por id de examen */
	$this->get('/listExamenPaciente/{id}',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Examen->listExamenPaciente($args['id']))
				   		
				   	);
	});

	$this->post('/',function($req, $res, $args){

		return $res->withHeader('Content-type', 'aplication/json')
			       -> write(
						json_encode($this->model->Examen->insert($req->getParsedBody()))

				   	);
	});

	$this->post('/insertType/',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
			       -> write(
						json_encode($this->model->Examen->insertarTipo($req->getParsedBody()))

				   	);
	});

	
	$this->post('/insertTest/',function($req, $res, $args){

		return $res->withHeader('Content-type', 'aplication/json')
			       -> write(
						json_encode($this->model->Examen->insertTest($req->getParsedBody()))
				   	);
	});


	$this->put('/{id}',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Examen->update($req->getParsedBody(), $args['id'] ))
				   		
				   	);
	});

	$this->delete('/{id}',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Examen->delete($args['id']))
				   		
				   	);

	});
});	
// })->add(new AuthMiddleware($app)); //agregar middleware

 ?>