@extends('layouts.principal')

@section('conteudo')
<div class="container d-flex justify-content-between align-items-center">
  <div class="mx-auto">
    <h1 class="card-title">Editar Produtos</h1>
  </div>
  <div>
    <a class="btn btn-primary" href="{{route('categoria.inicio')}}">Voltar</a>
  </div>
</div>
<form action="{{route('produtos.salvarEditar', $produtos->first()->id_produto)}}" method="POST">
  @csrf
  @foreach ($produtos as $produto)
  {{-- {{dd($produto)}} --}}
    <div class="input-group input-group-lg">
      <span class="input-group-text" id="inputGroup-sizing-lg">Cod. Produto</span>
      <input type="number" name="cod_produto" class="form-control" aria-label="Sizing example input" value="{{$produto->cod_produto}}">
      <span class="input-group-text" id="inputGroup-sizing-lg">Produto</span>
      <input type="text" name="nome_produto" class="form-control" aria-label="Sizing example input" value="{{$produto->nome_produto}}">
      <span class="input-group-text" id="inputGroup-sizing-lg">Descrição</span>
      <input type="text" name="descricao" class="form-control" aria-label="Sizing example input" value="{{$produto->descricao}}">
    </div>
    <div class="input-group input-group-lg">
      <span class="input-group-text" id="inputGroup-sizing-lg">Uni. Medida</span>
      <input type="text" name="unidade_medida" class="form-control" aria-label="Sizing example input" value="{{$produto->unidade_medida}}">
      <span class="input-group-text" id="inputGroup-sizing-lg">Inf. Nutricionais</span>
      <input type="text" name="inf_nutrientes" class="form-control" aria-label="Sizing example input" value="{{$produto->inf_nutrientes}}">
      <span class="input-group-text" id="inputGroup-sizing-lg">Validade</span>
      <input type="date" name="validade" class="form-control" aria-label="Sizing example input" value="{{$produto->validade}}">
    </div>
 @endforeach
 <div class="input-group input-group-lg w-25">
  <select class="form-select" aria-label="Default select example" name="nome_categoria">
    @foreach ($categorias as $categoria)
        <option value="{{ $categoria->id_categoria }}" >{{ $categoria->nome_categoria }}</option>
    @endforeach
</select>
</div>
    <button class="" type="submit">Editar</button>
</form>
{{-- <script>
  $(document).ready(function() {
      var categoriaAtual = "{{$categorias->first()->nome_categoria}}";
    console.log(categoriaAtual);
      $("#nome_categoria").find("option:contains('" + categoriaAtual + "')").prependTo("#nome_categoria");
      $("#nome_categoria").val(categoriaAtual);
  });
  </script> --}}
@endsection