<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modules | WEB-TRINITY</title>
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
  <?php $active = 'modules'; require __DIR__ . '/../app/views/partials/navbar.php'; ?>
  <main class="wrap">
  <h1>Modules</h1>
  <p class="muted">Reference reading for each technology. There are no exercises here; practice happens in the lessons.</p>
  <div class="grid" id="tracks"></div>
</main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/base.js"></script>
  <script>
    var n = { html: 'HTML', css: 'CSS', js: 'JavaScript' };
    document.getElementById('tracks').innerHTML = Object.keys(WT.MODULES).map(function (k) {
      var m = WT.MODULES[k], read = m.topics.filter(function (t) { return WT.S.read[k + '/' + t.id]; }).length;
      return '<div class="card"><span class="tag ' + k + '">' + n[k] + '</span><h3 class="text-primary mt-3">' + m.title + '</h3><p class="muted">' + m.topics.length + ' topics &middot; ' + read + ' read</p><a class="btn" href="module-track.php?track=' + k + '">Open ' + n[k] + '</a></div>';
    }).join('');


</script>
</body>
</html>
