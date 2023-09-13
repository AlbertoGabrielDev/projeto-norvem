<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Telefone;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FornecedorController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return view('fornecedor.index', compact('fornecedores'));
    }

    public function cadastro()
    {
        $estado = Estado::all();
        $cidade = Cidade::all();
        $status = Fornecedor::all();
        return view('fornecedor.cadastro', compact('estado','cidade','status'));
    }
    public function getCidade($estado)
    {
        $cidade = Cidade::where('id_estado_fk', $estado)->get();
        return response()->json($cidade);  
    }
    public function buscar(Request $request)
    {   
        $buscarFornecedor = $request->input('nome_fornecedor');
        $fornecedor = Fornecedor::where('nome_fornecedor', 'like' , '%' . $buscarFornecedor. '%')->get();
        return view('fornecedor.index', compact('fornecedor'));
    }

    public function inserirCadastro(Request $request)
    {
        $principal = $request->input('principal') ? $request->principal : 0;
        $whatsapp = $request->input('whatsapp') ? $request->whatsapp : 0;
        $telegram = $request->input('telegram') ? $request->telegram : 0;
          //dd($request);

        $telefones = Telefone::create([
            'ddd' => $request->ddd,
            'telefone' => $request->telefone,
            'principal' => $principal,
            'whatsapp' => $whatsapp,
            'telegram' => $telegram
        ]);

        $fornecedor = $request->validate([
            'status' => 'required|boolean',
        ]);
        $telefonesId = Telefone::latest('id_telefone')->first();
        $cidadeUf = $request->input('cidades');
        $cidade = Cidade::where('id', $cidadeUf)->first();
        $fornecedor = Fornecedor::create([
            'nome_fornecedor'   =>$request->nome_fornecedor,
            'cnpj'              =>$request->cnpj,
            'cep'               =>$request->cep,
            'logradouro'        =>$request->logradouro,
            'bairro'            =>$request->bairro,
            'numero_casa'       =>$request->numero_casa,
            'email'             =>$request->email,
            'id_cidade_fk'      =>$cidade->id,
            'id_users_fk'       =>Auth::id(),
            'status'            =>$request->status,    
            'id_telefone_fk'    => $telefonesId->id_telefone                           
       ]);
     return redirect()->route('fornecedor.index')->with('success','Inserido com sucesso');
    }
}
