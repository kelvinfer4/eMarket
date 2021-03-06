<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Usuario;
use App\Cliente;
use App\Setor;
use App\Categoria;
use App\Pedido;
use App\Produto;
Use App\Models\Venda;
class AutenticacaoController extends Controller {

    public function manager() {
        
        $clientes = Cliente::count();
        $pedidos = Pedido::count();
        $produtos = Produto::count();
        $data = date('Y-m-d');
        
        $vendaAprovadas = DB::table('vendas')
                ->where('data', '=', $data)
                ->where('status', '=', 1)
                ->sum('total');
        
        $vendasConcluidas = DB::table('vendas')
                ->where('data', '=', $data)
                ->where('status', '=', 2)
                ->sum('total');
        
        $vendasDia = $vendaAprovadas + $vendasConcluidas;
        
        return view('manager', compact('clientes', 'pedidos', 'produtos', 'vendasDia'));
        
    }

    public function login() {
        return view('autenticacao.login');
    }

    public function loginCliente() {
        $setores = Setor::all();
        $categorias = Categoria::all();
        session(['link' => url()->previous()]);
        
        return view('store.cliente.loginUser', compact('setores', 'categorias'));
    }

    public function logar(Request $request) {
        $dados = $request->all();

        $email = $dados['email'];
        $password = $dados['password'];

        $usuario = Usuario::where('email', $email)->first();

        if (Auth::check() || ($usuario && Hash::check($password, $usuario->password))) {
            Auth::login($usuario);
            return redirect(route('manager'));
        } else {
            return redirect()
                            ->route('login')
                            ->withErrors(['Login e/ou senha inválido(s)!']);
        }
    }

    public function logarCliente(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('clientes')->attempt($credentials))
            return redirect(route('minhaConta'));

        return redirect()
                        ->route('loginCliente')
                        ->withInput()
                        ->withErrors(['Login e/ou senha inválido(s)!']);
    }

    public function logout() {
        Auth::logout();
        return redirect(route('login'));
    }

    public function logoutCliente() {
        Auth()->guard('clientes')->logout();
        return redirect(route('loginCliente'));
    }

}
