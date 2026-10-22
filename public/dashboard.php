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
</head>
<body class="bg-deep text-light">
    <?php $active = 'dashboard'; require __DIR__ . '/../app/views/partials/navbar.php'; ?>
    <main class="container py-5">
        <div class="row align-items-center mb-4">
            <div class="col-lg-8">
                <h1 id="hi" class="display-5 fw-bold text-white mb-2">Dashboard</h1>
                <p class="text-secondary lead fs-6">Track your lesson progress, examine submission logs, and pick up right where you left off.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <button class="btn btn-outline-trinity btn-sm" id="clear">
                    <i class="fa-solid fa-rotate-right me-2"></i>Reset demo data
                </button>
            </div>
        </div>

        <!-- Progress Overview Card -->
        <div class="card p-4 mb-4 border-secondary border-opacity-25 shadow-sm" style="background-color: var(--card);">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-uppercase small fw-bold text-muted tracking-wider">Overall Course Progress</span>
                <strong id="pct" class="text-info fs-5">0%</strong>
            </div>
            <div class="bar mb-0" role="progressbar" aria-label="Lessons completed">
                <i id="fill"></i>
            </div>
        </div>

        <!-- Quick Stats Grid (Bootstrap Cards) -->
        <div class="row g-3 mb-5" id="stats">
            <!-- Dynamically populated stats cards -->
        </div>

        <!-- Lessons Section -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h4 fw-bold text-white mb-0"><i class="fa-solid fa-book-bookmark text-primary me-2"></i>Your Lessons</h2>
        </div>
        <div class="row g-4 mb-5" id="cards">
            <!-- Dynamically populated lesson cards -->
        </div>

        <!-- Recent Attempts Log Section -->
        <div class="card p-4 border-secondary border-opacity-25 shadow-sm" style="background-color: var(--card);">
            <h2 class="h5 fw-bold text-white mb-3"><i class="fa-solid fa-clock-rotate-left text-info me-2"></i>Recent Attempts</h2>
            <div id="log" class="text-secondary">
                <p class="muted mb-0">No attempts yet. Start Lesson 1 to see your history here.</p>
            </div>
        </div>

    </main>
    <footer class="py-4 text-center text-muted border-top border-secondary border-opacity-25 mt-5" style="background-color: rgba(11, 19, 43, 0.9);">
        <div class="container small">
            &copy; 2026 <b>WEB-TRINITY</b> Research Prototype. All rights reserved.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/base.js"></script>

    <script>
        // Dashboard dynamic rendering script leveraging WT framework state
        var L = WT.states(), 
            done = L.filter(function (l) { return l.state === 'completed'; }).length;
        var attempts = WT.S.log.length, 
            reads = Object.keys(WT.S.read).length, 
            pct = Math.round(done / L.length * 100);

        // Header greeting
        document.getElementById('hi').textContent = WT.S.user ? 'Welcome back, ' + WT.S.user : 'Dashboard';
        
        // Progress bar and percentage
        document.getElementById('pct').textContent = done + ' of ' + L.length + ' lessons completed (' + pct + '%)';
        document.getElementById('fill').style.width = pct + '%';

        // Stats blocks utilizing Bootstrap col-md-4 cards
        document.getElementById('stats').innerHTML = [
            [done, 'Lessons completed', 'fa-circle-check text-success'], 
            [attempts, 'Attempts submitted', 'fa-code-pull-request text-info'], 
            [reads, 'Module topics read', 'fa-book-open text-warning']
        ].map(function (s) { 
            return '<div class="col-md-4">' +
                     '<div class="card p-3 border-secondary border-opacity-25 h-100" style="background-color: var(--card);">' +
                       '<div class="d-flex align-items-center gap-3">' +
                         '<div class="fs-2"><i class="fa-solid ' + s[2] + '"></i></div>' +
                         '<div>' +
                           '<b class="fs-3 text-white d-block lh-1 mb-1">' + s[0] + '</b>' +
                           '<span class="text-secondary small">' + s[1] + '</span>' +
                         '</div>' +
                       '</div>' +
                     '</div>' +
                   '</div>'; 
        }).join('');

        // Lessons Grid using Bootstrap cards with responsive breakpoints
        document.getElementById('cards').innerHTML = L.map(function (l) {
            var go = l.state === 'locked' ? '' : '<a class="btn btn-glow btn-sm mt-3 w-100" href="lesson-code.php?id=' + l.id + '">' + ({ completed: 'Review Lesson', in_progress: 'Continue Lesson', available: 'Start Lesson' })[l.state] + '</a>';
            var stateBadgeClass = { completed: 'completed', in_progress: 'in_progress', locked: 'locked' }[l.state];
            
            return '<div class="col-md-4 col-sm-6">' +
                     '<div class="card h-100 p-4 border-secondary border-opacity-25 d-flex flex-column justify-content-between ' + (l.state === 'locked' ? 'lock opacity-75' : '') + '" style="background-color: var(--card);">' +
                       '<div>' +
                         '<div class="d-flex justify-content-between align-items-center mb-3">' +
                           '<span class="badge-status ' + stateBadgeClass + '">' + WT.LABEL[l.state] + '</span>' +
                           '<small class="text-muted font-monospace">#0' + l.id + '</small>' +
                         '</div>' +
                         '<h3 class="h5 text-white fw-bold mb-2">Lesson ' + l.id + ': ' + l.title + '</h3>' +
                         '<p class="text-secondary small mb-3">' + (l.state === 'completed' ? 'Completed on ' + l.p.completedAt : l.state === 'locked' ? 'Complete the previous lesson to unlock.' : (l.p.attempts || 0) + ' attempt(s) recorded.') + '</p>' +
                       '</div>' +
                       '<div>' + go + '</div>' +
                     '</div>' +
                   '</div>';
        }).join('');

        // Recent attempts feedback log list
        document.getElementById('log').innerHTML = attempts ? '<ul class="list-unstyled mb-0">' + WT.S.log.slice(0, 6).map(function (a) {
            var statusIcon = a.passed ? '<i class="fa-solid fa-circle-check text-success me-1"></i>' : '<i class="fa-solid fa-circle-xmark text-danger me-1"></i>';
            return '<li class="py-2 border-bottom border-secondary border-opacity-10 d-flex justify-content-between align-items-center small">' +
                     '<div><span class="fw-bold text-white me-2">Lesson ' + a.lesson + '</span> — ' + a.score + ' checks passed ' + statusIcon + '</div>' +
                     '<span class="text-muted font-monospace" style="font-size: 0.75rem;">' + a.at + '</span>' +
                   '</li>';
        }).join('') + '</ul>' : '<p class="text-secondary small mb-0"><i class="fa-solid fa-circle-info me-1"></i>No attempts yet. Start Lesson 1 to see your history here.</p>';

        // Reset demo data trigger
        document.getElementById('clear').onclick = function () { 
            if (confirm('Clear all demo progress?')) { 
                localStorage.removeItem('wt-proto-v1'); 
                location.reload(); 
            } 
        };
    </script>
</body>
</html>
