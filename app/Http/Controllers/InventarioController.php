<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
Use Exception;
Use Log;

class InventarioController extends Controller
{
    public function index(): View
    {
        return view('inventario.index');
    }

    public function miInventario(): View
    {
        return view('inventario.miinventario');
    }

    public function listarInventario(Request $request){

        $jsonReturn = array('success'=>false,'data'=>[],'error'=>'');
        
        try {
            $jsonReturn['data'] = Article::where('creador',auth()->user()->id)->get()->toArray();
            $jsonReturn['success'] = True;
        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Line: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = "Algo salio mal";
        }

        return response()->json(['data'=>$jsonReturn['data']]);
    }

    public function inventarioCrear(Request $request){
        $jsonReturn = array('success'=>false, 'error'=>[], 'data'=>[]);

        $new = Article::create([
            'nombre'   => $request->nombre,
            'descripcion'  => $request->descripcion,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
            'creador' => auth()->user()->id,
        ]);

        $jsonReturn['success'] = true;
        
        return response()->json($jsonReturn);
    }

    public function inventarioEditar(Request $request){
        $jsonReturn = array('success'=>false, 'error'=>[], 'data'=>[]);

        $edit = Article::findOrFail($request->id);

        if($edit->creador == auth()->user()->id){

            $edit->nombre = $request->nombre;
            $edit->descripcion = $request->descripcion;
            $edit->precio = $request->precio;
            $edit->cantidad = $request->cantidad;

            $edit->save();

            $jsonReturn['success'] = true;
        }
        
        return response()->json($jsonReturn);
    }

    public function inventarioEliminar(Request $request){

        $jsonReturn = array('success'=>false, 'error'=>[], 'data'=>[]);

        $record = Article::findOrFail($request->id);

        if($record->creador == auth()->user()->id){
            $record->delete();

            $jsonReturn['success'] = true;
        }
        
        
        return response()->json($jsonReturn);
    }

    public function listarInventarioTotal(Request $request){

        $jsonReturn = array('success'=>false,'data'=>[],'error'=>'');
        
        try {
            $jsonReturn['data'] = DB::table('users')
                ->join('articles', 'users.id', '=', 'articles.creador')
                ->select('users.name AS creador', 'articles.nombre AS nombre', 'articles.descripcion AS descripcion', 'articles.cantidad AS cantidad', 'articles.precio AS precio')
                ->whereNull('articles.deleted_at')
                ->whereNull('users.deleted_at')
            ->get()->toArray();
            $jsonReturn['success'] = True;
        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Line: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = "Algo salio mal";
        }

        return response()->json(['data'=>$jsonReturn['data']]);
    }
    public function vistaInventarioTotal(): View
    {
        return view('inventario.total');
    }
    
}
