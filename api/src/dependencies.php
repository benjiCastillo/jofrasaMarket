<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
//Database
$container['db'] = function ($c) {
	$connectionString = $c->get('settings')['connectionString'];

	$pdo = new PDO($connectionString['dns'],$connectionString['user'],$connectionString['pass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

	return new FluentPDO($pdo);
};


$container['db_mysqli'] = function ($c) {
	$connectionString = $c->get('settings')['connectionString'];

	$mysqli = new mysqli($connectionString['host'], $connectionString['user'], $connectionString['pass'], $connectionString['name_db']);
	$mysqli->set_charset("utf8");
	return $mysqli;
};

$container['db_pdo'] = function ($c) {
	$connectionString = $c->get('settings')['connectionString'];

	$pdo = new PDO($connectionString['dns'],$connectionString['user'],$connectionString['pass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

	return $pdo;
};
// Models

$container['model']	= function($c){

	return (object)[
		'Biometria'	=>	new App\Model\BiometriaModel($c->db,$c->db_mysqli),
		'Examen'	=>	new App\Model\ExamenModel($c->db,$c->db_mysqli),
		'ExamenGeneral'	=>	new App\Model\ExamenGeneralModel($c->db,$c->db_mysqli),
		'InformesG'	=>	new App\Model\InformesGModel($c->db,$c->db_mysqli),
		'Medico'	=>	new App\Model\MedicoModel($c->db,$c->db_mysqli),
		'Paciente'	=>	new App\Model\PacienteModel($c->db,$c->db_mysqli),
		'ReaccionW'	=>	new App\Model\ReaccionWModel($c->db,$c->db_mysqli),
		'User'	=>	new App\Model\UserModel($c->db,$c->db_mysqli)
	];
};



