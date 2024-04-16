<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Support\Facades\Gate;
use App\Models\Categoria;
use App\Models\CategoriaProduto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Http\Requests\ValidacaoProduto;
use App\Http\Requests\ValidacaoProdutoEditar;
use App\Repositories\ProdutoRepository;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    protected $produtoRepository;
    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }
    public function Index()
    {
        $produtos = $this->produtoRepository->getAll();
        return view('produtos.index', compact('produtos'));
    }

    public function Cadastro(Request $request) 
    {
        $categorias = Categoria::all();
        return view('produtos.cadastro',compact('categorias'));
    }

    public function inserirCadastro(ValidacaoProduto $request)
    {
        $this->produtoRepository->create($request);
        return redirect()->route('produtos.index')->with('success', 'Inserido com sucesso');
    }

    public function buscarProduto(Request $request)
    {
        $produtos = $this->produtoRepository->buscar($request);
        return view('produtos.index', compact('produtos'));
    }

    public function editar($produtoId) 
    {
        $produtos = $this->produtoRepository->editarView($produtoId);
      
        return view('produtos.editar',compact('produtos'));    
    }

    public function salvarEditar(ValidacaoProdutoEditar $request, $produtoId)
    {  
        $this->produtoRepository->update($request,$produtoId);
        return redirect()->route('produtos.index')->with('success', 'Editado com sucesso');
    }
    public function status($statusId)
    {
       $status = $this->produtoRepository->statusInativar($statusId);

        return response()->json(['status' => $status->status]);
    }

    // public function grafico(){
    //     return view('charts.vue');
    // }
}
