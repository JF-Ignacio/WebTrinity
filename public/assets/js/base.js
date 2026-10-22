/* WEB-TRINITY prototype - shared data, mock "database" (localStorage) and navbar.
   PROTOTYPE ONLY: later, lessons come from content/ + MySQL, progress from the server. */
(function () {
  var KEY = 'wt-proto-v1';
  var S = { user: '', progress: {}, read: {}, log: [] };
  try { Object.assign(S, JSON.parse(localStorage.getItem(KEY)) || {}); } catch (e) {}
  function save() { localStorage.setItem(KEY, JSON.stringify(S)); }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }

  var BTN_WHY = 'The button is not royalblue yet. Add background: royalblue; to the #btn rule. It only applies once the HTML button has id="btn".';
  var LESSONS = [
    { id: 1, title: 'Building a Button',
      concept: 'A button needs structure (HTML), appearance (CSS) and behavior (JavaScript) that all point at the same element.',
      objectives: ['Give the button an id so CSS and JS can find it', 'Style it with a rule that matches that id', 'Change the message when it is clicked'],
      related: [['html', 'elements'], ['css', 'selectors'], ['js', 'events']],
      starter: {
        html: '<button>Click me</button>\n<p id="message">Waiting...</p>',
        css: '#btn {\n  color: white;\n  padding: 0.6rem 1.2rem;\n  border: 0;\n  border-radius: 6px;\n  /* TODO: give the button a royalblue background */\n}',
        js: "const btn = document.querySelector('#btn');\nconst message = document.querySelector('#message');\n\nbtn.addEventListener('click', function () {\n  // TODO: change the text of #message\n});" },
      checks: [
        { id: 'id', layer: 'html', label: 'The button has id="btn"', type: 'dom-exists', sel: '#btn', why: 'Your CSS and JavaScript both look for #btn, but the <button> has no id="btn". Add the id so all three layers point at the same element.' },
        { id: 'bg', layer: 'css', label: 'The button is royalblue', type: 'computed-style', sel: '#btn', prop: 'background-color', expected: 'rgb(65, 105, 225)', why: BTN_WHY },
        { id: 'err', layer: 'js', label: 'The script runs without errors', type: 'js-no-error', why: 'Your script crashed before it finished. A common cause: querySelector("#btn") found nothing (null) because the HTML has no id="btn".' },
        { id: 'click', layer: 'js', label: 'Clicking changes the message', type: 'click-changes-text', sel: '#btn', target: '#message', why: 'Clicking did not change #message. Inside the click handler, set message.textContent to new text.' }],
      hints: ['Which element do both your CSS and your JS try to find?', 'Both use #btn. Which HTML attribute does "#" refer to?', 'Fix in order: add id="btn" in HTML, add background: royalblue in CSS, set message.textContent in the handler.'] },
    { id: 2, title: 'Building a Text Field',
      concept: 'An input only becomes interactive when HTML defines it, CSS styles it, and JavaScript reacts to what the user types.',
      objectives: ['Give the input an id the other layers can use', 'Add a royalblue border in CSS', 'Show "Hello, <name>!" as the user types'],
      related: [['html', 'elements'], ['css', 'selectors'], ['js', 'events']],
      starter: {
        html: '<label>Your name</label>\n<input type="text" placeholder="Type your name">\n<p id="greeting">Hello, stranger!</p>',
        css: '#name-input {\n  padding: 0.5rem 0.75rem;\n  border-radius: 6px;\n  /* TODO: add a 2px solid royalblue border */\n}',
        js: "const input = document.querySelector('#name-input');\nconst greeting = document.querySelector('#greeting');\n\ninput.addEventListener('input', function () {\n  // TODO: show \"Hello, <name>!\" in the greeting\n});" },
      checks: [
        { id: 'id', layer: 'html', label: 'The input has id="name-input"', type: 'dom-exists', sel: '#name-input', why: 'Nothing in the page has id="name-input", so the CSS rule and the JS selector match nothing. Add the id to the <input>.' },
        { id: 'border', layer: 'css', label: 'The input has a royalblue border', type: 'computed-style', sel: '#name-input', prop: 'border-top-color', expected: 'rgb(65, 105, 225)', why: 'Add border: 2px solid royalblue; to the #name-input rule.' },
        { id: 'err', layer: 'js', label: 'The script runs without errors', type: 'js-no-error', why: 'Your script crashed. querySelector("#name-input") probably returned null because the HTML input has no id.' },
        { id: 'type', layer: 'js', label: 'Typing updates the greeting', type: 'input-updates-text', sel: '#name-input', target: '#greeting', why: 'The greeting did not change while typing. In the input handler, set greeting.textContent = "Hello, " + input.value + "!".' }],
      hints: ['What do the CSS selector and the JS selector have in common?', 'Add id="name-input" to the <input> element.', 'In the handler: greeting.textContent = "Hello, " + input.value + "!";'] }
  ];

  var MODULES = {
    html: { title: 'HTML: structure', topics: [
      { id: 'elements', title: 'Elements and ids', body: '<p>HTML describes <b>what is on the page</b>. Each element can have an <code>id</code>, a unique name that CSS and JavaScript use to find it.</p><pre><code>&lt;button id="btn"&gt;Click me&lt;/button&gt;</code></pre><p class="note">If the id is missing or misspelled, CSS and JS silently stop working for that element.</p>' },
      { id: 'forms', title: 'Buttons and inputs', body: '<p>A <code>&lt;button&gt;</code> triggers actions. An <code>&lt;input&gt;</code> collects text. Pair an input with a <code>&lt;label&gt;</code> so people know what to type.</p><pre><code>&lt;label for="name-input"&gt;Your name&lt;/label&gt;\n&lt;input id="name-input" type="text"&gt;</code></pre>' }] },
    css: { title: 'CSS: appearance', topics: [
      { id: 'selectors', title: 'Selectors', body: '<p>A selector chooses <b>which elements</b> a rule styles. <code>#btn</code> matches the element with <code>id="btn"</code>; <code>.card</code> matches class <code>card</code>.</p><pre><code>#btn { background: royalblue; }</code></pre><p class="note">No matching element means the rule does nothing, with no error message.</p>' },
      { id: 'colors', title: 'Color and borders', body: '<p><code>background</code> fills an element, <code>color</code> sets text, and <code>border</code> draws an outline.</p><pre><code>input { border: 2px solid royalblue; }</code></pre>' }] },
    js: { title: 'JavaScript: behavior', topics: [
      { id: 'selecting', title: 'Selecting elements', body: '<p><code>document.querySelector("#btn")</code> returns the element with that id, or <code>null</code> if none exists. Using <code>null</code> causes a TypeError.</p><pre><code>const btn = document.querySelector("#btn");</code></pre>' },
      { id: 'events', title: 'Events: click and input', body: '<p>Events let code react to the user. Attach a function with <code>addEventListener</code>.</p><pre><code>btn.addEventListener("click", function () {\n  message.textContent = "Clicked!";\n});</code></pre><p>An <code>input</code> event fires on every keystroke; read <code>input.value</code> inside it.</p>' }] }
  };

  function states() {
    var prev = true;
    return LESSONS.map(function (l) {
      var p = S.progress[l.id] || {}, st;
      if (p.status === 'completed') st = 'completed';
      else if (prev) st = (p.attempts || p.draft) ? 'in_progress' : 'available';
      else st = 'locked';
      prev = prev && st === 'completed';
      return Object.assign({ state: st, p: p }, l);
    });
  }
  var LABEL = { completed: 'Completed', in_progress: 'In progress', available: 'Available', locked: 'Locked' };

  function nav() {
    var el = document.getElementById('nav'); if (!el) return;
    var page = location.pathname.split('/').pop() || 'index.php';
    function a(href, text, match) { return '<a href="' + href + '"' + (match.indexOf(page) > -1 ? ' class="on"' : '') + '>' + text + '</a>'; }
    el.className = 'nav';
    el.innerHTML = '<div class="wrap"><a class="logo" href="index.php">WEB-TRINITY</a>' +
      a('modules.php', 'Modules', ['modules.php', 'module-track.php']) + a('lesson.php', 'Lessons', ['lesson.php', 'lesson-code.php']) + a('dashboard.php', 'Dashboard', ['dashboard.php']) +
      (S.user ? '<span class="muted">Hi, ' + esc(S.user) + '</span><a href="#" id="out">Log out</a>' : '<a href="login.php">Log in</a><a class="btn" href="register.php">Sign up</a>') + '</div>';
    var out = document.getElementById('out');
    if (out) out.onclick = function (e) { e.preventDefault(); S.user = ''; save(); location.href = 'index.php'; };
  }
  document.addEventListener('DOMContentLoaded', nav);
  window.WT = { S: S, save: save, esc: esc, LESSONS: LESSONS, MODULES: MODULES, states: states, LABEL: LABEL };
})();
