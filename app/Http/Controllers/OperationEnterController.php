<?php

namespace App\Http\Controllers;

use App\Models\OperationEnter;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OperationEnterController extends Controller
{
 function determineXAxisUnit($startDate, $endDate)
 {
  $startTimestamp = strtotime($startDate);
  $endTimestamp = strtotime($endDate);
  $totalDays = ($endTimestamp - $startTimestamp) / (60 * 60 * 24);

  if ($totalDays >= 365) {
   return 'year';
  } elseif ($totalDays >= 30) {
   return 'month';
  } elseif ($totalDays >= 7) {
   return 'week';
  } else {
   return 'day';
  }
 }

 function generateDateLabels($startDate, $endDate, $unit)
 {
  $labels = [];

  $startTimestamp = strtotime($startDate);
  $endTimestamp = strtotime($endDate);
  switch ($unit) {
   case 'year':
    $currentYear = date('Y', $startTimestamp);
    while ($currentYear <= date('Y', $endTimestamp)) {
     $labels[] = (int) $currentYear;
     $currentYear++;
    }
    break;
   case 'month':
    $currentTimestamp = $startTimestamp;
    while ($currentTimestamp <= $endTimestamp) {
     $labels[] = date('M Y', $currentTimestamp);
     $currentTimestamp = strtotime('+1 month', $currentTimestamp);
    }
    break;
   case 'week':
    $currentTimestamp = strtotime('last monday', $startTimestamp);
    $endOfWeek = strtotime('next sunday', $endTimestamp);

    while ($currentTimestamp <= $endOfWeek) {
     $labels[] = 'Week ' . date('W Y', $currentTimestamp);
     $currentTimestamp = strtotime('+1 week', $currentTimestamp);
    }
    break;
   case 'day':
    $currentTimestamp = $startTimestamp;
    while ($currentTimestamp <= $endTimestamp) {
     $labels[] = date('d M Y', $currentTimestamp);
     $currentTimestamp = strtotime('+1 day', $currentTimestamp);
    }
    break;
  }

  return $labels;
 }

 function convertLabelsToDates($labels)
 {
  $dates = [];
  foreach ($labels as $label) {

   // Extract month
   if (preg_match('/^(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(\d{4})$/', $label, $matches)) {

    $month = array_search($matches[1], ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']) + 1;
    if (strlen($month) == 1) {
     $month = 0 . $month;
    }
    $date = "$matches[2]-$month-01";

    // Handle weeks
   } elseif (preg_match('/^Week (\d+) (\d{4})$/', $label, $matches)) {
    $weekNumber = $matches[1];

    $week_start = new DateTime();
    $week_start->setISODate($matches[2], $weekNumber);
    $month = $week_start->format('m');
    $date = "$matches[2]-$month-01";

    // Handle days
   } elseif (preg_match('/^(\d{2}) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) (\d{4})$/', $label, $matches)) {

    $day = $matches[1];
    $month = array_search($matches[2], ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']) + 1;
    if (strlen($month)) {
     $month = 0 . $month;
    }
    $year = '20' . substr($label, -2);
    $date = "$year-$month-$day";
    // dd($date);

    // Handle years
   } elseif (preg_match('/^(\d{4})$/', $label, $matches)) {
    $date = $label . '-01-01';

    // Handle invalid label format
   } else {
    $date = null;
   }

   if ($date) {
    $dates[] = $date;
   }
  }

  return $dates;
 }


 public function dashboard(Request $request)
 {
  if (isset($request->from)) {
   $startDate = $request->from;
   $endDate = $request->to;
  } else {
   $startDate = date('Y-m-d', strtotime("-1 month"));
   $endDate = date('Y-m-d');
  }

  $start_timestamp = strtotime($startDate);
  $end_timestamp = strtotime($endDate);

  $unit = $this->determineXAxisUnit($startDate, $endDate);
  $labels = $this->generateDateLabels($startDate, $endDate, $unit);

  $dates = $this->convertLabelsToDates($labels);

  // main query
  // $cost_results = OperationEnter::whereIn('type', ['cost', 'income'])->whereBetween('created_at', [$startDate, $endDate])
  //  ->get()
  //  ->groupBy('type');

  $query = OperationEnter::whereIn('type', ['cost', 'income'])->where(function ($query) use ($dates) {
   foreach ($dates as $date) {
    $query->orWhere('created_at', 'like', $date . '%');
   }
  });
  $cost_results = $query->get()->groupBy('type');

  // main query
  // $profit_results = OperationEnter::selectRaw('profit')->whereBetween('created_at', [$startDate, $endDate])
  //  ->get();

  $query1 = OperationEnter::selectRaw('profit')->where(function ($query1) use ($dates) {
   foreach ($dates as $date) {
    $query1->orWhere('created_at', 'like', $date . '%');
   }
  });
  $profit_results = $query1->get();

  // Prepare the data for chart
  $chartData = [
   'cost' => [],
   'income' => [],
   'profit' => [],
  ];

  foreach ($cost_results as $result) {
   foreach ($result as $val) {
    if ($val['type'] == 'cost') {
     $chartData['cost'][] = (float) $val['net_value'];
    } elseif ($val['type'] == 'income') {
     $chartData['income'][] = (float) $val['net_value'];
    }
   }
  }

  foreach ($profit_results as $value) {
   $chartData['profit'][] = (float) $value['profit'];
  }

  // Cost Chart Section
  // main query 
  // $cost_chart_results = OperationEnter::whereIn('category', ['credit', 'materials', 'transport', 'employes-payment'])->whereBetween('created_at', [$startDate, $endDate])
  //  ->get()
  //  ->groupBy('category');

  $query1 = OperationEnter::whereIn('category', ['credit', 'materials', 'transport', 'employes-payment'])
   ->where(function ($query1) use ($dates) {
    foreach ($dates as $date) {
     $query1->orWhere('created_at', 'like', $date . '%');
    }
   });
  $cost_chart_results = $query1->get()->groupBy('category');
  
  // dd($cost_chart_results);


  // Define the keys you want in the output
  $categories = ['credit', 'materials', 'transport', 'employes_payment'];

  // Initialize the result array with empty arrays for each category
  $result_cost_chart = array_fill_keys($categories, []);

  // Extract net_value for each entry in the grouped data
  foreach ($cost_chart_results as $category => $entries) {
   foreach ($entries->pluck('net_value') as $key => $value) {
    $result_cost_chart[$category][] = (float) $value;
   }
  }

  // Income Chart Section
  // main 
  // $income_chart_results = OperationEnter::whereIn('category', ['service', 'sell'])->whereBetween('created_at', [$startDate, $endDate])
  //  ->get()
  //  ->groupBy('category');

   $query1 = OperationEnter::whereIn('category', ['service', 'sell'])->where(function ($query1) use ($dates) {
    foreach ($dates as $date) {
     $query1->orWhere('created_at', 'like', $date . '%');
    }
   });
  $income_chart_results = $query1->get()
   ->groupBy('category');

  // Define the keys you want in the output
  $income_chart_categories = ['service', 'sell'];

  // Initialize the result array with empty arrays for each category
  $result_income_chart = array_fill_keys($income_chart_categories, []);

  // Extract net_value for each entry in the grouped data
  foreach ($income_chart_results as $income_chart_categories => $entries) {
   foreach ($entries->pluck('net_value') as $key => $value) {
    $result_income_chart[$income_chart_categories][] = (float) $value;
   }
  }

  return view('dashboard', compact('chartData', 'result_cost_chart', 'result_income_chart', 'startDate', 'endDate', 'labels'));
 }

 public function operationEnter()
 {
  return view('operation-enter');
 }

 public function operationHistory(Request $request)
 {
  if (isset($request->from)) {
   $operation_history = OperationEnter::whereBetween('created_at', [$request->from, $request->to])->paginate(10);
  } else {
   $operation_history = OperationEnter::paginate(10);
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