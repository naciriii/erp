
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">{{Auth::user()->name}}</p>
          @foreach(Auth::user()->roles as $role)
          <p class="app-sidebar__user-designation">-{{title_case($role->name)}}</p>
          @endforeach
        </div>

      </div>
      <ul class="app-menu">

        <li><a class="app-menu__item active" href="{{url('/')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        @foreach(collect(Module::getOrdered()) as $module)
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa {{$module->icon}}"></i><span class="app-menu__label">{{trans('modules.'.$module->name)}}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          @if(count($module->menus))
          <ul class="treeview-menu">
            @foreach(collect($module->menus)->sortBy('order') as $menu)
            <li><a class="treeview-item" href="{{route($menu['route'])}}"><i class="icon fa {{$menu['icon']}}"></i> 
            {{trans('global.'.$menu['name'])}}</a></li>
            @endforeach
           
          </ul>
          @endif
        </li>
        @endforeach
   
      </ul>
    </aside>