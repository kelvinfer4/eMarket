<?php

use App\Produto;

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
Route::get('/manager/login', 'AutenticacaoController@login')->name('login');
Route::post('/manager/logar', 'AutenticacaoController@logar')->name('logar');

/* Rotas do Facebook */
Route::get('auth/{provider}', 'FacebookController@redirectToProvider');
Route::get('auth/{provider}/callback', 'FacebookController@handleProviderCallback');

/* Rotas Publicas */
Route::get('/', 'StoreController@index')->name('index');
Route::any('/produtos/busca/', 'StoreController@buscaproduto')->name('buscaProduto');
Route::get('/produtos/{setor}/{categoria}/', 'StoreController@buscaMenu')->name('buscaMenu');
/* Rotas do Carrinho */
Route::get('/carrinho/adicionar/{id}', 'CarrinhoController@addCarrinho')->name('addCarrinho');
Route::get('/carrinho/remover/{id}', 'CarrinhoController@remove')->name('remove');
Route::get('/carrinho/deletar/{id}', 'CarrinhoController@removerProd')->name('removerProd');
/* Rotas de Cliente */
Route::get('/clientes/login', 'AutenticacaoController@loginCliente')->name('loginCliente');
Route::post('/clientes/logar', 'AutenticacaoController@logarCliente')->name('logarCliente');
Route::get('/clientes/cadastrar', 'AutenticacaoController@registerUser')->name('registerUser');
Route::post('/clientes/cadastrar/salvar', 'ClienteController@cadastroCliente')->name('cadastroCliente');
/* Middware de Clientes */

Route::middleware(['cliente'])->group(function () {
    /* Rotas de Carrinho */
    Route::get('/carrinho', 'CarrinhoController@carrinho')->name('carrinho');
    Route::get('/carrinho/voltar', 'CarrinhoController@redirectBack')->name('redirectBack');
    Route::get('/pedido/forma-pagamento', 'StoreController@metodoPagamento')->middleware('check.qtd.cart')->name('metodoPagamento');
    Route::post('pagseguro-getcode', 'PagSeguroController@getCode')->name('pagseguro.code.transparent');
    Route::post('pagseguro-payment-billet', 'PagSeguroController@billet')->name('pagseguro.billet');

    /* Rotas de Perfil de Clientes */
    Route::get('/minhaconta', 'ClienteController@minhaConta')->name('minhaConta');
    Route::post('/minhaconta/atualizar', 'ClienteController@atualizarPerfilCliente')->name('atualizarPerfilCliente');
    Route::get('/meuspedidos', 'ClienteController@meusPedidos')->name('meusPedidos');
    Route::get('/meuspedidos/visualizar/{id}', 'ClienteController@detalhesPedido')->name('detalhesPedido');
    Route::get('/meuspedidos/cancelar/{id}', 'ClienteController@cancelarPedido')->name('cancelarPedido');
    Route::get('/logout', 'AutenticacaoController@logoutCliente')->name('logoutCliente');
});

/* Middware do Manager */
Route::middleware(['manager'])->group(function () {
    Route::get('/manager', 'AutenticacaoController@manager')->name('manager');
    Route::get('/manager/logout', 'AutenticacaoController@logout')->name('logout');
    /* Rotas Protegidas de Usuários */
    Route::get('/pessoas/usuarios', 'UsuarioController@listarUsuarios')->name('listarUsuarios');
    Route::post('/pessoas/usuarios/atualizar/{id}', 'UsuarioController@atualizarUsuario')->name('atualizarUsuario');
    Route::post('/pessoas/usuarios/salvar', 'UsuarioController@salvarUsuario')->name('salvarUsuario');
    Route::get('/pessoas/usuarios/excluir/{id}', 'UsuarioController@excluirUsuario')->name('excluirUsuario');
    Route::any('/pessoas/usuarios/pesquisa', 'UsuarioController@pesquisarUsuario')->name('pesquisarUsuario');
    /* Rotas Protegidas de Fornecedores */
    Route::get('/pessoas/fornecedores', 'FornecedorController@listarFornecedores')->name('listarFornecedores');
    Route::post('/pessoas/fornecedores/atualizar/{id}', 'FornecedorController@atualizarFornecedor')->name('atualizarFornecedor');
    Route::post('/pessoas/fornecedores/salvar', 'FornecedorController@salvarFornecedor')->name('salvarFornecedor');
    Route::get('/pessoas/fornecedores/excluir/{id}', 'FornecedorController@excluirFornecedor')->name('excluirFornecedor');
    Route::any('/pessoas/fornecedores/pesquisa', 'FornecedorController@pesquisarFornecedor')->name('pesquisarFornecedor');
    /* Rotas Protegidas de Clientes */
    Route::get('/pessoas/clientes', 'ClienteController@listarClientes')->name('listarClientes');
    Route::post('/pessoas/clientes/atualizar/{id}', 'ClienteController@atualizarCliente')->name('atualizarCliente');
    Route::post('/pessoas/clientes/salvar', 'ClienteController@salvarCliente')->name('salvarCliente');
    Route::get('/pessoas/clientes/excluir/{id}', 'ClienteController@excluirCliente')->name('excluirCliente');
    Route::any('/pessoas/clientes/pesquisa', 'ClienteController@pesquisarCliente')->name('pesquisarCliente');
    /* Rotas Protegidas de Empresas */
    Route::get('/empresas', 'EmpresaController@listarEmpresas')->name('listarEmpresas');
    Route::post('/empresas/atualizar/{id}', 'EmpresaController@atualizarEmpresa')->name('atualizarEmpresa');
    Route::post('/empresas/salvar', 'EmpresaController@salvarEmpresa')->name('salvarEmpresa');
    Route::get('/empresas/excluir/{id}', 'EmpresaController@excluirEmpresa')->name('excluirEmpresa');
    /* Rotas Protegidas de Produtos */
    Route::get('/produtos', 'ProdutoController@listarProdutos')->name('listarProdutos');
    Route::post('/produtos/atualizar/{id}', 'ProdutoController@atualizarProduto')->name('atualizarProduto');
    Route::post('/produtos/salvar', 'ProdutoController@salvarProduto')->name('salvarProduto');
    Route::get('/produtos/excluir/{id}', 'ProdutoController@excluirProduto')->name('excluirProduto');
    Route::get('/produtos/apagar/{id}', 'ProdutoController@excluirProd')->name('excluirProd');
    Route::any('/produtos/pesquisa', 'ProdutoController@pesquisarProduto')->name('pesquisarProduto');
    /* Rotas Protegidas de Setores */
    Route::get('/produtos/setores', 'SetorController@listarSetores')->name('listarSetores');
    Route::post('/produtos/setores/atualizar/{id}', 'SetorController@atualizarSetor')->name('atualizarSetor');
    Route::post('/produtos/setores/salvar', 'SetorController@salvarSetor')->name('salvarSetor');
    Route::get('/produtos/setores/excluir/{id}', 'SetorController@excluirSetor')->name('excluirSetor');
    Route::any('/produtos/setores/pesquisa', 'SetorController@pesquisarSetor')->name('pesquisarSetor');
    /* Rotas Protegidas de Categorias */
    Route::get('/produtos/categorias', 'CategoriaController@listarCategorias')->name('listarCategorias');
    Route::post('/produtos/categorias/atualizar/{id}', 'CategoriaController@atualizarCategoria')->name('atualizarCategoria');
    Route::post('/produtos/categorias/salvar', 'CategoriaController@salvarCategoria')->name('salvarCategoria');
    Route::get('/produtos/categorias/excluir/{id}', 'CategoriaController@excluirCategoria')->name('excluirCategoria');
    Route::any('/produtos/categorias/pesquisa', 'CategoriaController@pesquisarCategoria')->name('pesquisarCategoria');
    /* Rotas Protegidas de Unidades */
    Route::get('/produtos/unidades', 'UnidadeController@listarUnidades')->name('listarUnidades');
    Route::post('/produtos/unidades/atualizar/{id}', 'UnidadeController@atualizarUnidade')->name('atualizarUnidade');
    Route::post('/produtos/unidades/salvar', 'UnidadeController@salvarUnidade')->name('salvarUnidade');
    Route::get('/produtos/unidades/excluir/{id}', 'UnidadeController@excluirUnidade')->name('excluirUnidade');
    Route::any('/produtos/unidades/pesquisa', 'UnidadeController@pesquisarUnidade')->name('pesquisarUnidade');
    /* Rotas Protegidas de Cargos */
    Route::get('/usuarios/cargos', 'CargoController@listarCargos')->name('listarCargos');
    Route::post('/usuarios/cargos/atualizar/{id}', 'CargoController@atualizarCargo')->name('atualizarCargo');
    Route::post('/usuarios/cargos/salvar', 'CargoController@salvarCargo')->name('salvarCargo');
    Route::get('/usuarios/cargos/excluir/{id}', 'CargoController@excluirCargo')->name('excluirCargo');
    /* Rotas Protegidas de Formas de Pagamentos */
    Route::get('/financeiro/formaspagamentos', 'FormaPagamentoController@listarFormasPag')->name('listarFormasPag');
    Route::post('/financeiro/formaspagamentos/atualizar/{id}', 'FormaPagamentoController@atualizarFormaPag')->name('atualizarFormaPag');
    Route::post('/financeiro/formaspagamentos/salvar', 'FormaPagamentoController@salvarFormaPag')->name('salvarFormaPag');
    Route::get('/financeiro/formaspagamentos/excluir/{id}', 'FormaPagamentoController@excluirFormaPag')->name('excluirFormaPag');
    /* Rotas Protegidas de Pedidos */
    Route::get('/financeiro/pedidos', 'PedidoController@listarPedidos')->name('listarPedidos');
    Route::post('/financeiro/pedidos/atualizar/{id}', 'PedidoController@atualizarPedido')->name('atualizarPedido');
    Route::post('/financeiro/pedidos/salvar', 'PedidoController@salvarPedido')->name('salvarPedido');
    Route::get('/financeiro/pedidos/excluir/{id}', 'PedidoController@excluirPedido')->name('excluirPedido');
    Route::any('/financeiro/pedidos/pesquisa', 'PedidoController@pesquisarPedido')->name('pesquisarPedido');
    Route::get('/financeiro/pedidos/excluir/{id}', 'PedidoController@excluirPedido')->name('excluirPedido');
    /* Rotas Protegidas de Vendas */
    Route::get('/financeiro/vendas', 'VendaController@listarVendas')->name('listarVendas');
    Route::post('/financeiro/vendas/atualizar/{id}', 'VendaController@atualizarVenda')->name('atualizarVenda');
    Route::post('/financeiro/vendas/salvar', 'VendaController@salvarVenda')->name('salvarVenda');
    Route::get('/financeiro/vendas/excluir/{id}', 'VendaController@excluirVenda')->name('excluirVenda');
    Route::any('/financeiro/vendas/pesquisa', 'VendaController@pesquisarVenda')->name('pesquisarVenda');
    Route::get('/financeiro/vendas/excluir/{id}', 'VendaController@excluirVenda')->name('excluirVenda');
    Route::get('/financeiro/vendas/entrega/concluir/{id}', 'VendaController@concluirEntrega')->name('concluirEntrega');
    Route::get('/financeiro/vendas/entrega/entregar/{id}', 'VendaController@realizarEntrega')->name('realizarEntrega');
    /* Rotas Protegidas de Frete */
    Route::get('/encomendas/fretes', 'FreteController@listarFretes')->name('listarFretes');
    Route::post('/encomendas/frete/atualizar/{id}', 'FreteController@atualizarFrete')->name('atualizarFrete');
    Route::post('/encomendas/frete/salvar', 'FreteController@salvarFrete')->name('salvarFrete');
    Route::get('/encomendas/frete/{id}', 'FreteController@excluirFrete')->name('excluirFrete');
    Route::any('/encomendas/frete/pesquisa', 'FreteController@pesquisarFrete')->name('pesquisarFrete');
    Route::get('/encomendas/frete/excluir/{id}', 'FreteController@excluirFrete')->name('excluirFrete');
    /* Rotas Protegidas de Entregas */
    Route::get('/encomendas/entregas', 'EntregaController@listarEntregas')->name('listarEntregas');
    Route::post('/encomendas/entrega/atualizar/{id}', 'EntregaController@atualizarEntrega')->name('atualizarEntrega');
    Route::post('/encomendas/entrega/salvar', 'EntregaController@salvarEntrega')->name('salvarEntrega');
    Route::get('/encomendas/entrega/{id}', 'EntregaController@excluirEntrega')->name('excluirEntrega');
    Route::any('/encomendas/entrega/pesquisa', 'EntregaController@pesquisarEntrega')->name('pesquisarEntrega');
    Route::get('/encomendas/entrega/excluir/{id}', 'EntregaController@excluirEntrega')->name('excluirEntrega');
    /* Rotas de Relatórios de Pedidos */
    Route::get('/relatorios/pedidos/', 'PedidoController@visualizarRelPedidos')->name('visualizarRelPedidos');
    Route::get('/relatorios/pedidos/aguardando-pagamento/{id}', 'PedidoController@relatorios')->name('relPedidosAguardPag');
    Route::get('/relatorios/pedidos/aprovados/{id}', 'PedidoController@relatorios')->name('relPedidosAprovados');
    Route::get('/relatorios/pedidos/cancelados/{id}', 'PedidoController@relatorios')->name('relPedidosCancelados');
    Route::post('/relatorios/pedidos/periodo', 'PedidoController@pedidosPeriodo')->name('relPedidoPeriodo');
    /* Rotas de Relatórios de Vendas */
    Route::get('/relatorios/vendas/', 'VendaController@visualizarRelVendas')->name('visualizarRelVendas');
    Route::get('/relatorios/vendas/realizadas/{id}', 'VendaController@relatorios')->name('relVendasRealizadas');
    Route::get('/relatorios/vendas/concluidas/{id}', 'VendaController@relatorios')->name('relVendasConcluidas');
    Route::get('/relatorios/vendas/canceladas/{id}', 'VendaController@relatorios')->name('relVendasCanceladas');
    Route::get('/relatorios/vendas/saiu-para-entrega/{id}', 'VendaController@relatorios')->name('relVendasEmEntrega');
    Route::post('/relatorios/vendas/periodo', 'VendaController@vendasPeriodo')->name('relVendasPeriodo');
     /* Rotas de Relatórios de Produtos */
    Route::get('/relatorios/produtos/', 'ProdutoController@visualizarRelProdutos')->name('visualizarRelProdutos');
    Route::get('/relatorios/produtos/estoque-minimo/{id}', 'ProdutoController@relEstoqueMin')->name('relProdutoEstoqueMin');
    Route::get('/relatorios/vendas/concluidas/{id}', 'VendaController@relatorios')->name('relVendasConcluidas');
    Route::get('/relatorios/vendas/canceladas/{id}', 'VendaController@relatorios')->name('relVendasCanceladas');
    Route::get('/relatorios/vendas/saiu-para-entrega/{id}', 'VendaController@relatorios')->name('relVendasEmEntrega');
    Route::post('/relatorios/vendas/periodo', 'VendaController@vendasPeriodo')->name('relVendasPeriodo');
    
    /* Rotas Utilizadas no Ajax */
    Route::get('ajax/pegar-lista-categorias', 'ProdutoController@getCategoriasAjax');
    Route::get('ajax/pegar-lista-modelos', 'VeiculoController@getModelosAjax');
});

/* Rotas de Cartao */
Route::get('pagseguro-transparent-card', 'PagSeguroController@card')->name('pagseguro.transparent.card');
Route::post('pagseguro-transparent-card', 'PagSeguroController@cardTransaction')->name('pagseguro.card.transaction');
Route::post('pagseguro-billet', 'PagSeguroController@billet')->name('pagseguro.billet');

/* Rota de Boleto */
Route::post('pagseguro-transparente', 'PagSeguroController@getCode')->name('pagseguro.code.transparente');
Route::post('pagseguro-transparente', 'PagSeguroController@getCodeSandBox')->name('pagseguro.code.transparente.sandbox');
Route::get('pagseguro-transparente', 'PagSeguroController@transparente')->name('pagseguro.transparente');
Route::get('pagseguro-lightbox', 'PagSeguroController@lightbox')->name('pagseguro.lightbox');
Route::post('pagseguro-lightbox', 'PagSeguroController@lightboxCode')->name('pagseguro.lightbox.code');
Route::get('pagseguro', 'PagSeguroController@pagseguro')->name('pagseguro');
Route::get('pagseguro-btn', function() {
    return view('pagseguro-btn');
});
