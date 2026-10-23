<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WEB-TRINITY | Learn HTML, CSS & JavaScript Together</title>
  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome for Tech Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts: Inter & Fira Code -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
  <!-- Custom Base CSS -->
  <link rel="stylesheet" href="assets/css/base.css">
  <link rel="icon" href="assets/img/webtrinityLOGO.png">
</head>

<body>
    <?php 
      $active = 'register'; require __DIR__ . '/../app/views/partials/navbar.php'; 
    
    ?>
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
