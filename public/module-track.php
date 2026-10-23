<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | WEB-TRINITY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="icon" href="assets/img/webtrinityLOGO.png">
</head>
<body>
  <div>
    <?php 
      require_once __DIR__ . "./.././app/views/partials/navbar.php"; ?>
  </div>
  <main class="wrap">
    <p><a href="modules.php">&larr; All modules</a></p>
    <div class="side">
      <nav id="topics" aria-label="Topics"></nav>
      <article class="card"><h1 id="t"></h1><div id="body"></div><p class="muted" id="read"></p></article>
    </div>
  </main>

  <script src="assets/js/base.js"></script>
  <script>
    var q = new URLSearchParams(location.search), track = WT.MODULES[q.get('track')] ? q.get('track') : 'html', m = WT.MODULES[track];
    var topic = m.topics.filter(function (t) { return t.id === q.get('topic'); })[0] || m.topics[0];
    document.getElementById('topics').innerHTML = '<strong>' + m.title + '</strong>' + m.topics.map(function (t) {
      return '<a href="?track=' + track + '&topic=' + t.id + '"' + (t === topic ? ' class="on"' : '') + '>' + (WT.S.read[track + '/' + t.id] ? '&#10003; ' : '') + t.title + '</a>';
    }).join('');
    document.getElementById('t').textContent = topic.title;
    document.getElementById('body').innerHTML = topic.body;   // trusted prototype content
    WT.S.read[track + '/' + topic.id] = true; WT.save();
    document.getElementById('read').innerHTML = 'Marked as read. Ready to practice? <a href="lesson.php">Go to the lessons</a>.';
  </script>
</body>
</html>
