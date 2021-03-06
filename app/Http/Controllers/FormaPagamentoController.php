<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FormaPagamento;

class FormaPagamentoController extends Controller
{
    public function cadastrarFormaPag()
    {
        return view('formaspagamentos.cadastrar');
    }

    public function listarFormasPag()
    {
        $formasPagamentos = FormaPagamento::where('isAtivo', 1)->get();
        return view('formaspagamentos.listar', compact('formasPagamentos'));
    }

    public function salvarFormaPag(Request $request)
    {
        $dados = $request->all();
        FormaPagamento::create($dados);
 
        return redirect()->route('listarFormasPag');
    }

    public function excluirFormaPag($id)
    {
        $formaPag = FormaPagamento::find($id);

        $formaPag->isAtivo = 0;

        $formaPag->update();

        return redirect()->route('listarFormasPag');
    }

    public function visualizarFormaPag($id)
    
    {
        $formaPag = FormaPagamento::find($id);

        return view('formaspagamentos.visualizar', compact('formaPag'));
    }

    public function atualizarFormaPag(Request $request, $id)
    {
        $dados = $request->all();
        $formaPag = FormaPagamento::find($id);
 
        $formaPag->update($dados);

        return redirect()->route('listarFormasPag');
    }

    public function editarFormaPag($id)
    {
        $formaPag = FormaPagamento::find($id);
        
        return view('formaspagamentos.editar', compact('formaPag'));
    }


}
