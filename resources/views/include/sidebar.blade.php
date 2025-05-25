<!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="{{url('dashboard')}}" class="brand-link">


        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>



    </a>



    <!-- Sidebar -->

    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->

        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Add icons to the links using the .nav-icon class

               with font-awesome or any other icon font library -->

                <li class="nav-item menu-open">

                    <a href="{{url('dashboard')}}" class="nav-link active">

                        <i class="nav-icon fas fa-tachometer-alt"></i>

                        <p>Dashboard



                        </p>

                    </a>



                </li>



            </ul>

        </nav>

        <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

</aside>
