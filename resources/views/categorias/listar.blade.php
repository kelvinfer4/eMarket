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
                            <li class="breadcrumb-item"><a href="{{ route('listarProdutos') }}">Produtos</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('listarSetores') }}">Setores</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('listarSetores') }}">Categorias</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header card-header-flex">
                        <div>
                            <h5>Lista de Categorias</h5>
                            <span>Listagem das categorias de produtos</span>   
                        </div>

                        @if (Auth::user()->can('view', App\Categoria::class))

                        <!-- FORMULÁRIO DE BUSCA -->

                        <div class="form-search">
                            {!! Form::open(['route' => 'pesquisarCategoria', 'class' => 'form form-inline']) !!}
                            {!! Form::text('key_search', null, ['class' => 'form-control', 'placeholder' => 'Pesquisar..']) !!}

                            <button class="btn btn-primary">Pesquisar <i class="fa fa-search" aria-hidden="true"></i></button>
                            {!! Form::close() !!}

                        </div>

                        <!-- FIM FORMULÁRIO DE BUSCA -->

                        @if (Auth::user()->can('create', App\Categoria::class))
                        <!-- BOTAO CADASTRAR CATEGORIA MODAL -->
                        @foreach($categorias as $categoria)
                        @if ($loop->first)
                        <a href="" data-toggle="modal" data-target="#modalCadastrar{{$categoria->id}}" data-whatever="{{$categoria->id}}" data-whatevernome="{{$categoria->nome}}" data-whateversetor="{{$categoria->produtoSetorId}}" data-whateverativo="{{$categoria->isAtivo}}"><button type="button" class="btn btn-primary waves-effect waves-light btnCadUser"><i class="fa fa-user-plus"></i>Cadastrar Categoria</button></a>

                        <!-- MODAL DE CADASTRAR -->
                        <div class="modal fade" id="modalCadastrar{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #0cb6734 !important; color: white">
                                        <h5 class="modal-title" id="exampleModalLongTitle" style="color: #fff">CATEGORIAS<i class="fa fa-help"></i></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" style="color: #fff">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{route ('salvarCategoria')}}" class="formEditUser">
                                            {{ csrf_field() }}
                                            <div class="card-header text-center">
                                                <h5>Cadastrar Categoria</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="form-group row">
                                                    <div class="col-sm-4">
                                                        <label for="produtoSetorId" class="control-label labelInputEditUser">Setor:</label>
                                                        <select class="form-control labelInputEditUser" name="produtoSetorId" id="produtoSetorId">
                                                            <option></option>
                                                            @foreach($setores as $setor)    
                                                            <option value="{{$setor->id}}">{{$setor->nome}}</option>
                                                            @endforeach  
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="nome" class="control-label labelInputEditUser">Nome da Categoria:</label>
                                                        <input type="text" class="form-control" name="nome" placeholder="Digite o nome da categoria" required>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="produtoUnidadeId" class="control-label labelInputEditUser">Ativo:</label>
                                                        <select class="form-control labelInputEditUser" name="isAtivo">
                                                            <option value="1">Ativo</option>
                                                            <option value="0">Inativo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="modal-footer modal-footer-formpag">
                                                <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i>Salvar</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            </div>       
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        <!-- FIM MODAL CADASTRO -->
                        @endif
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Setor</th>
                                            <th>Categoria</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>            
                                    <tbody>            
                                        @forelse($categorias as $categoria)
                                        <tr>
                                            <td>{{$categoria->id}}</td>
                                            <td>
                                                @foreach($setores as $setor)
                                                @if( $categoria->produtoSetorId == $setor->id)
                                                {{ $setor->nome }}   
                                                @endif
                                                @endforeach
                                            </td> 
                                            <td>{{$categoria->nome}}</td>                                
                                            <td>
                                                @if($categoria->isAtivo == 1)
                                                Ativo
                                                @else 
                                                Inativo
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::user()->can('update', $categoria))
                                                <!-- BOTAO EDITAR MODAL -->
                                                <a href="" data-toggle="modal" data-target="#modalEditar{{$categoria->id}}" data-whatever="{{$categoria->id}}" data-whatevernome="{{$categoria->nome}}" data-whateversetor="{{$categoria->produtoSetorId}}" data-whateverativo="{{$categoria->isAtivo}}"><img src="../../imgs/iconEdit.png" title="Editar Categoria" class="btnAcoes"></a>

                                                <!-- MODAL DE EDITAR -->
                                                <div class="modal fade" id="modalEditar{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #0cb6734 !important; color: white">
                                                                <h5 class="modal-title" id="exampleModalLongTitle" style="color: #fff">Categoria #{{$categoria->id}} <i class="fa fa-help"></i></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true" style="color: #fff">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="{{route ('atualizarCategoria', $categoria->id)}}" class="formEditUser">
                                                                    {{ csrf_field() }}
                                                                    <div class="card-header text-center">
                                                                        <h5>Editar Categoria</h5>
                                                                    </div>
                                                                    <div class="card-block">
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-4">
                                                                                <label for="produtoSetorId" class="control-label labelInputEditUser">Setor:</label>
                                                                                <select class="form-control labelInputEditUser" name="produtoSetorId" id="produtoSetorId" value="{{ $categoria->produtoSetorId }}">
                                                                                    @foreach($setores as $setor)    
                                                                                    <option value="{{ $setor->id }}" {{($categoria->produtoSetorId == $setor->id ? 'selected' : '')}}>{{ $setor->nome }}</option>
                                                                                    @endforeach  
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label for="nome" class="control-label labelInputEditUser">Nome da Categoria:</label>
                                                                                <input type="text" class="form-control" name="nome" placeholder="Digite o nome da categoria" value="{{$categoria->nome}}" required>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <label for="isAtivo" class="control-label labelInputEditUser">Status:</label>
                                                                                <select class="form-control labelInputEditUser" name="isAtivo">
                                                                                    <option value="1" {{ $categoria->isAtivo == 1 ? 'selected' : ''}}>Ativo</option>
                                                                                    <option value="0" {{ $categoria->isAtivo == 0 ? 'selected' : ''}}>Inativo</option>
                                                                                </select>
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
                                                @endif

                                                @if (Auth::user()->can('view', $categoria))
                                                <!-- BOTAO VISUALIZAR MODAL -->
                                                <a href="" data-toggle="modal" data-target="#modalVisualizar{{$categoria->id}}" data-whatever="{{$categoria->id}}" data-whatevernome="{{$categoria->nome}}" data-whateversetor="{{$categoria->produtoSetorId}}" data-whateverativo="{{$categoria->isAtivo}}"><img src="../../imgs/iconView.png" title="Visualizar Categoria" class="btnAcoes"></a>

                                                <!-- MODAL DE VISUALIZAR -->
                                                <div class="modal fade" id="modalVisualizar{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #0cb6734 !important; color: white">
                                                                <h5 class="modal-title" id="exampleModalLongTitle" style="color: #fff">Categoria #{{$categoria->id}} <i class="fa fa-help"></i></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true" style="color: #fff">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="{{route ('atualizarCategoria', $categoria->id)}}" class="formEditUser">
                                                                    {{ csrf_field() }}
                                                                    <div class="card-header text-center">
                                                                        <h5>Visualizar Categoria</h5>
                                                                    </div>
                                                                    <div class="card-block">
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-4">
                                                                                <label for="produtoSetorId" class="control-label labelInputEditUser">Setor:</label>
                                                                                <select disabled class="form-control labelInputEditUser" name="produtoSetorId" id="produtoSetorId" value="{{ $categoria->produtoSetorId }}">
                                                                                    @foreach($setores as $setor)    
                                                                                    <option value="{{ $setor->id }}" {{($categoria->produtoSetorId == $setor->id ? 'selected' : '')}}>{{ $setor->nome }}</option>
                                                                                    @endforeach  
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label for="nome" class="control-label labelInputEditUser">Nome da Categoria:</label>
                                                                                <input disabled type="text" class="form-control" name="nome" placeholder="Digite o nome do setor" value="{{$categoria->nome}}" required>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <label for="isAtivo" class="control-label labelInputEditUser">Status:</label>
                                                                                <select disabled class="form-control labelInputEditUser" name="isAtivo">
                                                                                    <option disabled {{ $categoria->isAtivo == 1 ? 'selected' : ''}}>Ativo</option>
                                                                                    <option disabled {{ $categoria->isAtivo == 0 ? 'selected' : ''}}>Inativo</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                                                                        </div>       
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                @endif
                                                <!-- FIM MODAL VISUALIZAR -->
                                                
                                                @if (Auth::user()->can('delete', $categoria))
                                                    <a href="{{route('excluirCategoria', $categoria->id)}}" onclick="return confirm('Tem certeza que deseja deletar este registro?')"><img src="../../imgs/iconTrash.png" title="Excluir Categoria" class="btnAcoes"></a>
                                                @endif
                                            </td>
                                        </tr>                         
                                        @empty
                                        <tr>
                                            <td colspan="200">Nenhum resultado encontrado!!</td>
                                        </tr>
                                        @endforelse                                
                                    </tbody>
                                </table> 
                                {!! $categorias->links() !!}
                            </div> 
                        </div>
                    </div>
                    @else
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <h3 style="color: red">Acesso NEGADO!!</h3>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endsection