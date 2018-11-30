@extends('stores::layouts.master')

@section('content')

    <div class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('global.Add')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">@lang('modules.Stores')</li>
                <li class="breadcrumb-item"><a href="#">@lang('global.Add')</a></li>
            </ul>
        </div>
        <div class="row">
            @foreach(collect(Module::find('Stores')->subMenus)->sortBy('order') as $subMenu)

                <div class="col-md-6 col-lg-3">
                    <div class="widget-small primary coloured-icon">
                        <i class="icon fa {{$subMenu['icon']}} fa-3x"></i>
                        <div class="info">
                            <a href="{{route($subMenu['route'],['id' => encode($store->id)])}}">
                                <h4>@lang('stores::global.StoreMenus.'.$subMenu['name'])</h4>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        {{--<div class="row">
            <div class="col-md-12">
                @foreach(collect(Module::find('Stores')->subMenus)->sortBy('order') as $subMenu)
                    <a href="{{route($subMenu['route'],['id' => encode($store->id)])}}">
                        <div class="col-md-3 col-lg-3">
                            <div class="widget-small primary coloured-icon"><i
                                        class="icon {{$subMenu['icon']}} fa-3x"></i>
                                <div class="info">
                                    <h4>
                                        @lang('stores::global.StoreMenus.'.$subMenu['name']) </h4>

                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="clearix"></div>
        </div>--}}
    </div>

@stop
@section('js')

@stop
