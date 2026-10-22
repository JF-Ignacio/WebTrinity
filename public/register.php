<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign up | WEB-TRINITY</title>
<link rel="stylesheet" href="assets/css/base.css">
</head>

<body>
<div id="nav"></div>
<main class="wrap">
  <form class="box" id="f">
    <h1>Create your account</h1>
    <label>Name<br><input id="name" required></label>
    <label>Email<br><input type="email" required></label>
    <label>Password<br><input type="password" minlength="8" required></label>
    <button class="btn">Sign up</button>
    <p class="muted">Already registered? <a href="login.php">Log in</a></p>
  </form>
</main>


<script src="assets/js/base.js"></script>
<script>
  // PROTOTYPE: no real registration. Stores the name in the browser only.
  document.getElementById('f').onsubmit = function (e) {
    e.preventDefault(); WT.S.user = document.getElementById('name').value.trim(); WT.save(); location.href = 'dashboard.php';
  };
</script>

</body>
</html>
