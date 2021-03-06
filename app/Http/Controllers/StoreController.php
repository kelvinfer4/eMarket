<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Produto;
use App\Setor;
use App\Categoria;

class StoreController extends Controller {

    private $produto;

    public function __construct(Produto $produto) {
        $this->produto = $produto;
    }

    public function index() {
        $produtos = Produto::all();
        $ofertas = $produtos->sortBy('produtoNome')->where('isPromocao', 1);
        $setores = Setor::all();
        $categorias = Categoria::all();

        return view('store.index', compact('produtos', 'ofertas', 'setores', 'categorias'));
    }

    public function carrinho() {
        $produtos = Produto::all();
        $setores = Setor::all();
        $categorias = Categoria::all();

        return view('store.carrinho', compact('produtos', 'setores', 'categorias'));
    }

    public function buscaProduto(Request $request) {
        $busca = $request->key_search;
        $produtos = $this->produto->pesquisa($request);
        $setores = Setor::all();
        $categorias = Categoria::all();

        return view('store.pesquisa', compact('produtos', 'busca', 'setores', 'categorias'));
    }

    public function buscaMenu($setor, $categoria) {
        $setores = Setor::all();
        $categorias = Categoria::all();
        
        $busca = Produto::orderBy('produtos.produtoNome')
                ->join('produtosetores', 'produtosetores.id', '=', 'produtos.produtoSetorId')
                ->join('produtocategorias', 'produtocategorias.id', '=', 'produtos.produtoCategoriaId')
                ->where('produtosetores.nome', $setor)
                ->where('produtocategorias.nome', $categoria)
                ->get();
        
        return view('store.categorias', compact('busca', 'setores', 'categorias'));
    }
    
    public function resetPassword(){
        return view('auth.passwords.reset');
    }
    
    public function metodoPagamento(){
        $setores = Setor::all();
        $categorias = Categoria::all();
        
        return view('store.pedido.metodoPagamento', compact('setores', 'categorias'));
    }

}
