<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransactionCreateRequest;
use App\Http\Requests\Transaction\TransactionUpdateRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $transactions = Transaction::paginate();

        return [
            'return' => new TransactionResource($transactions),
            'message' => "transações listadas com sucesso!",
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(TransactionCreateRequest $request)
    {
        $transaction = new Transaction($request->input());
        $transaction->transactionDate = date('Y-m-d H:i:s');
        $transaction->save();

        return [
            'return' => new TransactionResource($transaction),
            'message' => "transação cadastrada com sucesso!",
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        $transaction = Transaction::search($id);

        return [
            'return' => new TransactionResource($transaction),
            'message' => "transação $transaction->id listado com sucesso!",
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array
     */
    public function update(TransactionUpdateRequest $request, $id)
    {
        $transaction = Transaction::search($id);
        $transaction->fill($request->input());
        $transaction->update();

        return [
            'return' => new TransactionResource($transaction),
            'message' => "transação atualizada com sucesso!",
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        $transaction = Transaction::search($id);
        $transaction->delete();

        return [
            'return' => new TransactionResource($transaction),
            'message' => "transação deletada com sucesso!",
            'status' => Response::HTTP_OK
        ];
    }

    public function statistics()
    {
        $sum = DB::table('transactions')->sum('amount');
        $avg = DB::table('transactions')->avg('amount');
        $max = DB::table('transactions')->max('amount');
        $min = DB::table('transactions')->min('amount');
        $count = DB::table('transactions')->count('amount');

        return [
            'sum' => $sum,
            'avg' => $avg,
            'max' => $max,
            'min' => $min,
            'count' => $count,
            'message' => "estatísticas carregadas com sucesso!",
            'status' => Response::HTTP_OK
        ];
    }
}
