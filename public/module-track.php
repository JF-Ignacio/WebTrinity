<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Module | WEB-TRINITY</title>
<link rel="stylesheet" href="assets/css/base.css">
</head>
<body>
<div id="nav"></div>
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
