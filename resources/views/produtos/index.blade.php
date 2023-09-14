@extends('layouts.principal')

@section('conteudo')
<div class="categoria">Index Produtos</div> 
<div class="div_criar_produto">
    <a class="button_criar_produto" href="{{route('produtos.cadastro')}}">Cadastrar Produto</a>     
</div>
<form action="{{ route('produtos.buscar') }}" method="GET">
    <input type="text" name="nome_produto" placeholder="Digite nome do produto">
    <button type="submit">Pesquisar</button>
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
        @foreach ($produto as $produtos)
            <tr>
              <td>{{$produtos->cod_produto}}</td>
              <td>{{$produtos->nome_produto}}</td>
              <td>{{$produtos->descricao}}</td>
              <td>{{$produtos->unidade_medida}}</td>
              <td>{{$produtos->inf_nutrientes}}</td>
              <td>{{ \Carbon\Carbon::parse($produtos->validade)->format('d/m/Y') }}</td> 
            </tr>
            @endforeach
    </tbody>
</table>
@endsection