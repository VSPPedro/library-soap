var soap = require('soap');

var readlineSync = require('readline-sync');

var url = 'http://0.0.0.0:8080/server/libraryServer.php?wsdl';

console.log('Digite o numero da respectiva função de busca que deseja');
console.log('0 - Todos os livros do sistema (DEFAULT)');
console.log('1 - Consultar por titulo');
console.log('2 - Consultar por nome');
var codigo = readlineSync.question('Codigo(Ex: 0): ');

var searchType, _keywords;

if (codigo == 1) {0
    searchType = 'title';
    _keywords= readlineSync.question('Digite a(s) palavra(s)-chave para a consulta por titulo: ');
} else if (codigo == 2) {
    searchType = 'isbn';
    _keywords= readlineSync.question('Digite a(s) palavra(s)-chave para a consulta por isbn: ');
} else {
    console.log('Opção DEFAUL foi escohida.');
    searchType = 'all';
}

var args = {
    keywords: _keywords
};

if (searchType == 'all') {
    soap.createClient(url, function(err, client) {
        if(err) throw new Error(err);
        client.library_books(null, function(err, result) {
            if (err) console.log('err: ', err);
            if (result != null) {
                for (i = 0; i < result.return.item.length; i++) {
                    console.log('id: ', result.return.item[i].id.$value);
                    console.log('codigo: ', result.return.item[i].codigo.$value);
                    console.log('titulo: ', result.return.item[i].titulo.$value);
                    console.log('editora: ', result.return.item[i].editora.$value);
                    console.log('isbn: ', result.return.item[i].isbn.$value);
                    console.log('edicao: ', result.return.item[i].edicao.$value);
                    console.log('autor: ', result.return.item[i].autor.$value);
                }
            } else {
                console.log ("Nenhum resultado obtido");
            }
            
        });
    });
} else if (searchType == 'title') {
    soap.createClient(url, function(err, client) {
        if(err) throw new Error(err);
        client.library_books_title(args, function(err, result) {
            if (err) console.log('err: ', err);
            if (result != null) {
                for (i = 0; i < result.return.item.length; i++) {
                    console.log('id: ', result.return.item[i].id.$value);
                    console.log('codigo: ', result.return.item[i].codigo.$value);
                    console.log('titulo: ', result.return.item[i].titulo.$value);
                    console.log('editora: ', result.return.item[i].editora.$value);
                    console.log('isbn: ', result.return.item[i].isbn.$value);
                    console.log('edicao: ', result.return.item[i].edicao.$value);
                    console.log('autor: ', result.return.item[i].autor.$value);
                }
            } else {
                console.log ("Nenhum resultado obtido!");
            }
        });
    });
} else if (searchType == 'isbn') {
    soap.createClient(url, function(err, client) {
        if(err) throw new Error(err);
        client.library_books_isbn(args, function(err, result) {
            if (err) console.log('err: ', err);
            if (result != null) {
                for (i = 0; i < result.return.item.length; i++) {
                    console.log('id: ', result.return.item[i].id.$value);
                    console.log('codigo: ', result.return.item[i].codigo.$value);
                    console.log('titulo: ', result.return.item[i].titulo.$value);
                    console.log('editora: ', result.return.item[i].editora.$value);
                    console.log('isbn: ', result.return.item[i].isbn.$value);
                    console.log('edicao: ', result.return.item[i].edicao.$value);
                    console.log('autor: ', result.return.item[i].autor.$value);
                }
            } else {
                console.log ("Nenhum resultado obtido!");
            }
        });
    });
}