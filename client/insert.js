var soap = require('soap');

var readlineSync = require('readline-sync');

var url = 'http://0.0.0.0:8080/server/libraryServer.php?wsdl';

console.log('Insira os dados do livro')
var _codigo = readlineSync.question('codigo: ');
var _titulo = readlineSync.question('titulo: '); 
var _editora = readlineSync.question('editora: '); 
var _isbn = readlineSync.question('isbn: '); 
var _edicao = readlineSync.question('edicao: ');
var _autor = readlineSync.question('autor: ');;

var args = {
    codigo: _codigo, 
    titulo: _titulo, 
    editora: _editora, 
    isbn: _isbn, 
    edicao: _edicao, 
    autor: _autor
};

soap.createClient(url, function(err, client) {
    if(err) throw new Error(err);
    
    client.library_insert(args, function(err, result) {
        if (err) console.log(err);
    });
});