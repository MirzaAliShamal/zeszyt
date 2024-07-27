@extends('layouts.app')
@section('page_title', 'Monthly Summary')

@section('content')

    <section class="section">
        <div class="section-body">
            <h1 class="text-center">{{ $curernt_month }}</h1>
            <div class="row">
                <div class="col-12 col-md-5 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th class="text-danger font-weight-bold">Costs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bg-danger text-white font-weight-bold">{{ $total_net }} zt</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>NET</th>
                                        <th>VAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Credit</th>
                                        <td>{{ $credit_net }} zt</td>
                                        <td>{{ $credit_vat_tax }} zt</td>
                                    </tr>
                                    <tr>
                                        <th>Materials</th>
                                        <td>{{ $material_net }} zt</td>
                                        <td>{{ $material_vat_tax }} zt</td>
                                    </tr>
                                    <tr>
                                        <th>Transport</th>
                                        <td>{{ $transport_net }} zt</td>
                                        <td>{{ $transport_vat_tax }} zt</td>
                                    </tr>
                                    <tr>
                                        <th>Employes Payment</th>
                                        <td>{{ $employes_payment_net }} zt</td>
                                        <td>{{ $employes_payment_vat_tax }} zt</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center">VAT included</th>
                                        <td>{{ $total_vat_tax }} zt</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-5 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th class="text-success font-weight-bold">Incomes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bg-success text-white font-weight-bold">{{ $total_income_net }} zt</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>NET</th>
                                        <th>VAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Service</th>
                                        <td>{{ $service_net }} zt</td>
                                        <td>{{ $service_vat_tax }} zt</td>
                                    </tr>
                                    <tr>
                                        <th>Sell</th>
                                        <td>{{ $sell_net }} zt</td>
                                        <td>{{ $sell_vat_tax }} zt</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center">VAT due</th>
                                        <td>{{ $total_income_vat_tax }} zt</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-2 col-md-2 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($months as $k => $month_list)
                                <a href="{{ route('admin.monthly-summary', ['month' => $k + 1]) }}"
                                    class="btn btn-info w-100 mb-3">{{ $month_list }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="recent-report__chart">
                                <div id="operations-graph"></div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">

                                <tr>
                                    <th>The amount of VAT paid to the tax office</th>
                                    <td>{{ $vat_paid_to_tax_office }} zt</td>
                                </tr>
                                <tr class="text-center">
                                    <th>The amount of Income tax</th>
                                    <td>{{ $income_tax_amount }} zt</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th>PROFIT</th>
                                    <td class="bg-success font-weight-bold">{{ $profit }} zt</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@section('script')
    <script type="text/javascript"></script>
@endsection
@endsection
