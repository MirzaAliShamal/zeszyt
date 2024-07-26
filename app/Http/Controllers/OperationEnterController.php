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

    function formatNumber($number)
    {
        // Convert to string if it's not already
        $number = (string) $number;

        // If the string length is 1, add a leading '0'
        if (strlen($number) == 1) {
            return '0' . $number;
        }

        // If the string length is 2 and starts with '0', remove the '0'
        if (strlen($number) == 2 && $number[0] == '0') {
            return ltrim($number, '0');
        }

        // Otherwise, return the original number
        return $number;
    }

    public function monthlySummary(Request $request)
    {
        if (isset($request->month)) {
            $month = date('Y') . '-' . $this->formatNumber($request->month);
        } else {
            $month = date('Y-m');
        }

        // Cost Section
        $cost_results = OperationEnter::whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])->whereIn('category', ['credit', 'materials', 'transport', 'employes-payment'])
            ->selectRaw('category, SUM(net_value) as total_net, SUM(vat_tax_value) as total_vat_tax')
            ->groupBy('category')
            ->get()

            ->keyBy('category');

        $credit = $cost_results['credit'] ?? null;
        $materials = $cost_results['materials'] ?? null;
        $transport = $cost_results['transport'] ?? null;
        $employes_payment = $cost_results['employes-payment'] ?? null;

        $credit_net = $credit ? $credit->total_net : 0;
        $credit_vat_tax = $credit ? $credit->total_vat_tax : 0;

        $material_net = $materials ? $materials->total_net : 0;
        $material_vat_tax = $materials ? $materials->total_vat_tax : 0;

        $transport_net = $transport ? $transport->total_net : 0;
        $transport_vat_tax = $transport ? $transport->total_vat_tax : 0;

        $employes_payment_net = $employes_payment ? $employes_payment->total_net : 0;
        $employes_payment_vat_tax = $employes_payment ? $employes_payment->total_vat_tax : 0;

        // Sum all cost vat_tax variables
        $total_vat_tax = $credit_vat_tax + $material_vat_tax + $transport_vat_tax + $employes_payment_vat_tax;

        // Sum all cost net variables
        $total_net = $credit_net + $material_net + $transport_net + $employes_payment_net;

        // Income Section
        $income_results = OperationEnter::whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])->whereIn('category', ['service', 'sell'])
            ->selectRaw('category, SUM(net_value) as total_net, SUM(vat_tax_value) as total_vat_tax')
            ->groupBy('category')
            ->get()
            ->keyBy('category');

        $service = $income_results['service'] ?? null;
        $sell = $income_results['sell'] ?? null;

        $service_net = $service ? $service->total_net : 0;
        $service_vat_tax = $service ? $service->total_vat_tax : 0;

        $sell_net = $sell ? $sell->total_net : 0;
        $sell_vat_tax = $sell ? $sell->total_vat_tax : 0;

        // Sum all income vat_tax variables
        $total_income_vat_tax = $service_net + $service_vat_tax;

        // Sum all income net variables
        $total_income_net = $sell_net + $sell_vat_tax;

        $vat_paid_to_tax_office = $total_vat_tax + $total_income_vat_tax;

        $income_tax_amount = ($total_income_net - $total_net) * 0.19;

        // Month
        $curernt_month = date('F');

        // Get the current month and year
        $currentMonth = date('n');
        $currentYear = date('Y');

        // Create an array to store the month names
        $months = [];

        // Loop through the months from January to the current month
        for ($month = 1; $month <= $currentMonth; $month++) {
            // Use date() to get the month name
            $monthName = date('F', mktime(0, 0, 0, $month, 1, $currentYear));

            // Add the month name to the array
            $months[] = $monthName;
        }

        $profit = $total_income_net - $total_net - $income_tax_amount - $vat_paid_to_tax_office;

        return view(
            'monthly-summary',
            compact(
                'credit_net',
                'credit_vat_tax',
                'material_net',
                'material_vat_tax',
                'transport_net',
                'transport_vat_tax',
                'employes_payment_net',
                'employes_payment_vat_tax',
                'total_vat_tax',
                'total_net',
                'service_net',
                'service_vat_tax',
                'sell_net',
                'sell_vat_tax',
                'total_income_vat_tax',
                'total_income_net',
                'vat_paid_to_tax_office',
                'income_tax_amount',
                'curernt_month',
                'months',
                'profit'
            )
        );
    }
}
