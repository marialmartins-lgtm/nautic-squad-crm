#!/usr/bin/env python3
"""
Gera o protótipo navegável da Nautic Squad num único ficheiro HTML:
    python3 prototipo/tools/build.py  ->  prototipo/nautic-squad-prototipo.html

Fonte de conteúdos: prototipo/content/content.json (texto literal do site atual, PT e EN).
Cada "page" gerada corresponde a um template WordPress (ver prototipo/README.md).
"""
import base64, html, json, os, re

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
C = json.load(open(os.path.join(ROOT, 'content', 'content.json'), encoding='utf-8'))
MEDIA = json.load(open(os.path.join(ROOT, 'content', 'media.json')))
e = lambda s: html.escape(s, quote=True)

# --------------------------------------------------------------------------
# Interface (microtexto de navegação; não é conteúdo do site)
# --------------------------------------------------------------------------
UI = {
	'pt': {'menu': 'Menu', 'close': 'Fechar', 'all': 'Todos', 'prev': 'Anterior', 'next': 'Seguinte', 'view': 'Ver embarcação',
		'search': 'Pesquisar nas perguntas', 'found': 'resultado(s)', 'socio': 'Área de sócio', 'call': 'Ligar', 'mail': 'Email',
		'scroll': 'Scroll', 'drag': 'Arraste ou use as setas', 'swipe': 'Deslize para ver os três clubes', 'outings': 'saídas / mês',
		'wk': 'Durante a semana', 'we': 'Ao fim de semana', 'both': 'Semana e fim de semana', 'filter_all': 'Todas',
		'quiz_open': 'Qual a modalidade mais adequada?', 'quiz_txt': 'Responda a três perguntas para ver as modalidades que correspondem à sua utilização.',
		'quiz_q1': 'Quando prefere sair para o mar?', 'quiz_q2': 'Quantas saídas por mês?', 'quiz_q3': 'Quer partilhar a associação com um amigo?',
		'yes': 'Sim', 'no': 'Não', 'quiz_none': 'Nenhuma modalidade corresponde exatamente a esta combinação. Estas são as mais próximas:',
		'quiz_note': 'Demonstração: a sugestão baseia-se apenas no número de saídas e nos dias de cada modalidade, tal como descritos no site. Valores e disponibilidade são confirmados pela equipa Nautic Squad.',
		'demo': 'Demonstração', 'socio_note': '<b>Área de sócio:</b> ligação à aplicação de reservas dos sócios — a integrar (o endereço não consta do site atual).',
		'others': 'Outras embarcações', 'photo_needed': 'Fotografia da embarcação a disponibilizar', 'gallery': 'Galeria',
		'specs_model': 'Modelo', 'specs_len': 'Comprimento', 'specs_cap': 'Capacidade', 'specs_year': 'Ano', 'specs_cabins': 'Cabines', 'specs_marina': 'Marina', 'specs_club': 'Clube',
		'specs_head': 'Altura livre', 'specs_helm': 'Leme',
		'needs': 'Necessidade identificada', 'needs_txt': 'plantas e fotografias do interior não existem no site atual — a disponibilizar pela Nautic Squad.',
		'brochure': 'Brochura (PDF)', 'boats_shown': 'embarcações visíveis', 'types_of': 'Modalidades de associação', 'faq_of': 'Questões frequentes',
		'step': 'Passo', 'home': 'Início', 'boats': 'Frota'},
	'en': {'menu': 'Menu', 'close': 'Close', 'all': 'All', 'prev': 'Previous', 'next': 'Next', 'view': 'View boat',
		'search': 'Search the questions', 'found': 'result(s)', 'socio': 'Members area', 'call': 'Call', 'mail': 'Email',
		'scroll': 'Scroll', 'drag': 'Drag or use the arrows', 'swipe': 'Swipe to see the three clubs', 'outings': 'outings / month',
		'wk': 'On weekdays', 'we': 'At the weekend', 'both': 'Weekdays and weekends', 'filter_all': 'All',
		'quiz_open': 'Which membership suits you?', 'quiz_txt': 'Answer three questions to see the membership types that match how you want to sail.',
		'quiz_q1': 'When do you prefer to go sailing?', 'quiz_q2': 'How many outings per month?', 'quiz_q3': 'Would you like to share the membership with a friend?',
		'yes': 'Yes', 'no': 'No', 'quiz_none': 'No membership type matches this combination exactly. These are the closest:',
		'quiz_note': 'Demo: the suggestion is based only on the number of outings and days of each membership type, as described on the website. Prices and availability are confirmed by the Nautic Squad team.',
		'demo': 'Demo', 'socio_note': '<b>Members area:</b> link to the members’ booking app — to be integrated (the address is not on the current website).',
		'others': 'Other boats', 'photo_needed': 'Boat photo to be provided', 'gallery': 'Gallery',
		'specs_model': 'Model', 'specs_len': 'Length', 'specs_cap': 'Capacity', 'specs_year': 'Year', 'specs_cabins': 'Cabins', 'specs_marina': 'Marina', 'specs_club': 'Club',
		'specs_head': 'Headroom', 'specs_helm': 'Helm',
		'needs': 'Identified need', 'needs_txt': 'interior plans and photos are not on the current website — to be provided by Nautic Squad.',
		'brochure': 'Brochure (PDF)', 'boats_shown': 'boats shown', 'types_of': 'Membership types', 'faq_of': 'FAQ',
		'step': 'Step', 'home': 'Home', 'boats': 'Boats'},
}

LINKS = {
	'phone': 'tel:+351911924555', 'email': 'mailto:sales@nauticsquad.com', 'email_txt': 'sales@nauticsquad.com',
	'instagram': 'http://www.instagram.com/nautic.squad/', 'linkedin': 'http://www.linkedin.com/company/nauticsquad/',
	'facebook': 'https://www.facebook.com/Nautic-Squad-108675230929293/',
	'pdf': 'https://www.nauticsquad.com/_files/ugd/b673a7_d763e4bfcf994a0c837aae4e6f9a1e4a.pdf',
}
QR = {'6nTuwHtfwU': 'qr-informacoes', 'ugmNhFpCvC': 'qr-visita', '0076apC7rm': 'qr-aderir'}

# Embarcações: fotos atribuídas segundo o próprio site (secção Frota + legendas da galeria PT)
BOATS = [
	{'slug': 'oceanbliss', 'name': 'OCEANBLISS', 'club': 'sailing-club', 'marina': 'oeiras', 'imgs': ['galeria-oceanbliss'],
	 'specs': {'pt': [('specs_model', 'Sun Odyssey 350'), ('specs_helm', 'Dupla roda de leme'), ('specs_head', '+ 1,85 m')],
	           'en': [('specs_model', 'Sun Odyssey 350'), ('specs_helm', 'Twin steering wheels'), ('specs_head', '+ 1.85 m')]}},
	{'slug': 'oceanescape', 'name': 'OCEANESCAPE', 'club': 'sailing-club', 'marina': 'oeiras', 'imgs': ['oceanescape', 'galeria-oceanescape-italia', 'galeria-oceanescape-tejo'],
	 'specs': {'pt': [('specs_model', 'Beneteau Oceanis 37 Limited Edition'), ('specs_year', '2013'), ('specs_cabins', '3')],
	           'en': [('specs_model', 'Beneteau Oceanis 37 Limited Edition'), ('specs_year', '2013'), ('specs_cabins', '3')]}},
	{'slug': 'oceanvibes', 'name': 'OCEANVIBES', 'club': 'sailing-club', 'marina': 'cascais', 'imgs': ['galeria-oceanvibes'],
	 'specs': {'pt': [('specs_model', 'Dufour 45 Classic'), ('specs_year', '1998'), ('specs_len', '13,67 m')],
	           'en': [('specs_model', 'Dufour 45 Classic'), ('specs_year', '1998'), ('specs_len', '13.67 m')]}},
	{'slug': 'oceanfun', 'name': 'OCEANFUN', 'club': 'sailing-academy', 'marina': 'oeiras', 'imgs': ['oceanfun', 'galeria-oceanfun-1', 'galeria-oceanfun-2'],
	 'specs': {'pt': [('specs_model', 'Jeanneau Sun 2500'), ('specs_len', '7,50 m')],
	           'en': [('specs_model', 'Jeanneau Sun 2500'), ('specs_len', '7.50 m')]}},
	{'slug': 'fifty-fifty', 'name': 'FIFTY FIFTY', 'club': 'power-club', 'marina': 'oeiras', 'imgs': ['fifty-1', 'galeria-fifty-tejo', 'fifty-2', 'fifty-3', 'fifty-4'],
	 'specs': {'pt': [('specs_model', 'Quicksilver Activ 875'), ('specs_len', '8,7 m'), ('specs_cap', '12')],
	           'en': [('specs_model', 'Quicksilver Activ 875'), ('specs_len', '8.7 m'), ('specs_cap', '12')]}},
]
CLUB_NAME = {'sailing-club': 'Sailing Club', 'sailing-academy': 'Sailing Academy', 'power-club': 'Power Club'}
CLUB_IMG = {'sailing-club': 'oceanescape', 'sailing-academy': 'oceanfun', 'power-club': 'fifty-1'}
CLUB_HERO = {'sailing-club': 'marina-veleiro', 'sailing-academy': 'galeria-oceanfun-1', 'power-club': 'galeria-fifty-tejo'}
GALLERY_IMGS = ['galeria-fifty-tejo', 'galeria-oceanescape-italia', 'galeria-oceanescape-tejo', 'galeria-oceanbliss', 'galeria-tejo-por-do-sol',
                'galeria-la-rochelle', 'galeria-oceanfun-1', 'galeria-oceanfun-2', 'galeria-oceanvibes']
TYPE_RULES = {  # retirado literalmente das descrições das modalidades
	'Full light': (4, 2), 'Week light': (3, 0), 'Weekday': (6, 0), 'Weekend': (0, 3), 'Full week': (6, 3)}


PFX = {
	'reserv': ('As reservas', 'Reservations'),
	'simple': ('Basta agendar',),
	'pleasure': ('Ser membro', 'Being a Nautic', 'Membership in Nautic'),
	'dream': ('Parece um sonho', 'It sounds like', 'Although it may'),
	'limited': ('O número de inscrições', 'Membership is limited'),
	'secure': ('Assegure', 'Secure your'),
	'fee': ('A mensalidade', 'The monthly'),
}
def pick(lst, key):
	return next((p for p in lst if p.startswith(PFX[key])), '')

def reserv_parts(after):
	"""Parágrafos sobre reservas (até ao parágrafo 'Ser membro...')."""
	k = next((i for i, p in enumerate(after) if p.startswith(PFX['pleasure'])), len(after))
	return after[:k]

def R(lang, path=''):
	"""Rota (hash) de uma página."""
	if lang == 'en':
		return 'en' + ('/' + path if path else '')
	return path

def boat_route(lang, b):
	return R(lang, ('boats/' if lang == 'en' else 'frota/') + b['slug'])

def img(key, alt='', cls='', eager=False, attrs=''):
	m = MEDIA.get(key, {})
	return f'<img data-img="{key}" alt="{e(alt)}" width="{m.get("w", "")}" height="{m.get("h", "")}"{" class=" + chr(34) + cls + chr(34) if cls else ""} {attrs} decoding="async">'

def P(text):
	return f'<p>{e(text)}</p>'

ICON = {
	'arr': '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg>',
	'larr': '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M20 12H5M11 6l-6 6 6 6"/></svg>',
	'phone': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>',
	'mail': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="1"/><path d="m3 7 9 6 9-6"/></svg>',
	'cal': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="1"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>',
	'search': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>',
	'ig': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".8" fill="currentColor"/></svg>',
	'fb': '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.9.3-1.5 1.5-1.5h1.5V4.4c-.3 0-1.2-.1-2.2-.1-2.2 0-3.8 1.4-3.8 3.9v2.3H8v3h2.5V21h3z"/></svg>',
	'in': '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.9 8.8H3.8V20h3.1V8.8zM5.3 3.8a1.8 1.8 0 1 0 0 3.6 1.8 1.8 0 0 0 0-3.6zM20.2 13.6c0-3-1.6-4.9-4.2-4.9-1.5 0-2.4.8-2.8 1.5V8.8h-3V20h3.1v-5.9c0-1.5.6-2.6 1.9-2.6 1.3 0 1.9 1 1.9 2.6V20h3.1v-6.4z"/></svg>',
	'pdf': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M14 3H6a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8z"/><path d="M14 3v5h5"/></svg>',
}
ROUTE_SVG = '<svg class="route {cls}" viewBox="0 0 400 260" aria-hidden="true"><path class="draw" d="M10 240 C 90 200 120 120 200 130 S 320 60 390 20"/><path d="M10 250 C 100 215 140 140 210 145 S 330 80 395 35"/><circle cx="10" cy="240" r="3"/><circle cx="200" cy="130" r="2.5"/><circle cx="390" cy="20" r="3"/></svg>'
WAVE = '<span class="wave" aria-hidden="true"><svg viewBox="0 0 1200 18" preserveAspectRatio="none"><path d="M0 9 Q 37.5 1 75 9 T 150 9 T 225 9 T 300 9 T 375 9 T 450 9 T 525 9 T 600 9 T 675 9 T 750 9 T 825 9 T 900 9 T 975 9 T 1050 9 T 1125 9 T 1200 9"/></svg></span>'

# --------------------------------------------------------------------------
# Componentes
# --------------------------------------------------------------------------
def header():
	return f'''<header class="hdr has-hero"><div class="wrap hdr__in">
<a class="logo" href="#/" aria-label="Nautic Squad"><img class="l-sec" data-img="logo-secundario-branco" alt="Nautic Squad"><img class="l-pri" data-img="logo-principal" alt="" aria-hidden="true"></a>
<nav class="hdr__nav" aria-label="Principal">
''' + ''.join(f'''<span data-lang-ui="{l}"{' hidden' if l == 'en' else ''} style="display:contents">
<a class="hide-m" href="#/{R(l, 'sailing-club')}">SAILING CLUB</a><a class="hide-m" href="#/{R(l, 'sailing-academy')}">SAILING ACADEMY</a><a class="hide-m" href="#/{R(l, 'power-club')}">POWER CLUB</a>
<button class="hide-m" type="button" data-socio>{UI[l]['socio']}</button>
<a class="btn hide-m" href="#/{R(l, 'contactos' if l == 'pt' else 'contacts')}">{e(C[l]['home']['hero_cta'])} <span class="arr">→</span></a>
</span>''' for l in ('pt', 'en')) + '''
<span class="lang"><a href="#/" data-l="pt" aria-current="true" lang="pt">PT</a><a href="#/en" data-l="en" aria-current="false" lang="en">EN</a></span>
<button class="menu-btn" type="button" data-menu aria-haspopup="dialog"><span>Menu</span><i></i></button>
</nav></div></header>'''

def menu():
	parts = []
	for l in ('pt', 'en'):
		m = C[l]['home']['menu']
		F = C[l]['footer']
		sub_labels = m[1:5]  # Conceito / Tipos de Associação / Frota / FAQ
		sub_ids = ['conceito', 'tipos', 'frota', 'faq'] if l == 'pt' else ['concept', 'types', 'boats', 'faq']
		def item(i, label, route, img_key, subs=None):
			s = ''
			if subs:
				s = '<div class="mnu__sub">' + ''.join(f'<a href="#/{route}/{sid}">{e(sl)}</a>' for sl, sid in zip(sub_labels, sub_ids)) + '</div>'
			return f'<div class="mnu__item" data-img="{img_key}" style="--i:{i}"><a class="mnu__main" href="#/{route}"><small>0{i + 1}</small>{e(label)}</a>{s}</div>'
		home_sec = (lambda x: R(l, x))
		items = [
			item(0, 'SAILING CLUB', R(l, 'sailing-club'), 'oceanescape', True),
			item(1, 'SAILING ACADEMY', R(l, 'sailing-academy'), 'oceanfun', True),
			item(2, 'POWER CLUB', R(l, 'power-club'), 'fifty-1'),
			item(3, F['links'][2], home_sec('frota' if l == 'pt' else 'boats'), 'galeria-oceanbliss'),
			item(4, F['links'][3], home_sec('quem-somos' if l == 'pt' else 'about-us'), 'fundadores'),
			item(5, F['links'][4], home_sec('galeria' if l == 'pt' else 'gallery'), 'galeria-tejo-por-do-sol'),
			item(6, F['links'][5], home_sec('contactos' if l == 'pt' else 'contacts'), 'marina-veleiro'),
		]
		tools = f'<div class="mnu__tools"><button type="button" data-socio>{UI[l]["socio"]}</button><a href="#/" lang="pt">Português</a><a href="#/en" lang="en">English</a></div>'
		parts.append(f'<div data-lang-ui="{l}"{" hidden" if l == "en" else ""}>' + ''.join(items) + tools + '</div>')
	aside = ''.join(img(k, '', attrs=f'data-key="{k}"') for k in ['oceanescape', 'oceanfun', 'fifty-1', 'galeria-oceanbliss', 'fundadores', 'galeria-tejo-por-do-sol', 'marina-veleiro'])
	contact = f'<div class="mnu__contact"><a href="{LINKS["phone"]}">{e(C["pt"]["footer"]["phone"])}</a><a href="{LINKS["email"]}">{LINKS["email_txt"]}</a></div>'
	return f'''<div class="mnu" role="dialog" aria-modal="true" aria-label="Menu" aria-hidden="true">
<button class="mnu__close" type="button" data-menu-close><span data-lang-ui="pt">{UI['pt']['close']}</span><span data-lang-ui="en" hidden>{UI['en']['close']}</span> ✕</button>
<nav class="mnu__list" aria-label="Menu">{''.join(parts)}</nav>
<div class="mnu__aside">{aside.replace('data-key="oceanescape"', 'data-key="oceanescape" class="is-on"', 1)}{contact}</div>
</div>'''

def hero(l, title, img_key, cta=None, page=False, coords=True, label=None):
	cs = ''
	if coords:
		cs = '<div class="coords"><span>38°40′ N · 9°19′ W — Oeiras</span><span>38°41′ N · 9°25′ W — Cascais</span></div>'
	cta_html = f'<div class="rv" style="--d:.6s"><a class="btn" href="#/{cta[1]}">{e(cta[0])} <span class="arr">→</span></a></div>' if cta else ''
	lab = f'<p class="lbl lbl--light rv">{e(label)}</p>' if label else ''
	return f'''<section class="hero{' hero--page' if page else ''}">
<div class="hero__img" data-par>{img(img_key, '', '', True)}</div>
{ROUTE_SVG.format(cls='').replace('class="route "', 'class="route" style="right:4%;top:18%;width:min(34vw,420px)"')}
<div class="wrap hero__in"><div class="hero__grid"><div>{lab}<h1 class="h-xl tl">{e(title)}</h1></div>{cta_html}</div>
<div class="hero__meta">{cs}<a class="scroll" href="#/{R(l, 'clubes' if l == 'pt' else 'clubs') if not page else ''}" data-scroll>{UI[l]['scroll']} <i></i></a></div></div></section>'''

def club_panels(l):
	h = C[l]['home']
	out = []
	for i, c in enumerate(h['clubs']):
		txt = ''.join(P(t) for t in c['text'])
		out.append(f'''<a class="panel" href="#/{R(l, c['key'])}">{img(CLUB_IMG[c['key']], c['name'])}<span class="panel__n">0{i + 1}</span>
<div class="panel__in"><h3>{e(c['name'])}</h3><div class="panel__txt"><div>{txt}</div></div><span class="lnk">{e(c['more'])} <span class="arr">→</span></span></div></a>''')
	return f'''<section class="sec" id="{'clubes' if l == 'pt' else 'clubs'}"><div class="wrap">
<div class="panels rv">{''.join(out)}</div><p class="swipe-hint">{UI[l]['swipe']} →</p></div></section>'''

def how(l):
	sc = C[l]['sailing-club']; h = C[l]['home']
	first = h['clubs'][0]['text'][1]  # "Os sócios da Nautic Squad escolhem ... Depois, basta agendar ..."
	m = re.split(r'(?<=\.)\s+(?=Depois|Then)', first)
	res = reserv_parts(sc['after'])
	step3 = [res[0]] + ([res[1]] if len(res) > 1 and res[1][:1].islower() else [])
	step4 = [p for p in res if p not in step3]
	periods = re.findall(r'(manhã|tarde|noite|morning|afternoon|evening) \(([^)]*)\)', ' '.join(step3))
	chips = '<div class="chips">' + ''.join(f'<span class="chip">{e(n)} <b>{e(t)}</b></span>' for n, t in periods) + '</div>' if periods else ''
	steps = [(m[0], ''), (m[1] if len(m) > 1 else '', ''), (' '.join(step3), chips), (' '.join(step4), '')]
	steps = [s_ for s_ in steps if s_[0]]
	imgs = ['galeria-oceanbliss', 'galeria-oceanescape-tejo', 'galeria-tejo-por-do-sol', 'galeria-oceanfun-1']
	fr = ''.join(img(k, '', 'is-on' if i == 0 else '') for i, k in enumerate(imgs[:len(steps)]))
	st = ''.join(f'<div class="step{" is-on" if i == 0 else ""}"><div class="step__n">0{i + 1}</div><p>{e(t)}</p>{x}</div>' for i, (t, x) in enumerate(steps))
	return f'''<section class="sec" id="{'o-clube' if l == 'pt' else 'the-club'}"><div class="wrap">
<div class="sec__head"><div><p class="lbl">{e(sc['club_label'])}</p><h2 class="h-l tl">{e(pick(sc['after'], 'dream'))}</h2></div>
<p class="lead rv">{e(h['clubs'][0]['text'][0])}</p></div>
<div class="how"><div class="how__media"><div class="how__frame">{fr}</div><div class="how__bar"><span class="how__n">01 / 0{len(steps)}</span><span class="how__track"><i></i></span></div></div>
<div class="how__steps">{st}</div></div></div></section>'''

def bento(l, page='sailing-club'):
	sc = C[l][page]
	fee = pick(sc['concept'], 'fee')
	dream, limited, secure, pleasure = pick(sc['after'], 'dream'), pick(sc['after'], 'limited'), pick(sc['after'], 'secure'), pick(sc['after'], 'pleasure')
	ben = ''.join(f'<li>{e(b)}</li>' for b in sc['benefits'])
	sid = 'vantagens' if l == 'pt' else 'benefits'
	return f'''<section class="sec" id="{sid}" style="padding-top:0"><div class="wrap"><div class="bento">
<div class="bx bx--a rv"><p class="lbl lbl--light">{e(sc['club_label'])}</p><p class="h-m">{e(sc['benefits_intro'])}</p><ul class="benefits">{ben}</ul></div>
<div class="bx bx--b ri">{img('galeria-oceanescape-italia', '')}</div>
<div class="bx bx--c rv"><p class="quote">{e(dream)}</p></div>
<div class="bx bx--d rv"><p>{e(fee)}</p></div>
<div class="bx bx--e ri">{img('galeria-la-rochelle', '')}</div>
<div class="bx bx--f rv"><p>{e(pleasure)}</p><div><p style="margin:0 0 1rem;font-weight:600">{e(limited)}</p><a class="btn btn--white" href="#/{R(l, 'contactos' if l == 'pt' else 'contacts')}">{e(secure)} <span class="arr">→</span></a></div></div>
</div></div></section>'''

def fleet(l, boats, texts=None, dark=True, sid=None):
	"""texts: dict slug -> label (do site) para a etiqueta do cartão."""
	h = C[l]['home']
	label = {b['slug']: bt['label'] for b, bt in zip(BOATS, h['boats'])}
	cards = []
	for b in boats:
		im = b['imgs'][0]
		specs = ''.join(f'<span>{e(v)}</span>' for _, v in b['specs'][l][:2])
		cards.append(f'''<a class="boat" href="#/{boat_route(l, b)}" data-club="{b['club']}" data-marina="{b['marina']}" draggable="false">
<div class="boat__img">{img(im, b['name'])}</div><div class="boat__body"><div><p class="boat__lab">{e(label[b['slug']])}</p><h3>{e(b['name'])}</h3><p class="boat__specs">{specs}</p></div><span class="boat__go" aria-hidden="true">{ICON['arr']}</span></div></a>''')
	F = C[l]['footer']
	filt = ''
	if len(boats) > 1:
		clubs = sorted({b['club'] for b in boats}, key=list(CLUB_NAME).index)
		marinas = sorted({b['marina'] for b in boats})
		mnames = {'oeiras': F['marinas'][0], 'cascais': F['marinas'][1]}
		filt = '<div class="filters" role="group">' + f'<button type="button" data-group="club" data-v="*" aria-pressed="true">{UI[l]["all"]}</button>' + ''.join(
			f'<button type="button" data-group="club" data-v="{c}" aria-pressed="false">{CLUB_NAME[c]}</button>' for c in clubs) + '</div>'
		if len(marinas) > 1:
			filt += '<div class="filters" role="group">' + f'<button type="button" data-group="marina" data-v="*" aria-pressed="true">{UI[l]["filter_all"]}</button>' + ''.join(
				f'<button type="button" data-group="marina" data-v="{m}" aria-pressed="false">{e(mnames[m])}</button>' for m in marinas) + '</div>'
	lab = h['fleet_label']
	sid = sid or ('frota' if l == 'pt' else 'boats')
	return f'''<section class="sec{' sec--dark' if dark else ' fleet-light'}" id="{sid}"><div class="wrap" data-slider>
<div class="sec__head"><div><p class="lbl">{e(lab)}</p><h2 class="h-l tl">{e(' · '.join(F['marinas']))}</h2></div><p class="lead rv">{e(UI[l]['drag'])}</p></div>
<div class="fleet-tools"><div style="display:flex;flex-wrap:wrap;gap:.6rem 1.2rem">{filt}</div><div class="arrows"><button type="button" data-prev aria-label="{UI[l]['prev']}">{ICON['larr']}</button><button type="button" data-next aria-label="{UI[l]['next']}">{ICON['arr']}</button></div></div>
<div class="slider" aria-roledescription="carousel"><div class="track">{''.join(cards)}</div></div>
<div class="progress"><span class="progress__n">01 / 0{len(boats)}</span><span class="progress__bar"><i></i></span></div><p class="sr-only sr-live" aria-live="polite"></p>
</div></section>'''

def types(l, page='sailing-club', sid=None):
	t = C[l][page]
	colors = {'wk': 'var(--ns-teal)', 'we': 'var(--ns-turquesa)'}
	rows = []
	rules = []
	for ty in t['types']:
		wk, we = TYPE_RULES[ty['name']]
		n = wk + we
		kind = 'both' if wk and we else ('wk' if wk else 'we')
		bar = '<div class="split"><div class="split-bar">' + ''.join(f'<i style="--n:{v};--c:{colors[k]}"></i>' for k, v in (('wk', wk), ('we', we)) if v) + '</div></div>'
		body = ''.join(P(p) for p in ty['text'])
		rows.append(f'<details class="tr" data-wk="{wk}" data-we="{we}"><summary><span class="tr__name">{e(ty["name"])}</span><span class="tr__n">{n}<small>{UI[l]["outings"]}</small></span>{bar}<span class="tr__plus" aria-hidden="true">+</span></summary><div class="tr__body"><div>{body}</div></div></details>')
		rules.append({'name': ty['name'], 'n': n, 'kind': kind, 'html': body})
	team = t['team']
	team_html = ''.join(P(p) for p in team['text'])
	note = ''.join(P(p) for p in t['types_note'])
	data = {'types': rules, 'team': {'name': team['name'], 'html': team_html}, 'ui': {'none': UI[l]['quiz_none'], 'note': UI[l]['quiz_note']}}
	tools = '<div class="types__tools filters filters--light" role="group">' + ''.join(
		f'<button type="button" data-v="{v}" aria-pressed="{"true" if v == "*" else "false"}">{lab}</button>' for v, lab in (('*', UI[l]['all']), ('wk', UI[l]['wk']), ('we', UI[l]['we']), ('both', UI[l]['both']))) + '</div>'
	legend = f'<div class="legend"><span><i style="--c:{colors["wk"]}"></i>{UI[l]["wk"]}</span><span><i style="--c:{colors["we"]}"></i>{UI[l]["we"]}</span></div>'
	sid = sid or ('tipos' if l == 'pt' else 'types')
	intro = ''.join(f'<p class="lead rv">{e(p)}</p>' for p in t['types_intro'])
	return f'''<section class="sec" id="{sid}" data-types><div class="wrap">
<div class="sec__head"><div><p class="lbl">{e(t['types_label'])}</p><h2 class="h-l tl">{e(UI[l]['types_of'])}</h2></div><div>{intro}</div></div>
<div class="types"><div>{tools}<div class="tbl">{''.join(rows)}</div>{legend}<div class="types__note">{note}</div></div>
<aside><div class="team rv">{ROUTE_SVG.format(cls='')}<p class="lbl lbl--light" style="color:#fff">TEAM</p><h3>{e(team['name'])}</h3>{team_html}<a class="btn btn--white" href="#/{R(l, 'contactos' if l == 'pt' else 'contacts')}">{e(t['types_cta'])} <span class="arr">→</span></a></div>
<div class="quiz-cta rv"><span class="demo">{UI[l]['demo']}</span><h3 class="h-m" style="margin:0 0 .6rem">{UI[l]['quiz_open']}</h3><p>{UI[l]['quiz_txt']}</p><button class="btn btn--line" type="button" data-quiz="{l}">{UI[l]['quiz_open']} <span class="arr">→</span></button></div></aside></div>
</div></section>'''

def quiz_dialog():
	forms = []
	for l in ('pt', 'en'):
		t = C[l]['sailing-club']
		rules = []
		for ty in t['types']:
			wk, we = TYPE_RULES[ty['name']]
			rules.append({'name': ty['name'], 'n': wk + we, 'kind': 'both' if wk and we else ('wk' if wk else 'we'), 'html': ''.join(P(p) for p in ty['text'])})
		data = {'types': rules, 'team': {'name': t['team']['name'], 'html': ''.join(P(p) for p in t['team']['text'])}, 'ui': {'none': UI[l]['quiz_none'], 'note': UI[l]['quiz_note']}}
		def q(name, legend, opts):
			return f'<fieldset class="q"><legend>{legend}</legend><div class="opts">' + ''.join(
				f'<label><input type="radio" name="{l}-{name}" data-q="{name}" value="{v}"><span>{lab}</span></label>' for v, lab in opts) + '</div></fieldset>'
		forms.append(f'''<form class="quiz" data-lang-ui="{l}"{' hidden' if l == 'en' else ''} data-rules="{e(json.dumps(data, ensure_ascii=False))}" onsubmit="return false">
<span class="demo">{UI[l]['demo']}</span><h2 class="h-m" style="margin:0 0 1.6rem">{UI[l]['quiz_open']}</h2>
{q('when', UI[l]['quiz_q1'], (('wk', UI[l]['wk']), ('we', UI[l]['we']), ('both', UI[l]['both'])))}
{q('num', UI[l]['quiz_q2'], (('3', '3'), ('6', '6'), ('9', '9')))}
{q('team', UI[l]['quiz_q3'], (('yes', UI[l]['yes']), ('no', UI[l]['no'])))}
<div class="result" hidden aria-live="polite"></div></form>''')
	return f'<div class="dlg" role="dialog" aria-modal="true" aria-label="Quiz"><div class="dlg__box"><button class="dlg__x" type="button" data-dlg-close aria-label="Fechar / Close">×</button>{"".join(forms)}</div></div>'

def community(l):
	h = C[l]['home']; a = h['about']
	about_txt = ''.join(f'<p class="{"lead" if i == 0 else ""}">{e(p)}</p>' for i, p in enumerate(a['text']))
	figs = ''.join(f'<figure class="m{i + 1} ri" data-lb="gal" data-k="{k}" data-c="{e(c)}" tabindex="0">{img(k, c)}<figcaption>{e(c)}</figcaption></figure>'
	               for i, (k, c) in enumerate(zip(GALLERY_IMGS, h['gallery'])))
	return f'''<section class="sec" id="{'quem-somos' if l == 'pt' else 'about-us'}"><div class="wrap">
<div class="about"><div class="about__img ri">{img('fundadores', a['caption'])}<p class="cap">{e(a['caption'])}</p></div>
<div class="about__txt"><p class="lbl">{e(a['label'])}</p><h2 class="h-l tl" style="margin-bottom:1.6rem">{e(a['title'])}</h2>{about_txt}</div></div>
<div id="{'galeria' if l == 'pt' else 'gallery'}" class="sec__head" style="margin-top:2rem"><div><p class="lbl">{e(h['gallery_label'])}</p><h2 class="h-l tl">{e(h['gallery_label2'] if l == 'pt' else h['gallery_label'])}</h2></div>
<p class="lead rv"><a class="lnk" href="{LINKS['instagram']}" target="_blank" rel="noopener">@nautic.squad <span class="arr">→</span></a></p></div>
<div class="mag">{figs}</div></div></section>'''

def band(l, text, img_key, cta=None):
	b = f'<a class="btn" href="#/{cta[1]}">{e(cta[0])} <span class="arr">→</span></a>' if cta else ''
	return f'<section class="band"><div class="band__img" data-par>{img(img_key, "")}</div><div class="wrap"><p class="h-l tl">{e(text)}</p>{b}</div></section>'

def faq(l, pages_, sid=None):
	tabs, groups = [], []
	for i, pg in enumerate(pages_):
		f = C[l][pg]
		tabs.append(f'<button type="button" role="tab" aria-selected="{"true" if i == 0 else "false"}">{CLUB_NAME[pg]}</button>')
		qas = ''.join(f'<details class="qa"><summary><span data-raw="{e(x["q"])}">{e(x["q"])}</span><i aria-hidden="true"></i></summary><div class="qa__a"><div>' +
		              ''.join(f'<p data-raw="{e(p)}">{e(p)}</p>' for p in x['a']) + '</div></div></details>' for x in f['faq'])
		groups.append(f'<div class="faq-group"{"" if i == 0 else " hidden"} role="tabpanel">{qas}</div>')
	t = C[l][pages_[0]]
	tabs_html = f'<div class="tabs" role="tablist">{"".join(tabs)}</div>' if len(pages_) > 1 else '<div style="height:1.4rem"></div>'
	sid = sid or 'faq'
	return f'''<section class="sec" id="{sid}" data-faq data-found="{UI[l]['found']}" style="background:rgba(162,236,243,.16)"><div class="wrap faq">
<div class="faq__side"><p class="lbl">{e(t['faq_label'])}</p><h2 class="h-l tl">{e(UI[l]['faq_of'])}</h2>{tabs_html}
<label class="search"><span class="sr-only">{UI[l]['search']}</span>{ICON['search']}<input type="search" placeholder="{UI[l]['search']}"></label><p class="faq__count" aria-live="polite"></p></div>
<div>{''.join(groups)}</div></div></section>'''

def contacts(l, c, label=None, sid=None):
	F = C[l]['footer']
	rows = ''.join(f'''<a class="form-row" href="{e(f['url'])}" target="_blank" rel="noopener"><span class="form-row__n">0{i + 1}</span><span class="form-row__t">👉 {e(f['label'])}<small>{e(f['url'])}</small></span>{img(QR[f['url'].rstrip('/').split('/')[-1]], 'QR', 'form-row__qr')}</a>''' for i, f in enumerate(c['forms']))
	sid = sid or ('contactos' if l == 'pt' else 'contacts')
	return f'''<section class="sec sec--dark" id="{sid}"><div class="wrap contact__grid">
<div><p class="lbl">{e(label or F['links'][5])}</p><h2 class="h-l tl" style="margin-bottom:1.6rem">{e(c['title'])}</h2><p class="lead">{e(c['intro'])}</p>
<div class="info"><div><h4>{e(F['phone'])[:0] or ('Telefone' if l == 'pt' else 'Phone')}</h4><p><a href="{LINKS['phone']}">{e(F['phone'])}</a></p></div>
<div><h4>Email</h4><p><a href="{LINKS['email']}">{LINKS['email_txt']}</a></p></div>
<div><h4>{e(F['office_label'])}</h4><p>{e(F['office'])}</p></div>
<div><h4>{e(F['boats_label'])}</h4><p>{'<br>'.join(e(m) for m in F['marinas'])}</p></div>
<div><h4>{e(F['social_label'])}</h4><div class="social"><a href="{LINKS['instagram']}" target="_blank" rel="noopener" aria-label="Instagram">{ICON['ig']}</a><a href="{LINKS['facebook']}" target="_blank" rel="noopener" aria-label="Facebook">{ICON['fb']}</a><a href="{LINKS['linkedin']}" target="_blank" rel="noopener" aria-label="LinkedIn">{ICON['in']}</a></div></div></div></div>
<div><p class="lead" style="margin-top:0">{e(c['select'])}</p><div class="forms">{rows}</div></div></div></section>'''

def footer(l):
	F = C[l]['footer']
	targets = [R(l, 'sailing-club'), R(l, 'sailing-academy'), R(l, 'frota' if l == 'pt' else 'boats'), R(l, 'quem-somos' if l == 'pt' else 'about-us'), R(l, 'galeria' if l == 'pt' else 'gallery'), R(l, 'contactos' if l == 'pt' else 'contacts')]
	links = ''.join(f'<li><a href="#/{t}">{e(x)}</a></li>' for x, t in zip(F['links'], targets))
	return f'''<footer class="ftr"><div class="wrap"><div class="ftr__grid">
<div><a class="ftr__logo" href="#/{R(l)}">{img('logo-secundario-branco', 'Nautic Squad')}</a></div>
<div><h4>{e(F['links_label'])}</h4><ul>{links}</ul></div>
<div><h4>{e(F['office_label'])}</h4><p><a href="{LINKS['phone']}">{e(F['phone'])}</a><br>{e(F['office'])}</p><h4 style="margin-top:1.4rem">{e(F['boats_label'])}</h4><p>{'<br>'.join(e(m) for m in F['marinas'])}</p></div>
<div><h4>{e(F['social_label'])}</h4><div class="social"><a href="{LINKS['instagram']}" target="_blank" rel="noopener" aria-label="Instagram">{ICON['ig']}</a><a href="{LINKS['facebook']}" target="_blank" rel="noopener" aria-label="Facebook">{ICON['fb']}</a><a href="{LINKS['linkedin']}" target="_blank" rel="noopener" aria-label="LinkedIn">{ICON['in']}</a><a href="{LINKS['email']}" aria-label="Email">{ICON['mail']}</a><a href="{LINKS['pdf']}" target="_blank" rel="noopener" aria-label="{UI[l]['brochure']}" title="{UI[l]['brochure']}">{ICON['pdf']}</a></div></div>
</div><div class="ftr__bot"><span>{e(F['copyright'])}</span><span>{LINKS['email_txt']} · {e(F['phone'])}</span></div></div></footer>'''

# --------------------------------------------------------------------------
# Páginas
# --------------------------------------------------------------------------
def page(route, lang, title, body, alt_pt, alt_en):
	return f'<div class="page" data-route="{route}" data-lang="{lang}" data-title="{e(title)}" data-altpt="{alt_pt}" data-alten="{alt_en}">{body}{footer(lang)}</div>'

def home(l):
	h = C[l]['home']
	contact_route = R(l, 'contactos' if l == 'pt' else 'contacts')
	body = (hero(l, h['hero'], 'hero-veleiro', (h['hero_cta'], contact_route))
	        + club_panels(l) + how(l) + bento(l) + fleet(l, BOATS) + types(l) + community(l)
	        + band(l, h['cta'], 'marina-veleiro', (h['contact_btn'], contact_route))
	        + faq(l, ['sailing-club', 'sailing-academy', 'power-club']) + contacts(l, h['contact'], h['contacts_label']))
	return page(R(l), l, h['meta_title'], body, R('pt'), R('en'))

def club(l, key):
	t = C[l][key]
	ids = {'pt': ('conceito', 'tipos', 'frota', 'faq', 'contactos'), 'en': ('concept', 'types', 'boats', 'faq', 'contacts')}[l]
	concept = t['concept']
	after = t['after']
	res = reserv_parts(after)
	periods = re.findall(r'(manhã|tarde|noite|morning|afternoon|evening) \(([^)]*)\)', ' '.join(res))
	per = '<div class="periods">' + ''.join(f'<div class="period"><b>{e(n)}</b><span>{e(x)}</span></div>' for n, x in periods) + '</div>' if periods else ''
	dream = pick(after, 'dream')
	others = [p for p in after if p not in res and p != dream]
	ben = ''.join(f'<li>{e(b)}</li>' for b in t['benefits'])
	intro = f'''<section class="sec" id="{ids[0]}"><div class="wrap">
<div class="intro"><div><p class="lbl">{e(t['club_label'])}</p><p class="intro__big tl">{e(concept[0])}</p></div>
<div class="intro__txt rv">{''.join(P(p) for p in concept[1:])}</div></div>
<div class="bento" style="margin-top:clamp(3rem,6vw,5rem)"><div class="bx bx--a rv"><p class="h-m">{e(t['benefits_intro'])}</p><ul class="benefits">{ben}</ul></div>
<div class="bx bx--b ri">{img(CLUB_IMG[key], '')}</div>
<div class="bx bx--c rv" style="grid-column:span 5"><p class="quote">{e(dream)}</p></div></div>
<div class="intro" style="margin-top:clamp(3rem,6vw,5rem)"><div>{per}</div><div class="intro__txt rv">{''.join(P(p) for p in res)}{''.join(P(p) for p in others)}</div></div>
</div></section>'''
	boats = [b for b in BOATS if b['club'] == key]
	bl = []
	for b, bt in zip(boats, t['boats']):
		bl.append(f'''<article class="bl"><a class="bl__img ri" href="#/{boat_route(l, b)}">{img(b['imgs'][0], b['name'])}</a>
<div class="rv"><p class="lbl">{e(bt['label'])}</p><h3>{e(b['name'])}</h3>{''.join(P(p) for p in bt['text'])}<a class="lnk" href="#/{boat_route(l, b)}">{UI[l]['view']} <span class="arr">→</span></a></div></article>''')
	fleet_sec = f'''<section class="sec" id="{ids[2]}" style="background:rgba(162,236,243,.16)"><div class="wrap"><div class="sec__head"><div><p class="lbl">{e(t['fleet_label'])}</p><h2 class="h-l tl">{e(CLUB_NAME[key])}</h2></div></div><div class="boats-list">{''.join(bl)}</div></div></section>'''
	contact_route = R(l, key + '/' + ids[4])
	closing = band(l, t['closing'], CLUB_HERO[key], (C[l]['home']['hero_cta'], contact_route)) if t['closing'] else ''
	body = (hero(l, t['title'], CLUB_HERO[key], (t['types_cta'], R(l, key + '/' + ids[1])), page=True, coords=False, label=CLUB_NAME[key])
	        + intro + types(l, key, ids[1]) + fleet_sec + faq(l, [key], ids[3]) + closing + contacts(l, t['contact'], sid=ids[4]))
	return page(R(l, key), l, t['meta_title'], body, R('pt', key), R('en', key))

def boat_page(l, b, i):
	h = C[l]['home']
	bt_home = h['boats'][i]
	clubp = C[l][b['club']]
	bt_club = next((x for x, bb in zip(clubp['boats'], [z for z in BOATS if z['club'] == b['club']]) if bb['slug'] == b['slug']), None)
	paras = list(bt_home['text'])
	if bt_club:
		for p in bt_club['text']:
			if p not in paras and not any(p.replace(' ', '')[:60].lower() == q.replace(' ', '')[:60].lower() for q in paras):
				paras.append(p)
	extra_club = [p for p in (bt_club['text'] if bt_club else []) if p not in paras]
	F = C[l]['footer']
	mname = F['marinas'][0 if b['marina'] == 'oeiras' else 1]
	specs = b['specs'][l] + [('specs_club', CLUB_NAME[b['club']]), ('specs_marina', mname)]
	dl = ''.join(f'<div><dt>{UI[l][k]}</dt><dd>{e(v)}</dd></div>' for k, v in specs)
	gal = ''.join(f'<figure class="ri" data-lb="boat" data-k="{k}" data-c="{e(b["name"])}" tabindex="0">{img(k, b["name"])}</figure>' for k in b['imgs'])
	if b['slug'] == 'oceanbliss':
		pass
	others = ''.join(f'<a class="other" href="#/{boat_route(l, o)}">{img(o["imgs"][0], o["name"])}<small>{CLUB_NAME[o["club"]]}</small><span>{e(o["name"])}</span></a>' for o in BOATS if o is not b)
	tnames = ' · '.join(x['name'] for x in clubp['types']) + ' · TEAM'
	club_ids = {'pt': ('tipos', 'contactos'), 'en': ('types', 'contacts')}[l]
	body = f'''{hero(l, b['name'], b['imgs'][0], (h['hero_cta'], R(l, 'contactos' if l == 'pt' else 'contacts')), page=True, coords=False, label=bt_home['label'])}
<section class="sec"><div class="wrap"><dl class="bp-specs rv">{dl}</dl>
<div class="bp-txt" style="margin-top:clamp(3rem,6vw,5rem)"><div><p class="lbl">{e(h['fleet_label'])}</p><h2 class="h-m">{e(b['name'])}</h2></div><div class="bp-txt__body rv">{''.join(P(p) for p in paras)}</div></div></div></section>
<section class="sec" style="padding-top:0"><div class="wrap"><p class="lbl">{UI[l]['gallery']}</p><div class="bp-gal">{gal}</div>
<p class="need" style="margin-top:1.4rem"><b>{UI[l]['needs']}:</b> {UI[l]['needs_txt']}</p></div></section>
<section class="sec sec--teal"><div class="wrap sec__head" style="margin-bottom:0"><div><p class="lbl lbl--light" style="color:#fff">{e(clubp['types_label'])}</p><h2 class="h-m">{e(CLUB_NAME[b['club']])} — {e(mname)}</h2></div>
<div><p class="lead" style="color:#fff">{e(tnames)}</p><a class="btn btn--white" href="#/{R(l, b['club'] + '/' + club_ids[0])}">{UI[l]['types_of']} <span class="arr">→</span></a></div></div></section>
<section class="sec"><div class="wrap"><p class="lbl">{UI[l]['others']}</p><div class="others">{others}</div></div></section>'''
	title = f"{b['name']} | {C[l]['home']['meta_title']}"
	return page(boat_route(l, b), l, title, body, boat_route('pt', b), boat_route('en', b))

def build():
	pages = []
	for l in ('pt', 'en'):
		pages.append(home(l))
		for k in ('sailing-club', 'sailing-academy', 'power-club'):
			pages.append(club(l, k))
		for i, b in enumerate(BOATS):
			pages.append(boat_page(l, b, i))
	css = open(os.path.join(ROOT, 'src', 'styles.css'), encoding='utf-8').read()
	js = open(os.path.join(ROOT, 'src', 'app.js'), encoding='utf-8').read()
	imgs = {}
	for k in MEDIA:
		for ext, mime in (('webp', 'image/webp'), ('png', 'image/png')):
			pth = os.path.join(ROOT, 'img', k + '.' + ext)
			if os.path.exists(pth):
				imgs[k] = f'data:{mime};base64,' + base64.b64encode(open(pth, 'rb').read()).decode()
				break
	mbar = ''.join(f'''<div data-lang-ui="{l}"{' hidden' if l == 'en' else ''} style="display:contents"><a href="{LINKS['phone']}">{ICON['phone']}{UI[l]['call']}</a><a href="{LINKS['email']}">{ICON['mail']}{UI[l]['mail']}</a><a class="is-main" href="#/{R(l, 'contactos' if l == 'pt' else 'contacts')}">{ICON['cal']}{e(C[l]['home']['hero_cta'])}</a></div>''' for l in ('pt', 'en'))
	toast = ''.join(f'<div data-lang-ui="{l}"{" hidden" if l == "en" else ""}>{UI[l]["socio_note"]}</div>' for l in ('pt', 'en'))
	lightbox = '<div class="lb" role="dialog" aria-modal="true" aria-label="Galeria"><button class="lb__x" type="button" aria-label="Fechar / Close">✕</button><div class="lb__stage"><img alt=""></div><div class="lb__bar"><span class="lb__cap"></span><span class="lb__n"></span><span class="lb__nav"><button type="button" data-lb-prev aria-label="Anterior / Previous">←</button><button type="button" data-lb-next aria-label="Seguinte / Next">→</button></span></div></div>'
	doc = f'''<!doctype html>
<html lang="pt-PT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{e(C['pt']['home']['meta_title'])}</title>
<meta name="description" content="{e(C['pt']['home']['clubs'][0]['text'][0])}">
<meta name="robots" content="noindex">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
<style>{css}</style>
</head>
<body>
<a class="sr-only" href="#main">Saltar para o conteúdo</a>
{header()}
{menu()}
<main id="main">{''.join(pages)}</main>
{quiz_dialog()}
{lightbox}
<div class="toast" role="status">{toast}</div>
<nav class="mbar" aria-label="Ações rápidas">{mbar}</nav>
<script>window.NS_IMG={json.dumps(imgs)};window.NS_UI={json.dumps({'boatsShown': UI['pt']['boats_shown']})};</script>
<script>{js}</script>
</body></html>'''
	out = os.path.join(ROOT, 'nautic-squad-prototipo.html')
	open(out, 'w', encoding='utf-8').write(doc)
	print('OK', out, round(len(doc) / 1024 / 1024, 2), 'MB', len(pages), 'páginas')

if __name__ == '__main__':
	build()
