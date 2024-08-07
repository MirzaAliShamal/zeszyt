@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')

 <section class="section">
  <div class="section-body">
   <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
     <div class="card">
      <div class="card-body">
       <form action="{{ route('admin.dashboard') }}" method="get">
        <div class="row">
         <div class="col-md-4">
          <div class="form-group">
           <label>Od</label>
           <input type="date" class="form-control" name="from" value="{{ $startDate }}">
          </div>
         </div>
         <div class="col-md-4">
          <div class="form-group">
           <label>Do</label>
           <input type="date" class="form-control" name="to" value="{{ $endDate }}">
          </div>
         </div>
         <div class="col-md-4">
          <div class="form-group">
           <label> </label>
           <button type="submit" class="form-control btn btn-primary">Filtruj</button>
          </div>
         </div>
        </div>
       </form>
      </div>
     </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
     <div class="card">
      <div class="card-header">
       <h4>PODSUMOWANIE</h4>
      </div>
      <div class="card-body">
        
       <div class="recent-report__chart">
        <div id="summaryChart"></div>
       </div>
      </div>
     </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
     <div class="card">
      <div class="card-header">
       <h4>Koszty</h4>
      </div>
      <div class="card-body">
       <div class="recent-report__chart">
        <div id="costChart"></div>
       </div>
      </div>
     </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
     <div class="card">
      <div class="card-header">
       <h4>Przychody</h4>
      </div>
      <div class="card-body">
       <div class="recent-report__chart">
        <div id="incomeChart"></div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </section>

@section('script')
 <script type="text/javascript">
  let dates = JSON.parse('{!! json_encode($labels) !!}');
  // Summary
  let cost = JSON.parse("{{ json_encode($chartData['cost']) }}");
  let income = JSON.parse("{{ json_encode($chartData['income']) }}");
  let profit = JSON.parse("{{ json_encode($chartData['profit']) }}");

  summaryChart();

  function summaryChart() {
   var options = {
    chart: {
     height: 350,
     type: "line",
    },
    series: [{
      name: "Przychody",
      type: "column",
      data: income,
     },
     {
      name: "Koszty",
      type: "line",
      data: cost,
     },
     {
      name: "Zyski",
      type: "line",
      data: profit,
     }
    ],
    stroke: {
     width: [0, 4],
    },
    labels: dates,
    xaxis: {
     type: "date",
     labels: {
      style: {
       colors: "#9aa0ac",
      },
     },
    },
    yaxis: [{
     title: {
      text: "z t",
     },
     labels: {
      formatter: function(val) {
       return val.toFixed(0);
      },
      style: {
       color: "green",
      },
     },
    }],
   };

   var summaryChart = new ApexCharts(
    document.querySelector("#summaryChart"),
    options
   );

   summaryChart.render();
  }

  // Function to export data to CSV
  function exportToCSV(chart) {
   var series = chart.w.globals.series;
   var categories = chart.w.globals.labels;

   var csv = 'Category,' + series.map(s => s.name).join(',') + '\n';

   for (var i = 0; i < categories.length; i++) {
    csv += categories[i] + ',' + series.map(s => s.data[i]).join(',') + '\n';
   }

   // Create a downloadable link
   var hiddenElement = document.createElement('a');
   hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
   hiddenElement.target = '_blank';
   hiddenElement.download = 'chart-data.csv';
   hiddenElement.click();
  }

  // Bind the export function to the button click event
  $('#export-csv').click(function() {
   exportToCSV(chart);
  });

  // Cost
  let credit = JSON.parse("{{ json_encode($result_cost_chart['credit']) }}");
  let materials = JSON.parse("{{ json_encode($result_cost_chart['materials']) }}");
  let transport = JSON.parse("{{ json_encode($result_cost_chart['transport']) }}");
  let employes_payment = JSON.parse("{{ json_encode($result_cost_chart['employes_payment']) }}");

  costChart();

  function costChart() {
   var options = {
    chart: {
     height: 350,
     type: "line",
    },
    series: [{
      name: "Kredyty",
      type: "line",
      data: credit,
     },
     {
      name: "Materiały",
      type: "line",
      data: materials,
     },
     {
      name: "Transport",
      type: "line",
      data: transport,
     },
     {
      name: "Wynagrodzenia",
      type: "line",
      data: employes_payment,
     }
    ],
    stroke: {
     //  width: [0, 4],
     curve: 'straight'
    },
    labels: dates,
    xaxis: {
     type: "date",
     labels: {
      style: {
       colors: "#9aa0ac",
      },
     },
    },
    yaxis: [{
     title: {
      text: "z t",
     },
     labels: {
      formatter: function(val) {
       return val.toFixed(0);
      },
      style: {
       color: "green",
      },
     },
    }],
   };

   var costChart = new ApexCharts(
    document.querySelector("#costChart"),
    options
   );

   costChart.render();
  }

  // Income
  let service = JSON.parse("{{ json_encode($result_income_chart['service']) }}");
  let sell = JSON.parse("{{ json_encode($result_income_chart['sell']) }}");

  incomeChart();

  function incomeChart() {
   var options = {
    chart: {
     height: 350,
     type: "line",
    },
    series: [{
      name: "Usługi",
      type: "line",
      data: service,
     },
     {
      name: "Sprzedaż",
      type: "line",
      data: sell,
     }
    ],
    stroke: {
     //  width: [0, 4],
     curve: 'straight'
    },
    labels: dates,
    xaxis: {
     type: "date",
     labels: {
      style: {
       colors: "#9aa0ac",
      },
     },
    },
    yaxis: [{
     title: {
      text: "z t",
     },
     labels: {
      formatter: function(val) {
       return val.toFixed(0);
      },
      style: {
       color: "green",
      },
     },
    }],
   };

   var incomeChart = new ApexCharts(
    document.querySelector("#incomeChart"),
    options
   );

   incomeChart.render();
  }
 </script>
@endsection
@endsection
