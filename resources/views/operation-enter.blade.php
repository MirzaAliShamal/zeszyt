@extends('layouts.app')
@section('page_title', 'Operation Enter')

@section('content')

 <section class="section">
  <div class="section-body">
   <div class="row">
    <form action="{{ route('admin.operation-enter-save') }}" method="post">
     @csrf
     <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
       <div class="card-header">
        <h4>Horizontal Form</h4>
       </div>
       <div class="card-body">
        <div class="row">
         <div class="form-group col-md-3">
          <label>Typ</label>
          <select name="type" class="form-control" required>
           <option value="cost">Cost</option>
           <option value="income">Income</option>
          </select>
         </div>
         <div class="form-group col-md-3">
          <label>Kategorie</label>
          <select name="category" class="form-control" required>
           <option value="credit">Credit</option>
           <option value="employes-payment">Employes payment</option>
           <option value="materials">Materials</option>
           <option value="sell">Sell</option>
           <option value="service">Service</option>
           <option value="transport">Transport</option>
          </select>
         </div>
         <div class="form-group col-md-3">
          <label>Wartość Brutto</label>
          <input type="number" name="brut_value" class="brut_value form-control" required>
         </div>
         <div class="form-group col-md-3">
          <label>Zysk</label>
          <input type="number" name="profit" class="form-control" required>
         </div>
         <div class="form-group col-md-3">
          <label>Stawka VAT (%)</label>
          <input type="number" name="vat_tax_percent" class="vat_tax_percent form-control"
           placeholder="a. 23% b. 8% c. 5% d. 0%" required>
         </div>
         <div class="form-group col-md-3">
          <label>Wartość VATu (value)</label>
          <input type="number" name="vat_tax_value" class="vat_tax_value form-control" required>
         </div>
         <div class="form-group col-md-3">
          <label>Wartość Netto</label>
          <input type="number" name="net_value" class="net_value form-control" placeholder="34.55 zt" required>
         </div>
         <div class="form-group col-md-3">
          <label>Opis</label>
          <input type="text" name="title" class="form-control" placeholder="Opis" required>
         </div>
         <div class="form-group col-md-3">
          <label>Komentarz</label>
          <input type="text" name="comment" class="form-control" placeholder="Komentarz" required>
         </div>
         <div class="form-group col-md-12">
          <button class="btn btn-primary" type="submit">Zapisz</button>
         </div>
        </div>
       </div>
      </div>
     </div>
    </form>
   </div>
 </section>

@section('script')
 <script>
  $(document).on('keyup', '.vat_tax_value', function() {
   let vat_tax = $(this).val()
   $('.vat_tax_percent').val(vat_tax)
			
   let net_vat = $('.vat_tax_percent').val(vat_tax)
			
   let brut_value = $('.brut_value').val()
   let net_val = brut_value - (net_vat * brut_value)
			
   $('.net_value').val(net_val)
  });
 </script>
@endsection
@endsection
