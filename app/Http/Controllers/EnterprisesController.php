<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnterprisePostRequest;
use App\Http\Requests\EnterprisePutRequest;
use App\Models\Enterprise;
use Symfony\Component\HttpFoundation\Response;

class EnterprisesController extends Controller
{
    public function __construct() {
        $this->middleware('checkAdmin', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Enterprise::paginate(10);
    }

    public function store(EnterprisePostRequest $request)
    {
        $enterprise = Enterprise::create($request->all());
        return response()->json([
            'message' => 'La empresa ha sido creada con éxito.',
            'enterprise' => $enterprise
        ], Response::HTTP_CREATED);
    }

    public function show(Enterprise $enterprise)
    {
        return $enterprise;
    }

    public function update(EnterprisePutRequest $request, Enterprise $enterprise)
    {
         $enterprise->fill($request->all())->save();
        return response()->json([
            'message' => 'La empresa ha sido actualizada con éxito.'
        ], Response::HTTP_OK);
    }

    public function destroy(Enterprise $enterprise)
    {
        if( $enterprise->stores()->count() !== 0 ){
            return response()->json([
                'message' => 'La empresa no puede ser eliminada porque está en uso.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $enterprise->delete();
        return response()->json([
            'message' => 'La empresa ha sido eliminada con éxito.'
        ], Response::HTTP_OK);
    }
}
