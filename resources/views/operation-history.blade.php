@extends('layouts.app')
@section('page_title', 'Operation History')

@section('content')

 <section class="section">
  <div class="section-body">
   <div class="row">
    <div class="col-12 col-md-12 col-lg-12">
     <div class="card">
      <div class="card-header">
       <form action="{{ route('admin.operation-history') }}" method="get">
        @csrf
        <div class="row">
         <div class="col-md-4">
          <label>From</label>
          <input type="date" name="from" class="form-control"
           value="{{ request('from') != null ? request('from') : '' }}" required>
         </div>
         <div class="col-md-4">
          <label>To</label>
          <input type="date" name="to" class="form-control"
           value="{{ request('to') != null ? request('to') : '' }}" required>
         </div>
         <div class="col-md-4">
          <button class="btn btn-primary" type="submit">Filter</button>
         </div>
        </div>
       </form>
      </div>
      <div class="card-body">
       <table class="table">
        <thead>
         <tr>
          <th scope="col">#</th>
          <th scope="col">Data</th>
          <th scope="col">Typ</th>
          <th scope="col">Kategorie</th>
          <th scope="col">Wartość Brutto</th>
          <th scope="col">ZYSK</th>
          <th scope="col">Stawka VAT (%)</th>
          <th scope="col">Stawka VAT (value)</th>
          <th scope="col">Wartość Netto</th>
          <th scope="col">Opis</th>
          <th scope="col">Komentarz</th>
         </tr>
        </thead>
        <tbody>
         @foreach ($operation_history as $key => $list)
          <tr>
           <td>{{ $key + 1 }}</td>
           <td style="white-space: nowrap;">{{ explode(' ', $list['created_at'])[0] }}</td>
           <td>{{ $list['type'] }}</td>
           <td>{{ $list['category'] }}</td>
           <td class="brut_val">{{ $list['brut_value'] }} zt</td>
           <td>{{ $list['profit'] }} zt</td>
           <td>{{ $list['vat_tax_percent'] }} %</td>
           <td class="vat_tax_val">{{ $list['vat_tax_value'] }} zt</td>
           <td>{{ $list['net_value'] }} zt</td>
           <td>{{ $list['title'] }}</td>
           <td>{{ $list['comment'] }}</td>
          </tr>
         @endforeach
         <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="brut_val_sum font-bold">00 zt</td>
          <td></td>
          <td></td>
          <td class="vat_tax_val_sum font-bold">00 zt</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
         </tr>
        </tbody>
       </table>
       {!! $operation_history->links() !!}
      </div>
     </div>
    </div>
   </div>
  </div>
 </section>

@section('script')
 <script type="text/javascript">
  $(document).ready(function() {
   let brut_val_sum = 0
   $('.brut_val').each(function(index, element) {
    brut_val_sum += $(this).text().split(' ')[0]
   });
   $('.brut_val_sum').text(brut_val_sum.toFixed(3) + ' zt')

   let vat_tax_val_sum = 0
   $('.vat_tax_val').each(function(index, element) {
    vat_tax_val_sum += $(this).text().split(' ')[0]
   });

   $('.vat_tax_val_sum').text(vat_tax_val_sum.toFixed(3) + ' zt')
  });
 </script>
@endsection
@endsection
