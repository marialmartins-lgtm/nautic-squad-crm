"""Extrai os conteúdos do site atual (Wix) para content.json — texto literal, PT e EN."""
import json, re, sys

A = json.load(open(sys.argv[1]))
OUT = sys.argv[2]

def lines(page):
    t = A[page]['text']
    i = t.index('Use tab to navigate through the menu items.')
    j = len(t) - 1 - t[::-1].index('LINKS') if 'LINKS' in t else len(t)
    return t[:i], t[i + 1:], t[j:]

def is_end(l):
    return bool(re.search(r'[.!?:;)]$', l))

def paras(ls):
    """Junta linhas partidas pelo Wix (quebras <br>/spans) em parágrafos."""
    out = []
    for l in ls:
        prev = out[-1] if out else ''
        join = out and not is_end(prev) and (l[:1].islower() or l[:1] in '.,;:' or re.match(r'^\d', l) or len(prev) < 45 or l[:1] == '“')
        if join:
            sep = '' if l[:1] in '.,;:' else ' '
            out[-1] = prev + sep + l
        else:
            out.append(l)
    return out

def idx(ls, *cands, start=0):
    for k in range(start, len(ls)):
        if ls[k] in cands or any(ls[k].startswith(c) for c in cands if c.endswith('…')):
            return k
    raise KeyError(cands)

TYPES = ('Full light', 'Week light', 'Weekday', 'Weekend', 'Full week')
INTERNAL = {'Conceito - CLUB', 'Conceito', 'TIPOS DE ASSOCIADOS', 'TIPOS DE ASSOCIAÇÃO - ACADEMY', 'Frota Club', 'Frota - ACADEMY',
            'FAQ - ACADMEMY', 'Contact us - club', 'Contactos Academy', 'MEMBERSHIP PLANS', 'MEMBERSHIP PLANS - ACADEMY'}

def club_page(page, lang):
    nav, L, _ = lines(page)
    L = [l for l in L if l not in INTERNAL]
    d = {'title': L[0], 'meta_title': nav[0]}
    k_club = idx(L, 'O CLUBE', 'THE CLUB')
    k_types = idx(L, 'TIPOS DE ASSOCIAÇÃO', 'BECOME A MEMBER', start=k_club)
    concept = L[k_club + 1:k_types]
    d['club_label'] = L[k_club]
    # vantagens
    kb = next(i for i, l in enumerate(concept) if l.endswith(':') and ('vantagens' in l or 'advantages' in l or 'privileges' in l))
    kr = next(i for i, l in enumerate(concept) if l.startswith(('As reservas', 'Reservations')))
    d['concept'] = paras(concept[:kb])
    d['benefits_intro'] = concept[kb]
    d['benefits'] = concept[kb + 1:kr]
    d['after'] = paras(concept[kr:])
    d['types_label'] = L[k_types]
    k_fleet = idx(L, 'FROTA', 'BOATS', start=k_types)
    T = L[k_types + 1:k_fleet]
    first = next(i for i, l in enumerate(T) if l in TYPES)
    d['types_intro'] = paras(T[:first])
    types, note, team, cta = [], [], None, None
    i = first
    while i < len(T):
        l = T[i]
        if l in TYPES:
            body = []
            i += 1
            while i < len(T) and T[i] not in TYPES and not T[i].startswith(('Os sócios podem', 'Members can', 'Team')):
                body.append(T[i]); i += 1
            types.append({'name': l, 'text': paras(body)})
        elif l.startswith(('Os sócios podem', 'Members can')):
            note.append(l); i += 1
        elif l.startswith('Team'):
            team = {'name': l, 'text': []}
            i += 1
            while i < len(T) and not T[i].startswith(('Garanta', 'Secure')):
                team['text'].append(T[i]); i += 1
            team['text'] = paras(team['text'])
        elif l.startswith(('Garanta', 'Secure')):
            cta = l; i += 1
        else:
            raise ValueError('types: ' + l)
    d['types'], d['types_note'], d['team'], d['types_cta'] = types, note, team, cta
    d['fleet_label'] = L[k_fleet]
    k_faq = idx(L, 'QUESTÕES', 'FAQ', start=k_fleet)
    F = L[k_fleet + 1:k_faq]
    boats, cur = [], None
    for l in F:
        if re.match(r'^(Sailing Club|Sailing Academy|Power Club)\s*-', l):
            cur = {'label': l, 'text': []}; boats.append(cur)
        elif cur and cur['label'].endswith('-') and not cur['text']:
            cur['label'] += ' ' + l
        else:
            cur['text'].append(l)
    for b in boats:
        b['text'] = paras(b['text'])
    d['boats'] = boats
    # FAQ
    k = k_faq
    while not L[k].endswith('?'):
        k += 1
    d['faq_label'] = 'QUESTÕES FREQUENTES' if 'QUESTÕES' in L[k_faq:k] else 'FAQ'
    k_contact = idx(L, 'FALE CONNOSCO', 'CONTACT US', start=k)
    Q = L[k:k_contact]
    CLOSE = ('Está na hora', 'Está pronto', "It's time", 'Are you', 'Ready')
    kc = next((i for i, l in enumerate(Q) if l.startswith(CLOSE) or l == 'Are'), len(Q))
    closing = [l for l in Q[kc:] if l != 'FAQ']
    Q = Q[:kc]
    faq = []
    for l in Q:
        if l.endswith('?') and not (faq and not faq[-1]['a']):
            faq.append({'q': l, 'a': []})
        elif l == 'FAQ':
            continue
        else:
            faq[-1]['a'].append(l)
    for f in faq:
        f['a'] = paras(f['a'])
    d['faq'] = faq
    d['closing'] = ' '.join(closing)
    d['contact'] = contact_block(L[k_contact:])
    return d

def contact_block(C):
    c = {'title': C[0], 'intro': C[1], 'select': C[2], 'forms': []}
    i = 3
    while i < len(C) and C[i].startswith('👉'):
        c['forms'].append({'label': C[i].replace('👉', '').strip(), 'url': C[i + 1]}); i += 2
    return c

def footer(page):
    _, L, _ = lines(page)
    k = L.index('LINKS')
    F = L[k:]
    ko = next(i for i, l in enumerate(F) if l in ('Escritório', 'Office'))
    kb = next(i for i, l in enumerate(F) if l in ('Embarcações', 'Boats'))
    ks = F.index('SOCIAL')
    return {'links_label': F[0], 'links': F[1:ko - 1], 'phone': F[ko - 1], 'office_label': F[ko], 'office': ' '.join(F[ko + 1:kb]),
            'boats_label': F[kb], 'marinas': F[kb + 1:ks], 'social_label': F[ks], 'after_social': F[ks + 1:-1], 'copyright': F[-1]}

def home(page, lang):
    nav, L, _ = lines(page)
    d = {'meta_title': nav[0], 'menu': [l for l in nav[1:] if l not in ('More',)]}
    k_cta = idx(L, 'Agende a sua visita', 'Schedule your visit')
    d['hero'] = ' '.join(L[:k_cta]).replace('  ', ' ')
    d['hero_cta'] = L[k_cta]
    rest = L[k_cta + 1:]
    k_contact_btn = idx(rest, 'Contacte-nos', 'Contact Us')
    C = rest[:k_contact_btn]
    clubs = []
    def grab(name, start):
        k = idx(C, name, start=start)
        return k
    # Sailing Club: título antes do texto; Academy: texto antes do título; Power: título antes
    kSC = idx(C, 'SAILING CLUB'); kSCm = next(i for i, l in enumerate(C) if l.startswith(('Saiba mais sobre o Sailing Club', 'Learn more about the Sailing Club')))
    kSA = idx(C, 'SAILING ACADEMY'); kSAm = next(i for i, l in enumerate(C) if l.startswith(('Saiba mais sobre o Sailing Academy', 'Learn more about the Sailing Academy')))
    kPC = idx(C, 'POWER CLUB'); kPCm = next(i for i, l in enumerate(C) if l.startswith(('Saiba mais sobre o Power Club', 'Learn more about the Power Club')))
    clubs.append({'key': 'sailing-club', 'name': 'SAILING CLUB', 'text': paras(C[kSC + 1:kSCm]), 'more': C[kSCm]})
    clubs.append({'key': 'sailing-academy', 'name': 'SAILING ACADEMY', 'text': paras(C[kSCm + 1:kSA]), 'more': C[kSAm]})
    clubs.append({'key': 'power-club', 'name': 'POWER CLUB', 'text': paras(C[kPC + 1:kPCm]), 'more': C[kPCm]})
    d['clubs'] = clubs
    d['contact_btn'] = rest[k_contact_btn]
    R = rest[k_contact_btn + 1:]
    if R[0] == 'OCEANVIEW':
        d['legacy_anchor'] = R[0]; R = R[1:]
    d['fleet_label'] = R[0]
    k_about = idx(R, 'QUEM SOMOS', 'WHO WE ARE')
    boats, cur = [], None
    for l in R[1:k_about]:
        if re.match(r'^(Sailing Club|Sailing Academy|Power Club)\s*-', l):
            cur = {'label': l, 'text': []}; boats.append(cur)
        elif cur and cur['label'].endswith('-') and not cur['text']:
            cur['label'] += ' ' + l
        elif l in ('OCEANESCAPE', 'OCEANFUN'):
            continue  # âncoras internas do Wix
        else:
            cur['text'].append(l)
    for b in boats:
        b['text'] = paras(b['text'])
    d['boats'] = boats
    A2 = R[k_about:]
    k_gal = next(i for i, l in enumerate(A2) if l in ('GALERIA DE', 'GALLERY'))
    about = A2[:k_gal]
    d['about'] = {'label': about[0], 'title': about[1], 'text': paras(about[2:-2]), 'caption': about[-2], 'label2': about[-1]}
    if A2[k_gal] == 'GALERIA DE':
        d['gallery_label'] = 'GALERIA DE FOTOS'; g0 = k_gal + 2
    else:
        d['gallery_label'] = 'GALLERY'; g0 = k_gal + 1
    k_g_end = next(i for i, l in enumerate(A2) if l == 'GALERIA' and i > g0)
    caps = A2[g0:k_g_end]
    # legendas partidas em linhas: juntar as que não começam por nome de barco
    G = []
    for c in caps:
        if G and not re.match(r'^(OCEAN|FIFTY)', c):
            G[-1] += ' ' + c
        else:
            G.append(c)
    d['gallery'] = G
    d['gallery_label2'] = A2[k_g_end]
    d['cta'] = A2[k_g_end + 1]
    k_c = idx(A2, 'FALE CONNOSCO', 'CONTACT US')
    d['contacts_label'] = A2[k_c - 1]
    d['contact'] = contact_block(A2[k_c:])
    return d

content = {}
for lang, pre in (('pt', 'pt_'), ('en', 'en2_')):
    content[lang] = {
        'home': home(pre + 'root.html', lang),
        'sailing-club': club_page(pre + 'sailing-club.html', lang),
        'sailing-academy': club_page(pre + 'sailing-academy.html', lang),
        'power-club': club_page(pre + 'copy-of-sailing-club.html', lang),
        'footer': footer(pre + 'root.html'),
    }
json.dump(content, open(OUT, 'w'), ensure_ascii=False, indent=1)
for lang in content:
    h = content[lang]['home']
    print(lang, 'hero:', h['hero'][:80], '| clubs', [len(c['text']) for c in h['clubs']], '| boats', [b['label'] for b in h['boats']], '| gallery', len(h['gallery']))
    for p in ('sailing-club', 'sailing-academy', 'power-club'):
        c = content[lang][p]
        print('  ', p, c['title'], '| concept', len(c['concept']), '| benefits', len(c['benefits']), '| types', [t['name'] for t in c['types']], '| team', bool(c['team']), '| boats', len(c['boats']), '| faq', len(c['faq']), '| closing:', c['closing'][:50])
