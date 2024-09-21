<div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar" class="bg-light">
        <div class="p-4">
            <h5>Dashboard</h5>
            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('employees.index') }}">Employees</a>
                </li>
                @if(Auth::user()->role !== 'employee')
                <li>
                    <a href="{{ route('departments.index') }}">Departments</a>
                </li>
                @endif
                <li>
                    <a href="{{ route('tasks.index') }}">Tasks</a>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    </div>

<style>
    #sidebar {
        width: 112px;
        position: fixed;
        height: 100%;
    }
    #content {
        margin-left: 250px;
        width: calc(100% - 250px);
    }
</style>
