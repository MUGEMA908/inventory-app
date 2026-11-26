@extends('layout')
@section('content')
<h2>Dashboard</h2>
<p class="sub">Welcome back, {{ ['logistic' => 'Logistic Officer', 'coordinator' => 'Coordinator', 'hod' => 'Head of Department'][session('role')] }}.</p>
<div class="stats">
  @if (session('role') == 'logistic')
  <div class="stat"><b>{{ $units }}</b>Total equipment units</div>
  @else
  <div class="stat"><b>{{ $pending }}</b>Pending requests</div>
  <div class="stat green"><b>{{ $approved }}</b>Approved</div>
  <div class="stat yellow"><b>{{ $rejected }}</b>Rejected</div>
  @endif
</div>
@endsection
