@inject('roleController', "App\Http\Controllers\RolesController")
@php
 $menus = $roleController->getRoleMenus(auth()->user()->role_id);
@endphp
<ul id="sidebarnav">
    <li>
        <a href="{{ route('dashboard') }}">
            <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span>
        </a>
    </li>
    <li>
        <a class="has-arrow " href="#" aria-expanded="false">
            <i class="mdi mdi-settings"></i><span class="hide-menu">Configurations</span>
        </a>
        <ul aria-expanded="false" class="collapse">
            @if ($menus->contains('route', 'roles.index'))
                <li><a href="{{ route('roles.index') }}">Roles Management</a></li>
            @endif

                @if ($menus->contains('route', 'users.index'))
                    <li><a href="{{ route('users.index') }}">Users Management</a></li>
                @endif
                @if ($menus->contains('route', 'categories.index'))
                    <li><a href="{{ route('categories.index') }}">Categories Management</a></li>
                @endif
                @if ($menus->contains('route', 'slider.index'))
                    <li><a href="{{ route('slider.index') }}">Slider Management</a></li>
                @endif
                @if ($menus->contains('route', 'cars.index'))
                    <li><a href="{{ route('cars.index') }}">Car Brands Management</a></li>
                @endif
                @if ($menus->contains('route', 'cities.index'))
                    <li><a href="{{ route('cities.index') }}">Cities Management</a></li>
                @endif
                @if ($menus->contains('route', 'color.index'))
                    <li><a href="{{ route('color.index') }}">Colors Management</a></li>
                @endif
                @if ($menus->contains('route', 'phone.email.settings'))
                    <li><a href="{{ route('phone.email.settings') }}">Settings</a></li>
                @endif

                @if ($menus->contains('route', 'promotions.index'))
                    <li><a href="{{ route('promotions.index') }}">Manage Promotions</a></li>
                @endif

                @if ($menus->contains('route', 'staff.performance'))
                    <li><a href="{{ route('staff.performance') }}">Staff Performance</a></li>
                @endif
        </ul>
    </li>
    <li>
        <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Products</span></a>
        <ul aria-expanded="false" class="collapse">
            @if ($menus->contains('route', 'products.index'))
             <li><a href="{{ route('products.index') }}">Products List</a></li>
            @endif
            @if ($menus->contains('route', 'products.create'))
             <li><a href="{{ route('products.create') }}">Add Product</a></li>
            @endif
            @if ($menus->contains('route', 'products.discount'))
             <li><a href="{{ route('products.discount') }}">Apply Discounts</a></li>
            @endif
            @if ($menus->contains('route', 'export.products'))
               <li><a href="{{ route('export.products') }}">Product Exports</a></li>
            @endif
            @if ($menus->contains('route', 'manage.products.images'))
               <li><a href="{{ route('manage.products.images') }}">Manage Images</a></li>
            @endif
        </ul>
    </li>
    <li>
        <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-basket-unfill"></i><span class="hide-menu">Orders</span></a>
        <ul aria-expanded="false" class="collapse">
            @if ($menus->contains('route', 'admin.manage.orders'))
              <li><a href="{{ route('admin.manage.orders') }}">Manage Orders</a></li>
            @endif
        </ul>
    </li>
    @if ($menus->contains('route', 'pages.index'))
    <li>
        <a href="{{ route('pages.index') }}">
            <i class="mdi mdi-google-pages"></i>
            <span class="hide-menu">Manage Pages</span>
        </a>
    </li>
    @endif
    @if ($menus->contains('route', 'contact.us.index'))
    <li>
        <a href="{{ route('contact.us.index') }}">
            <i class="mdi mdi-contact-mail"></i>
            <span class="hide-menu">Manage ContactUs</span>
        </a>
    </li>
    @endif

    @if ($menus->contains('route', 'reports.index'))
    <li>
        <a href="{{ route('reports.index') }}">
            <i class="mdi mdi-library"></i>
            <span class="hide-menu">Reports</span>
        </a>
    </li>
    @endif
</ul>
