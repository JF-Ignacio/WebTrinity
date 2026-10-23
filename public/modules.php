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
    var names = {
    html: 'HTML',
    css: 'CSS',
    js: 'JavaScript'
  };

  var tracks = document.getElementById('tracks');

  tracks.innerHTML = Object.keys(WT.MODULES).map(function (key) {
    var module = WT.MODULES[key];
    var readCount = module.topics.filter(function (topic) {
      return WT.S.read[key + '/' + topic.id];
    }).length;
    var previewId = 'preview-' + key;

    var topics = module.topics.map(function (topic) {
      var isRead = WT.S.read[key + '/' + topic.id];

      return `
        <li class="module-topic${isRead ? ' is-read' : ''}">
          <span>${isRead ? '&#10003;' : '&#9675;'}</span>
          <span>${WT.esc(topic.title)}</span>
          <span class="topic-status">${isRead ? 'Read' : 'Not read'}</span>
        </li>
      `;
    }).join('');

    return `
      <article class="card module-card">
        <span class="tag ${key}">${names[key]}</span>
        <h2 class="text-primary mt-3">${WT.esc(module.title)}</h2>
        <p class="muted">${module.topics.length} topics &middot; ${readCount} read</p>

        <button
          class="btn preview-toggle"
          type="button"
          aria-expanded="false"
          aria-controls="${previewId}">
          <span class="preview-label">Preview topics</span>
          <span class="preview-chevron" aria-hidden="true">&#8964;</span>
        </button>

        <div class="module-preview" id="${previewId}">
          <h3>Topics in this module</h3>
          <ul class="module-topic-list">${topics}</ul>
        </div>

        <a class="btn module-open" href="module-track.php?track=${key}">
          Open ${names[key]}
        </a>
      </article>
    `;
  }).join('');

  tracks.addEventListener('click', function (event) {
    var button = event.target.closest('.preview-toggle');
    if (!button) return;

    var preview = document.getElementById(button.getAttribute('aria-controls'));
    var isExpanded = button.getAttribute('aria-expanded') === 'true';

    button.setAttribute('aria-expanded', String(!isExpanded));
    button.querySelector('.preview-label').textContent = isExpanded ? 'Preview topics' : 'Hide topics';
    preview.classList.toggle('is-open', !isExpanded);
  });

</script>
</body>
</html>
