@extends('stores::layouts.master')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Customers')
                </h1>
                <p class="mt-2">
                    <a href="{{route('Store.Customers.create',['id'=>encode($store->id)])}}">
                        <button class="btn btn-sm btn-primary">@lang('stores::global.NewCustomer')</button>
                    </a>
                </p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{trans('modules.Store')}}</li>
                <li class="breadcrumb-item active"><a href="#">@lang('stores::global.StoreMenus.Customers')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">

                        <table class="table table-hover table-bordered" id="customersTable">
                            <thead>
                            <tr>
                                <th>{{trans('stores::global.Email')}}</th>
                                <th>{{trans('stores::global.FirstName')}}</th>
                                <th>{{trans('stores::global.LastName')}}</th>
                                <th>{{trans('stores::global.Phone')}}</th>
                                <th>{{trans('stores::global.Address')}}</th>
                                <th>{{trans('stores::global.CreatedAt')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="customersTableBody">
                            @if(isset($result->items))
                                @foreach(collect($result->items) as $customer)
                                    <tr>
                                        <td>{{$customer->email}}</td>
                                        <td>{{$customer->firstname}}</td>
                                        <td>{{$customer->lastname}}</td>
                                        <td>@if(count($customer->addresses))
                                                {{$customer->addresses[0]->telephone}}
                                            @endif</td>
                                        <td>@if(count($customer->addresses))
                                                {{$customer->addresses[0]->country_id.' '.$customer->addresses[0]->city.' '.$customer->addresses[0]->postcode}}
                                            @endif</td>
                                        <td>{{$customer->created_at}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>


                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <nav aria-label="Page navigation example" class="pull-right">
                                    <ul class="pagination pull-right">
                                        <li class="page-item @if($result->search_criteria->current_page - 1 == 0) disabled @endif">
                                            <a class="page-link"
                                               href="{{route('Store.Customers.index',['id'=>encode($store->id), 'page'=>$result->search_criteria->current_page-1])}}">Previous</a>
                                        </li>


                                        @if((ceil($result->total_count / $result->search_criteria->page_size)) <= 3)
                                            @for ($i = 1; $i <= (ceil($result->total_count / $result->search_criteria->page_size)); $i++)
                                                <li class="page-item @if($result->search_criteria->current_page == $i) active @endif">
                                                    <a class="page-link"
                                                       href="{{route('Store.Customers.index',['id'=>encode($store->id), 'page'=>$i])}}">
                                                        {{$i}}
                                                    </a>
                                                </li>
                                            @endfor
                                        @elseif((ceil($result->total_count / $result->search_criteria->page_size)) >= 4)

                                            @if($result->search_criteria->page_size >= 3 )
                                                @for ($i = 1; $i <= 3; $i++)
                                                    <li class="page-item @if($result->search_criteria->current_page == $i) active @endif">
                                                        <a class="page-link"
                                                           href="{{route('Store.Customers.index',['id'=>encode($store->id), 'page'=>$i])}}">
                                                            {{$i}}
                                                        </a>
                                                    </li>
                                                @endfor
                                                <li class="page-item"><a class="page-link" href="{{route('Store.Customers.index',['id'=>encode($store->id), 'page'=>4])}}">...</a>
                                                </li>
                                            @else
                                                @for ($i = 3; $i <= $result->search_criteria->current_page + 3; $i++)
                                                    <li class="page-item @if($result->search_criteria->current_page == $i) active @endif">
                                                        <a class="page-link"
                                                           href="{{route('Store.Customers.index',['id'=>encode($store->id), 'page'=>$i])}}">
                                                            {{$i}}
                                                        </a>
                                                    </li>
                                                @endfor
                                            @endif



                                            

                                        @endif


                                        <li class="page-item @if($result->search_criteria->current_page + 1 > ceil($result->total_count / $result->search_criteria->page_size)) disabled @endif">
                                            <a class="page-link"
                                               href="{{route('Store.Customers.index',['id'=>encode($store->id), 'page'=>$result->search_criteria->current_page +1])}}">Next</a>
                                        </li>


                                    </ul>
                                </nav>
                            </div>
                            <div class="col-md-12">
                                @for ($i = 1; $i <= (ceil($result->total_count / $result->search_criteria->page_size)); $i++)
                                    <li class="page-item @if($result->search_criteria->current_page == $i) active @endif">
                                        <a class="page-link"
                                           href="{{route('Store.Customers.index',['id'=>encode($store->id), 'page'=>$i])}}">
                                            {{$i}}
                                        </a>
                                    </li>
                                @endfor
                            </div>
                        </div>


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
        $('#customersTable').DataTable({
            paginate: false,
            bInfo: false
        });


        $("#customersTableBody").on('click', '.deleteCustomerBtn', function (e) {
            e.preventDefault();
            bsAlert("@lang('global.AreYouSure')",
                "@lang('stores::global.AreYouSureCustomer')",
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
