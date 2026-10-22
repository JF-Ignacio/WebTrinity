<?php
$active = $active ?? '';
$base   = $base ?? '';   // '' for pages in public/, '../' for pages in public/admin/

function nav_link(string $key, string $active, string $base, string $file, string $label): string
{
    $cls = $active === $key ? 'text-white fw-semibold' : 'text-white-50';
    $cur = $active === $key ? ' aria-current="page"' : '';
    return '<li class="nav-item"><a class="nav-link ' . $cls . ' hover-text-white" href="'
         . $base . $file . '"' . $cur . '>' . $label . '</a></li>';
}
?>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-trinity sticky-top py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none justify-content-center" href="<?= $base ?>index.php">
            <div class="logo-placeholder">
                <img src="<?= $base ?>assets/img/webtrinityLOGO.png" alt="WEB-TRINITY logo" class="img-fluid">
            </div>
            <div class="d-flex flex-column">
                <span class="fw-bold fs-5 tracking-wide text-white">WEB-<span class="brand-highlight">TRINITY</span></span>
                <small class="text-white-50" style="font-size: 0.65rem; letter-spacing: 0.1em;">HTML • CSS • JS RESEARCH</small>
            </div>
        </a>
        <button class="navbar-toggler border-0 text-white shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-3 mt-3 mt-lg-0">
                <?= nav_link('modules', $active, $base, 'modules.php', 'Modules') ?>
                <?= nav_link('lessons', $active, $base, 'lesson.php', 'Lessons') ?>
                <?= nav_link('dashboard', $active, $base, 'dashboard.php', 'Dashboard') ?>
                <li class="nav-item"><a class="btn btn-outline-trinity btn-sm px-4" href="<?= $base ?>login.php">Sign In</a></li>
                <li class="nav-item"><a class="btn btn-glow btn-sm" href="<?= $base ?>register.php">Get Started</a></li>
            </ul>
        </div>
    </div>
</nav>