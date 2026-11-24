# Nautic Squad — novo site WordPress (versão cinematográfica)

Tema em blocos (Full Site Editing), premium e cinematográfico: fotografia em ecrã inteiro, scroll suave,
títulos que se revelam palavra a palavra, frota em scroll horizontal, galeria com revelação de imagens.
Tudo editável no editor do WordPress, sem page builders.

- `nautic-squad/` — o tema (também em `nautic-squad.zip`, pronto a carregar)
- `preview/index.html` — pré-visualização da página inicial (abrir no browser)
- `tools/build-preview.php` — regenera a pré-visualização a partir do tema: `php wordpress/tools/build-preview.php`

## Instalar

1. WordPress 6.5+ → **Aparência → Temas → Adicionar novo → Carregar tema** → `nautic-squad.zip` → Ativar.
2. **Definições → Leitura** → página inicial estática (o template "front-page" é usado automaticamente).
3. **Aparência → Editor → Site → Logótipo**: carregar o logótipo oficial.
4. **Frota → Adicionar barco**: título, imagem de destaque (vertical 4:5 fica melhor), tipo (Vela/Motor) e a caixa
   "Ficha técnica". Os barcos aparecem sozinhos na faixa horizontal da página inicial e em `/frota`.
5. Criar as páginas `sailing-academy` e `politica-de-privacidade`.
6. Ver o formulário de contacto: os pedidos chegam ao email de **Definições → Geral**.

## Fotografias e vídeo

| Onde | Como trocar |
|---|---|
| Qualquer secção com imagem de fundo (abertura, "Tu navegas", Academia, Contacto) | No editor, selecionar o Grupo → Estilos → **Imagem de fundo** |
| Imagens normais (passos, Power Club, galeria) | Clicar na imagem → **Substituir** |
| Sem editor | Colocar ficheiros em `nautic-squad/assets/img/` com o nome do slot: `hero.jpg`, `passo-1.jpg` … `passo-3.jpg`, `incluido.jpg`, `power.jpg`, `momento-1.jpg` … `momento-5.jpg`, `academia.jpg`, `contacto.jpg` |
| **Vídeo na abertura** | Colocar `nautic-squad/assets/video/hero.mp4` (≈10–20 s, sem som, 1920×1080, < 8 MB). Passa a tocar em loop automaticamente |

> As fotos atuais são **provisórias** (Unsplash, carregadas diretamente do site deles) — não foi possível
> aceder a www.nauticsquad.com nem verificá-las a partir do ambiente de desenvolvimento. Se alguma não carregar,
> aparece um fundo azul-escuro no lugar. Devem ser substituídas pelas fotografias da Nautic Squad.

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

- Fotografias, vídeo e logótipo oficiais
- Frota (pré-visualização, segundo o site atual): OCEANBLISS (Sun Odyssey 350, Oeiras), OCEANESCAPE (Oceanis 37 LE, Oeiras),
  OCEANVIBES (Dufour 45 Classic, Cascais), OCEANFUN (Jeanneau Sun 2500, Academia), FIFTY FIFTY (Power Club)
- Preços dos planos Weekday / Weekend / Team e textos da Sailing Academy
