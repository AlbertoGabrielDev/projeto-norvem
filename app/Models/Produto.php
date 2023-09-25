<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produto extends Model
{
    use HasFactory;
    protected $table= 'produto';
    protected $primaryKey = 'id_produto';

    protected $fillable=[
        'cod_produto',
        'nome_produto',
        'descricao',
        'unidade_medida',
        'validade',
        'id_categoria_fk',
        'id_users_fk',
        'status'
    ];

    public function search(): BelongsToMany
    {
        $query = $this->belongsToMany(Fornecedor::class, 'estoque', 'id_produto_fk', 'id_fornecedor_fk')
            ->as('estoque')
            ->withPivot([
                'id_estoque',
                'quantidade',
                'localizacao',
                'preco_custo',
                'preco_venda',
                'lote',
                'data_chegada',
                'localizacao',
                'quantidade_aviso',
                'created_at'
            ])
            ->join('produto as p', 'estoque.id_produto_fk', '=', 'p.id_produto')
            ->join('marca as m', 'estoque.id_marca_fk', '=', 'm.id_marca')
            ->join('categoria_produto as cp', 'p.id_produto', '=', 'cp.id_produto_fk')
            ->join('categoria as c', 'cp.id_categoria_fk', '=', 'c.id_categoria')
            ->where(function ($query) 
            {
                $query->where(function ($subquery) {
                    if (!is_null(request()->input('lote'))) {
                        $subquery->where('estoque.lote', request()->input('lote'));
                    }
                })->orWhere(function ($subquery) {
                    if (!is_null(request()->input('quantidade'))) {
                        $subquery->where('estoque.quantidade', request()->input('quantidade'));
                    }
                })->orWhere(function ($subquery) {
                    if (!is_null(request()->input('preco_custo'))) {
                        $subquery->where('estoque.preco_custo', request()->input('preco_custo'));
                    }
                })->orWhere(function ($subquery){
                    if (!is_null(request()->input('localizacao'))) {
                        $subquery->where('estoque.localizacao', request()->input('localizacao'));
                    }
                })->orWhere(function ($subquery){
                    if (!is_null(request()->input('preco_venda'))) {
                        $subquery->where('estoque.preco_venda', request()->input('preco_venda'));
                    }
                })->orWhere(function ($subquery){
                    if (!is_null(request()->input('data_chegada'))) {
                        $subquery->where('estoque.data_chegada', request()->input('data_chegada'));
                    }
                })->orWhere(function ($subquery){
                    if (!is_null(request()->input('nome_produto'))) {
                        $subquery->where('p.nome_produto', 'like' ,'%' .request()->input('nome_produto') . '%' );
                    }
                })->orWhere(function ($subquery){
                    if (!is_null(request()->input('nome_marca'))) {
                        $subquery->where('m.nome_marca', request()->input('nome_marca'));
                    }
                })->orWhere(function ($subquery){
                    if (!is_null(request()->input('nome_fornecedor'))) {
                        $subquery->where('fornecedor.nome_fornecedor',  request()->input('nome_fornecedor'));
                    }
                })->orWhere(function ($subquery){
                    if (!is_null(request()->input('nome_categoria'))) {
                        $subquery->where('c.nome_categoria', request()->input('nome_categoria'));
                    }
                });
            });

            return $query;
    }
   
    public function fornecedores() : BelongsToMany 
    {
        return $this->belongsToMany(Fornecedor::class ,'estoque', 'id_produto_fk', 'id_fornecedor_fk')
        ->as('estoque')
        ->withPivot([
            'id_estoque',
            'quantidade',
            'localizacao',
            'preco_custo',
            'preco_venda',
            'lote',
            'data_chegada',
            'localizacao',
            'quantidade_aviso',
            'created_at'
        ]);
    }

    public function categorias() : BelongsToMany
    {
        return $this->belongsToMany(Categoria::class,  'categoria_produto', 'id_categoria_fk', 'id_produto_fk');
    }

    public function marca(): BelongsToMany
    {
        return $this->belongsToMany(Marca::class, 'marca_produto' ,'id_marca_fk', 'id_marca')
        ->as('marca_produto');
    }
}
