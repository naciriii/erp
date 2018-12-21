@extends('stores::layouts.master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Products')
                </h1>
                <p class="mt-2">
                    <a href="{{route('Store.Products.create',['id'=>encode($store->id)])}}">
                        <button class="btn btn-sm btn-primary">@lang('stores::global.NewProduct')</button>
                    </a>
                </p>
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
                            <div class="col-md-12 col-sm-12">
                                <nav class="navbar navbar-light bg-light pull-right">
                                    <form class="form-inline" method="get" action="{{route('Store.Products.findProductBy',['id'=>encode($store->id)])}}">
                                        <input id="search" name="search" class="form-control mr-sm-2" type="search"
                                               placeholder="Search" aria-label="Search" value="{{$findBy or ''}}">
                                        <!--button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search
                                        </button-->
                                    </form>
                                </nav>
                            </div>
                        </div>
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

                                @foreach(collect($result->items) as $product)
                                    <tr @if($product->qty <= 10) class="bg-warning" @endif>
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
                                            <a href="{{route('Store.Products.show',['id'=>encode($store->id),'sku' => $product->sku])}}">
                                                <button class="btn btn-sm btn-primary">{{trans('global.Edit')}}</button>
                                            </a>
                                            <form class="d-inline" method="post"
                                                  action="{{route('Store.Products.destroy',['id' => encode($store->id),'sku'=>$product->sku])}}">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger deleteProductBtn">{{trans('global.Delete')}}</button>
                                            </form>
                                        </td>
                                    </tr>

                                @endforeach
                            @endif
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <nav id="simple-pagination" class="pull-right"></nav>
                            </div>
                        </div>
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

        {!! simplePagination($result,'#simple-pagination',$findBy) !!}

        $('#productsTable').DataTable({
            paginate: false,
            bInfo: false,
            searching: false
        });

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

        {{--}}$('#search').keyup(function () {
            if (this.value.length > 2) {
                $.get("{{route('Store.Products.findProductBy',['id'=>encode($store->id)])}}",
                    {
                        "_token": "{{ csrf_token() }}",
                        string: this.value
                    },
                    function (data) {
                    $.each(data.products.items, function (index, value) {
                        console.log((value));
                    })
                        //console.log(data.products.items);
                        //console.log(this.value);
                        //$( ".result" ).html( data );
                    });
            }
        })--}}
    </script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    @if(session('response'))
        <script>
            {!! bsNotify(session('response')) !!};
        </script>
    @endif
@stop
