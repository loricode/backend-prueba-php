<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;

class InventarioController extends Controller
{
 /**
    * Create a new InventarioController instance.
    *
    * @return void
    */
    public function __construct()

    {
        //$this->middleware('auth:api', ['except' => ['listCities', 'detail', 'getData']]);
    }

    /**
    * Consulta de inventario por producto o ubicación.
    * @param int id 
    * @param string ubicacion
    * @return \Illuminate\Http\JsonResponse
    */
    public function searchProductOrLocation(Request $request)
    {
        try {

          $results = DB::select('CALL sp_search_productOrLocation(?, ?)', [$request['id'], $request['ubicacion']]);

          return $results;

        } catch (Throwable $e) {
          report($e);
 
          return false;
        }
    }

   /**
    * Registrar inventario para un producto existente.
    * @param int id_producto
    * @param int cantidad_disponible 
    * @param string ubicacion
    * @param string
    * @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request){
      try {


      DB::select('CALL sp_register_inventory(?, ?, ?, @resultado)', 
      [$request['id_producto'],
       $request['ubicacion'], 
       $request['cantidad_disponible']]);

      $resultado = DB::select('SELECT @resultado AS resultado');

      return response()->json([
          'result' => $resultado,
      ], 200);

    } catch (Throwable $e) {
      report($e);

      return false;
    }
 }

  /**
    * Actualizar la cantidad de un producto en el inventario.
    * @param int id
    * @param int cantidad_disponible 
    * @return \Illuminate\Http\JsonResponse
    */
    public function update(Request $request){
      try {


      DB::select('CALL sp_update_inventory(?, ?)', 
      [
       $request['id'], 
       $request['cantidad_disponible']]);

      return response()->json([
          'result' => true,
      ], 200);

    } catch (Throwable $e) {
      report($e);

      return false;
    }
 }

  /**
    * Eliminar un registro de inventario.
    * @param int id
    * @return \Illuminate\Http\JsonResponse
    */
    public function delete(Request $request){
      try {


      DB::select('CALL sp_delete_inventory(?)', 
      [
       $request['id']
      ]);

      return response()->json([
          'result' => true,
      ], 200);

    } catch (Throwable $e) {
      report($e);

      return false;
    }
 }

    
}