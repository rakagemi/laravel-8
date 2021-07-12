<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        $response = [
            'message' => 'List Products by id.',
            'data' => $product
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'stock' => ['required', 'numeric'],
            'type_products' => ['required'],
            'price' => ['required', 'numeric']

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $product = Product::create($request->all());
            $response = [
                'message' => 'Product Created',
                'data' => $product
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QuerryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findorFail($id);
        $response = [
            'message' => 'Detail of Products',
            'data' => $product
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findorFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'stock' => ['required', 'numeric'],
            'type_products' => ['required'],
            'price' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $product->update($request->all());
            $response = [
                'message' => 'Product Updated',
                'data' => $product
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QuerryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findorFail($id);

        try {
            $product->delete();
            $response = [
                'message' => 'Product Deleted',
                'data' => $product
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QuerryException $e) {
            return response()->json([
                    'message' => "Failed" . $e->errorInfo
            ]);
        };
    }
}
