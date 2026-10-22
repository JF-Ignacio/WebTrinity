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
    <?php $active = 'home'; require __DIR__ . '/../app/views/partials/navbar.php'; ?>
    <!-- Main Content Wrapper -->
    <main class="container my-5">
        <!-- Hero Section -->
        <section class="hero-section row align-items-center g-5 py-4 rounded-4 mb-4">
            <div class="col-lg-7">
                <span class="badge bg-primary bg-opacity-25 text-info mb-3 px-3 py-2 rounded-pill fw-semibold border border-info border-opacity-25">
                    <i class="fa-solid fa-cube me-2"></i>Interactive Prototype Environment
                </span>
                <h1 class="hero-title display-4 fw-bold mb-4">
                    Learn how HTML, CSS and JavaScript work as <span class="brand-highlight">one ecosystem</span>.
                </h1>
                <p class="lead text-secondary mb-4">
                    Read each technology on its own, then fix real code where all three meet. Every answer comes with targeted feedback that explains why it failed.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-glow" href="register.php">
                        <i class="fa-solid fa-rocket me-2"></i>Create a free account
                    </a>
                    <a class="btn btn-outline-trinity" href="modules.php">
                        <i class="fa-solid fa-book-open me-2"></i>Browse the modules
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="trinity-stack">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-uppercase small fw-bold text-muted tracking-wider">The Trinity Layers</span>
                        <span class="badge-status completed" style="color: var(--neon-emerald)">Live Integration</span>
                    </div>
                    <div class="layer-box layer-html">
                        <div class="fw-bold mb-1"><i class="fa-brands fa-html5 me-2"></i>HTML: Structure</div>
                        &lt;button id="btn"&gt;Click me&lt;/button&gt;
                    </div>
                    <div class="layer-box layer-css">
                        <div class="fw-bold mb-1"><i class="fa-brands fa-css3-alt me-2"></i>CSS: Appearance</div>
                        #btn { background: royalblue; color: white; }
                    </div>
                    <div class="layer-box layer-js">
                        <div class="fw-bold mb-1"><i class="fa-brands fa-js me-2"></i>JavaScript: Behavior</div>
                        btn.addEventListener('click', () =&gt; alert('Triggered!'));
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive Live Demo Playground Section -->
        <section class="row my-5 py-4 playground-card p-4 mx-1">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold text-white">Live Trinity Preview Playground</h3>
                <p class="text-secondary small">Toggle the layers below to experience how HTML, CSS, and JS combine dynamically.</p>
            </div>
            
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center p-4 bg-dark bg-opacity-50 rounded border border-secondary border-opacity-25">
                <div class="mb-3 text-muted small fw-bold">LIVE RENDERED OUTPUT:</div>
                <div id="sandbox-container" class="p-4 rounded d-flex align-items-center justify-content-center min-vh-25 w-100">
                    <div id="dynamic-demo-btn" class="px-4 py-2 rounded shadow transition-all" style="cursor: pointer; font-weight: 600;">
                        Click Me!
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-center gap-3">
                <div class="form-check form-switch p-3 bg-secondary bg-opacity-10 rounded border border-secondary border-opacity-25">
                    <input class="form-check-input" type="checkbox" id="toggleHtml" checked disabled>
                    <label class="form-check-label text-white fw-semibold" for="toggleHtml">
                        <i class="fa-brands fa-html5 text-danger me-2"></i>HTML Structure (Base Element)
                    </label>
                </div>
                <div class="form-check form-switch p-3 bg-secondary bg-opacity-10 rounded border border-secondary border-opacity-25">
                    <input class="form-check-input" type="checkbox" id="toggleCss" checked onchange="updatePlayground()">
                    <label class="form-check-label text-white fw-semibold" for="toggleCss">
                        <i class="fa-brands fa-css3-alt text-primary me-2"></i>CSS Styling (Appearance & Hover effects)
                    </label>
                </div>
                <div class="form-check form-switch p-3 bg-secondary bg-opacity-10 rounded border border-secondary border-opacity-25">
                    <input class="form-check-input" type="checkbox" id="toggleJs" checked onchange="updatePlayground()">
                    <label class="form-check-label text-white fw-semibold" for="toggleJs">
                        <i class="fa-brands fa-js text-warning me-2"></i>JavaScript Behavior (Interactive Action)
                    </label>
                </div>
                <div id="playground-feedback" class="text-info small mt-2">
                    <i class="fa-solid fa-circle-info me-1"></i> All 3 layers active: Button is styled and fully interactive!
                </div>
            </div>
        </section>

        <section class="grid my-4">
            <div class="feature-card p-4">
                <div class="card-number">1</div>
                <h3 class="h5 fw-bold text-white mb-2">Read the concepts</h3>
                <p class="muted small mb-0">Short HTML, CSS and JavaScript modules. Reading only, no exercises. Open them any time, even mid-lesson.</p>
            </div>
            <div class="feature-card p-4">
                <div class="card-number">2</div>
                <h3 class="h5 fw-bold text-white mb-2">Fix the code</h3>
                <p class="muted small mb-0">Each lesson gives you code with something missing or wrong across the three integrated layers.</p>
            </div>
            <div class="feature-card p-4">
                <div class="card-number">3</div>
                <h3 class="h5 fw-bold text-white mb-2">Learn from feedback</h3>
                <p class="muted small mb-0">See which layer failed and why, with intelligent hints that nudge before they reveal the answer.</p>
            </div>
            <div class="feature-card p-4">
                <div class="card-number">4</div>
                <h3 class="h5 fw-bold text-white mb-2">Keep your progress</h3>
                <p class="muted small mb-0">Your work is securely saved. Finish a lesson module to unlock the next challenge automatically.</p>
            </div>
        </section>

        <section class="authors" id="authors"> 

        </section>
    </main>
    <footer class="py-4 text-center text-muted border-top border-secondary border-opacity-25 mt-5" style="background-color: rgba(11, 19, 43, 0.9);">
        <div class="container small">
            &copy; 2026 <b>WEB-TRINITY</b> Research Prototype. All rights reserved. Built with Bootstrap 5 & Custom Dark Tech Theme.
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/index.js"></script>
</body>
</html>
