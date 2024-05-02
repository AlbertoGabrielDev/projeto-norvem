<?php
namespace App\Http\Controllers;
use App\Models\Estoque;
use App\Models\Marca;
use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\Categoria;
use App\Models\MarcaProduto;
use App\Models\Historico;
use App\Models\CategoriaProduto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidacaoEstoque;
use App\Repositories\EstoqueRepository;
use Illuminate\Http\Request as Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class EstoqueController extends Controller
{    
    protected $estoqueRepository;
    public function __construct(EstoqueRepository $estoqueRepository)
    {
        $this->estoqueRepository = $estoqueRepository;
    }
    public function index()
    {
        $estoques = $this->estoqueRepository->index();
        return view('estoque.index', $estoques);
    }

    public function historico()
    { 
        $historicos = $this->estoqueRepository->historico();
        return view('estoque.historico', compact('historicos'));
    }

    public function cadastro()
    {
        $cadastro = $this->estoqueRepository->cadastro();
        return view('estoque.cadastro',$cadastro);
    }

    public function buscar(Request $request)
    {
        $buscar = $this->estoqueRepository->buscar($request);
        return view('estoque.index',$buscar);
    }

    public function inserirEstoque(ValidacaoEstoque $request)
    { 
        $this->estoqueRepository->inserirEstoque($request);
        return redirect()->route('estoque.index')->with('success', 'Inserido com sucesso');
    }

    public function editar($estoqueId)
    {
        $editar = $this->estoqueRepository->editar($estoqueId);
        return view('estoque.editar', $editar);
    }

    public function salvarEditar(ValidacaoEstoque $request, $estoqueId)
    {
        $this->estoqueRepository->salvarEditar($request,$estoqueId);
        return redirect()->route('estoque.index')->with('success', 'Editado com sucesso');
    }

    public function status($statusId)
    {
      $status = $this->estoqueRepository->status($statusId);
      return response()->json(['status' => $status->status]);
    }

    public function quantidade(Requests $request,$estoqueId, $operacao)
    {
        $this->estoqueRepository->quantidades($request, $estoqueId , $operacao);
 
        return redirect()->route('estoque.index')->with('success', 'Quantidade atualizada com sucesso');
    }

    public function ano()
    {
      $quantidade = $this->estoqueRepository->ano();
 
        return response()->json($quantidade);
    }
}
