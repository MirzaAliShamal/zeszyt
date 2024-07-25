<?php

namespace App\Http\Controllers;

use App\Models\OperationEnter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperationEnterController extends Controller
{
    public function operationEnter()
    {
        return view('operation-enter');
    }
    public function operationHistory(Request $request)
    {
        if (isset($request->from)) {
            $operation_history = OperationEnter::whereBetween('created_at', [$request->from, $request->to])->get();
        } else {
            $operation_history = OperationEnter::get();
        }

        return view('operation-history', compact('operation_history'));
    }
    public function operationEnterSave(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => 'required',
                'category' => 'required',
                'brut_value' => 'required|integer',
                'profit' => 'required|integer',
                'vat_tax_percent' => 'required|integer',
                'vat_tax_value' => 'required|integer',
                'net_value' => 'required|integer',
                'title' => 'required',
                'comment' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        OperationEnter::create($request->all());

        return redirect()->route('admin.operation-history')->with('msg', 'Operation created successfully');
    }
}
