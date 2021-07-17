<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StorePutRequest;
use App\Models\Store;
use Symfony\Component\HttpFoundation\Response;

class StoresController extends Controller
{

    public function index()
    {
        return Store::with('enterprise')
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
        return $store;
    }

    public function update(StorePutRequest $request, Store $store)
    {
        $store->fill($request->all())->save();
        return response()->json([
            'message' => 'La tienda ha sido actualizada con éxito.'
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
}
