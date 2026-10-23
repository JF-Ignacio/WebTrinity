<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lesson | WEB-TRINITY</title>
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
  <?php $active = 'lessons'; require __DIR__ . '/../app/views/partials/navbar.php'; ?>
  <main class="wrap py-4" id="app">
    <p><a href="lesson.php">&larr; All lessons</a></p>
    <h1 id="title"></h1>
    
    <div class="card text-white ">
      <p id="concept" class="text-white"></p>
      <strong >You will:</strong><ul id="objectives"></ul>
      <p>Need a refresher? <span id="related"></span> <span class="muted">(open the modules while you work)</span></p>
    </div>
    <div class="split" style="margin-top:1rem">
      <div>
        <div class="tabs" role="tablist"><button class="on" data-t="html">HTML</button><button data-t="css">CSS</button><button data-t="js">JS</button></div>
        <textarea id="code" class="code" spellcheck="false" aria-label="Code editor"></textarea>
        <div class="actions">
          <button class="btn alt" id="run">Run preview</button>
          <button class="btn" id="submit">Submit answer</button>
          <button class="btn alt" id="hint">Get a hint</button>
          <button class="btn alt" id="reset">Reset code</button>
          <span class="muted" id="saved"></span>
        </div>
        <div id="hints"></div>
      </div>
      <div><strong>Live preview</strong><iframe id="preview" sandbox="allow-scripts" title="Live preview"></iframe></div>
    </div>
    <section class="fb" id="feedback" aria-live="polite"><p class="muted">Feedback appears here after you submit.</p></section>
  </main>

  <script src="assets/js/base.js"></script>
  <script src="assets/js/lesson-code.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
