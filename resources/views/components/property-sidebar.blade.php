<div class="sidebar">
    <ul class="nav nav-tabs flex-column">
        <li class="nav-item">
            <a class="nav-link {{ isActiveRoute('my-properties') }} || {{ isActiveRoute('edit-properties')}}" href="{{route('my-properties')}}">My Properties</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isActiveRoute('add-property') }}" href="{{route('add-property')}}">Add Property</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">Recently Visited Property</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">Referred Renters</a>
        </li>
    </ul>
</div>