<?php
require_once('lib/nusoap.php');
require_once('lib/adodb.inc.php');

$namespace = "http://library-soap-pvspaiva.c9users.io/server/libraryServer.php?wsdl";
$server = new soap_server();
$server->configureWSDL('library');
$server->wsdl->schemaTargetNamespace = $namespace;

$servername = "localhost";
$dbname = "library";
$username = "pvspaiva";
$password = "";

$server->wsdl->addComplexType(
  'ArrayOfString',
  'complexType',
  'array',
  'sequence',
  '',
  array(
    'book' => array(
		'id'=> 'xsd:string',
	    'codigo'=> 'xsd:string',
	    'titulo'=> 'xsd:string',
	    'editora'=> 'xsd:string',
	    'isbn'=> 'xsd:string',
	    'edicao'=> 'xsd:string',
	    'autor'=> 'xsd:string'
    )
  )
);

//First Start
$createdb = false;

if (createdb) {
    $db = &ADONewConnection('mysqlt');
    
    $db->Connect($servername, $username, $password, $dbname);
    
    $sql = "CREATE TABLE books (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50),
    titulo VARCHAR(50),
    editora VARCHAR(50),
    isbn VARCHAR(50),
    edicao VARCHAR(50),
    autor VARCHAR(50)
    );";
    
    $rs = $db->Execute($sql);
    
    $sql = "INSERT INTO books (id, codigo, titulo, editora, isbn, edicao, autor) VALUES 
	(1, '8599','C++ By Example', 'Arqueiro', 'PR-123-A1', '1', 'John'),
	(2, '2964', 'Java Book', 'Saraiva', 'PR-456-A2', '3', 'Jane davis'),
	(3, '6493', 'Database Management Systems', 'BIT Editora', 'DB-123-ASD', '2', 'Mark'),
	(4, '9296', 'Harry Potter and the Order of the Phoenix', 'Rocco', 'FC-123-456', '1', 'J.K. Rowling'),
	(5, '8532', 'Data Structures', 'Editora 1', 'FC-456-678', '2', 'author 5');";
	
	$rs = $db->Execute($sql);
}

$server->register('library_books'
				,array()
            	,array('return'=>'tns:ArrayOfString')
            	,$namespace,false
            	,'rpc'
            	,'encoded');

function library_books() {
    
    $db = &ADONewConnection('mysqlt');
    
    $db->Connect("localhost", "pvspaiva", "", "library");
    
    $sql = "SELECT * FROM books;";
    
    $rs = $db->Execute($sql);
    
    $result = $rs->GetArray();
    
    foreach($result as $row=>$value)
   	{ 
		$return_value[] = array(
				    'id'=> $value['id'],
				    'codigo'=> $value['codigo'],
				    'titulo'=> $value['titulo'],
				    'editora'=> $value['editora'],
				    'isbn'=> $value['isbn'],
				    'edicao'=> $value['edicao'],
				    'autor'=> $value['autor']
				    );
	}
	
	return $return_value;
}

$server->register('library_books_title'
				,array('keywords' => 'xsd:string')
            	,array('return'=>'tns:ArrayOfString')
            	,$namespace,false
            	,'rpc'
            	,'encoded');

function library_books_title($keywords) {
    
    $db = &ADONewConnection('mysqlt');
    
    $db->Connect("localhost", "pvspaiva", "", "library");
    
    $sql = "SELECT * FROM books WHERE LOWER(titulo) LIKE '%".strtolower($keywords)."%';";
    
    $rs = $db->Execute($sql);
    
    $result = $rs->GetArray();
    
    foreach($result as $row=>$value)
   	{ 
		$return_value[] = array(
				    'id'=> $value['id'],
				    'codigo'=> $value['codigo'],
				    'titulo'=> $value['titulo'],
				    'editora'=> $value['editora'],
				    'isbn'=> $value['isbn'],
				    'edicao'=> $value['edicao'],
				    'autor'=> $value['autor']
				    );
	}
	
	return $return_value;
}

$server->register('library_books_isbn'
				,array('keywords' => 'xsd:string')
            	,array('return'=>'tns:ArrayOfString')
            	,$namespace,false
            	,'rpc'
            	,'encoded');

function library_books_isbn($keywords) {
    
    $db = &ADONewConnection('mysqlt');
    
    $db->Connect("localhost", "pvspaiva", "", "library");
    
    $sql = "SELECT * FROM books WHERE LOWER(isbn) LIKE '%".strtolower($keywords)."%';";
    
    $rs = $db->Execute($sql);
    
    $result = $rs->GetArray();
    
    foreach($result as $row=>$value)
   	{ 
		$return_value[] = array(
				    'id'=> $value['id'],
				    'codigo'=> $value['codigo'],
				    'titulo'=> $value['titulo'],
				    'editora'=> $value['editora'],
				    'isbn'=> $value['isbn'],
				    'edicao'=> $value['edicao'],
				    'autor'=> $value['autor']
				    );
	}
	
	return $return_value;
}

$server->register('library_insert'
				,array( 'codigo' =>'xsd:string', 'titulo' =>'xsd:string', 
						'editora'=> 'xsd:string','isbn'=> 'xsd:string',
					    'edicao'=> 'xsd:string', 'autor'=> 'xsd:string' )
            	,array()
            	,$namespace
            	,false
            	,'rpc'
            	,'encoded');

function library_insert($codigo, $titulo, $editora, $isbn, $edicao, $autor) {
    $db = &ADONewConnection('mysqlt');
   
	$db->Connect("localhost", "pvspaiva", "", "library");
	
	$sql = "INSERT INTO books (codigo, titulo, editora, isbn, edicao, autor) VALUES 
	( '".$codigo."', '".$titulo."', '".$editora."', 
	'".$isbn."', '".$edicao."', '".$autor."')";
	
	$rs = $db->Execute($sql);
}

$server->register('library_update'
				,array( 'id' =>'xsd:string', 'titulo' =>'xsd:string')
            	,array()
            	,$namespace
            	,false
            	,'rpc'
            	,'encoded');

function library_update($id, $titulo) {
	$db = &ADONewConnection('mysqlt');
	$db->Connect("localhost", "pvspaiva", "", "library");
	$rs = $db->Execute("UPDATE books SET titulo='".$titulo."' WHERE id=".$id);
}

$server->register('library_delete'
				,array( 'id' =>'xsd:string')
            	,array('return'=>'tns:ArrayOfString')
            	,$namespace
            	,false
            	,'rpc'
            	,'encoded');

function library_delete($id) {
	$db = &ADONewConnection('mysqlt');
	$db->Connect("localhost", "pvspaiva", "", "library");
	
	$sql = "SELECT * FROM books WHERE id='".$id."';";
    
    $rs = $db->Execute($sql);
    
    $result = $rs->GetArray();
    
    foreach($result as $row=>$value)
   	{ 
		$return_value[] = array(
				    'id'=> $value['id'],
				    'codigo'=> $value['codigo'],
				    'titulo'=> $value['titulo'],
				    'editora'=> $value['editora'],
				    'isbn'=> $value['isbn'],
				    'edicao'=> $value['edicao'],
				    'autor'=> $value['autor']
				    );
	}
	
	$rs = $db->Execute("DELETE FROM books WHERE id=".$id);
	
	return $return_value;
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.                
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) 
                ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service                    
$server->service($POST_DATA);                
exit();
?>
