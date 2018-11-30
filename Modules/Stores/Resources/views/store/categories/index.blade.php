@extends('stores::layouts.master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Categories')
                </h1>
                <p class="mt-2">
                    <a href="{{route('Store.Categories.create',['id'=>encode($store->id)])}}">
                        <button class="btn btn-sm btn-primary">@lang('stores::global.NewCategory')</button>
                    </a>
                </p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{trans('modules.Stores')}}</li>
                <li class="breadcrumb-item active"><a href="#">@lang('stores::global.StoreMenus.Categories')</a></li>
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
                                <th>{{trans('stores::global.Status')}}</th>
                                <th>{{trans('stores::global.Parent')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="productsTableBody">

                            @if(isset($result))
                                @foreach($result as $category)
                                    <tr>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            @if($category->is_active == 1)
                                                <label class="badge badge-primary">
                                                    <i class="fa fa-check"></i>
                                                </label>
                                            @else
                                                <label class="badge badge-danger">
                                                    <i class="fa fa-times"></i>
                                                </label>
                                            @endif
                                        </td>
                                        <td>{{$result->where('id',$category->parent_id)->first()->name or ''}}</td>
                                        <td>Action</td>
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