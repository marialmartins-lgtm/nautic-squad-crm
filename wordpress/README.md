# Nautic Squad — novo site WordPress (versão cinematográfica)

Tema em blocos (Full Site Editing), premium e cinematográfico: fotografia em ecrã inteiro, scroll suave,
títulos que se revelam palavra a palavra, frota em scroll horizontal, galeria com revelação de imagens.
Tudo editável no editor do WordPress, sem page builders.

- `nautic-squad/` — o tema (também em `nautic-squad.zip`, pronto a carregar)
- `preview/index.html` — pré-visualização da página inicial (abrir no browser)
- `tools/build-preview.php` — regenera a pré-visualização a partir do tema: `php wordpress/tools/build-preview.php`

## Instalar

Guia completo da mudança Wix → WordPress (alojamento, DNS, email): **[MIGRACAO.md](MIGRACAO.md)**.

1. WordPress 6.5+ (testado em 7.1) → **Aparência → Temas → Adicionar novo → Carregar tema** → `nautic-squad.zip` → Ativar.
2. Clicar em **Importar conteúdo da Nautic Squad** no aviso do painel: cria a frota (5 barcos com fotos e ficha técnica),
   as páginas Sailing Club / Sailing Academy / Power Club, a página inicial e um rascunho da política de privacidade.
3. **Definições → Geral**: email de administração `sales@nauticsquad.com` (recebe os pedidos do formulário).
4. Para editar a frota: **Frota** no menu lateral (foto de destaque, tipo Vela/Motor, caixa "Ficha técnica", campo "Ordem").

Os endereços antigos da Wix (`/en/...`, `/home`, `/copy-of-sailing-club`) são redirecionados automaticamente.

## Fotografias e vídeo

| Onde | Como trocar |
|---|---|
| Qualquer secção com imagem de fundo (abertura, "Tu navegas", Academia, Contacto) | No editor, selecionar o Grupo → Estilos → **Imagem de fundo** |
| Imagens normais (passos, Power Club, galeria) | Clicar na imagem → **Substituir** |
| Sem editor | Substituir o ficheiro com o mesmo nome em `nautic-squad/assets/img/`: `hero`, `passo-1..3`, `incluido`, `power`, `quem-somos`, `momento-1..5`, `academia`, `contacto`, `oceanbliss`, `oceanescape`, `oceanvibes`, `oceanfun`, `fiftyfifty` (.jpg) e `logo-branco` / `logo-teal` (.png) |
| **Vídeo na abertura** | Colocar `nautic-squad/assets/video/hero.mp4` (≈10–20 s, sem som, 1920×1080, < 8 MB). Passa a tocar em loop automaticamente |

> As fotografias, o logótipo e os textos foram retirados do site atual **nauticsquad.com** (PT) e otimizados
> para a web. Algumas fotos do site atual têm resolução baixa (ex.: `hero.jpg` 1263 px, `oceanvibes.jpg` 426 px) —
> vale a pena substituí-las pelos originais em alta resolução.

## Efeitos

- Ecrã de entrada (preloader) e barras de cinema que se abrem sobre a imagem/vídeo de abertura
- Scroll suave (Lenis, MIT), grão de filme, cursor personalizado no desktop
- Menu em ecrã inteiro (bloco Navegação com sobreposição "Sempre")
- Cabeçalho que se esconde ao descer e volta ao subir
- Manifesto cujas palavras se acendem com o scroll
- "Como funciona": imagem fixa que muda a cada passo
- Frota em scroll horizontal (no telemóvel passa a deslizar com o dedo)
- Imagens com parallax e revelação; galeria em mosaico
- Respeita "reduzir movimento" do sistema; no editor tudo fica visível

Classes reutilizáveis (Avançado → Classes CSS): `ns-split` (título palavra a palavra), `reveal`, `reveal-stagger`,
`ns-reveal-img` (imagem), `ns-media` (grupo com imagem de fundo animada), `ns-label`, `is-sand`, `is-ink`.

## Cores (theme.json) — paleta do site atual nauticsquad.com

| Nome | Hex | Origem no site atual |
|---|---|---|
| Turquesa | `#04BDC7` | botões "Secure your place" |
| Turquesa faixa | `#10B0B9` | faixa "Schedule your visit" |
| Teal títulos | `#0397AB` | títulos (GALLERY, BOATS, CONTACT US) |
| Teal | `#09848F` | logótipo e secção FAQ |
| Aqua | `#A8D7DC` | cabeçalho |
| Água clara | `#DBECEE` | fundos claros |
| Espuma | `#E7F3F4` | texto sobre fundos escuros |
| Abismo / Teal profundo | `#042A2F` / `#06404A` | fundos cinematográficos (versão profunda do teal da marca) |

Tipos de letra: **Cormorant Garamond** (títulos) e **Manrope** (texto), via Google Fonts.

## A confirmar antes de publicar

- Fotografias em alta resolução e (opcional) vídeo para a abertura
- Páginas interiores: Sailing Club, Sailing Academy e Power Club (slugs `sailing-club`, `sailing-academy`, `power-club`)
- Frota (pré-visualização, segundo o site atual): OCEANBLISS (Sun Odyssey 350, Oeiras), OCEANESCAPE (Oceanis 37 LE, Oeiras),
  OCEANVIBES (Dufour 45 Classic, Cascais), OCEANFUN (Jeanneau Sun 2500, Academia), FIFTY FIFTY (Power Club)
- Preços dos planos Weekday / Weekend / Team e textos da Sailing Academy
