<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Http\Controller\ProductController;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */

    public function __construct()
    {
        
    }
    
    public function index()
    {
        //$transaction = Transaction::orderBy('time', 'DESC')->get();
        $transaction = Transaction::all();
        $response = [
            'message' => 'List Transaction order by time.',
            'data' => $transaction
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
            'title' => ['required'],
            'amount' => ['required', 'numeric'],
            'amount_sold' => ['required'],
            'type' => ['required', 'in:expensive,revenue']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $transaction = Transaction::create($request->all());
            $response = [
                'message' => 'Transaction Created',
                'data' => $transaction
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
        $transaction = Transaction::findorFail($id);
        $response = [
            'message' => 'Detail of Transaction',
            'data' => $transaction
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
        $transaction = Transaction::findorFail($id);

        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'amount' => ['required', 'numeric'],
            'amount_sold' => ['required'],
            'type' => ['required', 'in:expense,revenue']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $transaction->update($request->all());
            $response = [
                'message' => 'Transaction Updated',
                'data' => $transaction
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
        $transaction = Transaction::findorFail($id);

        try {
            $transaction->delete();
            $response = [
                'message' => 'Transaction Deleted',
                'data' => $transaction
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QuerryException $e) {
            return response()->json([
                    'message' => "Failed" . $e->errorInfo
            ]);
        };
    }
}
