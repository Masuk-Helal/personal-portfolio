/* ==================================================================
   Portfolio 1 - main.js
   Each feature is a small init function. Plugins are optional:
   every init checks that its element / library exists first.
   ================================================================== */
(function ($) {
    'use strict';

    const $win = $(window);
    const $body = $('body');
    let lenis = null;
    let jumping = false;   // true while a link glides to its target

    /* ---------- Smooth scroll (Lenis) ----------
       Eased, momentum-style wheel scrolling. Native scroll position is still
       used underneath, so scroll events, IntersectionObserver and the
       accordion auto-open all keep working. Skipped for reduced motion.
       Elements with [data-lenis-prevent] (the drawer) scroll natively. */
    function initSmoothScroll() {
        if (typeof Lenis === 'undefined') return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        lenis = new Lenis({
            lerp: 0.085,           // lower = smoother / floatier
            wheelMultiplier: 1,
            smoothWheel: true,
            syncTouch: false,      // keep native touch scrolling on phones
            anchors: false         // in-page links handled below
        });
        window.pfLenis = lenis;    // page scripts (index-5.js) pause it during the loader

        // one clock for everything: when GSAP is present, Lenis ticks on the
        // GSAP ticker so ScrollTrigger (title reveals) reads the same frame
        // Lenis just wrote. Two separate rAF loops caused visible jitter.
        if (typeof gsap !== 'undefined') {
            gsap.ticker.add((time) => lenis.raf(time * 1000));
            gsap.ticker.lagSmoothing(0);
        } else {
            const raf = (time) => { lenis.raf(time); requestAnimationFrame(raf); };
            requestAnimationFrame(raf);
        }

        // accordion panels change the page height while they animate
        if ('ResizeObserver' in window) {
            new ResizeObserver(() => lenis.resize()).observe(document.body);
        }

        // in-page links glide to their target; "#" goes back to the top
        $(document).on('click', 'a[href^="#"]', function (e) {
            const hash = this.getAttribute('href');
            const target = hash === '#' ? 0 : document.getElementById(hash.slice(1));
            if (target === null) return;
            e.preventDefault();
            // let the accordion open first so the target lands in place
            requestAnimationFrame(() => {
                jumping = true;
                lenis.scrollTo(target, {
                    duration: 1.4,
                    onComplete: () => { jumping = false; }
                });
            });
            if (hash !== '#') history.replaceState(null, '', hash);
        });
    }

    /* ---------- Mobile drawer ----------
       [data-drawer-toggle] opens/closes, [data-drawer-close] closes.
       State lives on <body class="is-drawer-open"> (see layout/_mobile-menu.scss). */
    function initDrawer() {
        const $drawer = $('.pf-drawer');
        if (!$drawer.length) return;

        const $toggle = $('[data-drawer-toggle]');

        const setOpen = (open) => {
            $body.toggleClass('is-drawer-open', open);
            document.body.style.overflow = open ? 'hidden' : '';
            if (lenis) open ? lenis.stop() : lenis.start();
            $toggle.attr({ 'aria-expanded': open, 'aria-label': open ? 'Close menu' : 'Open menu' });
            $drawer.attr('aria-hidden', !open);
        };

        $toggle.on('click', () => setOpen(!$body.hasClass('is-drawer-open')));
        $('[data-drawer-close], .pf-drawer a').on('click', () => setOpen(false));
        $(document).on('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
    }

    /* ---------- Scroll reveal ----------
       [data-reveal] gets .is-in-view once; children use .pf-up (components/_reveal.scss) */
    function initReveal() {
        const $items = $('[data-reveal]');
        if (!$items.length) return;

        if (!('IntersectionObserver' in window)) { $items.addClass('is-in-view'); return; }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in-view');
                observer.unobserve(entry.target);
            });
        }, { threshold: .15, rootMargin: '0px 0px -10% 0px' });

        $items.each(function () { observer.observe(this); });
    }

    /* ---------- Work list: image preview follows the cursor (desktop) ---------- */
    function initWorkPreview() {
        const $preview = $('.pf-work-preview');
        if (!$preview.length || !window.matchMedia('(hover: hover)').matches) return;

        const el = $preview[0];
        const img = el.querySelector('img');
        let x = 0, y = 0, cx = 0, cy = 0, raf = null;

        // eased follow
        const loop = () => {
            cx += (x - cx) * .15;
            cy += (y - cy) * .15;
            el.style.left = `${cx}px`;
            el.style.top = `${cy}px`;
            raf = requestAnimationFrame(loop);
        };

        $('.pf-work-row[data-preview]')
            .on('mouseenter', function (e) {
                img.src = this.dataset.preview;
                if (!raf) { cx = x = e.clientX; cy = y = e.clientY; loop(); }
                $preview.addClass('is-visible');
            })
            .on('mousemove', (e) => { x = e.clientX; y = e.clientY; })
            .on('mouseleave', () => {
                $preview.removeClass('is-visible');
                cancelAnimationFrame(raf);
                raf = null;
            });
    }

    /* ---------- Section accordions ----------
       .pf-acc section toggles .is-open from .pf-acc-trigger.
       aria-expanded mirrors state; panels use grid-template-rows in CSS. */
    function initAccordion() {
        const $sections = $('.pf-acc');
        if (!$sections.length) return;

        $sections.each(function () {
            const $section = $(this);
            const $trigger = $section.find('.pf-acc-trigger').first();
            if (!$trigger.length) return;

            $trigger.attr('aria-expanded', $section.hasClass('is-open'));
        });

        $(document).on('click', '.pf-acc-trigger', function () {
            const $section = $(this).closest('.pf-acc');
            const open = !$section.hasClass('is-open');

            $section.toggleClass('is-open', open);
            $(this).attr('aria-expanded', open);
        });

        // in-page links (#story, #jobs ...) open the section they jump to
        $(document).on('click', 'a[href^="#"]', function () {
            const hash = this.getAttribute('href');
            if (!hash || hash.length < 2) return;

            const el = document.getElementById(hash.slice(1));
            if (!el) return;

            const $section = $(el).closest('.pf-acc');
            if (!$section.length || $section.hasClass('is-open')) return;

            $section.addClass('is-open');
            $section.find('.pf-acc-trigger').first().attr('aria-expanded', true);
        });

        /* Scroll-triggered open: while scrolling DOWN, a closed section opens
           when its header passes 70% of the viewport height. Each section
           auto-opens once, so if the user closes it, it stays closed. Opening
           only on the way down means content grows below the reader, so the
           page never jumps. */
        let pending = $sections.toArray().filter((s) => !s.classList.contains('is-open'));
        let lastY = window.scrollY;
        let ticking = false;
        let holdUntil = 0;

        const check = () => {
            ticking = false;
            const y = window.scrollY;
            const down = y >= lastY;
            lastY = y;
            if (!down || !pending.length || jumping) return;

            // open one section per pass, then wait for its panel to finish
            // growing (1.1s) so the next header is measured at its real spot
            const now = performance.now();
            if (now < holdUntil) { setTimeout(() => requestAnimationFrame(check), holdUntil - now + 10); return; }

            const section = pending[0];
            const trigger = section.querySelector('.pf-acc-trigger');
            if (trigger.getBoundingClientRect().top > window.innerHeight * .7) return;

            section.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
            pending.shift();
            holdUntil = now + 1150;
            if (pending.length) setTimeout(() => requestAnimationFrame(check), 1160);
        };

        $win.on('scroll resize', () => {
            if (!ticking) { ticking = true; requestAnimationFrame(check); }
        });
        check();

        // a manual click counts as the user's choice: stop auto-opening it
        $(document).on('click', '.pf-acc-trigger', function () {
            const section = this.closest('.pf-acc');
            pending = pending.filter((s) => s !== section);
        });
    }

    /* ---------- Section title reveal (.reveal-text) ----------
       Same effect as the Cunnet theme: the heading is split into
       div.split-line > word > char, every char starts dim (opacity .3) and
       nudged 7px left, then scrubs to full as the title scrolls from 80% to
       20% of the viewport. <em> keeps its colour per word. Lines are
       re-measured when the width changes. Needs GSAP + ScrollTrigger. */
    function initRevealText() {
        const titles = Array.from(document.querySelectorAll('.reveal-text'));
        if (!titles.length || typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        gsap.registerPlugin(ScrollTrigger);
        if (lenis) lenis.on('scroll', ScrollTrigger.update);

        const block = 'position:relative;display:inline-block;';

        // flatten the heading into [{ text, em }] word tokens
        const tokenize = (root) => {
            const words = [];
            const walk = (node, em) => {
                node.childNodes.forEach((n) => {
                    if (n.nodeType === 3) {
                        n.textContent.split(/\s+/).filter(Boolean).forEach((w) => words.push({ text: w, em }));
                    } else if (n.nodeType === 1) {
                        if (n.tagName === 'BR') words.push({ br: true });
                        else walk(n, em || n.tagName === 'EM');
                    }
                });
            };
            walk(root, false);
            return words;
        };

        const build = (el) => {
            if (el._revealAnim) { el._revealAnim.scrollTrigger.kill(); el._revealAnim.kill(); }
            el.innerHTML = el._revealSource;
            const tokens = tokenize(el);
            el.textContent = '';

            const holder = document.createElement('div');
            holder.setAttribute('aria-hidden', 'true');
            const words = [];
            tokens.forEach((t) => {
                if (t.br) { holder.appendChild(document.createElement('br')); return; }
                const word = document.createElement('div');
                word.style.cssText = block;
                Array.from(t.text).forEach((c) => {
                    const ch = document.createElement('div');
                    ch.style.cssText = block;
                    ch.textContent = c;
                    word.appendChild(ch);
                });
                let node = word;
                if (t.em) { node = document.createElement('em'); node.appendChild(word); }
                holder.appendChild(node);
                holder.appendChild(document.createTextNode(' '));
                words.push({ node, box: word });
            });
            el.appendChild(holder);

            // group words that share a baseline into div.split-line
            // (measure the inline-block word, not its inline <em> wrapper)
            const lines = [];
            words.forEach((w) => {
                const top = w.box.getBoundingClientRect().top;
                const last = lines[lines.length - 1];
                if (last && Math.abs(last.top - top) < 4) last.words.push(w.node);
                else lines.push({ top, words: [w.node] });
            });
            holder.textContent = '';
            lines.forEach((l) => {
                const line = document.createElement('div');
                line.className = 'split-line';
                line.style.cssText = 'display:block;position:relative;';
                l.words.forEach((w, i) => {
                    if (i) line.appendChild(document.createTextNode(' '));
                    line.appendChild(w);
                });
                holder.appendChild(line);
            });

            const chars = holder.querySelectorAll('.split-line div div');
            gsap.set(chars, { opacity: 0.3, x: -7 });
            el._revealAnim = gsap.to(chars, {
                scrollTrigger: { trigger: el, start: 'top 80%', end: 'top 20%', scrub: 1 },
                x: 0,
                opacity: 1,
                duration: 0.7,
                stagger: 0.2
            });
        };

        titles.forEach((el) => {
            el._revealSource = el.innerHTML;
            el.setAttribute('aria-label', el.textContent.replace(/\s+/g, ' ').trim());
            el._revealWidth = el.clientWidth;
            build(el);
        });

        // accordions and resizes move the titles: re-split on width change,
        // always refresh trigger positions
        let t = null;
        const refresh = () => {
            clearTimeout(t);
            t = setTimeout(() => {
                titles.forEach((el) => {
                    if (el.clientWidth !== el._revealWidth) { el._revealWidth = el.clientWidth; build(el); }
                });
                ScrollTrigger.refresh();
            }, 150);
        };
        if ('ResizeObserver' in window) new ResizeObserver(refresh).observe(document.body);
        $win.on('resize', refresh);
    }

    /* ---------- Dark / light theme ----------
       <html data-theme> is set before paint by the inline script in <head>
       (saved choice, else OS preference). The button flips it, saves it,
       and fires `pf:themechange` so the three.js orb can recolour. */
    function initTheme() {
        const root = document.documentElement;
        const btn = document.querySelector('[data-theme-toggle]');
        if (!btn) return;

        const sync = () => {
            const light = root.dataset.theme === 'light';
            btn.setAttribute('aria-pressed', String(light));
            btn.setAttribute('aria-label', light ? 'Switch to dark theme' : 'Switch to light theme');
        };
        sync();

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        let busy = false;

        const apply = (next) => {
            root.dataset.theme = next;
            sync();
            document.dispatchEvent(new CustomEvent('pf:themechange', { detail: { theme: next } }));
        };

        btn.addEventListener('click', (e) => {
            if (busy) return;
            const next = root.dataset.theme === 'light' ? 'dark' : 'light';
            try { localStorage.setItem('pf-theme', next); } catch (err) { /* private mode */ }

            if (reduceMotion.matches) { apply(next); return; }

            // Preferred: View Transitions. The browser snapshots the old page
            // and reveals the new one in a circle growing from the button, all
            // on the compositor, so nothing on the page has to transition.
            if (document.startViewTransition) {
                const r = btn.getBoundingClientRect();
                const x = e.clientX || r.left + r.width / 2;
                const y = e.clientY || r.top + r.height / 2;
                const radius = Math.hypot(Math.max(x, innerWidth - x), Math.max(y, innerHeight - y));

                busy = true;
                const vt = document.startViewTransition(() => apply(next));
                vt.ready.then(() => {
                    root.animate(
                        { clipPath: [`circle(0px at ${x}px ${y}px)`, `circle(${radius}px at ${x}px ${y}px)`] },
                        { duration: 650, easing: 'cubic-bezier(.65, 0, .35, 1)', pseudoElement: '::view-transition-new(root)' }
                    );
                }).catch(() => {});
                vt.finished.finally(() => { busy = false; });
                return;
            }

            // Fallback: short colour cross-fade (see .is-theme-switching)
            root.classList.add('is-theme-switching');
            apply(next);
            setTimeout(() => root.classList.remove('is-theme-switching'), 450);
        });

        // follow the OS setting until the visitor picks a theme themselves
        const mq = window.matchMedia('(prefers-color-scheme: light)');
        mq.addEventListener?.('change', (e) => {
            try { if (localStorage.getItem('pf-theme')) return; } catch (err) { /* ignore */ }
            root.dataset.theme = e.matches ? 'light' : 'dark';
            sync();
            document.dispatchEvent(new CustomEvent('pf:themechange', { detail: { theme: root.dataset.theme } }));
        });
    }

    /* ---------- data-background="img/..." ---------- */
    function initDataBackground() {
        $('[data-background]').each(function () {
            $(this).css('background-image', `url(${$(this).data('background')})`);
        });
    }

    /* ---------- Footer year: [data-year] / [data-h26-year] ---------- */
    function initYear() {
        const year = new Date().getFullYear();
        $('[data-year]').text(year);
        $('[data-h26-year]').text(year);
        // resume footer (index-2) prints the year as plain text inside <p>
        document.querySelectorAll('footer p').forEach((p) => {
            p.innerHTML = p.innerHTML.replace(/^\s*\d{4}/, year);
        });
    }

    /* ---------- Hero 26: entrance (motion whileInView, once) ----------
       .h26-in starts hidden (opacity 0 / offset) and gets .is-in the first
       time it scrolls into view (see pages/_hero-26.scss). index-2.html only. */
    function initH26Reveal() {
        const items = document.querySelectorAll('.h26-in');
        if (!items.length) return;

        if (!('IntersectionObserver' in window)) {
            items.forEach((el) => el.classList.add('is-in'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in');
                observer.unobserve(entry.target);
            });
        }, { threshold: .1 });

        // next frame so the hidden start state is painted first
        requestAnimationFrame(() => items.forEach((el) => observer.observe(el)));
    }

    /* ---------- Hero 26: menu drawer (shadcn Sheet, side = right) ----------
       State lives on <html class="is-h26-open"> (see pages/_hero-26.scss).
       [data-h26-open] opens, [data-h26-close] closes (overlay, links, logo). */
    function initH26Drawer() {
        const root = document.documentElement;
        const drawer = document.getElementById('h26-drawer');
        const opener = document.querySelector('[data-h26-open]');
        if (!drawer || !opener) return;

        const setOpen = (open) => {
            root.classList.toggle('is-h26-open', open);
            drawer.setAttribute('aria-hidden', String(!open));
            opener.setAttribute('aria-expanded', String(open));
            if (open) {
                const first = drawer.querySelector('button, a');
                setTimeout(() => first && first.focus(), 50);
            } else {
                opener.focus({ preventScroll: true });
            }
        };

        opener.addEventListener('click', () => setOpen(true));
        document.querySelectorAll('[data-h26-close]').forEach((el) => {
            el.addEventListener('click', () => setOpen(false));
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && root.classList.contains('is-h26-open')) setOpen(false);
        });
    }

    /* ---------- Resume (index-2): "Download PDF Resume" -> window.print() ----------
       Print CSS hides the page chrome (.no-print) and colours stay as-is. */
    function initPrintResume() {
        $('[data-print-resume]').on('click', () => window.print());
    }

    /* ---------- Resume (index-2): contact form ----------
       Native validation first, then a short confirmation on the button label. */
    function initContactForm() {
        const $form = $('[data-contact-form]');
        if (!$form.length) return;

        $form.on('submit', (e) => {
            e.preventDefault();
            const form = $form[0];
            if (!form.checkValidity()) { form.reportValidity(); return; }

            const $label = $form.find('[type="submit"] span').first();
            const original = $label.text();
            if ($label.length) $label.text('Thanks! Message sent');
            form.reset();
            setTimeout(() => { if ($label.length) $label.text(original); }, 3000);
        });
    }

    /* ---------- WOW scroll animations (inner pages) ---------- */
    function initWow() {
        if (typeof WOW === 'undefined') return;
        new WOW({ mobile: false }).init();
    }

    /* ==================================================================
       index-3.html (Jack, 3D creator). Vanilla ports of the React /
       Framer Motion components. Each init is a no-op without its markup.
       ================================================================== */
    const jackReduced = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const clamp01 = (v) => Math.min(1, Math.max(0, v));

    // Element's offset from the top of the document (ignores transforms).
    const docTop = (el) => {
        let y = 0;
        for (let n = el; n; n = n.offsetParent) y += n.offsetTop;
        return y;
    };

    // One rAF-throttled scroll/resize loop shared by the scroll-driven effects.
    const jackScrollJobs = [];
    let jackTicking = false;
    const jackRun = () => { jackTicking = false; jackScrollJobs.forEach((fn) => fn()); };
    const jackOnScroll = (fn) => {
        if (!jackScrollJobs.length) {
            const queue = () => { if (!jackTicking) { jackTicking = true; requestAnimationFrame(jackRun); } };
            window.addEventListener('scroll', queue, { passive: true });
            window.addEventListener('resize', queue);
        }
        jackScrollJobs.push(fn);
        fn();
    };

    /* FadeIn: [data-fade] gets .is-in when it enters the viewport.
       Mirrors whileInView, viewport { once: true, margin: '50px', amount: 0 }.
       Delay / duration / x / y come from --fd / --fdur / --fx / --fy. */
    function initJackFadeIn() {
        const items = document.querySelectorAll('.pf-jack [data-fade]');
        if (!items.length) return;
        if (!('IntersectionObserver' in window) || jackReduced()) {
            items.forEach((el) => el.classList.add('is-in'));
            return;
        }
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (!e.isIntersecting) return;
                e.target.classList.add('is-in');
                io.unobserve(e.target);
            });
        }, { rootMargin: '50px', threshold: 0 });
        // next frame so the hidden start state is painted before animating
        requestAnimationFrame(() => items.forEach((el) => io.observe(el)));
    }

    /* Magnet: element drifts toward the cursor while it is within
       `padding` px of the element's edges. Offset = distance / strength. */
    function initJackMagnet() {
        const magnets = document.querySelectorAll('[data-magnet]');
        if (!magnets.length || jackReduced()) return;
        if (!window.matchMedia('(hover: hover)').matches) return;   // touch: no cursor

        magnets.forEach((el) => {
            const padding = parseFloat(el.dataset.magnetPadding) || 100;
            const strength = parseFloat(el.dataset.magnetStrength) || 2;
            const activeT = 'transform 0.3s ease-out';
            const inactiveT = 'transform 0.6s ease-in-out';
            let active = false;
            let raf = null;
            let mx = 0, my = 0;

            el.style.transition = inactiveT;

            const update = () => {
                raf = null;
                const r = el.getBoundingClientRect();
                const cx = r.left + r.width / 2;
                const cy = r.top + r.height / 2;
                const dx = mx - cx;
                const dy = my - cy;
                const inside = Math.abs(dx) < r.width / 2 + padding && Math.abs(dy) < r.height / 2 + padding;

                if (inside) {
                    if (!active) { active = true; el.style.transition = activeT; }
                    el.style.transform = `translate3d(${dx / strength}px, ${dy / strength}px, 0)`;
                } else if (active) {
                    active = false;
                    el.style.transition = inactiveT;
                    el.style.transform = 'translate3d(0, 0, 0)';
                }
            };

            window.addEventListener('mousemove', (e) => {
                mx = e.clientX;
                my = e.clientY;
                if (!raf) raf = requestAnimationFrame(update);
            }, { passive: true });
        });
    }

    /* Marquee: two rows slide in opposite directions with page scroll.
       offset = (scrollY - sectionTop + innerHeight) * 0.3
       row 1 -> translateX(offset - 200), row 2 -> translateX(-(offset - 200)) */
    function initJackMarquee() {
        const section = document.querySelector('[data-marquee]');
        if (!section) return;
        const right = section.querySelector('[data-marquee-row="right"]');
        const left = section.querySelector('[data-marquee-row="left"]');
        if (jackReduced()) return;

        let top = docTop(section);
        window.addEventListener('resize', () => { top = docTop(section); });
        window.addEventListener('load', () => { top = docTop(section); });

        jackOnScroll(() => {
            const offset = (window.scrollY - top + window.innerHeight) * 0.3;
            if (right) right.style.transform = `translate3d(${offset - 200}px, 0, 0)`;
            if (left) left.style.transform = `translate3d(${-(offset - 200)}px, 0, 0)`;
        });
    }

    /* AnimatedText: wraps every character in an invisible placeholder plus
       an absolutely positioned copy whose opacity goes .2 -> 1 as scroll
       progress passes it. useScroll offset ['start 0.8', 'end 0.2']:
       progress 0 when the top hits 80% of the viewport, 1 when the bottom
       hits 20%. Character i spans [i/n, (i+1)/n] of that progress. */
    function initJackAnimatedText() {
        const blocks = document.querySelectorAll('[data-animated-text]');
        if (!blocks.length) return;

        blocks.forEach((el) => {
            const text = el.textContent.replace(/\s+/g, ' ').trim();
            el.setAttribute('aria-label', text);
            el.textContent = '';

            const frag = document.createDocumentFragment();
            const fills = [];
            // keep words together so lines only break between words
            text.split(' ').forEach((word, wi, words) => {
                const w = document.createElement('span');
                w.style.whiteSpace = 'nowrap';
                w.setAttribute('aria-hidden', 'true');
                Array.from(word).forEach((ch) => {
                    const c = document.createElement('span');
                    c.className = 'jk-char';
                    const ghost = document.createElement('span');
                    ghost.className = 'jk-char-ghost';
                    ghost.textContent = ch;
                    const fill = document.createElement('span');
                    fill.className = 'jk-char-fill';
                    fill.textContent = ch;
                    c.append(ghost, fill);
                    w.appendChild(c);
                    fills.push(fill);
                });
                frag.appendChild(w);
                if (wi < words.length - 1) frag.appendChild(document.createTextNode(' '));
            });
            el.appendChild(frag);

            if (jackReduced()) { fills.forEach((f) => { f.style.opacity = 1; }); return; }

            const n = fills.length;
            let last = -1;
            jackOnScroll(() => {
                const r = el.getBoundingClientRect();
                const vh = window.innerHeight;
                // scroll distance between "top at 80% of viewport" (p = 0)
                // and "bottom at 20% of viewport" (p = 1)
                const startY = r.top - vh * 0.8;       // > 0 before the start point
                const span = r.height + vh * 0.6;      // (top + height - .2vh) - (top - .8vh)
                const p = clamp01(-startY / span);
                if (Math.abs(p - last) < 0.001) return;
                last = p;
                for (let i = 0; i < n; i++) {
                    const local = clamp01((p - i / n) * n);
                    fills[i].style.opacity = (0.2 + 0.8 * local).toFixed(3);
                }
            });
        });
    }

    /* Card stack: cards are sticky; while the stack scrolls past, each card
       scales from 1 toward its data-target-scale
       (1 - (total - 1 - index) * 0.03), like
       useTransform(scrollYProgress, [index / total, 1], [1, targetScale]). */
    function initJackCardStack() {
        const stack = document.querySelector('[data-card-stack]');
        if (!stack) return;
        const cards = Array.from(stack.querySelectorAll('.jk-card'));
        if (!cards.length || jackReduced()) return;

        const total = cards.length;
        jackOnScroll(() => {
            const r = stack.getBoundingClientRect();
            const vh = window.innerHeight;
            // offset ['start start', 'end end']
            const progress = clamp01(-r.top / Math.max(1, r.height - vh));
            cards.forEach((card, i) => {
                const target = parseFloat(card.dataset.targetScale) || 1;
                const from = i / total;
                const t = clamp01((progress - from) / Math.max(0.0001, 1 - from));
                card.style.transform = `scale(${(1 + (target - 1) * t).toFixed(4)})`;
            });
        });
    }

    /* Timeline: the rail fills as the track travels from the middle of the
       viewport to its end (motion useScroll offset ['start center',
       'end center']) and the dot rides the tip of the fill. */
    function initJackTimeline() {
        const track = document.querySelector('.pf-jack [data-timeline]');
        if (!track) return;
        const fill = track.querySelector('.jk-timeline-line-fill');
        if (!fill) return;
        const dot = track.querySelector('.jk-timeline-dot');

        const draw = (p) => {
            fill.style.transform = 'scaleY(' + p + ')';
            if (dot) dot.style.top = (p * 100) + '%';
        };

        if (jackReduced()) { draw(1); return; }

        // useScroll offset ['start center', 'end center']
        const readTarget = () => {
            const start = docTop(track) - window.innerHeight / 2;
            return clamp01((window.scrollY - start) / (track.offsetHeight || 1));
        };

        // useSpring: ease the drawn value toward the scroll value so the rail
        // and dot glide instead of stepping with each wheel tick. The loop
        // parks itself once it has caught up.
        const APPROACH = 0.16;
        let target = readTarget();
        let cur = target;
        let raf = 0;

        const tick = () => {
            cur += (target - cur) * APPROACH;
            if (Math.abs(target - cur) < 0.0005) { cur = target; raf = 0; draw(cur); return; }
            draw(cur);
            raf = requestAnimationFrame(tick);
        };

        jackOnScroll(() => {
            target = readTarget();
            if (!raf) raf = requestAnimationFrame(tick);
        });
    }

    /* ==================================================================
       index-4.html (Attorna, lawyer & attorney)
       Each init bails out when its elements are absent, so the other
       pages are untouched.
       ================================================================== */

    /* Header goes solid once the page leaves the hero. */
    function initAttornaHeader() {
        const header = document.querySelector('.pf-attorna [data-header]');
        if (!header) return;
        const sync = () => header.classList.toggle('is-stuck', window.scrollY > 40);
        sync();
        window.addEventListener('scroll', sync, { passive: true });
    }

    /* Off-canvas menu. */
    function initAttornaDrawer() {
        const drawer = document.querySelector('.pf-attorna [data-drawer]');
        const burger = document.querySelector('.pf-attorna [data-burger]');
        if (!drawer || !burger) return;

        const setOpen = (open) => {
            drawer.classList.toggle('is-open', open);
            burger.setAttribute('aria-expanded', String(open));
            drawer.setAttribute('aria-hidden', String(!open));
            document.body.style.overflow = open ? 'hidden' : '';
        };

        burger.addEventListener('click', () => setOpen(burger.getAttribute('aria-expanded') !== 'true'));
        drawer.addEventListener('click', (e) => { if (e.target.closest('a')) setOpen(false); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
        window.addEventListener('resize', () => { if (window.innerWidth >= 992) setOpen(false); });
    }

    /* Count-up stats. Animates once, the first time the block is in view. */
    function initAttornaCounters() {
        const nums = document.querySelectorAll('.pf-attorna [data-count]');
        if (!nums.length) return;

        const run = (el) => {
            const target = parseFloat(el.dataset.count) || 0;
            const dur = 1600;
            const start = performance.now();
            const step = (now) => {
                const p = Math.min(1, (now - start) / dur);
                const eased = 1 - Math.pow(1 - p, 3);   // easeOutCubic
                const val = Math.round(target * eased);
                el.textContent = val >= 1000 ? val.toLocaleString('en-US') : String(val);
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        };

        if (!('IntersectionObserver' in window)) { nums.forEach((el) => { el.textContent = Number(el.dataset.count).toLocaleString('en-US'); }); return; }

        const io = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                run(entry.target);
                obs.unobserve(entry.target);
            });
        }, { threshold: .5 });
        nums.forEach((el) => io.observe(el));
    }

    /* Contact form: local, no backend — validate and confirm inline. */
    function initAttornaForm() {
        const form = document.querySelector('.pf-attorna [data-contact-form]');
        if (!form) return;
        const note = form.querySelector('[data-form-note]');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = form.querySelector('[name="name"]');
            const email = form.querySelector('[name="email"]');
            if (!name.value.trim() || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email.value.trim())) {
                if (note) { note.hidden = false; note.textContent = 'Please add your name and a valid email.'; }
                (!name.value.trim() ? name : email).focus();
                return;
            }
            if (note) { note.hidden = false; note.textContent = 'Thanks, ' + name.value.trim() + '. We will be in touch shortly.'; }
            form.reset();
        });
    }

    /* Back-to-top button. */
    function initAttornaToTop() {
        const btn = document.querySelector('.pf-attorna [data-to-top]');
        if (!btn) return;
        const sync = () => btn.classList.toggle('is-visible', window.scrollY > 600);
        sync();
        window.addEventListener('scroll', sync, { passive: true });
        btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    /* Hero dot navigation: highlight the dot for the section in view. */
    function initAttornaScrollSpy() {
        const dots = document.querySelectorAll('.pf-attorna .at-hero-dots a');
        if (!dots.length) return;
        const sections = Array.from(dots).map((a) => {
            const el = document.getElementById(a.getAttribute('href').slice(1));
            return el ? { a, el } : null;
        }).filter(Boolean);
        if (!sections.length) return;

        const sync = () => {
            const mid = window.scrollY + window.innerHeight * 0.4;
            let current = sections[0];
            sections.forEach((s) => { if (s.el.offsetTop <= mid) current = s; });
            sections.forEach((s) => s.a.classList.toggle('is-active', s === current));
        };

        sync();
        window.addEventListener('scroll', sync, { passive: true });
        window.addEventListener('resize', sync);
    }

    /* ---------- Law portfolio (index-6.html) ----------
       Header progress, mobile navigation, focus trap and active section nav.
       Reveal + year are handled by initReveal() / initYear(). */
    function initLawPortfolio() {
        const header = document.getElementById('site-header');
        const progressBar = document.getElementById('scroll-progress-bar');
        const menu = document.getElementById('mobile-menu');
        const menuToggle = document.querySelector('.menu-toggle');
        if (!header && !menu) return;

        const menuPanel = menu ? menu.querySelector('.mobile-menu__panel') : null;
        let lastFocusedElement = null;

        const updateScrollUI = () => {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            const scrollable = document.documentElement.scrollHeight - window.innerHeight;
            const progress = scrollable > 0 ? Math.min(scrollTop / scrollable, 1) : 0;

            if (header) header.classList.toggle('is-scrolled', scrollTop > 24);
            if (progressBar) progressBar.style.transform = `scaleX(${progress})`;
        };

        window.addEventListener('scroll', updateScrollUI, { passive: true });
        window.addEventListener('resize', updateScrollUI);
        updateScrollUI();

        const openMenu = () => {
            if (!menu || !menuToggle) return;

            lastFocusedElement = document.activeElement;
            menu.inert = false;
            menu.classList.add('is-open');
            menu.setAttribute('aria-hidden', 'false');
            menuToggle.setAttribute('aria-expanded', 'true');
            menuToggle.setAttribute('aria-label', 'Close navigation menu');
            document.body.classList.add('menu-open');
            if (window.pfLenis) window.pfLenis.stop();

            const closeButton = menu.querySelector('.menu-close');
            if (closeButton) setTimeout(() => closeButton.focus(), 60);
        };

        const closeMenu = (returnFocus = true) => {
            if (!menu || !menuToggle) return;

            menu.classList.remove('is-open');
            menu.setAttribute('aria-hidden', 'true');
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Open navigation menu');
            document.body.classList.remove('menu-open');
            if (window.pfLenis) window.pfLenis.start();

            setTimeout(() => { menu.inert = true; }, 560);

            if (returnFocus !== false) {
                const target = lastFocusedElement || menuToggle;
                target.focus();
            }
        };

        const trapMenuFocus = (event) => {
            if (!menuPanel || event.key !== 'Tab') return;

            const focusable = menuPanel.querySelectorAll(
                'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            if (!focusable.length) return;

            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        };

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                if (menu && menu.classList.contains('is-open')) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });
        }

        if (menu) {
            menu.addEventListener('click', (event) => {
                if (event.target.closest('[data-menu-close]')) {
                    closeMenu();
                    return;
                }

                if (event.target.closest('a')) {
                    closeMenu(false);
                }
            });
        }

        document.addEventListener('keydown', (event) => {
            if (!menu || !menu.classList.contains('is-open')) return;

            if (event.key === 'Escape') {
                closeMenu();
            } else {
                trapMenuFocus(event);
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 980 && menu && menu.classList.contains('is-open')) {
                closeMenu(false);
            }
        });

        const navLinks = Array.from(document.querySelectorAll('.nav__link'));
        const navSections = navLinks
            .map((link) => document.querySelector(link.getAttribute('href')))
            .filter(Boolean);

        const setActiveLink = (id) => {
            navLinks.forEach((link) => {
                if (link.getAttribute('href') === `#${id}`) {
                    link.setAttribute('aria-current', 'true');
                } else {
                    link.removeAttribute('aria-current');
                }
            });
        };

        if ('IntersectionObserver' in window && navSections.length) {
            const navObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) setActiveLink(entry.target.id);
                });
            }, { rootMargin: '-38% 0px -52% 0px', threshold: 0 });

            navSections.forEach((section) => navObserver.observe(section));
        }
    }

    /* ==================================================================
       index-7.html (Marcus Bennet - business analytics student)
       Header state, scroll progress, scroll-spy nav, mobile menu with
       focus trap and the [data-reveal] entrance animations.
       ================================================================== */
    function initIndex7() {
        // index-7.html only - the full-screen menu panel exists nowhere else,
        // so the shared pages keep their own header / progress / nav logic
        if (!document.querySelector('[data-menu-panel]')) return;

        var root = document.documentElement;
        var body = document.body;
        var header = document.querySelector('[data-header]');
        var progress = document.querySelector('[data-progress]');
        var menuToggle = document.querySelector('[data-menu-toggle]');
        var menuPanel = document.querySelector('[data-menu-panel]');
        var navLinks = Array.prototype.slice.call(document.querySelectorAll('.site-nav a[href^="#"]'));
        var menuLinks = Array.prototype.slice.call(document.querySelectorAll('[data-menu-link]'));
        var yearNodes = document.querySelectorAll('[data-year]');
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        var lastFocused = null;
        var menuOpen = false;
        var ticking = false;

        function setYear() {
            var year = new Date().getFullYear();
            yearNodes.forEach(function (node) {
                node.textContent = year;
            });
        }

        function setHeaderState() {
            if (!header) return;
            header.classList.toggle('is-scrolled', window.scrollY > 24);
        }

        function setProgress() {
            if (!progress) return;
            var docHeight = document.documentElement.scrollHeight - window.innerHeight;
            var value = docHeight > 0 ? Math.min(window.scrollY / docHeight, 1) : 0;
            progress.style.transform = 'scaleX(' + value + ')';
        }

        function setActiveNav() {
            if (!navLinks.length) return;

            var marker = window.innerHeight * 0.34;
            var currentId = '';

            navLinks.forEach(function (link) {
                var id = link.getAttribute('href').slice(1);
                var section = document.getElementById(id);
                if (!section) return;
                if (section.getBoundingClientRect().top <= marker) {
                    currentId = id;
                }
            });

            if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 4) {
                currentId = 'contact';
            }

            navLinks.forEach(function (link) {
                if (currentId && link.getAttribute('href') === '#' + currentId) {
                    link.setAttribute('aria-current', 'true');
                } else {
                    link.removeAttribute('aria-current');
                }
            });
        }

        function updateOnScroll() {
            setHeaderState();
            setProgress();
            setActiveNav();
            ticking = false;
        }

        function requestScrollUpdate() {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(updateOnScroll);
        }

        function getFocusableItems() {
            if (!menuPanel || !menuToggle) return [];
            var panelItems = Array.prototype.slice.call(
                menuPanel.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])')
            ).filter(function (item) {
                return item.offsetParent !== null;
            });
            return [menuToggle].concat(panelItems);
        }

        function openMenu() {
            if (!menuPanel || !menuToggle || menuOpen) return;
            lastFocused = document.activeElement;
            menuOpen = true;
            body.classList.add('menu-open');
            menuToggle.setAttribute('aria-expanded', 'true');
            menuToggle.setAttribute('aria-label', 'Close menu');
            menuPanel.setAttribute('aria-hidden', 'false');
            menuPanel.inert = false;

            window.requestAnimationFrame(function () {
                var firstLink = menuPanel.querySelector('[data-menu-link]');
                if (firstLink) firstLink.focus();
            });

            document.addEventListener('keydown', onMenuKeydown);
        }

        function closeMenu(returnFocus) {
            if (!menuPanel || !menuToggle || !menuOpen) return;
            menuOpen = false;
            body.classList.remove('menu-open');
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Open menu');
            menuPanel.setAttribute('aria-hidden', 'true');
            menuPanel.inert = true;
            document.removeEventListener('keydown', onMenuKeydown);

            if (returnFocus !== false && lastFocused && typeof lastFocused.focus === 'function') {
                lastFocused.focus();
            }
        }

        function onMenuKeydown(event) {
            if (event.key === 'Escape') {
                event.preventDefault();
                closeMenu(true);
                return;
            }

            if (event.key !== 'Tab') return;

            var items = getFocusableItems();
            if (!items.length) return;

            var first = items[0];
            var last = items[items.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }

        if (menuPanel) {
            menuPanel.inert = true;
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', function () {
                if (menuOpen) {
                    closeMenu(true);
                } else {
                    openMenu();
                }
            });
        }

        menuLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                closeMenu(false);
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 980 && menuOpen) {
                closeMenu(false);
            }  
            requestScrollUpdate();
        });

        window.addEventListener('scroll', requestScrollUpdate, { passive: true });

        if ('IntersectionObserver' in window) {
            var revealItems = document.querySelectorAll('[data-reveal]');

            if (reduceMotion.matches) {
                revealItems.forEach(function (item) {
                    item.classList.add('is-visible');
                });
            } else {
                var revealObserver = new IntersectionObserver(function (entries, observer) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    });
                }, {
                    threshold: 0.12,
                    rootMargin: '0px 0px -7% 0px'
                });

                revealItems.forEach(function (item) {
                    revealObserver.observe(item);
                });
            }
        } else {
            document.querySelectorAll('[data-reveal]').forEach(function (item) {
                item.classList.add('is-visible');
            });
        }

        if (typeof reduceMotion.addEventListener === 'function') {
            reduceMotion.addEventListener('change', function (event) {
                if (!event.matches) return;
                document.querySelectorAll('[data-reveal]').forEach(function (item) {
                    item.classList.add('is-visible');
                });
            });
        }

        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function () {
                var hash = link.getAttribute('href');
                if (!hash || hash === '#') return;
                var target = document.querySelector(hash);
                if (!target) return;
                if (!target.hasAttribute('tabindex')) {
                    target.setAttribute('tabindex', '-1');
                }
                window.setTimeout(function () {
                    target.focus({ preventScroll: true });
                }, 650);
            });
        });

        root.classList.add('js');
        setYear();
        setHeaderState();
        setProgress();
        setActiveNav();
    }

    /* ---------- Boot ---------- */
    document.documentElement.classList.remove('no-js');
    $(function () {
        initSmoothScroll();
        initTheme();
        initDrawer();
        initReveal();
        initAccordion();
        initWorkPreview();
        initRevealText();
        initDataBackground();
        initYear();
        initWow();
        // index-2.html (resume + hero 26) — each is a no-op when its
        // elements are missing, so index.html is unaffected
        initH26Reveal();
        initH26Drawer();
        initPrintResume();
        initContactForm();
        // index-3.html (Jack, 3D creator)
        initJackFadeIn();
        initJackMagnet();
        initJackMarquee();
        initJackAnimatedText();
        initJackCardStack();
        initJackTimeline();
        // index-4.html (Attorna, lawyer & attorney)
        initAttornaHeader();
        initAttornaDrawer();
        initAttornaCounters();
        initAttornaForm();
        initAttornaToTop();
        initAttornaScrollSpy();
        // index-6.html (law student portfolio)
        initLawPortfolio();
        // index-7.html (Marcus Bennet)
        initIndex7();
    });
})(jQuery);
