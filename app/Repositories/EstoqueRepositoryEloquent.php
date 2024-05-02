<?php

namespace App\Repositories;

use App\Http\Requests\ValidacaoEstoque;
use App\Models\Categoria;
use App\Models\Estoque;
use App\Models\Fornecedor;
use App\Models\Historico;
use App\Models\Marca;
use App\Models\MarcaProduto;
use App\Models\Produto;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EstoqueRepository;
use Illuminate\Support\Facades\Auth;
use App\Validators\EstoqueValidator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as Requests;

/**
 * Class EstoqueRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EstoqueRepositoryEloquent extends BaseRepository implements EstoqueRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Estoque::class;
    }

    public function index()
    {
        $fornecedores = Fornecedor::all();
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $produtos = Produto::paginate(2);
        if (Gate::allows('permissao')) {
            $estoques = [];
            foreach ($produtos as $produto) 
            {
                $estoquesProduto = $produto->fornecedores->pluck('estoque')->all();
                $estoques = array_merge($estoques, $estoquesProduto); 
            }
        } else {
            $estoques = [];
            foreach ($produtos as $produto) 
            {
                $estoquesProduto = $produto->fornecedores->pluck('estoque')->where('status', 1)->all();
                $estoques = array_merge($estoques, $estoquesProduto); 
            }
        }
        return compact('estoques','produtos','fornecedores','marcas','categorias');
    }

    public function inserirEstoque(ValidacaoEstoque $request)
    {
        $estoque = Estoque::create([
            'quantidade'        =>$request->quantidade,
            'localizacao'       =>$request->localizacao,
            'preco_custo'       =>$request->preco_custo,
            'preco_venda'       =>$request->preco_venda,
            'data_chegada'      =>$request->data_chegada,
            'lote'              =>$request->lote,
            'id_produto_fk'     =>$request->input('nome_produto'),
            'id_fornecedor_fk'  =>$request->input('fornecedor'),
            'id_marca_fk'       =>$request->input('marca'),
            'quantidade_aviso'  =>$request->quantidade_aviso,
            'validade'          =>$request->validade,
            'id_users_fk'       =>Auth::id()
        ]);

      $marcaProduto = MarcaProduto::create([
            'id_produto_fk'     =>$request->input('nome_produto'),
            'id_marca_fk'       =>$request->input('marca')
        ]);
      //  return redirect()->route('estoque.index')->with('success', 'Inserido com sucesso');
      
    }

    public function historico()
    { 
        $historicos = Cache::remember('historico', now()->addMinutes(1), function () {
            $historicos = Historico::with('estoques')->get();
            return $historicos;
        });
        return $historicos;
    }

    public function cadastro()
    {
        $produtos = Produto::all();
        $marcas = Marca::all();
        $fornecedores = Fornecedor::all();
        return compact('fornecedores','marcas','produtos');
    }

    public function buscar(Request $request)
    {
        $fornecedores = Fornecedor::all();
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $produtos = Produto::paginate(2);
        if (Gate::allows('permissao')) {
            $estoques = [];
            foreach ($produtos as $produto) 
            {
                $estoquesProduto = $produto->search->pluck('estoque')->all();
                $estoques = array_merge($estoques, $estoquesProduto);
            }
        } else {
            $estoques = [];
            foreach ($produtos as $produto) 
            {
                $estoquesProduto = $produto->search->pluck('estoque')->where('status', 1)->all();
                $estoques = array_merge($estoques, $estoquesProduto); 
            }
        }
        
        return  compact('estoques', 'produtos','fornecedores','marcas','categorias');
    }

    public function editar($estoqueId)
    {
        $produtos = Estoque::find($estoqueId)->produtos->merge(Produto::all());
        $fornecedores = Estoque::find($estoqueId)->fornecedores->merge(Fornecedor::all());
        $marcas = Estoque::find($estoqueId)->marcas->merge(Marca::all());
        $estoques = Estoque::where('id_estoque', $estoqueId)->get();

        return compact('estoques','produtos','fornecedores','marcas');
    }

    public function salvarEditar(ValidacaoEstoque $request, $estoqueId)
    {
        $estoques = Estoque::where('id_estoque' , $estoqueId)
        ->update([
            'localizacao'       =>$request->localizacao,
            'preco_custo'       =>$request->preco_custo,
            'preco_venda'       =>$request->preco_venda,
            'id_fornecedor_fk'  =>$request->input('fornecedor'),
            'quantidade_aviso'  =>$request->quantidade_aviso
        ]);

        MarcaProduto::where('id_produto_fk', $request->input('nome_produto'))
        ->update([
            'id_produto_fk' => $request->input('nome_produto'),
            'id_marca_fk'   => $request->input('marca')
        ]);
     //   return redirect()->route('estoque.index')->with('success', 'Editado com sucesso');
    }

    public function status($statusId)
    {
        $status = Estoque::findOrFail($statusId);
        $status->status = ($status->status == 1) ? 0 : 1;
        $status->save();
        return $status;
    }

    public function quantidades(Requests $request,$estoqueId, $operacao)
    {

        $produto = Estoque::find($estoqueId);
        if ($operacao === 'aumentar') {
            $produto->quantidade += $request->input('quantidadeHistorico');
        } elseif ($operacao === 'diminuir') {
            if ($produto->quantidade > 0) {
                $produto->quantidade -= $request->input('quantidadeHistorico');
                Historico::create([
                    'id_estoque_fk'  =>$estoqueId,    
                    'quantidade_diminuida' =>$request->input('quantidadeHistorico'),
                    'quantidade_historico' =>$produto->quantidade
                ]);
            }
        }
        $produto->save();
        return $produto;
    }

    public function ano():array
    {
        $quantidade = Estoque::selectRaw('quantidade')->get();
      //  dd($quantidade);

        $backgrounds = $quantidade->map(function ($value, $key){
            return '#' . dechex(rand(0x000000 , 0xFFFFFF));
        });

        $values = $quantidade->map(function($order, $key){
            return number_format($order->quantidade, 0,'','');
        });

        return [
            'labels' => $quantidade->pluck('quantidade'),
            'values' => $values,
            'backgrounds' => $backgrounds
        ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
