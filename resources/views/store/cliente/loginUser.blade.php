@extends('shared.layoutStore')

@section('conteudoStore')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" action="{{route ('logarUser')}}" method="post" role="form" style="display: block;">
                                {{ csrf_field() }}
                                <center><img src="http://www.fenixaerocarga.com.br/img/avatar.png" width="30%"></center>
                                <div class="form-group">
                                    <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="senha" id="senha" tabindex="2" class="form-control" placeholder="Senha" required>
                                </div>
                                <div class="col-xs-6 form-group pull-left checkbox">
                                    <input id="checkbox1" type="checkbox" name="remember">
                                    <label for="checkbox1">Lembrar-me</label>   
                                </div>
                                <div class="col-xs-6 form-group pull-right">     
                                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                                </div>
                            </form>
                            <form id="register-form" action="{{route ('cadastroCliente')}}" method="post" role="form" style="display: none;">
                                {{ csrf_field() }}
                                <div class="col-sm-12">
                                    <center><img src="https://www.like4like.org/img/login/register.png" width="30%"></center>
                                </div>
                                <center><div class="col-sm-12"><h1>CADASTRO</h1></div></center>
                                <div class="form-group">
                                    <input type="text" name="nome" id="nome" tabindex="1" class="form-control" placeholder="Nome Completo" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="password" name="senha" id="senha" tabindex="2" class="form-control" placeholder="Senha" required>
                                </div>

                                <div class="form-group col-sm-6">
                                    <input type="text" name="cpf" id="cpf" tabindex="2" class="form-control" placeholder="CPF" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <p>Sexo:</p>
                                    <label class="radio-inline">
                                        <input type="radio" name="sexo" value="1" checked>Masculino
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="sexo" value="2">Feminino
                                    </label>
                                </div>

                                <div class="form-group col-sm-6">
                                    <p>Data Nascimento:</p>
                                    <input type="date" name="dataNasc" id="dataNasc" tabindex="2" class="form-control" required placeholder="CPF">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" name="cep" id="cep" tabindex="2" class="form-control" required placeholder="CEP">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" name="estado" id="estado" tabindex="2" class="form-control" required placeholder="Estado">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="municipio" id="municipio" tabindex="2" class="form-control" required placeholder="Municipio">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="logradouro" id="logradouro" tabindex="2" class="form-control" required placeholder="Logradouro">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" name="numero" id="numero" tabindex="2" class="form-control" required placeholder="Número">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" name="bairro" id="bairro" tabindex="2" class="form-control" required placeholder="Bairro">
                                </div>  

                                <div class="form-group">
                                    <input type="text" name="fone" id="fone" tabindex="2" class="form-control" required placeholder="Contato">
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Criar minha conta">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6 tabs">
                            <a href="#" class="active" id="login-form-link"><div class="login">LOGIN</div></a>
                        </div>
                        <div class="col-xs-6 tabs">
                            <a href="#" id="register-form-link"><div class="register">CRIAR CONTA</div></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#login-form-link').click(function (e) {
            $("#login-form").delay(100).fadeIn(100);
            $("#register-form").fadeOut(100);
            $('#register-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });
        $('#register-form-link').click(function (e) {
            $("#register-form").delay(100).fadeIn(100);
            $("#login-form").fadeOut(100);
            $('#login-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });
    });
</script>

@endsection