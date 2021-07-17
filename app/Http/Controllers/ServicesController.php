<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicePostRequest;
use App\Http\Requests\ServicePutRequest;
use App\Models\Comment;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
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
        return Service::orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function store(ServicePostRequest $request)
    {
        $service = Service::create($request->all());
        return response()->json([
            'message' => 'El servicio ha sido creado con éxito.',
            'service' => $service
        ], Response::HTTP_CREATED);
    }

    public function show(Service $service)
    {
        return $service;
    }

    public function update(ServicePutRequest $request, Service $service)
    {
        $service->fill($request->all())->save();
        return response()->json([
            'message' => 'El servicio ha sido actualizado con éxito.'
        ], Response::HTTP_OK);
    }

    public function destroy(Service $service)
    {
        if(
            $service->stores()->count() !== 0
        ){
            return response()->json([
                'message' => 'El servicio no puede ser eliminado porque está en uso.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $service->delete();
        return response()->json([
            'message' => 'El servicio ha sido eliminado con éxito.'
        ], Response::HTTP_OK);
    }
}
