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
                        <li class="breadcrumb-item active">Currency!</li>
                    </ol>
                </div>
                <h4 class="page-title">Currency!</h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Add Currency </h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('currency.store')}}">
                    @csrf
                        <div class="row g-2">

                           <div class="mb-3 col-md-6">
                               <label for="inputEmail4" class="form-label">Indian Take(INR)</label>
                               <input type="text" name="rupee" value="1" class="form-control" id="inputEmail4"
                                   placeholder="Indian Take">
                           </div>

                          <div class="mb-3 col-md-6">
                               <label for="inputEmail4" class="form-label">Bd Take(BDT)</label>
                               <input  type="text" name="take"  class="form-control" id="inputEmail4"
                                   placeholder="Bd Take">
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
                        <th>Rupee</th>
                        <th>Take</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($currency as $key=>$currencyData)
                        <tr>
                            <td>{{$key+1}}</td>

                            <td>{{$currencyData->rupee}} INR</td>
                            <td>{{$currencyData->take}} TK</td>
                            <td>
                                {{$currencyData->created_at->format('d/m/Y')}}
                            </td>
                            <td>{{$currencyData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$currencyData->id}}">Edit</button>
                                        <a href="{{route('currency.destroy',$currencyData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$currencyData->id}}">Delete</a>
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$currencyData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$currencyData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$currencyData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('currency.update',$currencyData->id)}}">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="take" class="form-label">Take</label>
                                                            <input type="text" id="take" name="take" value="{{$currencyData->take}}"
                                                                   class="form-control" placeholder="Enter  Take" >
                                                        </div>
                                                    </div>

                                                     <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="rupee" class="form-label">Rupee</label>
                                                            <input type="text" id="rupee" name="rupee" value="{{$currencyData->rupee}}"
                                                                   class="form-control" placeholder="Enter  Rupee" >
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1" {{ $currencyData->status === 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $currencyData->status === 0 ? 'selected' : '' }}>Inactive</option>
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
                            <!-- Delete Modal -->
                            <div id="danger-header-modal{{$currencyData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$currencyData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$currencyData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('currency.destroy',$currencyData->id)}}" class="btn btn-danger">Delete</a>
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
