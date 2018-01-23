var soap = require('soap');

var readlineSync = require('readline-sync');

var url = 'http://0.0.0.0:8080/server/libraryServer.php?wsdl';

console.log('Insira a id do livro a ser atualizado')
var _id = readlineSync.question('id: ');

console.log('Insira o novo titulo do livro:')
var _titulo = readlineSync.question('titulo: ');

var args = {
    id: _id,
    titulo: _titulo
};

soap.createClient(url, function(err, client) {
    if(err) throw new Error(err);
    
    client.library_update(args, function(err, result) {
        if (err) console.log(err);
    });
});