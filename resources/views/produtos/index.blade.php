@extends('layouts.principal')

@section('conteudo')
<div class="container d-flex justify-content-between align-items-center">
  <div class="mx-auto">
    <h1 class="card-title">Index Produtos</h1>
  </div>
  <div>
    <a class="btn btn-primary" href="{{route('categoria.inicio')}}">Voltar</a>
  </div>
</div>

<div class="div_criar_produto">
  <a class="button_criar_produto" href="{{route('produtos.cadastro')}}">Cadastrar Produto</a>     
</div>

<form action="{{ route('produtos.buscar') }}" method="GET" class="d-flex">
  <input type="text" name="nome_produto" class="form-control w-25" placeholder="Digite o nome do Produto">
  <button class="btn btn-outline-success" type="submit">Pesquisar</button>
</form>

<table class="table mt-5">
    <thead>
      <tr>
        <th scope="col">Cod. Produto</th>
        <th scope="col">Nome Produto</th>
        <th scope="col">Descrição</th>
        <th scope="col">Unidade de Medida</th>
        <th scope="col">Infor. Nutricional</th>
        <th scope="col">Validade</th>
        <th>Editar</th>
        <th>Inativar</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($produtos as $produto)
          <tr>
            <td>{{$produto->cod_produto}}</td>
            <td>{{$produto->nome_produto}}</td>
            <td>{{$produto->descricao}}</td>
            <td>{{$produto->unidade_medida}}</td>
            <td>
              <button class="btn btn-primary btn-show-nutrition" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop" data-produto-id="{{ $produto->id_produto }}">Infor. Nutricionais</button>
              <span class="nutritional-info" data-produto-id="{{ $produto->id_produto }}" style="display: none;">{{ $produto->inf_nutrientes }}</span>
            </td>
            <td class= "expiration-date" id="data">{{($produto->validade)}}</td>
            <td><a href="{{route('produtos.editar', $produto->id_produto)}}" class="btn btn-primary">Editar</a></td>
            <td>
              <button class="btn btn-primary toggle-ativacao @if($produto->status === 1) btn-danger @elseif($produto->status === 0) btn-success @else btn-primary @endif"
                data-id="{{ $produto->id_produto }}">
                {{ $produto->status ? 'Inativar' : 'Ativar' }}
              </button>
            </td>
          </tr>
        @endforeach
    </tbody>
</table>
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Informações Nútricionais</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <p id="nutritional-info">{{ $produto->inf_nutrientes }}</p>
  </div>
</div>

<nav class="Page navigation example">
  <ul class="pagination">
    {{ $produtos->links()}}
  </ul>
</nav>
@endsection