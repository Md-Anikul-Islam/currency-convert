@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inventory</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Sell!</li>
                    </ol>
                </div>
                <h4 class="page-title">Sell!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Product Name</th>
                        <th>Stock Sell</th>
                        <th>INR Price</th>
                        <th>Bd Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sell as $key=>$sellData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$sellData->product->name}}</td>
                            <td>{{$sellData->stock_sell}}</td>
                            <td>{{$sellData->product->india_price * $sellData->stock_sell}} INR</td>
                            <td>{{ number_format($sellData->product->india_price * $conversionRate * $sellData->stock_sell, 2) }} BDT</td>
                         </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
