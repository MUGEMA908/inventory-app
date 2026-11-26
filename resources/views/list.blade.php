@extends('layout')
@section('content')
<h2>{{ $table == 'equipment' ? 'Equipment list' : 'Requests' }}</h2>

@if ((session('role') == 'logistic' && $table == 'equipment') || (session('role') == 'coordinator' && $table == 'requests'))
<form method="post" action="/{{ $table }}">
  @csrf
  <input name="name" placeholder="Name" required>
  <input name="qty" type="number" placeholder="Qty" required style="width:80px">
  <button>Add</button>
</form>
@endif

<table>
  <tr><th>ID</th><th>Name</th><th>Qty</th>@if($table == 'requests')<th>Status</th><th></th>@endif</tr>
  @foreach ($rows as $x)
  <tr>
    <td>{{ $x->id }}</td><td>{{ $x->name }}</td><td>{{ $x->qty }}</td>
    @if ($table == 'requests')
      <td>{{ $x->status }}</td>
      <td>
        @if (session('role') == 'hod' && $x->status == 'pending')
        <form class="inline" method="post" action="/decide/{{ $x->id }}/approved">@csrf<button class="ok">Approve</button></form>
        <form class="inline" method="post" action="/decide/{{ $x->id }}/rejected">@csrf<button class="no">Reject</button></form>
        @endif
      </td>
    @endif
  </tr>
  @endforeach
</table>

<div class="pages">
@for ($i = 1; $i <= $pages; $i++)
  <a class="{{ $i == $page ? "now" : "" }}" href="/{{ $table }}?page={{ $i }}">Page {{ $i }}</a>
@endfor
</div>
@endsection
