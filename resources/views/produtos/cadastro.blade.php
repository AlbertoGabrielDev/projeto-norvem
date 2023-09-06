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
            <div class="col-md-4">
                <input type="number" class="form-control form-control-lg w-75" required name="lote"  placeholder="Lote">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-lg w-75" required name="unidade_medida"  placeholder="Unidade de Medida">
            </div>
            <div class="col-md-4">
                <input type="Number" class="form-control form-control-lg w-75" required name="preco_venda" placeholder="Preço">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <select class="form-control form-control-lg w-75" name="categoria" required>
                    <option value="">Selecione uma Marca</option>
                    @foreach ($marca as $marcas)
                        <option value="{{ $marcas->id_marca }}">{{ $marcas->nome_marca }}</option>
                    @endforeach
                </select>
           </div>
           <div class="col-md-4">
                <select class="form-control form-control-lg w-75" name="categoria" required>
                    <option value="">Selecione uma Categoria</option>
                    @foreach ($categoria as $categorias)
                        <option value="{{ $categorias->id_categoria }}">{{ $categorias->nome_categoria }}</option>
                    @endforeach
                </select>
           </div>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-lg w-75" required name="localizacao"  placeholder="Localização no Estoque">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input type="Date" class="form-control form-control-lg w-75" required name="data_chegada"  placeholder="Data de Entrega">
            </div>
            {{-- <div class="col-md-4">
                <input type="Date" class="form-control form-control-lg w-75" required name="data_cadastro"  placeholder="Data de Cadastro">
            </div> --}}
            <div class="col-md-4">
                <select class="form-control form-control-lg w-75" name="categoria" required>
                    <option value="">Selecione um Fornecedor</option>
                    @foreach ($fornecedor as $fornecedores)
                        <option value="{{ $fornecedores->id_fornecedor }}">{{ $fornecedores->nome_fornecedor }}</option>
                    @endforeach
                </select>
           </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input type="number" required class="form-control form-control-lg w-75" name="preco_custo"  placeholder="Preço Fornecedor">
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control form-control-lg w-75" required name="quantidade"  placeholder="Quantidade">
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control form-control-lg w-75" required name="cod_produto"  placeholder="Cod. Produto">
            </div>
        </div>
    
        <div class="div_criar_categoria2">
            <button class="button_criar_categoria2" type="submit">Criar Produto</button>     
        </div>
              
    </form>    

@endsection