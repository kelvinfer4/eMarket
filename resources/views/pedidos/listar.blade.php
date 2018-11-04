@extends('shared.layoutManager')

@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="page-header-title">
                        <h4>Manager</h4>
                    </div>
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="icofont icofont-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('manager') }}">Manager</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('listarProdutos') }}">Vendas</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('listarProdutos') }}">Pedidos</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header card-header-flex">
                        <div>
                            <h5>Lista de Pedidos Realizados </h5>
                            <span>Listagem dos pedidos realizados no site</span>   
                        </div>

                        <!-- FORMULÁRIO DE BUSCA -->

                        <div class="form-search">
                            {!! Form::open(['route' => 'pesquisarPedido', 'class' => 'form form-inline']) !!}
                            {!! Form::text('key_search', null, ['class' => 'form-control', 'placeholder' => 'Pesquisar..']) !!}

                            <button class="btn btn-primary">Pesquisar <i class="fa fa-search" aria-hidden="true"></i></button>
                            {!! Form::close() !!}

                        </div>

                        <!-- FIM FORMULÁRIO DE BUSCA -->

                        <!-- BOTAO CADASTRAR PEDIDO MODAL -->
                        <a href="" data-toggle="modal" data-target="#modalCadastrar" >
                            <button type="button" style="display: none" class="btn btn-primary waves-effect waves-light btnCadUser"><i class="fa fa-user-plus"></i>Cadastrar Pedido</button></a>

                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nº Pedido</th>
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Data</th>
                                            <th class="text-center">Forma de Pagamento</th>
                                            <th class="text-center">Valor Total</th> 
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>            
                                    <tbody>            
                                        @forelse($pedidos as $pedido)
                                        <tr>
                                            <td class="text-center">{{$pedido->id}}</td>
                                            <td class="text-center">
                                                @foreach($clientes as $cliente)
                                                @if($cliente->id == $pedido->cliente_id)
                                                {{$cliente->nome}}
                                                @endif
                                                @endforeach
                                            </td>
                                            <td class="text-center">{{$pedido->data}}</td>
                                            <td class="text-center">{{$pedido->getFormaPagamento($pedido->metodo_pagamento)}}</td>
                                            <td class="text-center">R$ {{$pedido->formatValue($pedido->total)}}</td>
                                            <td class="text-center">{{$pedido->getStatus($pedido->status)}}</td>
                                            <td>
                                                <!-- BOTAO EDITAR MODAL -->
                                                <a href="" data-toggle="modal" data-target="#modalEditar{{$pedido->id}}" data-whatever="{{$pedido->id}}" data-whateverclienteId="{{$pedido->cliente_id}}" data-whateverreferencia="{{$pedido->referencia}}" data-whatevercodigo="{{$pedido->codigo}}" data-whatevertotal="{{$pedido->total}}" data-whateverfrete="{{$pedido->frete}}" data-whateverstatus="{{$pedido->status}}" data-whatevermetodoPagamento="{{$pedido->metodo_pagamento}}" data-whateverdata="{{$pedido->data}}" data-whateverdataRefreshStatus="{{$pedido->data_refresh_status}}"><img src="../../imgs/iconEdit.png" title="Editar Produto" class="btnAcoes"></a>

                                                <!-- MODAL DE EDITAR -->
                                                <div class="modal fade" id="modalEditar{{$pedido->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modalProd" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #0cb6734 !important; color: white">
                                                                <h5 class="modal-title" id="exampleModalLongTitle" style="color: #fff">Pedido Nº {{$pedido->id}} <i class="fa fa-help"></i></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true" style="color: #fff">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="{{route ('atualizarPedido', $pedido->id)}}" class="formEditUser">
                                                                    {{ csrf_field() }}
                                                                    <div class="card-header text-center">
                                                                        <h5>Editar Pedido</h5>
                                                                    </div>
                                                                    <div class="card-block">
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12">
                                                                                <ul class="nav nav-tabs" role="tablist">
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link active" data-toggle="tab" href="#home">Pedido</a>
                                                                                    </li>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" data-toggle="tab" href="#menu1">Produtos</a>
                                                                                    </li>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" data-toggle="tab" href="#menu2">Entrega</a>
                                                                                    </li>
                                                                                </ul>

                                                                                <!-- Tab panes -->
                                                                                <div class="tab-content">
                                                                                    <div id="home" class="container tab-pane active"><br>
                                                                                        <div class="row">
                                                                                            <div class="col-sm-2">
                                                                                                <label for="data" class="control-label labelInputEditUser">Nº Pedido:</label>
                                                                                                <input disabled type="text" class="form-control" name="data" value="{{$pedido->id}}" required>
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <!-- Formata a data para o formatado americano para enviar ao input date -->
                                                                                                <?php
                                                                                                $data = DateTime::createFromFormat('d/m/Y', $pedido->data);
                                                                                                $dataPedido = $data->format('Y-m-d');
                                                                                                ?>
                                                                                                <label for="data" class="control-label labelInputEditUser">Data:</label>
                                                                                                <input type="date" class="form-control" name="data" value="{{$dataPedido}}" required>
                                                                                            </div>
                                                                                            <div class="col-sm-7">
                                                                                                <label for="cliente_id" class="control-label labelInputEditUser">Nome do Cliente:</label>
                                                                                                <select disabled class="form-control labelInputEditUser" name="cliente_id" id="cliente_id" value="{{$pedido->cliente_id}}">
                                                                                                    @foreach($clientes as $cliente)    
                                                                                                    <option disabled value="{{$cliente->id}}"{{$cliente->id == $pedido->cliente_id ? 'selected' : ''}}>{{$cliente->nome}}</option>
                                                                                                    @endforeach  
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <label for="metodo_pagamento" class="control-label labelInputEditUser">Forma de Pagamento:</label>
                                                                                                <select class="form-control labelInputEditUser" name="metodo_pagamento">
                                                                                                    <option value="1" {{ $pedido->metodo_pagamento == 1 ? 'selected' : ''}}>Cartão de Crédito</option>
                                                                                                    <option value="2" {{ $pedido->metodo_pagamento == 2 ? 'selected' : ''}}>Boleto Bancário</option>
                                                                                                    <option value="4" {{ $pedido->metodo_pagamento == 4 ? 'selected' : ''}}>Saldo PagSeguro</option>
                                                                                                    <option value="7" {{ $pedido->metodo_pagamento == 7 ? 'selected' : ''}}>Débito em Conta</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <label for="cliente_id" class="control-label labelInputEditUser">Status:</label>
                                                                                                <select class="form-control labelInputEditUser" name="status">
                                                                                                    <option value="1" {{ $pedido->status == 1 ? 'selected' : ''}}>Aguardando Pagamento</option>
                                                                                                    <option value="2" {{ $pedido->status == 2 ? 'selected' : ''}}>Em Análise</option>
                                                                                                    <option value="3" {{ $pedido->status == 3 ? 'selected' : ''}}>Pagamento Aprovado</option>
                                                                                                    <option value="4" {{ $pedido->status == 4 ? 'selected' : ''}}>Disponível</option>
                                                                                                    <option value="5" {{ $pedido->status == 5 ? 'selected' : ''}}>Em Disputa</option>
                                                                                                    <option value="6" {{ $pedido->status == 6 ? 'selected' : ''}}>Pagamento Devolvido</option>
                                                                                                    <option value="7" {{ $pedido->status == 7 ? 'selected' : ''}}>Cancelado</option>
                                                                                                    <option value="9" {{ $pedido->status == 9 ? 'selected' : ''}}>Retenção Temporária</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-sm-2">
                                                                                                <label for="total" class="control-label labelInputEditUser">Valor Total:</label>
                                                                                                <input type="number" step="any" class="form-control" name="total" value="{{$pedido->total}}" required>
                                                                                            </div>
                                                                                            <div class="col-sm-2">
                                                                                                <label for="precoVenda" class="control-label labelInputEditUser">Frete:</label>
                                                                                                <input type="number" step="any" class="form-control" name="frete" value="{{$pedido->frete}}">
                                                                                            </div>

                                                                                            <div class="col-sm-6">
                                                                                                <label for="codigo" class="control-label labelInputEditUser">Código da Transação:</label>
                                                                                                <input type="text" id="codigo" class="form-control" name="codigo" value="{{$pedido->codigo}}" required>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <label for="referencia" class="control-label labelInputEditUser">Referencia:</label>
                                                                                                <input type="text" class="form-control" name="referencia" value="{{$pedido->referencia}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="menu1" class="container tab-pane fade"><br>
                                                                                        <h3>Menu 1</h3>
                                                                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                                                    </div>
                                                                                    <div id="menu2" class="container tab-pane fade"><br>
                                                                                        <h3>Menu 2</h3>
                                                                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i>Salvar</button>
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        </div>       
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <!-- FIM MODAL EDITAR -->

                                                <a href="{{route('detalhesPedido', $pedido->id)}}"><img src="../../imgs/visualizar.png" class="iconPedido" alt="Visualizar Pedido"</a>
                                                <a href="{{route('excluirProduto', $pedido->id)}}" onclick="return confirm('Tem certeza que deseja deletar este registro?')"><img src="../../imgs/iconTrash.png" title="Excluir Produto" class="btnAcoes"></a>
                                            </td>
                                        </tr>                         
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table> 
                                <center><div class="pagination paginationPedidos">{!! $pedidos->links() !!}</div></center>
                            </div> 
                        </div>
                    </div>
                </div>
                @endsection