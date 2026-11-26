<!DOCTYPE html>
<html>
<head><title>Login</title><link rel="stylesheet" href="/style.css"></head>
<body class="login">
  <div class="left">
    <h1>INVENTORY SYSTEM</h1>
    <small>Group 2</small>
    <p><b>Logistic officer</b> registers new equipment as it arrives.</p>
    <p><b>Coordinator</b> checks stock and requests what is missing.</p>
    <p><b>Head of Department</b> approves or rejects each request.</p>
  </div>
  <div class="right">
    <form class="card" method="post" action="/login">
      @csrf
      <h2>Log in</h2>
      <span class="sub">Use the account given to you by the department.</span>
      <p class="msg">{{ session("msg") }}</p><p class="good">{{ session("ok") }}</p>
      <label>Username</label><input name="username" required>
      <label>Password</label><input name="password" type="password" required>
      <button>Log in</button>
    </form>
  </div>
</body>
</html>
