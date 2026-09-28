
  // header darken on scroll
  const header = document.getElementById('siteHeader');
  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 40);
  });

  // mobile nav: right-side drawer with blurred backdrop
  const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');
  const navBackdrop = document.getElementById('navBackdrop');
  const navClose = document.getElementById('navClose');

  function openNav(){
    navLinks.classList.add('open');
    navBackdrop.classList.add('open');
    navToggle.classList.add('active');
    navToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }
  function closeNav(){
    navLinks.classList.remove('open');
    navBackdrop.classList.remove('open');
    navToggle.classList.remove('active');
    navToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }
  navToggle.addEventListener('click', () => {
    navLinks.classList.contains('open') ? closeNav() : openNav();
  });
  if (navClose) navClose.addEventListener('click', closeNav);
  navBackdrop.addEventListener('click', closeNav);
  navLinks.querySelectorAll('a').forEach(a => a.addEventListener('click', closeNav));
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && navLinks.classList.contains('open')) closeNav();
  });

  // scroll-spy: mark the nav item whose section is currently in view.
  // Only same-page anchors resolve to an element here; links rewritten to the
  // home URL by the theme (PHP) are skipped automatically.
  const spyLinks = Array.from(document.querySelectorAll('#navLinks a.nav-anchor')).reduce((acc, a) => {
    const hash = a.getAttribute('href') || '';
    if (hash.length < 2 || hash[0] !== '#') return acc;
    let section = null;
    try { section = document.querySelector(hash); } catch (e) { /* not a valid selector */ }
    if (section) acc.push({ a, section });
    return acc;
  }, []);

  // A "Home" menu item that links to the front page itself (not "#home") is
  // marked current by WordPress for the whole page, so it would stay
  // underlined next to the scroll-spy's item. Let the spy drive it via #home.
  const homeLink = document.querySelector('#navLinks li.menu-item-home > a');
  const homeSection = document.getElementById('home');
  if (homeLink && homeSection && !spyLinks.some(({ a }) => a === homeLink)) {
    spyLinks.unshift({ a: homeLink, section: homeSection });
  }

  if (spyLinks.length && 'IntersectionObserver' in window) {
    document.querySelectorAll('#navLinks li.current-menu-item, #navLinks li.current_page_item').forEach(li => {
      li.classList.remove('current-menu-item', 'current_page_item');
    });

    const spy = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        spyLinks.forEach(({ a, section }) => a.classList.toggle('current-menu-item', section === entry.target));
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    spyLinks.forEach(({ section }) => spy.observe(section));
  }

  // scroll reveal + number count-up
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  function animateCount(el){
    const target = parseFloat(el.dataset.count);
    if (prefersReduced || isNaN(target)) return;
    const decimals = parseInt(el.dataset.decimals || '0', 10);
    const suffix = el.dataset.suffix || '';
    const dur = 900, start = performance.now();
    function format(v){
      let s = v.toFixed(decimals);
      let parts = s.split('.');
      if (decimals === 0 && parts[0].length < 2) parts[0] = '0' + parts[0];
      return parts.join('.') + suffix;
    }
    function tick(now){
      const p = Math.min((now - start) / dur, 1);
      const eased = 1 - Math.pow(1 - p, 3);
      el.textContent = format(target * eased);
      if (p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }
  // GSAP ScrollTrigger drives the reveal-on-scroll animation; fall back to a
  // plain class toggle (no motion) if the local GSAP files failed to load.
  if (window.gsap && window.ScrollTrigger) {
    gsap.registerPlugin(ScrollTrigger);

    document.querySelectorAll('.reveal:not(.stagger)').forEach(el => {
      gsap.fromTo(el,
        { opacity: 0, y: 24, scale: .985 },
        {
          opacity: 1, y: 0, scale: 1, duration: .8, ease: 'power3.out',
          scrollTrigger: { trigger: el, start: 'top 88%', once: true },
          onStart: () => {
            el.classList.add('in-view');
            el.querySelectorAll('[data-count]').forEach(animateCount);
          }
        }
      );
    });

    document.querySelectorAll('.reveal.stagger').forEach(parent => {
      const children = Array.from(parent.children);
      gsap.fromTo(children,
        { opacity: 0, y: 22, scale: .97 },
        {
          opacity: 1, y: 0, scale: 1, duration: .7, ease: 'power3.out', stagger: .07,
          scrollTrigger: { trigger: parent, start: 'top 88%', once: true },
          onStart: () => {
            parent.classList.add('in-view');
            parent.querySelectorAll('[data-count]').forEach(animateCount);
          }
        }
      );
    });
    // This page loads 30+ images and custom fonts after ScrollTrigger's initial
    // measurement pass, which silently shifts every trigger's pixel position.
    // Re-measure once everything has actually settled.
    const refresh = () => ScrollTrigger.refresh();
    window.addEventListener('load', refresh);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(refresh);
    document.querySelectorAll('img').forEach(img => {
      if (!img.complete) img.addEventListener('load', refresh, { once: true });
    });
  } else {
    document.querySelectorAll('.reveal').forEach(el => {
      el.classList.add('in-view');
      el.querySelectorAll('[data-count]').forEach(animateCount);
    });
  }

  // data analytics — expandable featured projects (any number of them)
  document.querySelectorAll('.da-toggle').forEach(btn => {
    const card = btn.closest('.da-featured');
    if (!card) return;
    btn.addEventListener('click', () => {
      const expanded = card.classList.toggle('expanded');
      btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    });
  });

  // hero stats count up immediately on load (hero is visible without scrolling)
  window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      document.querySelectorAll('.hero-stats [data-count]').forEach(animateCount);
    }, 380);
  });

  // top scroll-progress bar + subtle hero parallax, combined in one rAF-throttled handler
  const scrollProgressEl = document.getElementById('scrollProgress');
  const heroBgEl = document.querySelector('.hero-bg');
  const heroEl = document.querySelector('.hero');
  let scrollTicking = false;
  function onScrollFrame(){
    const doc = document.documentElement;
    const scrollable = doc.scrollHeight - doc.clientHeight;
    const pct = scrollable > 0 ? (doc.scrollTop / scrollable) * 100 : 0;
    scrollProgressEl.style.width = pct + '%';

    if (!prefersReduced && heroBgEl && heroEl) {
      const heroHeight = heroEl.offsetHeight;
      if (doc.scrollTop < heroHeight) {
        heroBgEl.style.transform = `translateY(${doc.scrollTop * 0.1}px)`;
      }
    }
    scrollTicking = false;
  }
  window.addEventListener('scroll', () => {
    if (!scrollTicking) {
      requestAnimationFrame(onScrollFrame);
      scrollTicking = true;
    }
  }, { passive: true });
  onScrollFrame();
