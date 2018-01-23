var soap = require('soap');

var readlineSync = require('readline-sync');

var url = 'http://0.0.0.0:8080/server/libraryServer.php?wsdl';

console.log('Insira a id do livro a ser deletado')
var _id = readlineSync.question('id: ');

var args = {
    id: _id
};

soap.createClient(url, function(err, client) {
    if(err) throw new Error(err);
    
    client.library_delete(args, function(err, result) {
        if (err) console.log(err);
        console.log('Livro deletado')
        console.log('id: ', result.return.item.id.$value);
        console.log('codigo: ', result.return.item.codigo.$value);
        console.log('titulo: ', result.return.item.titulo.$value);
        console.log('editora: ', result.return.item.editora.$value);
        console.log('isbn: ', result.return.item.isbn.$value);
        console.log('edicao: ', result.return.item.edicao.$value);
        console.log('autor: ', result.return.item.autor.$value);
    });
});