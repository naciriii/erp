@extends('stores::layouts.master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Products')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{trans('modules.Stores')}}</li>
                <li class="breadcrumb-item active"><a href="#">@lang('stores::global.StoreMenus.Products')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <nav class="navbar navbar-light bg-light pull-left">
                                    <form class="form-inline" method="get"
                                          action="{{route('Store.Products.search',['id'=>encode($store->id)])}}">
                                        <input id="search" name="search" class="form-control mr-sm-2" type="search"
                                               placeholder="Search" aria-label="Search" value="{{$findBy or ''}}">
                                    </form>
                                </nav>
                            </div>
                        </div>
                        <form method="post"
                              action="{{route('Store.order.create.stepTow',['id'=>encode($store->id),'customerId' => $customerId])}}">
                            {{csrf_field()}}
                            <table class="table table-hover table-bordered" id="productsTable">
                                <thead>
                                <tr>
                                    <th>{{trans('stores::global.Name')}}</th>
                                    <th>{{trans('stores::global.Price')}}</th>
                                    <th>{{trans('stores::global.Sku')}}</th>
                                    <th>{{trans('stores::global.Image')}}</th>
                                    <th>{{trans('stores::global.Quantity')}}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="productsTableBody">
                                @if(isset($result->items))
                                    @foreach(collect($result->items)->sortByDesc('created_at') as $product)
                                        <tr @if($product->qty <= 10) class="bg-warning"
                                            @endif id="row-{{$product->id}}">
                                            <td>{{$product->name}}</td>
                                            <td>
                                                @if(count(collect($product->custom_attributes)->where('attribute_code','special_price')))
                                                    Regular Price  <s>€ {{$product->price}} </s>
                                                    <br>
                                                    Promotion
                                                    €{{collect($product->custom_attributes)->where('attribute_code','special_price')->first()->value}}
                                                    <br>
                                                    From
                                                    {{collect($product->custom_attributes)->where('attribute_code','special_from_date')->first()->value}}
                                                    To
                                                    {{collect($product->custom_attributes)->where('attribute_code','special_to_date')->first()->value}}
                                                @else
                                                    {{$product->price}}
                                                @endif
                                            </td>

                                            <td>{{$product->sku}}</td>
                                            <td>
                                                @if(collect($product->custom_attributes)->where('attribute_code','image')->first() != null)
                                                    <img class="img-thumbnail" style="width: 100px; height: 100px"
                                                         src="{{$store->base_url.config('stores.api.public_resources').collect($product->custom_attributes)->where('attribute_code','image')->first()->value}}">
                                                @endif
                                            </td>
                                            <td>{{$product->qty}}</td>
                                            <td>
                                                <div class="form-check" id="prod_{{$product->id}}">
                                                    <label class="form-check-label">

                                                        <input class="form-check-input" type="checkbox"
                                                               value="{{$product->id}}"
                                                               onchange="selectProduct({{$product->id}})"
                                                               name="products[prod_{{$product->id}}][id]">
                                                        <input type="text" class="form-control" disabled
                                                               name="products[prod_{{$product->id}}][qty]"
                                                               placeholder="Quantity">

                                                        <input type="hidden" disabled
                                                               name="products[prod_{{$product->id}}][prop]"
                                                               value="{{json_encode($product)}}">
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <nav class="navbar navbar-light bg-light pull-right">
                                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                                            @lang('stores::global.Next')
                                        </button>
                                    </nav>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <nav id="simple-pagination" class="pull-right"></nav>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
@section ('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/simplePagination.css')}}">
@stop
@section('js')
    <script type="text/javascript" src="{{asset('js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/sweetalert.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/jquery.simplePagination.js')}}"></script>

    <script type="text/javascript">

        {!! dataTable('#productsTable') !!}
        {!! simplePagination($result,'#simple-pagination',$findBy) !!}

        $("#productsTableBody").on('click', '.deleteProductBtn', function (e) {
            e.preventDefault();
            bsAlert("@lang('global.AreYouSure')",
                "@lang('stores::global.AreYouSureProduct')",
                "warning",
                "@lang('global.Confirm')",
                "@lang('global.Cancel')",
                function (isConfirm) {
                    if (isConfirm) {
                        $(e.target).closest('form').submit();
                    }
                });
        });

        function selectProduct(id) {

            if ($('#row-' + id).find("input[type='checkbox']").prop("checked")) {
                $('#row-' + id).find("input[type='text']").val(1);
                $('#row-' + id).find("input[type='text']").prop("disabled", false);
                $('#row-' + id).find("input[type='hidden']").prop("disabled", false);
            } else {
                $('#row-' + id).find("input[type='text']").val('');
                $('#row-' + id).find("input[type='text']").prop("disabled", true);
                $('#row-' + id).find("input[type='hidden']").prop("disabled", true);
            }
        }
    </script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    @if(session('response'))
        <script>
            {!! bsNotify(session('response')) !!};
        </script>
    @endif
@stop
