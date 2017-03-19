          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              <!-- Sidebar user panel (optional) -->
              <div class="user-panel">
                <div class="pull-left image">
                
                <img src="{!! url().'/images/3hammers_footer.png' !!}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                  <p>{{ access()->user()->name }}</p>
                  <!-- Status -->
                  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
              </div>

              

              <!-- Sidebar Menu -->
              <ul class="sidebar-menu">
                <li class="header">{{ trans('menus.main_navigation') }}</li>
                @permission('view-page-management')
                <li class="{{ Active::pattern('admin/pages*') }} treeview">
                  <a href="#">
                    <i class="fa fa-files-o"></i><span>{{ trans('menus.pages.pages') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/pages*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/pages*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/pages/create') }}">
                      <a href="{!! url('admin/pages/create') !!}"><i class="fa fa-plus"></i> {{ trans('menus.pages.new') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/pages ') }}">
                      <a href="{!! url('admin/pages') !!}"><i class="fa fa-file-text-o"></i> {{ trans('menus.pages.all') }}</a>
                    </li>
                  </ul>
                </li>
                @endauth

                @permission('view-page-management')
                <li class="{{ Active::pattern('admin/innerpages*') }} treeview">
                  <a href="#">
                    <i class="fa fa-files-o"></i><span>{{ trans('Inner Pages') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/innerpages*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/innerpages*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/innerpages/create') }}">
                      <a href="{!! url('admin/innerpages/create') !!}"><i class="fa fa-plus"></i> {{ trans('Add New') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/innerpages ') }}">
                      <a href="{!! url('admin/innerpages') !!}"><i class="fa fa-file-text-o"></i> {{ trans('All Inner Pages') }}</a>
                    </li>
                  </ul>
                </li>
                @endauth

              
              @permission ('view-packages-management')
                <li class="{{ Active::pattern('admin/package*')}} treeview">
                  <a href="#">
                    <i class="fa fa-minus-circle"></i><span>{{ trans('Package') }}</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/package*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/package*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/packages ') }}">
                      <a href="{!! url('admin/packages') !!}"><i class="fa fa-file-text-o"></i> {{ trans('All Packages') }}</a>
                    </li>
                    <!--
                    <li class="{{ Active::pattern('admin/packages/create ') }}">
                      <a href="{!! url('admin/packages/create') !!}"><i class="fa fa-plus"></i> {{ trans('Add New Package') }}</a>
                    </li> -->
                    <li class="{{ Active::pattern('admin/packages/datesprices ') }}">
                      <a href="{!! url('admin/packages/datesprices') !!}"><i class="glyphicon glyphicon-th-list"></i> {{ trans('Package Date & Price') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/packages/itinerary') }}">
                      <a href="{!! url('admin/packages/itinerary') !!}"><i class="glyphicon glyphicon-th-list"></i> {{ trans('Package Itinerary') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/packages/category ') }}">
                      <a href="{!! url('admin/packages/category') !!}"><i class="glyphicon glyphicon-th-list"></i> {{ trans('Package Category') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/packages/options ') }}">
                      <a href="{!! url('admin/packages/options') !!}"><i class="glyphicon glyphicon-th-list"></i> {{ trans('Package Options') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/packages/gallery ') }}">
                      <a href="{!! url('admin/packages/gallery') !!}"><i class="glyphicon glyphicon-th-list"></i> {{ trans('Gallery') }}</a>
                    </li>
                  </ul>
                  </li>
                @endauth

<!-- previous code -->
               <!--  @permission ('view-package-management')
                <li class="{{ Active::pattern('admin/package*')}} treeview">
                  <a href="#">
                    <i class="fa fa-minus-circle"></i><span>{{ trans('Package') }}</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/package*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/package*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/packages/create ') }}">
                      <a href="{!! url('admin/packages/create') !!}"><i class="fa fa-plus"></i> {{ trans('Add New') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/packages ') }}">
                      <a href="{!! url('admin/packages') !!}"><i class="fa fa-file-text-o"></i> {{ trans('All Packages') }}</a>
                    </li>
                  </ul>
                  </li>
                @endauth -->
<!-- end previous code -->
  
              @permission ('view-customer-management')
                <li class="{{ Active::pattern('admin/customers*')}} treeview">
                  <a href="#">
                    <i class="fa fa-user"></i><span>{{ trans('Customers') }}</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/customers*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/customers*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/customers') }}">
                      <a href="{!! url('admin/customers') !!}"><i class="fa fa-file-text-o"></i> {{ trans('All Customers') }}</a>
                    </li>
                  </ul>
                </li>
                @endauth

                @permission ('view-menu-management')
                <li class="{{ Active::pattern('admin/menus*')}} treeview">
                  <a href="#">
                    <i class="fa fa-minus-circle"></i><span>{{ trans('Menu') }}</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/menus*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/menus*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/menus ') }}">
                      <a href="{!! url('admin/menus') !!}"><i class="fa fa-file-text-o"></i> {{ trans('All Menu') }}</a>
                    </li>
                  </ul>
                  </li>
                @endauth
            
              <!-- Sidebar Menu -->
                @permission('view-slider-management')
                <li class="{{ Active::pattern('admin/slides*') }} treeview">
                  <a href="#">
                    <i class="fa fa-file-image-o"></i><span>{{ trans('menus.slides.slide') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/slides*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/slides*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/slides ') }}">
                      <a href="{!! url('admin/slides/management') !!}"><i class="fa fa-file-text-o"></i> {{ trans('menus.slides.Manages') }}</a>
                    </li>
                  </ul>
                </li>
                @endauth

                <!-- setting Menu -->
                @permission('settings-management')
                <li class="{{ Active::pattern('admin/settings*') }} treeview">
                  <a href="#">
                    <i class="fa fa-cogs"></i><span>{{ trans('menus.settings') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/settings*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/settings*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/settings') }}">
                      <a href="{!! url('admin/settings') !!}"><i class="fa fa-cog"></i>{{ trans('menus.general_settings') }}</a>
                    </li>
                  </ul>
                </li>
                @endauth

                @permission('emails-management')
                <li class="{{ Active::pattern('admin/email*') }} treeview">
                  <a href="#">
                    <i class="fa fa-cogs"></i><span>{{ trans('Email Template') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/email*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/email*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/email/travellerregister') }}">
                      <a href="{!! url('admin/email/travellerregister') !!}"><i class="fa fa-cog"></i>{{ trans('Traveller Register') }}</a>
                    </li>
                  </ul>
                </li>
                @endauth

                @permission('view-Permission-management')
                <li class="{{ Active::pattern('admin/permission*') }} treeview">
                  <a href="#">
                    <i class="glyphicon glyphicon-ok-sign"></i><span>{{ trans('menus.permission.permission') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/permission*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/permission*', 'display: block;') }}">
                  <li class="{{ Active::pattern('admin/permission/user ') }}">{!! link_to_route('admin.access.users.index', trans('menus.permission.user')) !!}</li>

                  <li class="{{ Active::pattern('admin/permission/roles ') }}">{!! link_to_route('admin.access.roles.index', trans('menus.permission.role')) !!}</li>
                   
                  </ul>
                </li>
                
                @endauth

               
                @permission('view-summitteers-management')
                <li class="{{ Active::pattern('admin/Summitteers*') }} treeview">
                  <a href="#">
                    <i class="glyphicon glyphicon-ok-sign"></i><span>{{ trans('Summitteers') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/Summitteers*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/permission*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/summitteers/create') }}">
                      <a href="{!! url('admin/summitteers/create') !!}"><i class="fa fa-plus"></i>{{ trans('Add New') }}</a>
                    </li> 
                    <li class="{{ Active::pattern('admin/summitteers') }}">
                      <a href="{!! url('admin/summitteers') !!}"><i class="fa fa-file-text-o"></i>{{ trans('All Summitteers') }}</a>
                    </li>                  
                  </ul>
                </li>                
                @endauth

                @permission('view-video-management')
                <li class="{{ Active::pattern('admin/videos*') }} treeview">
                  <a href="#">
                    <i class="glyphicon glyphicon-facetime-video"></i><span>{{ trans('Videos') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/videos*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/videos*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/videos ') }}">
                      <a href="{!! url('admin/videos/management') !!}">{{ trans('All Videos') }}</a>
                    </li>
                    <!-- <li class="{{ Active::pattern('admin/videos ') }}">
                      <a href="{!! url('admin/videos/create') !!}">{{ trans('Add Videos') }}</a>
                    </li> -->
                  </ul>
                </li>
                @endauth
                
                @permission('view-ad-management')
                <li class="{{ Active::pattern('admin/ads*') }} treeview">
                  <a href="#">
                    <i class="fa fa-file-image-o"></i><span>{{ trans('ads') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/ads*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/ads*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/ads ') }}">
                      <a href="{!! url('admin/ads/management') !!}">{{ trans('All Ads') }}</a>
                    </li>
                    <!-- <li class="{{ Active::pattern('admin/videos ') }}">
                      <a href="{!! url('admin/videos/create') !!}">{{ trans('Add Videos') }}</a>
                    </li> -->
                  </ul>
                </li>
                @endauth
                
                @permission('view-linksearch-management')
                <li class="{{ Active::pattern('admin/linksearch*') }} treeview">
                  <a href="#">
                    <i class="fa fa-file-image-o"></i><span>{{ trans('linksearch') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/linksearch*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/linksearch*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/linksearch ') }}">
                      <a href="{!! url('admin/linksearch/management') !!}">{{ trans('All Search Link') }}</a>
                    </li>
                    <!-- <li class="{{ Active::pattern('admin/videos ') }}">
                      <a href="{!! url('admin/videos/create') !!}">{{ trans('Add Videos') }}</a>
                    </li> -->
                  </ul>
                </li>
                @endauth
                

              </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
          </aside>
