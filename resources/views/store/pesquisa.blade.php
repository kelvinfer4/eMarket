@extends('shared.layoutStore')

@section('conteudoStore')

<div class="col-sm-12 text-center"><h1>Resultados de "{{$busca}}":</h1></div>

<section class="containerFlex flex flex-wrap gridProducts">
    @forelse($produtos as $produto)

    <div class='itemFlex'>
        <figure class='card card-product effectHover'>
            <div class='img-wrap'><img src='../imgs/produtos/{{$produto->imagem1}}'></div>
            <figcaption class='info-wrap'>
                <h4 class='title'>{{$produto->produtoNome}}</h4>
            </figcaption>

            <div class='bottom-wrap'>
                <div class='price-wrap h5'>
                    <p><del class='price-old'>De: R$12,95</del></p>
                    <span class='price-new'>Por: R${{$produto->precoVenda}}</span>
                </div>

                <div class='col-sm-8 input-group seletorQtd'>
                    <span class='input-group-btn'>
                        <button type='button' class='quantity-left-minus btn btn-primary btn-number' data-type='minus' data-field=''>
                            <i class='fas fa-minus'></i>
                        </button>
                    </span>
                    <input type='text' id='quantity1' name='quantity1' class='form-control input-number' style='text-align: center' value='1' min='0' max='100'>
                    <span class='input-group-btn'>
                        <button type='button' class='addQtd btn btn-primary btn-number' data-type='plus' data-field=''>
                            <i class='fas fa-plus'></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="text-center">
                <a href="{{route ('addCarrinho', $produto->id)}}" class="btn btn-sm btn-primary btnCart"><i class='fas fa-cart-plus fa-2x'></i> Adicionar ao Carrinho</a></div>
        </figure>
    </div>
    @empty
    <h3>Nenhum produto encontrado!</h3>
    @endforelse
</section>

@endsection