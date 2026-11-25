#!/usr/bin/env python3
"""
Valida que TODOS os textos do site atual (PT e EN) estão presentes no protótipo.
Uso: python3 prototipo/tools/validar.py <analysis.json do site> [protótipo.html]
Gera prototipo/VALIDACAO-CONTEUDOS.md
"""
import html, json, os, re, sys
from html.parser import HTMLParser

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
A = json.load(open(sys.argv[1]))
proto = sys.argv[2] if len(sys.argv) > 2 else os.path.join(ROOT, 'nautic-squad-prototipo.html')

class T(HTMLParser):
	def __init__(self):
		super().__init__(); self.out = []; self.skip = 0
	def handle_starttag(self, tag, attrs):
		if tag in ('script', 'style'): self.skip += 1
		for k, v in attrs:
			if k in ('data-rules', 'data-title') and v: self.out.append(' ' + re.sub(r'<[^>]+>', ' ', html.unescape(v)) + ' ')
	def handle_endtag(self, tag):
		if tag in ('script', 'style') and self.skip: self.skip -= 1
	def handle_data(self, d):
		if not self.skip: self.out.append(' ' + d + ' ')

def norm(s):
	s = s.replace('​', '').replace('\xa0', ' ').replace('👉', '')
	return re.sub(r'\s+', ' ', s).strip()

p = T(); p.feed(open(proto, encoding='utf-8').read())
P = norm(''.join(p.out))
Pn = norm(P.replace(' .', '.').replace(' ,', ','))

IGNORE = {'Use tab to navigate through the menu items.', 'More', 'top of page', 'bottom of page', 'Conceito - CLUB', 'Frota Club', 'Frota - ACADEMY',
          'FAQ - ACADMEMY', 'Contact us - club', 'Contactos Academy', 'TIPOS DE ASSOCIAÇÃO - ACADEMY', 'MEMBERSHIP PLANS', 'MEMBERSHIP PLANS - ACADEMY',
          'TIPOS DE ASSOCIADOS', 'GALERIA', 'QUEM SOMOS?', 'OCEANVIEW', 'LINKS', '.'}
report, total, missing_all = [], 0, []
for page, d in A.items():
	lines = d['text']
	k = lines.index('Use tab to navigate through the menu items.') if 'Use tab to navigate through the menu items.' in lines else 0
	nav = lines[1:k]
	body = [l for l in lines[k + 1:] if l not in IGNORE]
	miss = []
	for l in body + [lines[0]]:
		n = norm(l)
		if not n or n in IGNORE: continue
		total += 1
		if n not in P and n not in Pn and n.replace(' .', '.') not in Pn:
			miss.append(n)
	nav_miss = [x for x in nav if norm(x) not in P and x not in IGNORE]
	report.append((page, len(body), miss, nav_miss))
	missing_all += miss

ok = total - len(missing_all)
md = ['# Validação de conteúdos — protótipo vs. nauticsquad.com', '',
      f'Linhas de texto do site atual verificadas: **{total}** · presentes no protótipo: **{ok}** · em falta: **{len(missing_all)}**', '',
      'Método: o texto visível de cada página do site atual (PT e EN) foi extraído do HTML publicado e procurado, literalmente, no texto do protótipo.',
      'Etiquetas internas do Wix (âncoras invisíveis como "Frota Club" ou "FAQ - ACADMEMY") e linhas só de pontuação são ignoradas.', '']
for page, n, miss, nav_miss in report:
	md.append(f'## {page} — {n} linhas · em falta: {len(miss)}')
	for m in miss:
		md.append(f'- ❌ {m}')
	if nav_miss:
		md.append(f'- Menu do site não reproduzido literalmente: {", ".join(sorted(set(nav_miss)))}')
	md.append('')
open(os.path.join(ROOT, 'VALIDACAO-CONTEUDOS.md'), 'w', encoding='utf-8').write('\n'.join(md))
print(f'{ok}/{total} presentes; em falta: {len(missing_all)}')
for page, n, miss, nav_miss in report:
	print(page, len(miss), [m[:70] for m in miss][:12], '| nav:', sorted(set(nav_miss))[:8])

# ---------------------------------------------------------------- Cores
ALLOWED = {  # Manual de Normas 2020 + site atual nauticsquad.com
	'#008392': 'Manual — Pantone 7713', '#0097A9': 'Manual — Pantone 7711', '#00B0B9': 'Manual — Pantone 3262',
	'#04BDC7': 'site — turquesa (botões)', '#004647': 'site — petróleo', '#A2ECF3': 'site — aqua claro',
	'#323333': 'site — texto', '#646666': 'site — texto secundário', '#8F8F8F': 'site — cinzento', '#E2E2E2': 'site — linhas', '#FFFFFF': 'branco'}
def rgb2hex(m):
	return '#%02X%02X%02X' % tuple(int(x) for x in m)
src = open(os.path.join(ROOT, 'src', 'styles.css'), encoding='utf-8').read() + open(os.path.join(ROOT, 'tools', 'build.py'), encoding='utf-8').read()
used = {}
for h in re.findall(r'#[0-9a-fA-F]{6}\b', src):
	used[h.upper()] = used.get(h.upper(), 0) + 1
for m in re.findall(r'rgba?\((\d+),\s*(\d+),\s*(\d+)', src):
	h = rgb2hex(m); used[h] = used.get(h, 0) + 1
for short in re.findall(r'#([0-9a-fA-F]{3})\b(?![0-9a-fA-F])', src):
	h = '#' + ''.join(c * 2 for c in short).upper(); used[h] = used.get(h, 0) + 1
bad = {k: v for k, v in used.items() if k not in ALLOWED}
lines = ['', '# Validação de cores', '', '| Cor | Origem | Utilizações |', '|---|---|---|']
lines += [f'| `{k}` | {ALLOWED.get(k, "**NÃO AUTORIZADA**")} | {v} |' for k, v in sorted(used.items())]
lines += ['', 'Resultado: ' + ('**todas as cores usadas pertencem à paleta da marca.**' if not bad else f'**cores fora da paleta: {", ".join(bad)}**'),
          'As transparências (rgba) usam exclusivamente estas mesmas cores, em diferentes proporções.']
with open(os.path.join(ROOT, 'VALIDACAO-CONTEUDOS.md'), 'a', encoding='utf-8') as f:
	f.write('\n'.join(lines) + '\n')
print('cores usadas:', sorted(used), '| fora da paleta:', bad or 'nenhuma')
