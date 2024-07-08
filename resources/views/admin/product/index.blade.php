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
                        <li class="breadcrumb-item active">Product!</li>
                    </ol>
                </div>
                <h4 class="page-title">Product!</h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Add Product </h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('product.store')}}">
                    @csrf
                        <div class="row g-2">
                           <div class="mb-3 col-md-6">
                                <label for="inputEmail4" class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" id="inputEmail4"
                                    placeholder="Product Name">
                            </div>

                           <div class="mb-3 col-md-6">
                               <label for="inputEmail4" class="form-label">Product Indian Price Per Qty/Piece</label>
                               <input type="text" name="india_price" class="form-control" id="inputEmail4"
                                   placeholder="Enter Product Indian Price Per Qty/Piece">
                           </div>

                           <div class="mb-3 col-md-12">
                              <label for="inputEmail4" class="form-label">Product Stock</label>
                              <input type="text" name="stock" class="form-control" id="inputEmail4"
                                  placeholder="Enter Product Stock">
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
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
                        <th>Stock</th>
                        <th>Available Stock</th>
                        <th>Bd Price</th>
                        <th>Total Price BDT</th>
                        <th>Indian Price</th>
                        <th>Total Price INR</th>


                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product as $key=>$productData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$productData->name}}</td>
                            <td>{{$productData->stock}}</td>
                            <td>{{$productData->available_stock}}</td>
                            <td>
                                <span class="text-primary">{{ number_format($productData->india_price * $conversionRate, 2) }} BDT</span>
                            </td>

                            <td>
                                <span class="text-primary">{{ number_format($productData->india_price * $conversionRate * $productData->stock, 2) }} BDT</span>
                            </td>

                            <td>
                               <span class="text-success">{{$productData->india_price}} INR</span>
                            </td>

                            <td>
                              <span class="text-success">{{$productData->india_price*$productData->stock}} INR</span>
                            </td>


                            <td>{{$productData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#sellNewModalId{{$productData->id}}">Sell</button>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$productData->id}}">Edit</button>
                                        <a href="{{route('product.destroy',$productData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$productData->id}}">Delete</a>
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$productData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$productData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$productData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('product.update',$productData->id)}}">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="name" class="form-label">Product Name</label>
                                                            <input type="text" id="name" name="name" value="{{$productData->name}}"
                                                                   class="form-control" placeholder="Enter  Product Name" >
                                                        </div>
                                                    </div>



                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="india_price" class="form-label">Product Indian Price Per Qty/Piece</label>
                                                            <input type="text" id="india_price" name="india_price" value="{{$productData->india_price}}"
                                                                   class="form-control" placeholder="Enter  Rupee" >
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1" {{ $productData->status === 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $productData->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="sellNewModalId{{$productData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="sellNewModalLabel{{$productData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="sellNewModalLabel{{$productData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('product.sell',$productData->id)}}">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <input hidden="" type="text" id="product_id" name="product_id" value="{{$productData->id}}"
                                                                   class="form-control">
                                                        </div>
                                                    </div>



                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="india_price" class="form-label">Sell Qty/Piece to Stock</label>
                                                            <input type="text" id="stock_sell" name="stock_sell"
                                                                   class="form-control" placeholder="Enter  Sell Qty to Stock" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="submit">Sell</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Delete Modal -->
                            <div id="danger-header-modal{{$productData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$productData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$productData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('product.destroy',$productData->id)}}" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
