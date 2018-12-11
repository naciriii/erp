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
                    </a></p>
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
                        <table class="table table-hover table-bordered" id="productsTable">
                            <thead>
                            <tr>
                                <th>{{trans('stores::global.Name')}}</th>
                                <th>{{trans('stores::global.Price')}}</th>
                                <th>{{trans('stores::global.Sku')}}</th>
                                <th>{{trans('stores::global.Quantity')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="productsTableBody">
                            @if(isset($result->items))
                                @foreach(collect($result->items) as $product)
                                    <tr>
                                        <td>{{$product->name}}</td>
                                        <td>€ {{$product->price}}</td>
                                        <td>{{$product->sku}}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </main>

@stop
@section('js')
    <script type="text/javascript" src="{{asset('js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/sweetalert.min.js')}}"></script>

    <script type="text/javascript">
        $('#productsTable').DataTable();

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

    </script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    @if(session('response'))
        <script>
            {!! bsNotify(session('response')) !!};
        </script>
    @endif
@stop
