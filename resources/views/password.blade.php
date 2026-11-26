@extends('layout')
@section('content')
<h2>Change password</h2>
<form method="post" action="/password">
  @csrf
  <input name="old" type="password" placeholder="Old password" required><br>
  <input name="new" type="password" minlength="8" placeholder="New password" required><br>
  <input name="confirm" type="password" minlength="8" placeholder="Confirm new password" required><br>
  <button>Change</button>
</form>
@endsection
