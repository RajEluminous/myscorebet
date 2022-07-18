<?php $r = \Route::current()->getAction() ?>
<?php $route = (isset($r['as'])) ? $r['as'] : ''; ?>

<ul class="sidebar-menu">
    <li class="header">MENU</li>
    <!-- Dashboard -->
    <li class="<?php echo ( starts_with($route, ADMIN.'.dash') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.dash') }}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <!-- Members -->
    <li class="<?php echo ( starts_with($route, ADMIN.'.members') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.members.index') }}">
            <i class="fa fa-users"></i>
            <span>Members</span>
        </a>
    </li>

    <!-- Events -->
    <li class="<?php echo ( starts_with($route, ADMIN.'.events') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.events.index') }}">
            <i class="fa fa-calendar"></i>
            <span>Events</span>
        </a>
    </li>

    <!-- Sub Events -->
    <li class="<?php echo ( starts_with($route, ADMIN.'.subevents') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.subevents.index') }}">
            <i class="fa fa-calendar"></i>
            <span>Sub Events</span>
        </a>
    </li>

    <!-- Winners Selection -->
    <li class="<?php echo ( starts_with($route, ADMIN.'.winners-selection') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.winnersselection') }}">
            <i class="fa fa-trophy"></i>
            <span>Last Month Winners</span>
        </a>
    </li>

    <!-- Sub Events -->
    <li class="treeview <?php echo ( starts_with($route, ADMIN.'.overallreports') || starts_with($route, ADMIN.'.eventsreports') || starts_with($route, ADMIN.'.monthreports')) ? "active" : '' ?>">
        <a href="#"><i class="fa fa-universal-access"></i><span>Reports</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="<?php echo ( starts_with($route, ADMIN.'.overallreports') ) ? "active" : '' ?>">
                <a href="{{ route(ADMIN.'.overallreports') }}"><i class="fa fa-circle-o"></i>Overall User Predictions</a>
            </li>
            <li class="<?php echo ( starts_with($route, ADMIN.'.eventsreports') ) ? "active" : '' ?>">
                <a href="{{ route(ADMIN.'.eventsreports') }}"><i class="fa fa-circle-o"></i>Eventwise User Predictions</a>
            </li>
            <li class="<?php echo ( starts_with($route, ADMIN.'.monthreports') ) ? "active" : '' ?>">
                <a href="{{ route(ADMIN.'.monthreports') }}"><i class="fa fa-circle-o"></i>Monthwise User Predictions</a>
            </li>
        </ul>
    </li>
</ul>
