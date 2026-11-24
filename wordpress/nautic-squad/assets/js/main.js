/**
 * Nautic Squad — interações cinematográficas (sem dependências além do Lenis).
 */
(function () {
	'use strict';

	var root = document.documentElement;
	root.classList.add('ns-js');
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

	/* Preloader ----------------------------------------------------------- */
	function loaded() { root.classList.add('is-loaded'); }
	if (document.readyState === 'complete') setTimeout(loaded, 900);
	else window.addEventListener('load', function () { setTimeout(loaded, 900); });
	setTimeout(loaded, 2500); // nunca bloquear o site

	/* Imagens que falham: esconder o ícone partido (fica o fundo escuro) */
	$$('img').forEach(function (img) {
		function fail() { img.classList.add('ns-img-failed'); }
		if (img.complete && img.naturalWidth === 0 && img.getAttribute('src')) fail();
		else img.addEventListener('error', fail);
	});

	/* Imagens de fundo -> camada animável (para zoom/parallax) ------------- */
	$$('.ns-media').forEach(function (el) {
		var bg = el.style.backgroundImage;
		if (!bg || bg === 'none') return;
		var layer = document.createElement('div');
		layer.className = 'ns-media__layer';
		layer.style.backgroundImage = bg;
		el.style.backgroundImage = '';
		el.insertBefore(layer, el.firstChild);
		layer.setAttribute('data-speed', el.getAttribute('data-speed') || '0.25');
	});

	/* Divide títulos em palavras ----------------------------------------- */
	function splitWords(el, cls, innerTag) {
		var i = 0;
		(function walk(node) {
			Array.prototype.slice.call(node.childNodes).forEach(function (n) {
				if (n.nodeType === 3) {
					var frag = document.createDocumentFragment();
					n.textContent.split(/(\s+)/).forEach(function (part) {
						if (!part) return;
						if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(' ')); return; }
						var w = document.createElement('span');
						w.className = cls;
						if (innerTag) {
							var s = document.createElement('span');
							s.style.setProperty('--i', i);
							s.textContent = part;
							w.appendChild(s);
						} else {
							w.textContent = part;
						}
						i++;
						frag.appendChild(w);
					});
					n.parentNode.replaceChild(frag, n);
				} else if (n.nodeType === 1 && n.tagName !== 'BR') {
					walk(n);
				}
			});
		})(el);
	}
	$$('.ns-split').forEach(function (el) { splitWords(el, 'w', true); });
	$$('.ns-manifesto__text').forEach(function (el) { splitWords(el, 'mw', false); });

	/* Entradas ao scroll -------------------------------------------------- */
	var io = 'IntersectionObserver' in window ? new IntersectionObserver(function (entries) {
		entries.forEach(function (e) {
			if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
		});
	}, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }) : null;
	$$('.reveal-stagger').forEach(function (g) {
		$$(':scope > *, :scope > .wp-block-post-template > *', g).forEach(function (c, n) {
			c.classList.add('reveal'); c.style.setProperty('--d', (n * 0.12) + 's');
		});
	});
	$$('.reveal, .ns-split, .ns-reveal-img, .ns-media').forEach(function (el) {
		if (io) io.observe(el); else el.classList.add('is-visible');
	});

	/* Smooth scroll (Lenis) ------------------------------------------------ */
	var lenis = null;
	if (window.Lenis && !reduce) {
		lenis = new window.Lenis({ duration: 1.25, easing: function (t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); } });
		(function raf(t) { lenis.raf(t); requestAnimationFrame(raf); })(0);
	}
	$$('a[href^="#"]').forEach(function (a) {
		a.addEventListener('click', function (ev) {
			var id = a.getAttribute('href');
			if (id.length < 2) return;
			var t = document.querySelector(id);
			if (!t) return;
			ev.preventDefault();
			closeMenu();
			if (lenis) lenis.scrollTo(t, { offset: 0, duration: 1.6 }); else t.scrollIntoView({ behavior: 'smooth' });
		});
	});

	/* Menu ecrã inteiro (pré-visualização) ------------------------------- */
	function closeMenu() { root.classList.remove('ns-menu-open'); if (lenis) lenis.start(); }
	$$('[data-menu-toggle]').forEach(function (b) {
		b.addEventListener('click', function () {
			var open = root.classList.toggle('ns-menu-open');
			if (lenis) { if (open) lenis.stop(); else lenis.start(); }
		});
	});
	document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMenu(); });

	/* Elementos dependentes do scroll ------------------------------------- */
	var header = $('.ns-header');
	var lastY = 0;
	var layers = $$('[data-speed]');
	var manifestos = $$('.ns-manifesto__text');
	var hscrolls = $$('.ns-hscroll');
	var stepsBlocks = $$('.ns-steps');

	function setupH() {
		hscrolls.forEach(function (sec) {
			var track = $('.ns-track', sec);
			if (!track) return;
			if (window.innerWidth <= 900) { sec.style.height = ''; return; }
			var dist = Math.max(0, track.scrollWidth - window.innerWidth);
			sec._dist = dist;
			sec.style.height = (window.innerHeight + dist) + 'px';
		});
	}
	setupH();
	window.addEventListener('resize', setupH);
	window.addEventListener('load', setupH);

	function frame() {
		var y = window.scrollY, vh = window.innerHeight;

		if (header) {
			header.classList.toggle('is-scrolled', y > 60);
			if (Math.abs(y - lastY) > 6) {
				header.classList.toggle('is-hidden', y > lastY && y > vh * 0.8 && !root.classList.contains('ns-menu-open'));
				lastY = y;
			}
		}

		if (!reduce) {
			layers.forEach(function (l) {
				var r = l.parentNode.getBoundingClientRect();
				if (r.bottom < 0 || r.top > vh) return;
				var sp = parseFloat(l.getAttribute('data-speed')) || 0.2;
				var off = (r.top + r.height / 2 - vh / 2) * -sp;
				l.style.translate = '0 ' + off.toFixed(1) + 'px';
			});
		}

		manifestos.forEach(function (m) {
			var r = m.getBoundingClientRect();
			var p = Math.min(1, Math.max(0, (vh * 0.85 - r.top) / (r.height + vh * 0.35)));
			var words = m._w || (m._w = $$('.mw', m));
			var lit = Math.round(p * words.length);
			words.forEach(function (w, i) { w.classList.toggle('on', i < lit); });
		});

		hscrolls.forEach(function (sec) {
			var track = $('.ns-track', sec);
			if (!track || window.innerWidth <= 900 || !sec._dist) return;
			var r = sec.getBoundingClientRect();
			var p = Math.min(1, Math.max(0, -r.top / (sec.offsetHeight - vh)));
			track.style.transform = 'translate3d(' + (-p * sec._dist).toFixed(1) + 'px,0,0)';
			var bar = $('.ns-hscroll__progress', sec);
			if (bar) bar.style.setProperty('--p', p.toFixed(3));
		});

		stepsBlocks.forEach(function (b) {
			var steps = $$('.ns-step', b);
			var figs = $$('.ns-steps__media figure', b);
			var media = $('.ns-steps__media', b);
			var active = 0;
			steps.forEach(function (s, i) { if (s.getBoundingClientRect().top < vh * 0.55) active = i; });
			steps.forEach(function (s, i) { s.classList.toggle('is-active', i === active); });
			figs.forEach(function (f, i) { f.classList.toggle('is-active', i === Math.min(active, figs.length - 1)); });
			if (media) media.setAttribute('data-count', '0' + (active + 1) + ' / 0' + steps.length);
		});

		requestAnimationFrame(frame);
	}
	requestAnimationFrame(frame);

	/* Cursor --------------------------------------------------------------- */
	if (window.matchMedia('(hover: hover)').matches && !reduce) {
		var c = document.createElement('div');
		c.className = 'ns-cursor';
		document.body.appendChild(c);
		var mx = 0, my = 0, cx = 0, cy = 0;
		window.addEventListener('mousemove', function (e) { mx = e.clientX; my = e.clientY; c.classList.add('is-on'); });
		document.addEventListener('mouseleave', function () { c.classList.remove('is-on'); });
		(function loop() {
			cx += (mx - cx) * 0.18; cy += (my - cy) * 0.18;
			c.style.transform = 'translate3d(' + cx + 'px,' + cy + 'px,0)';
			requestAnimationFrame(loop);
		})();
		document.addEventListener('mouseover', function (e) {
			var t = e.target;
			c.classList.toggle('is-drag', !!t.closest('.ns-boat'));
			c.classList.toggle('is-hover', !t.closest('.ns-boat') && !!t.closest('a, button, summary, input, select, textarea'));
		});
	}
})();
