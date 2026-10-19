# WEB-TRINITY Roadmap

> Shared source of truth for the team. Update the checkboxes as work lands on `main`.
> If this file and a chat message disagree, this file wins. Change it in a commit so everyone sees the change.

---

## 1. What we are building

**WEB-TRINITY** helps second-year Computer Programming students move from knowing HTML, CSS, and JavaScript *separately* to making them work *together*.

The student experience is fixed. Do not add features that break it:

| # | Part | Rule |
|---|---|---|
| 1 | **Modules** | Reference pages split into HTML, CSS, JavaScript. Always accessible. **No coding exercises inside modules.** |
| 2 | **Lessons** | The actual practice. Starter code has something missing or wrong in HTML, CSS, or JS. The student adds or corrects it so the three work together (Lesson 1: build a button). |
| 3 | **Feedback** | After a submission, show **why** each error happens, not just "wrong". |
| 4 | **Saved progress** | Students can leave and return. They **cannot open Lesson N+1 until Lesson N is completed.** |

**Prototype goal (14 days):** two fully working lessons, login, dashboard, module pages, live preview, feedback, server-enforced lock, and a read-only teacher view.

---

## 2. Architecture decisions (agreed, do not re-argue mid-sprint)

1. **The server is the authority.** The browser may *show* a lesson as locked or passed, but PHP decides. Locked lessons are refused by `LessonGate` on every page and API call.
2. **"Locked" is never stored.** `progress` only holds `in_progress` or `completed`. `LessonGate` derives locked/available every time, so data can never get out of sync.
3. **No unlock endpoint.** Unlocking is a *result* of a validated, saved completion inside `submit-attempt.php`.
4. **Drafts and completions are separate.** `save-draft.php` saves unfinished code. Only `submit-attempt.php` can mark a lesson completed.
5. **Lesson content is private.** `content/` is never served. The browser receives starter code, instructions, and the checks it needs for instant feedback. It **never** receives `solution.json` or server-only rules.
6. **Student code runs in a sandboxed iframe** (`sandbox="allow-scripts"`, no `allow-same-origin`), so it cannot touch our session, cookies, or pages.
7. **Editor = CodeMirror 6**, built once into a single committed bundle. `editor.js` is the only file that knows about CodeMirror (it falls back to a `<textarea>` if the bundle fails to load).
8. **All URLs go through `url()` / `asset()`.** Never hardcode `/css/...` or `/web-trinity/...`. See section 3.2.
9. **Prepared statements only. Escape all output with `e()`. CSRF token on every POST.**

---

## 3. Team working agreement

### 3.1 Git on a shared `main`

We all push to `main`. That works only if everyone follows these rules:

1. **One-time:** `git config pull.rebase true`
2. **Start of work and before every push:** `git pull --rebase`
3. **Small commits, pushed often** (at least after each finished task). Big, rare pushes cause conflicts.
4. **Never `git push --force`.** Never rewrite shared history.
5. **Do not push a broken `main`.** Before pushing, run a 1-minute smoke test: `_check.php` passes, you can log in, the page you touched loads.
6. **Commit message format:** `area: what changed`. Examples: `auth: add register form validation`, `db: add hints_used column`, `lesson: write checks for lesson 1`.
7. **Own your files.** Each folder has an owner (section 3.3). Do not reformat or "clean up" files you do not own. If you need a change in someone else's file, message them or make a tiny, focused commit and tell them.
8. **Conflict while rebasing?** Stop. Do not guess. `git rebase --abort`, then talk to the owner of that file.
9. **Never commit:** `app/config/local.php`, `node_modules/`, passwords, `storage/logs/*`.

### 3.2 Local setup and BASE_URL

Every teammate has their **own** `app/config/local.php` (git-ignored, copied from `local.example.php`). This is where machine-specific things live: DB credentials and `base_url`.

```php
// XAMPP project inside htdocs:
'base_url' => '/web-trinity/public',

// Virtual host whose DocumentRoot is /public:
'base_url' => '',
```

Rules for everyone:

```php
<link rel="stylesheet" href="<?= e(asset('css/base.css')) ?>">   // assets
<a href="<?= e(url('lessons.php')) ?>">Lessons</a>               // pages
redirect('login.php');                                          // redirects (PHP)
```

For JavaScript, print the values once in the page layout (`header.php`) and read them in JS:

```php
<meta name="csrf-token" content="<?= e(Csrf::token()) ?>">
<script>window.WT = { baseUrl: <?= json_encode(BASE_URL) ?> };</script>
```

```js
fetch(`${WT.baseUrl}/api/save-draft.php`, { method: 'POST', headers: { 'X-CSRF-Token': document.querySelector('meta[name=csrf-token]').content, 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
```

### 3.3 Workstreams and ownership

Fill in names on Day 1. One person can hold more than one lane, but every folder needs exactly one owner.

| Lane | Owner | Owns | Focus |
|---|---|---|---|
| **A. Backend** | ______ | `app/`, `public/api/`, `database/` | Auth, DB, `LessonGate`, attempts, security |
| **B. Frontend** | ______ | `public/assets/`, `app/views/`, `tools/codemirror/` | Layout, editor, preview, checker, feedback UI |
| **C. Content & QA** | ______ | `content/`, `docs/`, test checklist | Modules, lessons, checks, hints, testing, demo script |
| **Pages** (shared) | A + B | `public/*.php`, `public/admin/` | A writes logic at the top, B writes the HTML below it |

### 3.4 Database changes

- Structure changes go in `database/migrations/NNN_short_name.sql` (for example `001_add_hints_used.sql`) **and** are merged into `schema.sql` in the **same commit**.
- Announce it in the team chat: "pull, then run migration 001".
- Never edit tables by hand in phpMyAdmin without writing the SQL into the repo.

### 3.5 Daily rhythm

- **10-minute stand-up** (start of day): what I finished, what I do today, what blocks me.
- **End of day:** everything pushed to `main`, this roadmap's checkboxes updated, tomorrow's first task known.
- **Blocked more than 30 minutes? Say so.** The 14 days have no slack for silent blocking.

### 3.6 Definition of done (for any task)

- Works on a clean clone (follows README setup).
- No hardcoded URLs or credentials.
- User/DB output escaped; queries prepared; POST forms/endpoints CSRF-checked.
- Pushed to `main` and the checkbox ticked.

---

## 4. Database overview

Full SQL: `database/schema.sql`. Seed data: `database/seed.sql` + `php database/seed_users.php`.

| Table | Purpose | Key columns |
|---|---|---|
| `users` | Students and teachers | `email` (unique), `password_hash`, `role` (`student`/`teacher`), `last_login_at` |
| `lessons` | Ordered curriculum metadata | `slug` (= folder in `content/lessons/`), `order_no` (unique, drives the lock), `is_active` |
| `progress` | One row per student per lesson | `status` (`in_progress`/`completed`), `draft_html/css/js`, `hints_used`, `completed_at`. Unique on (`user_id`,`lesson_id`) |
| `attempts` | Every submission, pass or fail (research data) | code, `passed`, `checks_passed/total`, `failed_checks` (JSON ids), `created_at` |
| `module_views` | Which reference topics a student read | (`user_id`,`track`,`topic_slug`) |

**The lock rule (implemented in `app/services/LessonGate.php`):** lesson N is accessible only if every active lesson with a lower `order_no` has `progress.status = 'completed'` for that student.

---

## 5. Roadmap at a glance

| Phase | Days | Goal | Deliverable |
|---|---|---|---|
| 0 | 1 | Team setup | Everyone runs the same project locally |
| 1 | 2 | Platform foundation | Layout, shared components, DB-driven page |
| 2 | 3-4 | Accounts and dashboard | Login works; dashboard shows real lesson states |
| 3 | 5-6 | Learning content | Modules readable; lesson pages open; locked lessons blocked |
| 4 | 7-8 | Workspace | CodeMirror + live preview + instant checker + feedback |
| 5 | 9-10 | Assessment and gating | Server-verified completion, drafts, unlocking |
| 6 | 11-12 | Lesson 2, security, teacher view | Full 2-lesson path; teacher sees real progress |
| 7 | 13-14 | Testing and demo | Stable, demonstrable prototype |

**If we fall behind, cut in this order (top first):**
1. Teacher reports beyond the read-only table
2. Extra modules/topics beyond 2-3 per track
3. Lesson 3 or any lesson beyond two
4. Depth of server-side checking (keep essentials, document the limitation)

**Never cut:** editor, live preview, feedback that explains why, saved progress, server-enforced lock, testing.

---

## 6. Phase details

Each phase lists **why** it exists, **tasks by lane**, a **deliverable**, a **"done when"** test, and **watch-outs**.

### Phase 0: Team setup (Day 1)

**Why:** Most early time loss comes from "works on my machine". Fix that before writing features.

- [ ] **All:** Clone the repo, run `git config pull.rebase true`, follow README setup steps 1-6.
- [ ] **All:** `_check.php` shows all PASS on **every** teammate's machine.
- [ ] **All:** Confirm `http://localhost/web-trinity/content/` returns **403** (private folders protected).
- [ ] **A:** Create the MySQL user (`webtrinity_user`), import `schema.sql` + `seed.sql`, run `seed_users.php`.
- [ ] **A:** Decide: project in `htdocs` (default) or virtual host. Everyone uses the same approach, each with their own `local.php`.
- [ ] **B:** Confirm `codemirror-bundle.js` loads in a test page (`WebTrinityCM` is defined in the browser console).
- [ ] **C:** Fill names in section 3.3; create `docs/requirements.md` (copy section 1 of this file as the start).
- [ ] **C:** Draft Lesson 1 content on paper: concept, objectives, the broken starter code, what a correct answer looks like.

**Deliverable:** same project runs on every machine.
**Done when:** each teammate can log a PASS screenshot of `_check.php`.
**Watch out for:** teammates editing `config.php` instead of `local.php`; line-ending noise (fixed by `.gitattributes`); XAMPP MySQL port conflicts.

---

### Phase 1: Platform foundation (Day 2)

**Why:** A shared layout and CSS system means the pages built in later days look consistent, and nobody rebuilds navbars.

- [ ] **B:** `app/views/partials/header.php`, `footer.php`, `navbar.php` (logged-out vs student vs teacher menus). Header prints the CSRF meta tag and `window.WT.baseUrl`.
- [ ] **B:** `public/assets/css/base.css` (CSS variables, reset, typography), `layout.css`, `components.css` (buttons, cards, badges for `locked / available / in_progress / completed`).
- [ ] **A:** `public/index.php` redirects to `dashboard.php` if logged in, otherwise `login.php`.
- [ ] **A:** Model skeletons: `models/User.php`, `Lesson.php`, `Progress.php`, `Attempt.php` (static methods using `Database::one/all/run`).
- [ ] **C:** `docs/database-design.md` summarizing section 4; `docs/api-design.md` copying the contracts from Appendix B.

**Deliverable:** a styled page that lists lessons from the database.
**Done when:** `_check.php` still passes and a test page using the header/footer shows the two seeded lessons.
**Watch out for:** page-specific CSS leaking into `base.css`; hardcoded asset paths.

---

### Phase 2: Accounts and dashboard (Days 3-4)

**Why:** Everything after this (progress, locking, teacher view) needs to know *who* the user is.

**Day 3, authentication**
- [ ] **A:** `register.php`: validate name/email/password (min length), reject duplicate email, `password_hash()`, CSRF check, show errors.
- [ ] **A:** `login.php`: `Auth::attempt()`, **one generic error** for wrong email or wrong password, CSRF check.
- [ ] **A:** `logout.php`: POST + CSRF, then `Auth::logout()`.
- [ ] **B:** Login and register page markup and styling (`app/views/` or inline below the PHP block).
- [ ] **C:** Test cases written for auth (valid, wrong password, duplicate email, empty fields, logged-out access to `dashboard.php`).

**Day 4, dashboard**
- [ ] **A:** `dashboard.php` uses `LessonGate::statesFor()` to get lesson states.
- [ ] **B:** Lesson cards showing state badges, a Start/Continue/Review button (disabled for locked), and an overall progress bar. `dashboard.css`.
- [ ] **A:** `lessons.php` ordered lesson map using the same states.
- [ ] **C:** Manually change `progress` in phpMyAdmin and confirm cards update correctly.

**Deliverable:** students register, log in, and see real states from the DB.
**Done when:** a new student sees Lesson 1 *Available* and Lesson 2 *Locked*; logging out and visiting `dashboard.php` redirects to login.
**Watch out for:** revealing whether an email exists in login errors; forgetting `session_regenerate_id` (already handled in `Auth::attempt`).

---

### Phase 3: Learning content (Days 5-6)

**Why:** The platform needs real teaching material and the lesson pages that will host the editor.

**Day 5, modules (reading only)**
- [ ] **C:** Write 2-3 topics per track in `content/modules/{html,css,js}/` (Markdown or HTML fragments). Examples to read; **no exercises**.
- [ ] **A:** `modules.php` (three tracks, topic lists) and `module.php?track=html&topic=buttons`.
- [ ] **A:** **Whitelist** `track` (`html|css|js`) and `topic` (match against files that exist). Never build a path from raw input.
- [ ] **A:** Record a row in `module_views` when a topic is opened (`INSERT ... ON DUPLICATE KEY UPDATE last_viewed_at = NOW()`).
- [ ] **B:** Module page styling; a persistent "Modules" link available from the lesson page (students use modules while answering lessons).

**Day 6, lesson content and lesson page shell**
- [ ] **C:** For Lessons 1 and 2, create the full folder: `lesson.json`, `starter.html/css/js`, `solution.json`, `checks.json`, `hints.json` (formats in Appendix A).
- [ ] **A:** `lesson.php?id=1`: require login, call `LessonGate::canAccess()`. If denied, respond **403** with a friendly "Complete Lesson N first" page. If allowed, create the `progress` row (`in_progress`) on first open.
- [ ] **A:** `api/get-lesson.php` (contract in Appendix B) returns **only** the safe fields.
- [ ] **B:** Lesson page layout: instructions + objectives panel, editor area placeholder, preview placeholder, feedback panel placeholder.

**Deliverable:** students can read modules; Lesson 1 opens; Lesson 2 is blocked at the URL level.
**Done when:** typing `lesson.php?id=2` as a fresh student returns 403, and `get-lesson.php?id=1` never contains the word "solution" or any server-only rule.
**Watch out for:** path traversal in `module.php`; lesson content taking longer than coding. **C should start Lesson 1 content in Phase 0.**

---

### Phase 4: Workspace (Days 7-8)

**Why:** This is the core experience and the heart of the research prototype.

**Day 7, editor and live preview**
- [ ] **B:** Three tabs (HTML | CSS | JS). Each tab hosts a `WTEditor.create(...)` instance loaded with the starter code (or saved draft, once Phase 5 lands).
- [ ] **B:** `preview.js`: assemble one document from the three editors and set `iframe.srcdoc`. Iframe uses `sandbox="allow-scripts"` **only**.
- [ ] **B:** Run button (and optional debounced auto-run); **Reset to starter code** button with a confirm dialog.
- [ ] **B:** `lesson.css`: split layout (editor left, preview right), responsive stacking on small screens.
- [ ] **C:** Break it on purpose: JS syntax errors, infinite loop (`while(true){}`), huge code, `<script>` tags in HTML. Report findings.

**Day 8, instant checker and feedback**
- [ ] **B:** `checker.js`: runs *behavior* checks inside the preview and sends results back using `postMessage`. Check types in Appendix A.
- [ ] **B:** `feedback.js`: result panel listing each failed check with its **layer tag** (`HTML`, `CSS`, `JS`) and its **why** message; passed checks shown in green; progressive **Hint** button (hint 1 vague, hint 2 specific).
- [ ] **C:** Finalize `checks.json` and `hints.json` for Lesson 1 and test with a wrong, a half-right, and a correct answer.
- [ ] **A:** Support B with `get-lesson.php` (add `client_checks`, `hints_count`) and a hint counter endpoint if needed (`progress.hints_used`).

**Deliverable:** edit code, see a live preview, get specific feedback.
**Done when:** wrong Lesson 1 code produces explanations that name the broken layer; correct code shows all checks green; Reset works; a JS error in student code does not break the page around the iframe.
**Watch out for:** letting student code run on the parent page (never); checks that only pass for one exact spelling of the solution (test behavior, not exact text); an infinite loop freezing the tab (see Day 13 note).

---

### Phase 5: Assessment and gating (Days 9-10)

**Why:** This phase turns the prototype from a demo page into a system that *enforces* learning order. It is the most important backend work.

**Day 9, server-side attempts**
- [ ] **A:** `api/submit-attempt.php` (contract in Appendix B): require login (JSON 401), CSRF header, `LessonGate::canAccess()` (403 if locked), validate sizes with `max_code_length`.
- [ ] **A:** `services/AnswerChecker.php`: evaluates the **server-scope** checks from `checks.json` (HTML via `DOMDocument`/`DOMXPath`, CSS and JS via simple pattern checks). Behavior checks reported by the browser are accepted as *supporting* results only.
- [ ] **A:** `models/Attempt.php`: save every attempt (code, pass/fail, failed check ids).
- [ ] **A:** `services/FeedbackBuilder.php`: converts failed check ids to `{id, layer, why}` using the private rules.
- [ ] **B:** Add a **Submit** button next to Run; wire it to `submit-attempt.php`; render the server's feedback with the same `feedback.js` panel.

**Day 10, progress, drafts, unlocking**
- [ ] **A:** On pass: inside one DB **transaction**, mark `progress.status = 'completed'`, set `completed_at`, and insert the attempt. Return `next_lesson_unlocked` using `LessonGate::nextLesson()`.
- [ ] **A:** `api/save-draft.php`: autosave html/css/js for lessons the student can access. **It must never mark anything completed.**
- [ ] **B:** `progress.js`: debounced autosave (every few seconds and on tab close); restore draft on load; show "Saved" status; after a pass show a "Next lesson unlocked" button.
- [ ] **A + B:** Dashboard and lesson map now reflect real persisted progress.
- [ ] **C:** Bypass testing: open `lesson.php?id=2`, `get-lesson.php?id=2`, and POST to `submit-attempt.php` / `save-draft.php` for Lesson 2 **before** completing Lesson 1. All must be refused.

**Deliverable:** the full sequence works end to end.
**Done when:** pass Lesson 1 -> Lesson 2 unlocks; close the browser mid-lesson and return to find your code restored; direct URL and direct POST bypass attempts all fail with 403.
**Watch out for:** trusting `passed` from the browser (the server computes it); a draft save accidentally completing a lesson; saving completion outside a transaction.

> **Known prototype limitation (write it in the final docs):** behavior checks run in the browser, so a determined student could fake those results. Server-side structural checks are authoritative. A future version could run checks in a headless browser on the server.

---

### Phase 6: Lesson 2, security, teacher view (Days 11-12)

**Why:** Prove the system works for more than one lesson, harden it, and give the researcher visibility.

**Day 11, Lesson 2 and security pass**
- [ ] **C + B + A:** Finish Lesson 2 (Building a Card) end to end: starter, checks, hints, server checks.
- [ ] **A:** Security sweep: every user/DB value printed through `e()`; every query prepared; CSRF on all POSTs; `requireRole` on every `public/admin/` page; `display_errors` off outside development.
- [ ] **A:** Confirm no response ever includes `solution.json` or server-only check rules (search responses for answer fragments).
- [ ] **B:** Responsive and accessibility pass on dashboard and lesson page (keyboard focus, labels, contrast).

**Day 12, teacher view**
- [ ] **A:** `admin/dashboard.php`: student count, completion count per lesson.
- [ ] **A:** `admin/students.php`: table of students x lessons with status, attempt count, last activity (real DB data). Guard everything with `Auth::requireRole('teacher')`.
- [ ] **B:** Style the teacher pages.
- [ ] **Optional (only if everything above is done):** `admin/reports.php`: most-failed checks per lesson from `attempts.failed_checks`.

**Deliverable:** two-lesson path works; teacher sees live progress.
**Done when:** a student account visiting `/admin/` gets 403; the teacher table matches what the database says.
**Watch out for:** teacher pages that forget the role check (the most common mistake).

---

### Phase 7: Testing and demo (Days 13-14)

**Why:** A prototype that fails during the demo fails the research. Reserve real time for this.

**Day 13, testing (bug fixes only, no new features)**
- [ ] **C:** Run the full checklist and record results in `docs/testing-plan.md`:
  - **Auth:** wrong password, duplicate email, empty fields, logged-out access to every page, student opening `/admin/`
  - **Gating:** direct URL, direct POST, skipping ahead, replaying a completed lesson
  - **Submissions:** empty code, very long code, `<script>` in HTML, malformed HTML, infinite loop in student JS
  - **Persistence:** refresh, logout/login, second browser
  - **Responsive:** laptop and phone widths
  - **Browsers:** Chrome plus one other
- [ ] **All:** Fix major bugs. Anything cosmetic goes into the "Future work" list instead.
- [ ] **A:** Infinite-loop decision for the prototype: either document it as a known limitation or add a simple run-timeout guard in `preview.js` (B).

**Day 14, demo preparation**
- [ ] **C:** Demo data: 1 teacher, 3 students at different progress levels (none, Lesson 1 done, both done).
- [ ] **C:** Demo script: register -> dashboard -> read a module -> Lesson 1 with the error -> feedback -> fix -> pass -> Lesson 2 unlocks -> teacher view.
- [ ] **A:** Delete `public/_check.php`; set `'env' => 'production'` in the demo machine's `local.php`; export the final database (`web_trinity.sql`).
- [ ] **All:** Finish `docs/architecture.md`; add **Limitations and Future Work** (more lessons, headless server-side checking, pre/post tests, analytics, accessibility).
- [ ] **All:** Tag the release (`git tag v0.1-prototype`) and rehearse the demo once, start to finish.

**Deliverable:** a stable, demonstrable research prototype.

---

## 7. Appendix A: Content formats

### `content/lessons/<slug>/lesson.json`

```json
{
  "id": "lesson-01-button",
  "title": "Building a Button",
  "concept": "A button needs structure (HTML), appearance (CSS), and behavior (JavaScript) that all refer to the same element.",
  "objectives": [
    "Give an element an id so CSS and JavaScript can find it",
    "Style a button using a selector that matches your HTML",
    "Change page content when the button is clicked"
  ],
  "instructions": "Complete the button so it is styled and changes the message when clicked.",
  "related_modules": [
    { "track": "html", "topic": "buttons" },
    { "track": "css", "topic": "selectors" },
    { "track": "js", "topic": "click-events" }
  ]
}
```

### Starter files (deliberately broken or incomplete)

```html
<!-- starter.html -->
<button>Click me</button>
<p id="message">Waiting...</p>
```

```css
/* starter.css */
#btn { background: royalblue; color: white; padding: .6rem 1.2rem; border: 0; border-radius: .4rem; }
```

```js
// starter.js
const btn = document.querySelector('#btn');
btn.addEventListener('click', () => {
  // TODO: change the #message text
});
```

Here, the HTML button has no `id="btn"`, so the CSS never applies and the JS crashes on `null`. That is one root cause visible in three layers, which is exactly what the platform teaches.

### `content/lessons/<slug>/checks.json` (PRIVATE; never sent whole to the browser)

```json
{
  "checks": [
    {
      "id": "btn-has-id",
      "layer": "html",
      "scope": "server",
      "type": "html-element-exists",
      "selector": "button#btn",
      "why": "Your CSS and JavaScript look for #btn, but the <button> in your HTML has no id=\"btn\". Add the id so all three can find the same element."
    },
    {
      "id": "btn-is-styled",
      "layer": "css",
      "scope": "client",
      "type": "computed-style",
      "selector": "#btn",
      "property": "background-color",
      "expected": "rgb(65, 105, 225)",
      "why": "The button is not blue yet. A CSS rule only applies if its selector matches the HTML element."
    },
    {
      "id": "click-changes-message",
      "layer": "js",
      "scope": "client",
      "type": "click-changes-text",
      "clickSelector": "#btn",
      "targetSelector": "#message",
      "why": "Clicking the button does not change #message. Set its textContent inside the click handler."
    },
    {
      "id": "js-has-handler",
      "layer": "js",
      "scope": "server",
      "type": "js-contains-pattern",
      "pattern": "addEventListener\\s*\\(\\s*['\"]click['\"]",
      "why": "Use addEventListener('click', ...) so the button can react to clicks."
    }
  ]
}
```

**Supported check types (keep this list small for the prototype):**

| Type | Runs | Meaning |
|---|---|---|
| `html-element-exists` | server | Element matching a simple selector exists. Supported: `tag`, `#id`, `.class`, `tag#id`, `tag.class` |
| `css-rule-has` | server | A rule for `selector` sets `property: value` |
| `js-contains-pattern` | server | Student JS matches a regular expression |
| `dom-exists` | client | Element exists in the rendered preview |
| `computed-style` | client | `getComputedStyle` of an element equals an expected value |
| `click-changes-text` | client | Simulating a click changes the target's text |

Add new types only when a lesson cannot be checked otherwise.

### `solution.json` and `hints.json`

```json
// solution.json (never leaves the server; used for authoring and optional comparison)
{ "html": "<button id=\"btn\">Click me</button>\n<p id=\"message\">Waiting...</p>", "css": "...", "js": "..." }

// hints.json (revealed one at a time)
{ "hints": [
  "Look at how your CSS and JavaScript find the button. Do they find the same thing?",
  "Both use #btn. Which attribute does that selector refer to?"
] }
```

---

## 8. Appendix B: API contracts (agree before coding both sides)

All endpoints return `{"ok": true, ...}` or `{"ok": false, "error": "..."}`. All POSTs send header `X-CSRF-Token`. Status codes: `401` not logged in, `403` locked/not allowed, `419` expired session/CSRF, `422` invalid input.

### `GET api/get-lesson.php?id=1`

```json
{
  "ok": true,
  "lesson": {
    "id": 1, "title": "Building a Button",
    "concept": "...", "objectives": ["..."], "instructions": "...",
    "starter": { "html": "...", "css": "...", "js": "..." },
    "draft": { "html": "...", "css": "...", "js": "..." },
    "status": "in_progress",
    "hints_count": 2,
    "client_checks": [ { "id": "btn-is-styled", "layer": "css", "type": "computed-style", "...": "..." } ]
  }
}
```

`draft` is `null` if none is saved. **Never includes** `solution`, server-scope checks, or hint text beyond what has been unlocked.

### `POST api/save-draft.php`

Request: `{ "lesson_id": 1, "html": "...", "css": "...", "js": "..." }`
Response: `{ "ok": true, "saved_at": "2026-10-20 09:15:02" }`
Never changes `status` to completed.

### `POST api/submit-attempt.php`

Request:

```json
{
  "lesson_id": 1,
  "html": "...", "css": "...", "js": "...",
  "client_results": [ { "id": "btn-is-styled", "passed": true } ]
}
```

Response:

```json
{
  "ok": true,
  "passed": false,
  "checks_passed": 2,
  "checks_total": 4,
  "results": [
    { "id": "btn-has-id", "layer": "html", "passed": false, "why": "Your CSS and JavaScript look for #btn, but ..." }
  ],
  "next_lesson_unlocked": false,
  "next_lesson_id": null
}
```

`why` is included only for failed checks.

---

## 9. Quick reference

| Need | Use |
|---|---|
| Escape output | `e($value)` |
| Page URL / asset URL | `url('x.php')` / `asset('css/x.css')` |
| Redirect | `redirect('login.php')` |
| DB query | `Database::one()`, `Database::all()`, `Database::run()`, `Database::value()` |
| Require login | `Auth::requireLogin()` (pages) / `Auth::requireLogin(true)` (API) |
| Require teacher | `Auth::requireRole('teacher')` |
| CSRF in forms | `<?= Csrf::field() ?>` + `Csrf::verifyRequest()` |
| CSRF in fetch | Header `X-CSRF-Token` + `Csrf::verifyRequest(true)` |
| Can student open lesson? | `LessonGate::canAccess($userId, $lessonId)` |
| Lesson states for dashboard | `LessonGate::statesFor($userId)` |
| JSON response | `Response::ok([...])` / `Response::error('msg', 403)` |