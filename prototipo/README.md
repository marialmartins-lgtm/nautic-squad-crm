# Nautic Squad — Protótipo v6 · Premium Nautical Lifestyle

**Ficheiro a abrir:** [`nautic-squad-prototipo.html`](nautic-squad-prototipo.html). É um único ficheiro, abre-se em qualquer browser e funciona offline, com exceção do tipo de letra Montserrat, que vem do Google Fonts.

O protótipo anterior (v5) ficou intacto em `wordpress/preview/index.html`.

| | |
|---|---|
| Páginas navegáveis | 18 = 9 PT + 9 EN: Início, Sailing Club, Sailing Academy, Power Club e 5 embarcações |
| Conteúdos | **785/785** linhas de texto do site atual presentes, verificado automaticamente (ver [VALIDACAO-CONTEUDOS.md](VALIDACAO-CONTEUDOS.md)) |
| Cores | 11 cores, todas do Manual de Normas 2020 ou do site atual; nenhuma cor nova |
| Fotografias | 19 fotografias reais do site atual (WebP), sem imagens de banco nem geradas por IA |
| Dependências | Nenhuma (JavaScript próprio, cerca de 20 KB); sem page builder |

Rotas: `#/` (PT), `#/en` (EN), `#/sailing-club`, `#/en/sailing-academy`, `#/frota/oceanescape`, `#/en/boats/fifty-fifty`, etc.

---

## 1. Análise do site atual (feita antes do redesign)

**Páginas (PT e EN):** Início (`/`, `/en`), Sailing Club (`/sailing-club`), Sailing Academy (`/sailing-academy`) e Power Club (`/copy-of-sailing-club`). Todo o texto foi extraído literalmente do HTML publicado para [`content/content.json`](content/content.json), com a cópia bruta em `content/site-atual-extraido.json`.

**Ligações e funcionalidades existentes, todas preservadas:**
- 3 formulários Microsoft Forms com os respetivos QR codes (descodificados para confirmar que cada QR corresponde à ligação certa):
  - mais informações (`6nTuwHtfwU`);
  - agendar visita (`ugmNhFpCvC`);
  - aderir ou lista de espera (`0076apC7rm`).
- Telefone 911 924 555, `sales@nauticsquad.com`, escritório, marinas.
- Instagram, Facebook, LinkedIn.
- A brochura PDF ligada no rodapé (o "." do site atual).

**Cores efetivamente usadas:**

| HEX | Origem | Uso no protótipo |
|---|---|---|
| `#008392` | Manual de Normas (Pantone 7713) | Cor principal de marca, botões ao passar o rato, faixa teal |
| `#0097A9` | Manual de Normas (Pantone 7711) | Numerais grandes |
| `#00B0B9` | Manual de Normas (Pantone 3262) | Variável de tema (reserva) |
| `#04BDC7` | Site atual — turquesa dos botões | Botões, destaques, filtros, bloco Team |
| `#004647` | Site atual — petróleo | Secções escuras, frota, contactos, rodapé, texto sobre turquesa |
| `#A2ECF3` | Site atual — aqua | Etiquetas sobre fundo escuro, tons claros (em transparência) |
| `#323333` · `#646666` · `#8F8F8F` · `#E2E2E2` | Site atual — cinzentos | Texto, texto secundário, linhas |
| `#FFFFFF` | — | Fundos |

**Tipografia:** Segoe UI (Manual de Normas), com Montserrat (já usada no site atual) nas etiquetas e botões.

**Logótipo:** original, sem alterações.
- Versão secundária branca sobre fotografia e fundos escuros.
- Versão principal a cores no cabeçalho sólido, acima da largura mínima de 79 px.

## 2. O que mudou (visual e funcional)

| Área | Antes (v5) | Agora (v6) |
|---|---|---|
| **Abertura** | Cartões sobrepostos, título inventado | Foto real em ecrã inteiro com parallax e entrada palavra a palavra do título **original**. Coordenadas das marinas, indicador de scroll e uma linha de rota animada. Os cartões sobrepostos foram retirados. |
| **Menu** | Barra simples | Cabeçalho transparente sobre a foto, que fica sólido ao descer e se esconde ao descer depressa. Menu em ecrã inteiro com tipografia grande e foto que muda conforme a opção, PT/EN e "Área de sócio". |
| **Clubes** | 3 cartões | 3 painéis fotográficos verticais. No computador expandem ao passar o rato e revelam a descrição. No telemóvel deslizam com o dedo e o texto está sempre visível (nada depende do hover). |
| **Como funciona** | Ícones | Fotografia fixa que muda a cada passo, ajustando-se ao formato da foto. Numeração, barra de progresso, passo ativo destacado e os 3 períodos de reserva. |
| **Vantagens** | Lista | Bento grid com as 7 vantagens, o que a mensalidade inclui, "Parece um sonho, mas é realidade." e a nota de inscrições limitadas, intercalados com fotos. |
| **Frota** | Grelha | Slider horizontal: arrastar com o rato ou o dedo, setas, teclado, progresso e filtros por **clube** e por **marina**. Cada foto mantém o seu formato e há página individual para cada barco. |
| **Embarcações** | — | 5 páginas com foto de abertura, ficha técnica (só dados do site), descrição editorial, galeria em ecrã inteiro (setas, teclado, swipe), modalidades aplicáveis e outras embarcações. |
| **Modalidades** | Lista | Tabela comparativa: saídas/mês, barra semana vs. fim de semana, filtros, linhas expansíveis com o texto original e Team em destaque. Inclui o **questionário (demonstração)**. |
| **Comunidade** | Galeria simples | "Quem somos" com os fundadores e as 9 fotos da galeria numa composição editorial assimétrica, com as legendas originais de cada língua e visualização em ecrã inteiro. |
| **FAQ** | Uma lista | Separadores por clube (Sailing Club / Academy / Power Club, cada um com as suas perguntas, que diferem no site), pesquisa com destaque e acordeão animado. |
| **Contactos** | Formulário próprio | Os **3 formulários originais** (mesmos destinos) em linhas grandes com QR, mais telefone, email, escritório, marinas e redes. O formulário próprio do v5 foi retirado, porque mudava o destinatário. |
| **Telemóvel** | Adaptação | Barra fixa em baixo (Ligar · Email · Agende a sua visita), painéis e frota com swipe, menu em ecrã inteiro, tipografia e alvos de toque ajustados. |

**Animações:** revelação de texto e de imagens, parallax subtil, linha de rota a desenhar-se, onda contínua, setas com microinteração, expansão animada dos acordeões e transição dos painéis. Não há preloader nem cursor personalizado. Tudo é desativado com "reduzir movimento".

## 3. Microtexto de interface criado

Não é conteúdo do site; são etiquetas de navegação, necessárias para as novas interações:
- botões e navegação: "Ver embarcação", "Anterior/Seguinte", "Arraste ou use as setas", "Deslize para ver os três clubes", "Ligar", "Email", "Brochura (PDF)";
- filtros: "Todos", "Durante a semana", "Ao fim de semana";
- títulos das ferramentas: "Modalidades de associação", "Pesquisar nas perguntas";
- as perguntas do questionário e os rótulos da ficha técnica: Modelo, Comprimento, Ano, Cabines, Capacidade, Leme, Altura livre, Clube, Marina.

Todos os slogans e títulos editoriais são os do site.

## 4. Funcionalidades que precisam de integração real

| Funcionalidade | Estado no protótipo |
|---|---|
| Área de sócio | Botão no menu com nota "a integrar". O endereço da aplicação de reservas não consta do site atual. |
| Questionário de modalidade | **Demonstração identificada como tal.** A lógica usa só as regras publicadas (n.º de saídas e dias de cada modalidade); sem preços nem disponibilidade. |
| Formulários | Ligações aos Microsoft Forms atuais. Integração com o CRM ou envio por WordPress a definir. |
| Botão WhatsApp ("Questions? Talk to us") | O widget do site atual é injetado pela Wix e o número não aparece no HTML. É preciso indicar o número. |
| Quotas disponíveis / oportunidades Team | Não há dados no site. A arquitetura prevê o campo, mas o protótipo não simula disponibilidade. |
| Agendamento de visitas, eventos, email marketing | Conceito apenas. |
| GA4, Google Tag Manager, Meta Pixel, consentimento de cookies | A instalar no WordPress, com banner de consentimento (RGPD). |

## 5. Materiais em falta

- **Abertura em alta resolução** (a foto atual tem 1263 px) e, idealmente, **vídeo** real de navegação.
- **OCEANBLISS:** só existe 1 foto, e na galeria aparece com a legenda "OCEANVIEW II". É preciso confirmar se é o mesmo barco e obter mais fotos.
- **OCEANVIBES:** a foto do site tem apenas 426 px.
- **Interiores e plantas** de todas as embarcações (não existem no site).
- Fotos de sócios, eventos e convívio, para reforçar a secção de comunidade.

## 6. Divergências encontradas no site atual (preservadas tal como estão)

1. **Legendas da galeria em EN** diferentes das PT e desatualizadas (por exemplo, a foto do FIFTY FIFTY aparece como "OCEANVIEW, Tejo River, August 2022").
2. **Menu FROTA** do site lista OCEANVIEW, OCEANESCAPE e OCEANFUN, enquanto a secção Frota descreve OCEANBLISS, OCEANESCAPE, OCEANVIBES, OCEANFUN e FIFTY FIFTY. O protótipo segue a secção Frota.
3. **Sailing Academy PT:** a FAQ diz "dois períodos (9h–14h e 15h–8h)", mas a página e a versão EN dizem três.
4. **Power Club:** o período da noite é "19h–20h" (nas outras páginas é 19h–08h). Os textos referem "veleiro".
5. **Rodapé:** "© 2021 NAUTIC SQUAD"; o link "." abre a brochura PDF.
6. **Manual de Normas:** indica outro contacto da marina (Av. Marginal, Praia da Torre). O protótipo usa os contactos do site.

## 7. Preparação para WordPress

| Protótipo | WordPress (tema em blocos, sem page builder) |
|---|---|
| Página Início, páginas de clube, página de embarcação | `templates/front-page.html`, `page-clube.html` e `single-barco.html` |
| Cada secção (abertura, painéis, como funciona, bento, frota, modalidades, comunidade, faixa, FAQ, contactos) | **Block Patterns** reutilizáveis |
| Embarcações | **CPT `barco`**. Campos: nome, clube, marina, modelo, ano, comprimento, capacidade, cabines, galeria e textos PT/EN; taxonomias clube e marina (alimentam os filtros). |
| Modalidades | **CPT `modalidade`**. Campos: saídas à semana, saídas ao fim de semana, descrição; associação aos clubes. Alimenta a tabela e o questionário. |
| FAQ | **CPT `pergunta`** com taxonomia clube (separadores) |
| Galeria | Bloco Galeria nativo + lightbox do tema |
| Cores, tipografia, espaçamentos | `theme.json` (as 11 cores acima, Segoe UI e Montserrat) |
| PT / EN | Polylang (ou WPML): textos de `content/content.json` → traduções ligadas |
| URLs antigos | Redirecionamentos 301: `/copy-of-sailing-club` → `/power-club`, `/home` → `/`, `/en/*` mantidos |
| Metadados | Os títulos de página do site atual foram preservados (por exemplo, "Nautic Squad \| Clube de Vela para Skippers \| Oeiras \| Lisboa") |

**Próximo passo técnico:** passar este design para o tema `wordpress/nautic-squad/`. Hoje o tema ainda tem o design da v5.

## 8. Qualidade técnica

- **Imagens:** WebP; carregamento só quando visíveis. A abertura carrega primeiro.
- **Acessibilidade:**
  - contraste AA (por exemplo, texto `#004647` sobre `#04BDC7` = 4,63:1);
  - navegação por teclado em menu, slider, galeria e acordeões;
  - `alt` nas imagens, link "Saltar para o conteúdo" e `aria-live` nos filtros e na pesquisa;
  - respeita "reduzir movimento".
- **HTML:** semântico; um `h1` por página; `lang` muda entre PT e EN.
- **Testado:**
  - em computador (1440), tablet (834) e telemóvel (390), sem deslocamento horizontal;
  - menu, slider (setas e filtros), questionário, galeria em ecrã inteiro, pesquisa nas FAQ e troca PT/EN;
  - sem erros de JavaScript.

## 9. Regenerar e validar

```bash
python3 prototipo/tools/build.py                                          # gera o HTML
python3 prototipo/tools/validar.py prototipo/content/site-atual-extraido.json   # conteúdos + cores
```

Para atualizar os conteúdos a partir do site:
1. Descarregar as páginas (PT e EN).
2. Correr `tools/analisar_site.py`.
3. Correr `tools/extrair_conteudos.py`.
