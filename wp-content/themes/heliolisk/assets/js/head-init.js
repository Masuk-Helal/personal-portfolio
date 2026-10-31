/* =====================================================================
   head-init.js
   Blocking script (no defer/async) loaded from <head> so it runs before
   first paint — both pages use it, so the inline <head> snippets are gone.

   1) Theme (index.html): saved choice, else OS preference -> data-theme,
      applied before paint so there is no theme flash.
   2) Hero 26 (index-2.html): html.h26-js unlocks the entrance-animation
      start state (html:not(.h26-js) .h26-in shows everything for no-JS).
   3) Law portfolio (index-6.html): html.law-js enables the hidden reveal
      start state; without it the page stays fully visible.
   ===================================================================== */
(function () {
    'use strict';

    // ---- 1) theme ----
    try {
        var t = localStorage.getItem('pf-theme');
        if (!t) t = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', t);
    } catch (e) {
        document.documentElement.setAttribute('data-theme', 'dark');
    }

    // ---- 2) hero-26 entrance animations ----
    document.documentElement.classList.add('h26-js');

    // ---- 3) law portfolio reveal start state ----
    if (document.documentElement.classList.contains('pf-law')) {
        document.documentElement.classList.add('law-js');
    }
})();
