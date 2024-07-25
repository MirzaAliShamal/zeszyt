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
                                        <label>Type</label>
                                        <select name="type" class="form-control" required>
                                            <option value="cost">Cost</option>
                                            <option value="income">Income</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Category</label>
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
                                        <label>BRUT Value</label>
                                        <input type="number" name="brut_value" class="form-control" placeholder="1234 zt"
                                            required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Profit</label>
                                        <input type="number" name="profit" class="form-control" placeholder="1234 zt"
                                            required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>VAT tax (%)</label>
                                        <input type="number" name="vat_tax_percent" class="form-control" placeholder="34%"
                                            required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>VAT tax (value)</label>
                                        <input type="number" name="vat_tax_value" class="form-control"
                                            placeholder="34.232.55%" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>NET Value</label>
                                        <input type="number" name="net_value" class="form-control" placeholder="34.55 zt"
                                            required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Comment</label>
                                        <input type="text" name="comment" class="form-control" placeholder="Comment"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </section>

@endsection
