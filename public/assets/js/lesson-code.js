/* Lesson workspace prototype: tabs, live preview, answer checking, feedback, saved progress. */
(function () {
  var id = parseInt(new URLSearchParams(location.search).get('id'), 10) || 1;
  var st = WT.states().filter(function (l) { return l.id === id; })[0];
  var root = document.getElementById('app');
  if (!st) { root.innerHTML = '<p>Lesson not found. <a href="lesson.php">Back to lessons</a></p>'; return; }
  if (st.state === 'locked') {
    root.innerHTML = '<div class="card"><h2>Lesson locked</h2><p>Complete the previous lesson first, then this one opens.</p><a class="btn" href="lesson.php">Back to lessons</a></div>';
    return;
  }
  var P = WT.S.progress[id] = WT.S.progress[id] || { status: 'in_progress', attempts: 0 };
  var code = Object.assign({}, st.starter, P.draft || {});
  var tab = 'html', hint = 0, ta = document.getElementById('code'), frame = document.getElementById('preview');
  var $ = function (i) { return document.getElementById(i); };

  $('title').textContent = 'Lesson ' + id + ': ' + st.title;
  $('concept').textContent = st.concept;
  $('objectives').innerHTML = st.objectives.map(function (o) { return '<li>' + WT.esc(o) + '</li>'; }).join('');
  $('related').innerHTML = st.related.map(function (r) { return '<a href="module-track.php?track=' + r[0] + '&topic=' + r[1] + '"><span class="tag ' + r[0] + '">' + r[0].toUpperCase() + '</span></a>'; }).join('');

  function showTab(t) {
    code[tab] = ta.value; tab = t; ta.value = code[t];
    document.querySelectorAll('.tabs button').forEach(function (b) { b.classList.toggle('on', b.dataset.t === t); });
  }
  document.querySelectorAll('.tabs button').forEach(function (b) { b.onclick = function () { showTab(b.dataset.t); }; });
  ta.value = code.html;
  ta.onkeydown = function (e) { if (e.key === 'Tab') { e.preventDefault(); ta.setRangeText('  ', ta.selectionStart, ta.selectionEnd, 'end'); } };
  ta.oninput = function () { code[tab] = ta.value; P.draft = Object.assign({}, code); WT.save(); $('saved').textContent = 'Draft saved'; };

  function harness(checks) {
    setTimeout(function () {
      var res = checks.map(function (c) {
        var ok = false, extra = '';
        try {
          var el = c.sel && document.querySelector(c.sel);
          if (c.type === 'dom-exists') ok = !!el;
          else if (c.type === 'computed-style') ok = !!el && getComputedStyle(el).getPropertyValue(c.prop) === c.expected;
          else if (c.type === 'js-no-error') { ok = !window.__wtErr; extra = window.__wtErr || ''; }
          else if (c.type === 'click-changes-text') { var t = document.querySelector(c.target), b = t.textContent; el.click(); ok = t.textContent !== b; }
          else if (c.type === 'input-updates-text') { var g = document.querySelector(c.target); el.value = 'Franz'; el.dispatchEvent(new Event('input', { bubbles: true })); ok = g.textContent.indexOf('Franz') > -1; }
        } catch (e) { ok = false; }
        return { id: c.id, ok: ok, extra: extra };
      });
      parent.postMessage({ wt: 1, results: res }, '*');
    }, 60);
  }
  function render(withChecks) {
    code[tab] = ta.value;
    var js = code.js.replace(/<\/script/gi, '<\\/script');
    frame.srcdoc = '<!doctype html><body style="font-family:system-ui;padding:14px"><style>' + code.css + '</style>' + code.html +
      '<script>try{' + js + '\n}catch(e){window.__wtErr=e.message}<\/script>' +
      (withChecks ? '<script>(' + harness.toString() + ')(' + JSON.stringify(st.checks) + ')<\/script>' : '') + '</body>';
  }

  window.addEventListener('message', function (e) {
    if (e.source !== frame.contentWindow || !e.data || !e.data.wt) return;
    var res = e.data.results, passed = res.filter(function (r) { return r.ok; }).length, all = passed === res.length;
    var items = st.checks.map(function (c) {
      var r = res.filter(function (x) { return x.id === c.id; })[0] || {};
      return r.ok ? '<li class="pass"><span class="tag ' + c.layer + '">' + c.layer.toUpperCase() + '</span>&#10003; ' + WT.esc(c.label) + '</li>'
        : '<li class="fail"><span class="tag ' + c.layer + '">' + c.layer.toUpperCase() + '</span>&#10007; ' + WT.esc(c.label) +
          '<span class="why"><b>Why:</b> ' + WT.esc(c.why) + (r.extra ? ' <i>Browser said: ' + WT.esc(r.extra) + '</i>' : '') + '</span></li>';
    }).join('');
    P.attempts = (P.attempts || 0) + 1;
    WT.S.log.unshift({ lesson: id, passed: all, score: passed + '/' + res.length, at: new Date().toLocaleString() });
    if (all && P.status !== 'completed') { P.status = 'completed'; P.completedAt = new Date().toLocaleString(); }
    WT.save();
    var next = WT.LESSONS.filter(function (l) { return l.id === id + 1; })[0];
    $('feedback').innerHTML = '<h3>' + (all ? 'All checks passed' : passed + ' of ' + res.length + ' checks passed') + '</h3><ul>' + items + '</ul>' +
      (all ? '<p class="note">Lesson complete. Progress saved.' + (next ? ' Lesson ' + next.id + ' is now unlocked.' : '') + '</p>' + (next ? '<a class="btn" href="lesson-code.php?id=' + next.id + '">Next lesson</a> ' : '') + '<a class="btn alt" href="dashboard.php">See progress</a>' : '<p class="muted">Fix the items above, then submit again.</p>');
    $('feedback').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  });

  $('run').onclick = function () { render(false); };
  $('submit').onclick = function () { render(true); };
  $('reset').onclick = function () { if (confirm('Reset all three files to the starter code?')) { code = Object.assign({}, st.starter); ta.value = code[tab]; P.draft = null; WT.save(); render(false); } };
  $('hint').onclick = function () {
    if (hint < st.hints.length) { $('hints').innerHTML += '<p class="note">Hint ' + (hint + 1) + ': ' + WT.esc(st.hints[hint]) + '</p>'; hint++; }
    if (hint >= st.hints.length) $('hint').disabled = true;
  };
  render(false);
})();
