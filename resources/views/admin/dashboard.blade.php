<h1>Admin Dashboard</h1>
<a href="" onclick="event.preventDefault(); getElementById('logout').submit();"
    class="dropdown-item">Logout</a>
<!-- Authentication -->
<form method="POST" id="logout" action="{{ route('admin.logout') }}">
    @csrf
</form>