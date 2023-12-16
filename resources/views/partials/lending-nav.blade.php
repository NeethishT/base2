<li class="nav-item dropdown @if(in_array(Route::currentRouteName(), ['cms.len.productroutes.list','cms.len.lensettings.list','cms.len.lenproducts.list','cms.len.lenproductstatus.list','cms.len.lenstatusgroupmaster.list'])) active @endif">
    <a class="nav-link dropdown-toggle" href="#lending" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
      <span class="nav-link-icon d-md-none d-lg-inline-block">
        <i class="ti ti-package icon"></i>
    </span>
      <span class="nav-link-title">
        Lending
      </span>
    </a>
    <div class="dropdown-menu @if(in_array(Route::currentRouteName(), ['cms.len.productroutes.list','cms.len.lensettings.list','cms.len.lenproducts.list','cms.len.lenproductstatus.list','cms.len.lenstatusgroupmaster.list'])) show @endif">
      <div class="dropdown-menu-columns">
        <div class="dropdown-menu-column">
          <div class="dropend">
            <a class="dropdown-item dropdown-toggle @if(in_array(Route::currentRouteName(), ['cms.len.productroutes.list','cms.len.lensettings.list','cms.len.lenproducts.list','cms.len.lenproductstatus.list','cms.len.lenstatusgroupmaster.list'])) show @endif" href="#lending" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-package icon"></i>
                </span>
                <span class="nav-link-title">
                    Masters
                </span>
            </a>
            <div class="dropdown-menu show">
              @if(in_array('cms.len.productroutes.list',$rolePermission))
              <div class="dropdown-menu-columns show">
                  <a class="dropdown-item @if(in_array(Route::currentRouteName(), ['cms.len.productroutes.list'])) active @endif" href="{{ route('cms.len.productroutes.list') }}" >
                      <i class="ti ti-file icon"></i> Product Routes
                  </a>
              </div>
              @endif
              @if(in_array('cms.len.lensettings.list',$rolePermission))
              <div class="dropdown-menu-columns show">
                  <a class="dropdown-item @if(in_array(Route::currentRouteName(), ['cms.len.lensettings.list'])) active @endif" href="{{ route('cms.len.lensettings.list') }}" >
                      <i class="ti ti-file icon"></i> Len Settings
                  </a>
              </div>
              @endif
              @if(in_array('cms.len.lenproducts.list',$rolePermission))
              <div class="dropdown-menu-columns show">
                  <a class="dropdown-item @if(in_array(Route::currentRouteName(), ['cms.len.lenproducts.list'])) active @endif" href="{{ route('cms.len.lenproducts.list') }}" >
                      <i class="ti ti-file icon"></i> Len Products
                  </a>
              </div>
              @endif
              @if(in_array('cms.len.lenproductstatus.list',$rolePermission))
              <div class="dropdown-menu-columns show">
                  <a class="dropdown-item @if(in_array(Route::currentRouteName(), ['cms.len.lenproductstatus.list'])) active @endif" href="{{ route('cms.len.lenproductstatus.list') }}" >
                      <i class="ti ti-file icon"></i> Len Product Status
                  </a>
              </div>
              @endif
              @if(in_array('cms.len.lenstatusgroupmaster.list',$rolePermission))
              <div class="dropdown-menu-columns show">
                  <a class="dropdown-item @if(in_array(Route::currentRouteName(), ['cms.len.lenstatusgroupmaster.list'])) active @endif" href="{{ route('cms.len.lenstatusgroupmaster.list') }}" >
                      <i class="ti ti-file icon"></i> Len Status Group Master
                  </a>
              </div>
              @endif
          </div>
          </div>
        </div>
      </div>
    </div>
  </li>