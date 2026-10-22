

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lessons | WEB-TRINITY</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/base.css">
</head>
<body>
<?php $active = 'lessons'; require __DIR__ . '/../app/views/partials/navbar.php'; ?>
<main class="wrap py-4">
  <h1>Lessons</h1>
  <p class="muted">Finish each lesson to unlock the next one.</p>
  <div class="grid" id="map">

  </div>
</main>
<script src="assets/js/base.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('map').innerHTML = WT.states().map(function (l) {
    var go = l.state === 'locked' ? '<button class="btn" disabled>Locked</button>'
      : '<a class="btn" href="lesson-code.php?id=' + l.id + '">' + ({ completed: 'Review', in_progress: 'Continue', available: 'Start' })[l.state] + '</a>';
    return '<div class="card' + (l.state === 'locked' ? ' lock' : '') + '"><span class="badge ' + l.state + '">' + WT.LABEL[l.state] + '</span><h3 class="text-white">Lesson ' + l.id + ': ' + l.title + '</h3><p class="muted">' + l.concept + '</p>' + go + '</div>';
  }).join('');
</script>
</body>
</html>
