@extends('layouts.principal')

@section('conteudo')
    <div class="produto">
        Cadastro de Produtos
    </div>

    {{-- {{dd($vars_localidade)}} --}}

    <form action="{{route('produtos.salvarCadastro')}}" method="POST">
        @csrf
     <div class="estoque_espacamento"></div>
        <div class="row">
            <div class="col-md-4">
              <input type="text" class="form-control form-control-lg w-75" required name="nome_produto" placeholder="Nome do Produto">
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control form-control-lg w-75" required name="descricao"  placeholder="Descrição do produto">
            </div>
            <div class="col-md-4">
              <input type="Date" class="form-control form-control-lg w-75" required name="validade"  placeholder="Validade do produto">
            </div>
        </div>
          
        <div class="row">
            {{-- <div class="col-md-4">
                <input type="number" class="form-control form-control-lg w-75" required name="lote"  placeholder="Lote">
            </div> --}}
            <div class="col-md-4">
                <input type="text" class="form-control form-control-lg w-75" required name="unidade_medida"  placeholder="Unidade de Medida">
            </div>
        </div>
       
       
        <div class="row">
            <div class="col-md-4">
                <input type="number" class="form-control form-control-lg w-75" required name="quantidade"  placeholder="Quantidade">
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control form-control-lg w-75" required name="cod_produto"  placeholder="Cod. Produto">
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-control form-control-lg w-75" name="nome_categoria" required>
                <option value="">Selecione uma Categoria</option>
                @foreach ($categoria as $categorias)
                    <option value="{{ $categorias->id_categoria }}">{{ $categorias->nome_categoria}}</option>
                @endforeach
            </select>
       </div>
    
        <div class="div_criar_categoria2">
            <button class="button_criar_categoria2" type="submit">Criar Produto</button>     
        </div>
              
    </form>    

@endsection