<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnterprisePostRequest;
use App\Http\Requests\EnterprisePutRequest;
use App\Models\Enterprise;

use Illuminate\Http\Request;
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
        if( auth()->user()->is_admin ){
            return Enterprise::orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return Enterprise::where('is_active', 1)
            ->with(['stores' => function ($query) {
                $query->where('is_active', 1);
            }])
            ->orderBy('name', 'asc')
            ->get();
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
        if( !auth()->user()->is_admin && !$enterprise->is_active ) {
            return response()->json([
                'message' => 'Empresa no encontrada.'
            ], Response::HTTP_NOT_FOUND);
        }
        return $enterprise;
    }

    public function update(EnterprisePutRequest $request, Enterprise $enterprise)
    {
         $enterprise->fill($request->all())->save();
         $enterpriseUpdate = Enterprise::find($enterprise->id);
        return response()->json([
            'message' => 'La empresa ha sido actualizada con éxito.',
            'enterprise' => $enterpriseUpdate
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request, Enterprise $enterprise)
    {
        $enterprise->is_active = $request->is_active;
        $enterprise->save();
        $enterpriseUpdate = Enterprise::find($enterprise->id);
        return response()->json([
            'message' => 'El estado de la empresa ha sido actualizado.',
            'enterprise' => $enterpriseUpdate
        ], Response::HTTP_OK);
    }
}
