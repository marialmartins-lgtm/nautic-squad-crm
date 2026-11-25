/* Nautic Squad — protótipo v6 · interações (JavaScript sem dependências) */
(function () {
	'use strict';
	var d = document, root = d.documentElement;
	root.classList.add('js');
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var $ = function (s, c) { return (c || d).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || d).querySelectorAll(s)); };
	var IMG = window.NS_IMG || {};
	var UI = window.NS_UI || {};
	var hdr = $('.hdr');

	/* Imagens: carregadas quando a página/elemento fica visível ------------ */
	function hydrate(scope) {
		$$('img[data-img]', scope).forEach(function (im) {
			if (im.getAttribute('src')) return;
			var k = im.getAttribute('data-img');
			if (IMG[k]) {
				im.addEventListener('load', function () { im.classList.add('is-loaded'); }, { once: true });
				im.src = IMG[k];
			}
		});
	}
	var lazyIO = 'IntersectionObserver' in window ? new IntersectionObserver(function (es) {
		es.forEach(function (e) { if (e.isIntersecting) { hydrate(e.target.parentNode || e.target); lazyIO.unobserve(e.target); } });
	}, { rootMargin: '600px 0px' }) : null;

	/* Texto palavra a palavra ---------------------------------------------- */
	function splitText(el) {
		if (el.dataset.split) return; el.dataset.split = 1;
		var i = 0;
		(function walk(n) {
			Array.prototype.slice.call(n.childNodes).forEach(function (c) {
				if (c.nodeType === 3) {
					var f = d.createDocumentFragment();
					c.textContent.split(/(\s+)/).forEach(function (p) {
						if (!p) return;
						if (/^\s+$/.test(p)) { f.appendChild(d.createTextNode(' ')); return; }
						var w = d.createElement('span'); w.className = 'w';
						var s = d.createElement('span'); s.style.setProperty('--i', i++); s.textContent = p;
						w.appendChild(s); f.appendChild(w);
					});
					c.parentNode.replaceChild(f, c);
				} else if (c.nodeType === 1) walk(c);
			});
		})(el);
	}
	var revIO = 'IntersectionObserver' in window ? new IntersectionObserver(function (es) {
		es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); revIO.unobserve(e.target); } });
	}, { threshold: .12, rootMargin: '0px 0px -6% 0px' }) : null;

	function activate(page) {
		$$('.tl', page).forEach(splitText);
		$$('.rv, .ri, .tl', page).forEach(function (el) {
			if (revIO && !reduce) revIO.observe(el); else el.classList.add('is-in');
		});
		hydrate($('.hero', page) || page);
		$$('img[data-img]', page).forEach(function (im) { if (lazyIO) lazyIO.observe(im); else hydrate(page); });
		page.__sliders && page.__sliders.forEach(function (s) { s.update(); });
		howSetup(page);
	}

	/* Router (hash) -------------------------------------------------------- */
	var pages = $$('.page');
	var current = null;
	function go() {
		var h = decodeURIComponent(location.hash.replace(/^#\/?/, ''));
		var path = h.replace(/\/$/, '');
		var page = null, rest = '';
		pages.forEach(function (p) {
			var r = p.dataset.route;
			if (r && (path === r || path.indexOf(r + '/') === 0) && (!page || r.length > page.dataset.route.length)) page = p;
		});
		if (!page) page = pages.filter(function (p) { return p.dataset.route === ''; })[0];
		rest = page && page.dataset.route ? path.slice(page.dataset.route.length + 1) : path;
		if (!page) page = pages[0];
		if (page !== current) {
			pages.forEach(function (p) { p.classList.toggle('is-active', p === page); });
			current = page;
			var lang = page.dataset.lang;
			root.lang = lang === 'en' ? 'en' : 'pt-PT';
			d.title = page.dataset.title;
			$$('[data-lang-ui]').forEach(function (el) { el.hidden = el.getAttribute('data-lang-ui') !== lang; });
			$$('.lang a').forEach(function (a) { a.setAttribute('aria-current', a.dataset.l === lang ? 'true' : 'false'); var alt = page.dataset['alt' + a.dataset.l]; if (alt !== undefined) a.href = '#/' + alt; });
			hdr.classList.toggle('has-hero', !!$('.hero', page));
			activate(page);
			window.scrollTo(0, 0);
		}
		closeMenu();
		if (rest) {
			var t = page.querySelector('#' + CSS.escape(rest.split('/').pop()));
			if (t) setTimeout(function () { t.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth' }); }, 60);
		}
		onScroll();
	}
	window.addEventListener('hashchange', go);

	/* Cabeçalho ------------------------------------------------------------- */
	var lastY = 0, mbar = $('.mbar');
	function onScroll() {
		var y = window.scrollY;
		var hasHero = current && $('.hero', current);
		hdr.classList.toggle('is-solid', !hasHero || y > window.innerHeight * .6 - 80);
		if (Math.abs(y - lastY) > 8) { hdr.classList.toggle('is-hidden', y > lastY && y > window.innerHeight); lastY = y; }
		if (mbar) mbar.classList.toggle('is-on', y > window.innerHeight * .5);
		howScroll();
	}
	window.addEventListener('scroll', function () { requestAnimationFrame(onScroll); }, { passive: true });

	/* Menu em ecrã inteiro --------------------------------------------------- */
	var mnu = $('.mnu'), lastFocus = null;
	function openMenu() { lastFocus = d.activeElement; mnu.classList.add('is-open'); mnu.setAttribute('aria-hidden', 'false'); d.body.style.overflow = 'hidden'; hydrate(mnu); var f = $('.mnu__main:not([hidden])', mnu); setTimeout(function () { var a = $$('[data-lang-ui]:not([hidden]) .mnu__main', mnu)[0]; a && a.focus(); }, 300); }
	function closeMenu() { if (!mnu.classList.contains('is-open')) return; mnu.classList.remove('is-open'); mnu.setAttribute('aria-hidden', 'true'); d.body.style.overflow = ''; lastFocus && lastFocus.focus && lastFocus.focus(); }
	$$('[data-menu]').forEach(function (b) { b.addEventListener('click', openMenu); });
	$$('[data-menu-close]').forEach(function (b) { b.addEventListener('click', closeMenu); });
	$$('.mnu__item').forEach(function (it) {
		var key = it.dataset.img;
		function show() { $$('.mnu__aside img', mnu).forEach(function (im) { im.classList.toggle('is-on', im.dataset.key === key); }); }
		it.addEventListener('mouseenter', show); it.addEventListener('focusin', show);
	});

	/* Área de sócio (sem ligação real) ---------------------------------------- */
	var toast = $('.toast'), tt;
	$$('[data-socio]').forEach(function (b) {
		b.addEventListener('click', function (e) { e.preventDefault(); toast.classList.add('is-on'); clearTimeout(tt); tt = setTimeout(function () { toast.classList.remove('is-on'); }, 6000); });
	});

	/* Como funciona: imagem fixa + passos ------------------------------------ */
	function howSetup(page) {
		$$('.how', page).forEach(function (h) { h.__steps = $$('.step', h); h.__imgs = $$('.how__frame img', h); });
	}
	function howScroll() {
		if (!current) return;
		$$('.how', current).forEach(function (h) {
			var steps = h.__steps || [], imgs = h.__imgs || [], active = 0, vh = window.innerHeight;
			steps.forEach(function (s, i) { if (s.getBoundingClientRect().top < vh * .55) active = i; });
			if (h.__a === active) return; h.__a = active;
			steps.forEach(function (s, i) { s.classList.toggle('is-on', i === active); });
			imgs.forEach(function (im, i) { im.classList.toggle('is-on', i === active); });
			var im = imgs[active], fr = $('.how__frame', h);
			if (im && im.naturalWidth && fr) fr.style.aspectRatio = im.naturalWidth + ' / ' + im.naturalHeight;
			else if (im) im.addEventListener('load', function () { if (h.__a === active) fr.style.aspectRatio = im.naturalWidth + ' / ' + im.naturalHeight; }, { once: true });
			var bar = $('.how__track', h); if (bar) bar.style.setProperty('--p', (active + 1) / steps.length);
			var n = $('.how__n', h); if (n) n.textContent = ('0' + (active + 1)).slice(-2) + ' / ' + ('0' + steps.length).slice(-2);
		});
	}

	/* Frota: slider com arrastar, setas, progresso e filtros ------------------- */
	$$('[data-slider]').forEach(function (wrap) {
		var slider = $('.slider', wrap), track = $('.track', wrap), prev = $('[data-prev]', wrap), next = $('[data-next]', wrap);
		var bar = $('.progress__bar i', wrap), count = $('.progress__n', wrap);
		var x = 0, max = 0, start = 0, sx = 0, drag = false, moved = 0;
		function items() { return $$('.boat:not(.is-out)', track); }
		function clamp(v) { return Math.max(-max, Math.min(0, v)); }
		function update() {
			max = Math.max(0, track.scrollWidth - slider.clientWidth);
			x = clamp(x); track.style.transform = 'translate3d(' + x + 'px,0,0)';
			var p = max ? -x / max : 0, vis = Math.min(1, slider.clientWidth / Math.max(1, track.scrollWidth));
			if (bar) { bar.style.setProperty('--w', (vis * 100) + '%'); bar.style.setProperty('--x', (p * (1 / vis - 1) * 100) + '%'); }
			if (prev) prev.disabled = x >= 0; if (next) next.disabled = x <= -max;
			if (count) { var its = items(), idx = 0; its.forEach(function (it, i) { if (it.offsetLeft <= -x + 10) idx = i; }); count.textContent = ('0' + (idx + 1)).slice(-2) + ' / ' + ('0' + its.length).slice(-2); }
		}
		function step(dir) {
			var its = items(), target = -x;
			if (dir > 0) { var n = its.filter(function (it) { return it.offsetLeft > -x + 5; })[0]; target = n ? n.offsetLeft : max; }
			else { var p = its.filter(function (it) { return it.offsetLeft < -x - 5; }).pop(); target = p ? p.offsetLeft : 0; }
			x = clamp(-target); update();
		}
		prev && prev.addEventListener('click', function () { step(-1); });
		next && next.addEventListener('click', function () { step(1); });
		slider.addEventListener('pointerdown', function (e) { if (e.button !== 0) return; drag = true; moved = 0; sx = e.clientX; start = x; slider.classList.add('is-drag'); });
		window.addEventListener('pointermove', function (e) { if (!drag) return; var dx = e.clientX - sx; moved = Math.abs(dx); x = clamp(start + dx); track.style.transform = 'translate3d(' + x + 'px,0,0)'; });
		window.addEventListener('pointerup', function () { if (!drag) return; drag = false; slider.classList.remove('is-drag'); update(); });
		track.addEventListener('click', function (e) { if (moved > 6) { e.preventDefault(); e.stopPropagation(); } }, true);
		track.addEventListener('dragstart', function (e) { e.preventDefault(); });
		slider.setAttribute('tabindex', '0');
		slider.addEventListener('keydown', function (e) { if (e.key === 'ArrowRight') { step(1); e.preventDefault(); } if (e.key === 'ArrowLeft') { step(-1); e.preventDefault(); } });
		$$('.filters button', wrap).forEach(function (b) {
			b.addEventListener('click', function () {
				var g = b.dataset.group;
				$$('.filters button[data-group="' + g + '"]', wrap).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
				var f = {}; $$('.filters button[aria-pressed="true"]', wrap).forEach(function (o) { f[o.dataset.group] = o.dataset.v; });
				$$('.boat', track).forEach(function (it) {
					var ok = (!f.club || f.club === '*' || it.dataset.club === f.club) && (!f.marina || f.marina === '*' || it.dataset.marina === f.marina);
					it.classList.toggle('is-out', !ok);
				});
				x = 0; hydrate(track); update();
				var live = $('.sr-live', wrap); if (live) live.textContent = items().length + ' ' + (UI.boatsShown || '');
			});
		});
		window.addEventListener('resize', update);
		var page = wrap.closest('.page'); (page.__sliders = page.__sliders || []).push({ update: update });
		$$('img', track).forEach(function (im) { im.addEventListener('load', update); });
		update();
	});

	/* Modalidades: filtros + questionário --------------------------------------- */
	$$('[data-types]').forEach(function (box) {
		$$('.types__tools button', box).forEach(function (b) {
			b.addEventListener('click', function () {
				$$('.types__tools button', box).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
				var v = b.dataset.v;
				$$('.tr', box).forEach(function (r) {
					var wk = +r.dataset.wk, we = +r.dataset.we;
					var ok = v === '*' || (v === 'wk' && wk > 0 && we === 0) || (v === 'we' && we > 0 && wk === 0) || (v === 'both' && wk > 0 && we > 0);
					r.classList.toggle('is-dim', !ok);
				});
			});
		});
	});
	var dlg = $('.dlg');
	function openDlg(lang) {
		$$('.dlg [data-lang-ui]').forEach(function (el) { el.hidden = el.getAttribute('data-lang-ui') !== lang; });
		dlg.classList.add('is-open'); d.body.style.overflow = 'hidden';
		setTimeout(function () { var f = $('.dlg [data-lang-ui]:not([hidden]) input', dlg); f && f.focus(); }, 200);
	}
	function closeDlg() { dlg.classList.remove('is-open'); d.body.style.overflow = ''; }
	$$('[data-quiz]').forEach(function (b) { b.addEventListener('click', function () { openDlg(b.dataset.quiz); }); });
	$$('[data-dlg-close]').forEach(function (b) { b.addEventListener('click', closeDlg); });
	dlg && dlg.addEventListener('click', function (e) { if (e.target === dlg) closeDlg(); });
	$$('.quiz').forEach(function (form) {
		var data = JSON.parse(form.dataset.rules);
		form.addEventListener('change', function () {
			var val = function (k) { var x = form.querySelector('[data-q="' + k + '"]:checked'); return x ? x.value : ''; };
			var when = val('when'), n = +val('num') || 0, team = val('team');
			var out = $('.result', form); if (!when || !n) { out.hidden = true; return; }
			var exact = data.types.filter(function (t) { return t.kind === when && t.n === n; });
			var near = exact.length ? [] : data.types.filter(function (t) { return t.kind === when || t.n === n; });
			var html = '';
			if (exact.length) html += exact.map(function (t) { return '<h4>' + t.name + '</h4>' + t.html; }).join('');
			else html += '<p><strong>' + data.ui.none + '</strong></p>' + near.map(function (t) { return '<h4>' + t.name + '</h4>' + t.html; }).join('');
			if (team === 'yes') html += '<h4>' + data.team.name + '</h4>' + data.team.html;
			html += '<small>' + data.ui.note + '</small>';
			out.innerHTML = html; out.hidden = false;
		});
	});

	/* Galeria: lightbox ------------------------------------------------------- */
	var lb = $('.lb'), lbImg = $('.lb__stage img', lb), lbCap = $('.lb__cap', lb), lbN = $('.lb__n', lb), set = [], pos = 0, lbFocus;
	function lbShow() { var it = set[pos]; lbImg.src = IMG[it.k] || ''; lbImg.alt = it.c; lbCap.textContent = it.c; lbN.textContent = (pos + 1) + ' / ' + set.length; }
	function lbOpen(group, i) { lbFocus = d.activeElement; set = group; pos = i; lbShow(); lb.classList.add('is-open'); d.body.style.overflow = 'hidden'; $('.lb__x', lb).focus(); }
	function lbClose() { lb.classList.remove('is-open'); d.body.style.overflow = ''; lbFocus && lbFocus.focus(); }
	d.addEventListener('click', function (e) {
		var f = e.target.closest('[data-lb]'); if (!f) return;
		var grp = $$('[data-lb="' + f.dataset.lb + '"]', f.closest('.page'));
		lbOpen(grp.map(function (g) { return { k: g.dataset.k, c: g.dataset.c }; }), grp.indexOf(f));
	});
	d.addEventListener('keydown', function (e) {
		if (e.key === 'Enter' && e.target.matches && e.target.matches('[data-lb]')) e.target.click();
		if (e.key === 'Escape') { if (lb.classList.contains('is-open')) lbClose(); else if (dlg.classList.contains('is-open')) closeDlg(); else closeMenu(); }
		if (lb.classList.contains('is-open')) { if (e.key === 'ArrowRight') { pos = (pos + 1) % set.length; lbShow(); } if (e.key === 'ArrowLeft') { pos = (pos - 1 + set.length) % set.length; lbShow(); } }
	});
	$('[data-lb-next]', lb).addEventListener('click', function () { pos = (pos + 1) % set.length; lbShow(); });
	$('[data-lb-prev]', lb).addEventListener('click', function () { pos = (pos - 1 + set.length) % set.length; lbShow(); });
	$('.lb__x', lb).addEventListener('click', lbClose);
	var tx = 0; $('.lb__stage', lb).addEventListener('touchstart', function (e) { tx = e.touches[0].clientX; }, { passive: true });
	$('.lb__stage', lb).addEventListener('touchend', function (e) { var dx = e.changedTouches[0].clientX - tx; if (Math.abs(dx) > 50) { pos = (pos + (dx < 0 ? 1 : -1) + set.length) % set.length; lbShow(); } });

	/* FAQ: separadores, pesquisa e acordeão animado ------------------------------- */
	$$('[data-faq]').forEach(function (box) {
		var tabs = $$('.tabs button', box), groups = $$('.faq-group', box), input = $('.search input', box), cnt = $('.faq__count', box);
		function filter() {
			var q = (input.value || '').trim().toLowerCase();
			var g = groups.filter(function (x) { return !x.hidden; })[0], n = 0;
			$$('.qa', g).forEach(function (qa) {
				var t = qa.textContent.toLowerCase(), ok = !q || t.indexOf(q) > -1;
				qa.classList.toggle('is-hidden', !ok); if (ok) n++;
				$$('[data-raw]', qa).forEach(function (el) {
					var raw = el.getAttribute('data-raw');
					if (!q) { el.textContent = raw; return; }
					var i = raw.toLowerCase().indexOf(q);
					el.innerHTML = i < 0 ? escapeHtml(raw) : escapeHtml(raw.slice(0, i)) + '<mark>' + escapeHtml(raw.slice(i, i + q.length)) + '</mark>' + escapeHtml(raw.slice(i + q.length));
					if (i > -1 && el.closest('.qa__a')) qa.open = true;
				});
			});
			cnt.textContent = q ? n + ' ' + (box.dataset.found || '') : '';
		}
		tabs.forEach(function (t, i) {
			t.addEventListener('click', function () {
				tabs.forEach(function (o) { o.setAttribute('aria-selected', o === t ? 'true' : 'false'); });
				groups.forEach(function (g, j) { g.hidden = j !== i; }); filter();
			});
		});
		input && input.addEventListener('input', filter);
	});
	function escapeHtml(s) { return s.replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	$$('details.qa, details.tr').forEach(function (det) {
		var sum = $('summary', det), body = sum.nextElementSibling;
		sum.addEventListener('click', function (e) {
			if (reduce || !body.animate) return;
			e.preventDefault();
			if (det.open) {
				var a = body.animate([{ height: body.offsetHeight + 'px', opacity: 1 }, { height: '0px', opacity: 0 }], { duration: 380, easing: 'cubic-bezier(.2,.8,.2,1)' });
				a.onfinish = function () { det.open = false; };
			} else {
				det.open = true; var h = body.offsetHeight;
				body.animate([{ height: '0px', opacity: 0 }, { height: h + 'px', opacity: 1 }], { duration: 480, easing: 'cubic-bezier(.2,.8,.2,1)' });
			}
		});
	});

	/* Parallax subtil nas fotos de fundo ------------------------------------------ */
	if (!reduce) {
		window.addEventListener('scroll', function () {
			if (!current) return;
			$$('[data-par]', current).forEach(function (el) {
				var r = el.parentNode.getBoundingClientRect(); if (r.bottom < 0 || r.top > window.innerHeight) return;
				el.style.transform = 'translate3d(0,' + ((r.top) * -0.12).toFixed(1) + 'px,0)';
			});
		}, { passive: true });
	}

	hydrate(hdr);
	go();
})();
