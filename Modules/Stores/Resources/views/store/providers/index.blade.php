@extends('stores::layouts.master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Providers')
                </h1>
                <p class="mt-2">
                    <a href="{{route('Store.Providers.create',['id'=>encode($store->id)])}}">
                        <button class="btn btn-sm btn-primary">@lang('stores::global.NewProvider')</button>
                    </a>
                </p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{trans('modules.Stores')}}</li>
                <li class="breadcrumb-item active"><a href="#">@lang('stores::global.StoreMenus.Providers')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="providersTable">
                            <thead>
                            <tr>
                                <th>{{trans('stores::global.Name')}}</th>
                                <th>{{trans('stores::global.Slug')}}</th>
                                <th>{{trans('stores::global.IsActive')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="providersTableBody">

                            @if(isset($result))
                                @foreach($result as $provider)
                                    <tr>
                                        <td>{{$provider->name}}</td>
                                        <td>{{$provider->slug}}</td>
                                        <td>
                                            @if($provider->is_active == 1)
                                                <label class="badge badge-primary">
                                                    <i class="fa fa-check"></i>
                                                </label>
                                            @else
                                                <label class="badge badge-danger">
                                                    <i class="fa fa-times"></i>
                                                </label>
                                            @endif
                                        </td>
                                        <td>
                                               <button class="btn btn-sm btn-info">{{trans('global.Addresses')}}</button>
                                            <a href="{{route('Store.Providers.show',['id'=>encode($store->id),'cat' => encode($provider->id)])}}">
                                                <button class="btn btn-sm btn-primary">{{trans('global.Edit')}}</button>
                                            </a>
                                            <form class="d-inline" method="post"
                                                  action="{{route('Store.Providers.destroy',['id' => encode($store->id),'cat'=>encode($provider->id)])}}">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger deleteProviderBtn">{{trans('global.Delete')}}</button>
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
        $('#providersTable').DataTable();

        $("#providersTableBody").on('click', '.deleteProviderBtn', function (e) {
            e.preventDefault();
            bsAlert("@lang('global.AreYouSure')",
                "@lang('stores::global.AreYouSureProvider')",
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