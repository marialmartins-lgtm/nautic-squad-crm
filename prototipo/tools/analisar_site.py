import sys, re, html, collections, json
from html.parser import HTMLParser

class P(HTMLParser):
    def __init__(self):
        super().__init__()
        self.skip = 0; self.out = []; self.links = []; self.cur = None
    def handle_starttag(self, tag, attrs):
        a = dict(attrs)
        if tag in ('script', 'style', 'noscript', 'svg', 'template'): self.skip += 1
        if tag in ('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'li', 'div', 'br', 'span', 'a', 'button'): self.out.append('\n')
        if tag == 'a' and a.get('href'):
            self.cur = [a['href'], '']
            self.links.append(self.cur)
    def handle_endtag(self, tag):
        if tag in ('script', 'style', 'noscript', 'svg', 'template') and self.skip: self.skip -= 1
        if tag == 'a': self.cur = None
    def handle_data(self, d):
        if not self.skip:
            self.out.append(d)
            if self.cur is not None: self.cur[1] += d

res = {}
for f in sys.argv[1:]:
    src = open(f, encoding='utf-8', errors='ignore').read()
    p = P(); p.feed(src)
    lines = [re.sub(r'\s+', ' ', l.replace('​', '')).strip() for l in ''.join(p.out).split('\n')]
    seen = []
    for l in lines:
        if l and (not seen or seen[-1] != l): seen.append(l)
    a = seen.index('Use tab to navigate through the menu items.') if 'Use tab to navigate through the menu items.' in seen else 0
    body = [l for l in seen if l not in ('top of page', 'bottom of page')]
    links = sorted({(h, re.sub(r'\s+', ' ', t).strip()) for h, t in p.links})
    cols = collections.Counter(c.upper() for c in re.findall(r'#[0-9a-fA-F]{6}\b', src))
    rgb = collections.Counter(re.findall(r'--color_\d+:\s*([0-9,\s]+);', src))
    fonts = collections.Counter(re.findall(r'font-family:\s*([^;"]+)', src))
    res[f.split('/')[-1]] = {'text': body, 'links': links, 'colors': cols.most_common(25), 'wixpalette': rgb.most_common(40), 'fonts': fonts.most_common(8)}
json.dump(res, open(sys.argv[1].rsplit('/', 1)[0] + '/../analysis.json', 'w'), ensure_ascii=False, indent=1)
for k, v in res.items():
    print('==', k, len(v['text']), 'linhas;', len(v['links']), 'links')
