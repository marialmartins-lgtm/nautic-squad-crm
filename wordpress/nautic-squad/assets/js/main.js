/**
 * Nautic Squad — interações (sem dependências).
 * - cabeçalho que muda ao fazer scroll + menu móvel
 * - animações de entrada (classe .reveal) e títulos palavra a palavra (.ns-split-text)
 * - contadores animados ([data-count])
 * - parallax suave no hero, barra de progresso, botão "voltar ao topo"
 * - bolhas decorativas no hero
 */
(function () {
	'use strict';

	var doc = document.documentElement;
	doc.classList.add('ns-js');

	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var header = document.querySelector('.ns-header');
	var progress = document.querySelector('.ns-progress');
	var toTop = document.querySelector('.ns-totop');
	var heroMedia = document.querySelector('.ns-hero__media img, .ns-hero__media video');

	/* Scroll: cabeçalho, progresso, topo, parallax --------------------------- */
	var ticking = false;
	function onScroll() {
		var y = window.scrollY;
		if (header) header.classList.toggle('is-scrolled', y > 40);
		if (toTop) toTop.classList.toggle('is-visible', y > 700);
		if (progress) {
			var max = document.documentElement.scrollHeight - window.innerHeight;
			progress.style.transform = 'scaleX(' + (max > 0 ? y / max : 0) + ')';
		}
		if (heroMedia && !reduceMotion && y < window.innerHeight) {
			heroMedia.style.transform = 'scale(1.08) translateY(' + y * 0.25 + 'px)';
		}
		ticking = false;
	}
	window.addEventListener('scroll', function () {
		if (!ticking) { window.requestAnimationFrame(onScroll); ticking = true; }
	}, { passive: true });
	onScroll();

	if (toTop) toTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });

	/* Menu móvel ------------------------------------------------------------- */
	var burger = document.querySelector('.ns-burger');
	if (burger && header) {
		burger.addEventListener('click', function () {
			var open = header.classList.toggle('is-open');
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
			document.body.style.overflow = open ? 'hidden' : '';
		});
		header.querySelectorAll('.ns-nav a').forEach(function (a) {
			a.addEventListener('click', function () {
				header.classList.remove('is-open');
				burger.setAttribute('aria-expanded', 'false');
				document.body.style.overflow = '';
			});
		});
	}

	/* Títulos palavra a palavra --------------------------------------------- */
	document.querySelectorAll('.ns-split-text').forEach(function (el) {
		var i = 0;
		function wrap(node) {
			Array.prototype.slice.call(node.childNodes).forEach(function (child) {
				if (child.nodeType === 3) {
					var frag = document.createDocumentFragment();
					child.textContent.split(/(\s+)/).forEach(function (part) {
						if (!part) return;
						if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(part)); return; }
						var w = document.createElement('span');
						w.className = 'w';
						var inner = document.createElement('span');
						inner.style.setProperty('--i', i++);
						inner.textContent = part;
						w.appendChild(inner);
						frag.appendChild(w);
					});
					child.parentNode.replaceChild(frag, child);
				} else if (child.nodeType === 1) {
					wrap(child);
				}
			});
		}
		wrap(el);
		el.classList.add('reveal-text');
	});

	/* Contadores ------------------------------------------------------------- */
	function countUp(el) {
		var target = parseFloat(el.getAttribute('data-count'));
		var dur = 1800;
		var start = null;
		if (reduceMotion || isNaN(target)) { el.textContent = el.getAttribute('data-count'); return; }
		function step(ts) {
			if (!start) start = ts;
			var p = Math.min((ts - start) / dur, 1);
			var eased = 1 - Math.pow(1 - p, 4);
			el.textContent = Math.round(target * eased).toLocaleString('pt-PT');
			if (p < 1) window.requestAnimationFrame(step);
		}
		window.requestAnimationFrame(step);
	}

	/* Entrada ao scroll ------------------------------------------------------ */
	var targets = document.querySelectorAll('.reveal, .ns-split-text, [data-count]');
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				var el = entry.target;
				el.classList.add('is-visible');
				if (el.hasAttribute('data-count')) countUp(el);
				io.unobserve(el);
			});
		}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
		targets.forEach(function (el) { io.observe(el); });
	} else {
		targets.forEach(function (el) { el.classList.add('is-visible'); });
	}

	/* Atraso em cascata para grelhas (.reveal-stagger > *) ------------------- */
	document.querySelectorAll('.reveal-stagger').forEach(function (group) {
		Array.prototype.forEach.call(group.querySelectorAll(':scope > *, :scope > .wp-block-post-template > *'), function (child, idx) {
			child.classList.add('reveal');
			child.style.setProperty('--d', (idx * 0.1) + 's');
			if (io) io.observe(child); else child.classList.add('is-visible');
		});
	});

	/* Bolhas no hero --------------------------------------------------------- */
	var bubbles = document.querySelector('.ns-bubbles');
	if (bubbles && !reduceMotion) {
		for (var b = 0; b < 14; b++) {
			var s = document.createElement('span');
			var size = 6 + Math.random() * 22;
			s.style.width = s.style.height = size + 'px';
			s.style.left = Math.random() * 100 + '%';
			s.style.animationDuration = 10 + Math.random() * 14 + 's';
			s.style.animationDelay = -Math.random() * 20 + 's';
			bubbles.appendChild(s);
		}
	}
})();
