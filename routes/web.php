<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MarcaController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('/verdurao')->group(function(){
    Route::prefix('/categoria')->group(function(){
        Route::get('/',[CategoriaController::class, 'Inicio'])->name('categoria.inicio');
        Route::get('/index',[CategoriaController::class, 'Index'])->name('categoria.index');
        Route::get('/cadastro',[CategoriaController::class, 'cadastro'])->name('categoria.cadastro');
        Route::post('/cadastro',[CategoriaController::class, 'inserirCategoria'])->name('categoria.inserirCategoria');
        Route::get('/produto/{categoria}',[CategoriaController::class, 'produto'])->name('categorias.produto');
        Route::get('/editar/{categoriaId}',[CategoriaController::class, 'editar'])->name('categorias.editar');
        Route::post('/editar/{categoriaId}',[CategoriaController::class, 'salvarEditar'])->name('categorias.salvarEditar');
        Route::post('/status/{categoriaId}',[CategoriaController::class, 'status'])->name('categorias.status');
        Route::post('/produto/status/{produtoId}',[ProdutoController::class, 'status'])->name('produtos.status');
    });

    Route::prefix('/produtos')->group(function(){
        Route::get('/',[ProdutoController::class, 'produtos'])->name('produtos.inicio');
        Route::get('/index',[ProdutoController::class, 'Index'])->name('produtos.index');
        Route::get('/cadastro',[ProdutoController::class, 'cadastro'])->name('produtos.cadastro');
        Route::post('/salvar-cadastro',[ProdutoController::class, 'inserirCadastro'])->name('produtos.salvarCadastro');
        Route::get('/buscar-produto',[ProdutoController::class, 'buscarProduto'])->name('produtos.buscar');
        Route::get('/editar/{produtoId}',[ProdutoController::class, 'editar'])->name('produtos.editar');
        Route::post('/editar/{produtoId}',[ProdutoController::class, 'salvarEditar'])->name('produtos.salvarEditar');
        Route::post('/status/{produtoId}',[ProdutoController::class, 'status'])->name('produtos.');
    });
     
    Route::prefix('/estoque')->group(function(){
        Route::get('/',[EstoqueController::class, 'Index'])->name('estoque.index');
        Route::get('/cadastro',[EstoqueController::class, 'Cadastro'])->name('estoque.cadastro');
        Route::post('/cadastro',[EstoqueController::class, 'inserirEstoque'])->name('estoque.inserirEstoque');
        Route::get('/buscar-estoque',[EstoqueController::class, 'buscar'])->name('estoque.buscar');
        Route::get('/editar/{estoqueId}',[EstoqueController::class, 'editar'])->name('estoque.editar');
        Route::post('/editar/{estoqueId}',[EstoqueController::class, 'salvarEditar'])->name('estoque.salvarEditar');
        Route::post('/status/{estoqueId}',[EstoqueController::class, 'status'])->name('estoque.status');
        Route::get('/quantidade/{quantidadeId}/{operacao}',[EstoqueController::class, 'quantidade'])->name('estoque.quantidade');
    });

    Route::prefix('/fornecedor')->group(function(){
        Route::get('/',[FornecedorController::class, 'index'])->name('fornecedor.index');
        Route::get('/cadastro',[FornecedorController::class, 'Cadastro'])->name('fornecedor.cadastro');
        Route::post('/cadastro',[FornecedorController::class, 'inserirCadastro'])->name('fornecedor.inserirCadastro');
        Route::get('/cidade/{estado}',[FornecedorController::class, 'getCidade'])->name('fornecedor.cidade');
        Route::get('/buscar-fornecedor',[FornecedorController::class, 'Buscar'])->name('fornecedor.buscar');
        Route::get('/editar/{fornecedorId}',[FornecedorController::class, 'editar'])->name('fornecedor.editar');
        Route::post('/editar/{fornecedorId}',[FornecedorController::class, 'salvarEditar'])->name('fornecedor.salvarEditar');
        Route::post('/status/{fornecedorId}',[FornecedorController::class, 'status'])->name('fornecedor.status');
    });

    Route::prefix('/marca')->group(function(){
        Route::get('/index',[MarcaController::class, 'index'])->name('marca.index');
        Route::get('/cadastro',[MarcaController::class, 'cadastro'])->name('marca.cadastro');
        Route::post('/cadastro',[MarcaController::class, 'inserirMarca'])->name('marca.inserirMarca');
        Route::get('/buscar-marca',[MarcaController::class, 'Buscar'])->name('marca.buscar');
        Route::get('/editar/{marcaId}',[MarcaController::class, 'editar'])->name('marca.editar');
        Route::post('/editar/{marcaId}',[MarcaController::class, 'salvarEditar'])->name('marca.salvarEditar');
        Route::post('/status/{marcaId}',[MarcaController::class, 'status'])->name('marca.status');
    });

    Route::prefix('/usuario')->group(function(){
        Route::get('/index', [UsuarioController::class , 'index'])->name('usuario.index');
        Route::get('/cadastro', [UsuarioController::class , 'cadastro'])->name('usuario.cadastro');
        Route::get('/editar/{userId}', [UsuarioController::class , 'editar'])->name('usuario.editar');
        Route::post('/status/{userId}',[UsuarioController::class, 'status'])->name('usuario.status');
        Route::post('/editar/{userid}',[UsuarioController::class, 'salvarEditar'])->name('usuario.salvarEditar');
        Route::get('/buscar-usuario',[UsuarioController::class, 'Buscar'])->name('usuario.buscar');
    });

});

// Route::post('/logout', function () {
//     Auth::logout();
//     return redirect('/login');
// })->name('logout');