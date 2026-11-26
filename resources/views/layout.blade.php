<!DOCTYPE html>
<html>
<head><title>Inventory</title><link rel="stylesheet" href="/style.css"></head>
<body>
  @php $role = session('role'); $name = ['logistic' => 'Logistic Officer', 'coordinator' => 'Coordinator', 'hod' => 'Head of Department'][$role] ?? ''; @endphp
  <aside>
    <h1>INVENTORY SYSTEM</h1>
    <a class="item {{ request()->is('home') ? 'on' : '' }}" href="/home">Dashboard</a>
    @if ($role == 'hod')<a class="item {{ request()->is('requests') ? 'on' : '' }}" href="/requests">Approve requests</a>@endif
    @if ($role == 'coordinator')<a class="item {{ request()->is('requests') ? 'on' : '' }}" href="/requests">Request equipment</a>@endif
    <a class="item {{ request()->is('equipment') ? 'on' : '' }}" href="/equipment">{{ $role == 'logistic' ? 'Register equipment' : 'Equipment list' }}</a>
    <a class="item {{ request()->is('password') ? 'on' : '' }}" href="/password">Change password</a>
    <div class="user">
      <span class="avatar">{{ strtoupper(substr($role, 0, 1)) }}</span>
      <b>{{ $name }}</b>
      <a href="/logout">Log out</a>
    </div>
  </aside>
  <main>
    <p class="msg">{{ session('msg') }}</p>
    <p class="good">{{ session('ok') }}</p>
    @yield('content')
  </main>
</body>
</html>
