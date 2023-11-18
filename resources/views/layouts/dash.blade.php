@include('layouts.header')
<div class="full_container">
    <div class="inner_container">
    <!-- Sidebar  -->
    @include('layouts.sidenav')
    <!-- end sidebar -->
    <!-- right content -->
    <div id="content">
        <!-- topbar -->
        @include('layouts.topnav')
        <!-- end topbar -->
        <!-- dashboard inner -->
        @yield('content')
        <!-- end dashboard inner -->
     
    </div>
    
    </div>
</div>
@include('layouts.footer')
      