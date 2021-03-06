<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Produto;
use App\Setor;
use App\Categoria;
use App\Unidade;
use App\Fornecedor;
use PDF;
use View;
use Auth;

class ProdutoController extends Controller {

    private $produto;

    public function __construct(Produto $produto) {
        $this->produto = $produto;
    }

    public function cadastrarProduto() {
        $setores = Setor::where('isAtivo', 1)->get();
        $unidades = Unidade::where('isAtivo', 1)->get();
        $categorias = Categoria::where('isAtivo', 1)->get();
        $fornecedores = Fornecedor::where('isAtivo', 1)->get();
        return view('produtos.cadastrar', compact('setores', 'unidades', 'categorias', 'fornecedores'));
    }

    public function listarProdutos() {
        $produtos = Produto::where('isAtivo', 1)
                    ->paginate(10);
        $setores = Setor::where('isAtivo', 1)->get();
        $unidades = Unidade::where('isAtivo', 1)->get();
        $categorias = Categoria::where('isAtivo', 1)->get();
        $fornecedores = Fornecedor::where('isAtivo', 1)->get();

        return view('produtos.listar', compact('produtos', 'setores', 'unidades', 'categorias', 'fornecedores'));
    }

    public function salvarProduto(Request $request) {
        
        $dados = $request->all();

        $codBarras = $request->codBarras;

        $this->validate($request, $this->produto->rules, $this->produto->messages);

        $prod = new Produto();
        $prod->codBarras = $request->codBarras;
        $prod->produtoNome = $request->produtoNome;
        $prod->qtd = $request->qtd;
        $prod->qtdMin = $request->qtdMin;
        $prod->precoCusto = $request->precoCusto;
        $prod->precoVenda = $request->precoVenda;
        $prod->precoVendaAnterior = $request->precoVenda + 0.30;
        $prod->margemLucro = $request->margemLucro;
        $prod->produtoSetorId = $request->produtoSetorId;
        $prod->produtoCategoriaId = $request->produtoCategoriaId;
        $prod->produtoMarca = $request->produtoMarca;
        $prod->produtoUnidadeId = $request->produtoUnidadeId;
        $prod->produtoFornecedorId = $request->produtoFornecedorId;
        $prod->isPromocao = $request->isPromocao;
        $prod->isAtivo = $request->isAtivo;
        $prod->save();
        $id = $prod->id;

        if ($request->hasFile('file')) {
            $contador = 1;
            foreach ($request->file as $file) {
                $file_extension = $file->getClientOriginalExtension();
                $filename = $id . "-" . $contador . "." . $file_extension;
                DB::table('produtos')
                        ->where('id', $id)
                        ->update(array('imagem' . $contador => $filename));
                $destination_path = public_path('/imgs/produtos');
                $file->move($destination_path, $filename);
                $contador = $contador + 1;
            }
        }

        return redirect()->route('listarProdutos');
    }

    public function visualizarProduto($id) {
        $produto = Produto::find($id);
        $setores = Setor::where('isAtivo', 1)->get();
        $unidades = Unidade::where('isAtivo', 1)->get();
        $categorias = Categoria::where('isAtivo', 1)->get();
        $fornecedores = Fornecedor::where('isAtivo', 1)->get();

        return view('produtos.visualizar', compact('produto', 'setores', 'unidades', 'categorias', 'fornecedores'));
    }

    public function excluirProduto($id) {
        
        // verifica se o usuario tem permissao para realizar esta acao
        $this->authorize('delete', Auth::user());
        
        $produto = Produto::find($id);

        $produto->isAtivo = 0;

        $produto->update();

        return redirect()->route('listarProdutos');
    }
    
    public function excluirProd($id)
    {
        $produto = Produto::find($id);

        $produto->isAtivo = 0;

        $produto->update();

        return redirect()->route('listarFretes');
    }

    public function editarProduto($id) {
        $produto = Produto::find($id);
        $setores = Setor::where('isAtivo', 1)->get();
        $unidades = Unidade::where('isAtivo', 1)->get();
        $categorias = Categoria::where('isAtivo', 1)->get();
        $fornecedores = Fornecedor::where('isAtivo', 1)->get();

        return view('produtos.editar', compact('produto', 'setores', 'unidades', 'categorias', 'fornecedores'));
    }

    public function atualizarProduto(Request $request, $id) {
        
        // verifica se o usuario tem permissao para realizar esta acao
        $this->authorize('update', Auth::user());
        
        $dados = $request->all();
        $produto = Produto::find($id);
        $codBarras = $request->codBarras;

        // verifica se o preco de venda da alteracao é maior que o preco anterior
        if ($request->precoVenda > $produto->precoVendaAnterior) {
            $produto->precoVendaAnterior = $request->precoVenda + 0.29;
        } else if ($request->precoVenda == $produto->precoVendaAnterior) {
            $produto->precoVendaAnterior = $request->precoVenda + 0.29;
        } else if ($request->precoVenda > $produto->precoVenda) {
            $produto->precoVenda = $request->precoVenda;
        } else {
            $produto->precoVendaAnterior = $produto->precoVenda;
            $produto->precoVenda = $request->precoVenda;
        }

        $produto->update($dados);
        $id = $produto->id;

        if ($request->hasFile('file')) {
            $contador = 1;
            foreach ($request->file as $file) {
                $file_extension = $file->getClientOriginalExtension();
                $filename = $id . "-" . $contador . "." . $file_extension;
                DB::table('produtos')
                        ->where('id', $id)
                        ->update(array('imagem' . $contador => $filename));
                $destination_path = public_path('/imgs/produtos');
                $file->move($destination_path, $filename);
                $contador = $contador + 1;
            }
        }

        return redirect()->route('listarProdutos');
    }
    
    public function visualizarRelProdutos() {
        return view('relatorios.produtos.listar');
    }
    
    public function relEstoqueMin() {
        
        $produtos = Produto::all();

        $pdf = \App::make('dompdf.wrapper');
        $view = View::make('relatorios.produtos.relatorioQtdMin', compact('produtos', 'fornecedores'))->render();
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    public function getCategoriasAjax(Request $request) {
        $categoriasAjax = DB::table("produtocategorias")
                ->where("produtoSetorId", $request->produtoSetorId)
                ->pluck("nome", "id");
        return response()->json($categoriasAjax);
    }

    public function pesquisarProduto(Request $request) {

        $produtos = $this->produto->pesquisa($request);
        $setores = Setor::where('isAtivo', 1)->get();
        $unidades = Unidade::where('isAtivo', 1)->get();
        $categorias = Categoria::where('isAtivo', 1)->get();
        $fornecedores = Fornecedor::where('isAtivo', 1)->get();

        return view('produtos.listar', compact('produtos', 'setores', 'unidades', 'categorias', 'fornecedores'));
    }

}
