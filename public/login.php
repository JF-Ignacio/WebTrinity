<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log in | WEB-TRINITY</title>
<link rel="stylesheet" href="assets/css/base.css">
</head>
<body>
<div id="nav"></div>
<main class="wrap">
  <form class="box" id="f">
    <h1>Log in</h1>
    <label>Email<br><input type="email" id="email" required></label>
    <label>Password<br><input type="password" required></label>
    <button class="btn">Log in</button>
    <p class="muted">New here? <a href="register.php">Create an account</a></p>
  </form>
</main>
<script src="assets/js/base.js"></script>
<script>
  // PROTOTYPE: no real authentication. Uses the part of the email before @ as the name.
  document.getElementById('f').onsubmit = function (e) {
    e.preventDefault(); WT.S.user = document.getElementById('email').value.split('@')[0]; WT.save(); location.href = 'dashboard.php';
  };
</script>
</body>
</html>
