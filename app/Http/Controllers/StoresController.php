<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StorePutRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class StoresController extends Controller
{

    public function __construct() {
        $this->middleware('checkAdmin', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return Store::with('enterprise')
            ->with('services')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function store(StorePostRequest $request)
    {
        $store = Store::create($request->all());
        return response()->json([
            'message' => 'La tienda ha sido creada con éxito.',
            'store' => $store
        ], Response::HTTP_CREATED);
    }


    public function show(Store $store)
    {
        $data = $store;
        $data["services"] =  $store->services;
        $data["enterprise"] =  $store->enterprise;
        return response()->json(
            $data
        , Response::HTTP_OK);
    }

    public function update(StorePutRequest $request, Store $store)
    {
        $store->fill($request->all())->save();
        $storeUpdate = Store::find($store->id);
        return response()->json([
            'message' => 'La tienda ha sido actualizada con éxito.',
            'store' => $storeUpdate
        ], Response::HTTP_OK);
    }

    public function destroy(Store $store)
    {
        if( $store->services()->count() !== 0 ){
            return response()->json([
                'message' => 'La tienda no puede ser eliminada porque está en uso.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $store->delete();
        return response()->json([
            'message' => 'La tienda ha sido eliminada con éxito.'
        ], Response::HTTP_OK);
    }

    public function updateStores(Request $request, $store_id)
    {
        try{
            $store = Store::findOrFail($store_id);
            $services_id = $request->data;

            if( !is_array($services_id) || is_null($services_id) ){
                return response()->json([
                    'message' => 'Cuerpo de la petición no válido. '
                ], Response::HTTP_BAD_REQUEST);
            }

            $store->services()->sync($services_id);

            return response()->json([
                'message' => 'Se ha vinculado los servicios con éxito.'
            ], Response::HTTP_OK);
        }
        catch (Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
