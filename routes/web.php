<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/registrar', 'UsuarioController@registrar')->name('registrar');
Route::post('/salvar', 'UsuarioController@salvar')->name('salvar');
Route::get('/login', 'AutenticacaoController@login')->name('login');
Route::post('/logar', 'AutenticacaoController@logar')->name('logar');
Route::get('/', 'AutenticacaoController@index')->name('index');
Route::get('/logout', 'AutenticacaoController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/manager', 'AutenticacaoController@manager')->name('manager');

    /* Rotas Protegidas de Usuários */
    Route::get('/usuarios', 'UsuarioController@listarUsuarios')->name('listarUsuarios');
    Route::get('/usuarios/editar/{id}', 'UsuarioController@editarUsuario')->name('editarUsuario');
    Route::post('/usuarios/atualizar/{id}', 'UsuarioController@atualizarUsuario')->name('atualizarUsuario');
    Route::get('/usuarios/visualizar/{id}', 'UsuarioController@visualizarUsuario')->name('visualizarUsuario');
    Route::get('/usuarios/excluir/{id}', 'UsuarioController@excluirUsuario')->name('excluirUsuario');
    Route::get('/usuarios/cadastrar', 'UsuarioController@cadastrarUsuario')->name('cadastrarUsuario');
    Route::post('/usuarios/salvar', 'UsuarioController@salvarUsuario')->name('salvarUsuario');

    /* Rotas Protegidas de Produtos */
    Route::get('/produtos', 'ProdutoController@listarProdutos')->name('listarProdutos');
    Route::get('/produtos/excluir/{id}', 'ProdutoController@excluirProduto')->name('excluirProduto');
    Route::get('/produtos/editar/{id}', 'ProdutoController@editarProduto')->name('editarProduto');
    Route::post('/produtos/atualizar/{id}', 'ProdutoController@atualizarProduto')->name('atualizarProduto');
    Route::get('/produtos/visualizar/{id}', 'ProdutoController@visualizarProduto')->name('visualizarProduto');
    Route::post('/produtos/salvar', 'ProdutoController@salvarProduto')->name('salvarProduto');
    Route::get('/produtos/cadastrar', 'ProdutoController@cadastrarProduto')->name('cadastrarProduto');

    /* Rotas Protegidas de Setores */
    Route::get('/produtos/setores', 'SetorController@listarSetores')->name('listarSetores');
    Route::get('/produtos/setores/excluir/{id}', 'SetorController@excluirSetor')->name('excluirSetor');
    Route::get('/produtos/setores/editar/{id}', 'SetorController@editarSetor')->name('editarSetor');
    Route::post('/produtos/setores/atualizar/{id}', 'SetorController@atualizarSetor')->name('atualizarSetor');
    Route::get('/produtos/setores/visualizar/{id}', 'SetorController@visualizarSetor')->name('visualizarSetor');
    Route::get('/produtos/setores/cadastrar', 'SetorController@cadastrarSetor')->name('cadastrarSetor');  
    Route::post('/produtos/setores/salvar', 'SetorController@salvarSetor')->name('salvarSetor');

    /* Rotas Protegidas de Categorias */
    Route::get('produtos/cadastrar/Categoria', 'CategoriaController@cadastrarCategoria')->name('cadastrarCategoria');  
    Route::get('/categorias', 'CategoriaController@listarCategorias')->name('listarCategorias');
  });
