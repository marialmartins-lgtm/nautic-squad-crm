# Nautic Squad — novo site em WordPress

Proposta de redesign do site da Nautic Squad (atualmente em Wix) como **tema WordPress em blocos**
(Full Site Editing): moderno, animado e totalmente editável no editor do WordPress, sem page builders.

- `nautic-squad/` — o tema
- `preview/index.html` — pré-visualização estática da página inicial (abrir no browser)
- `tools/build-preview.php` — regenera a pré-visualização a partir dos padrões do tema (`php tools/build-preview.php`)

## Instalar

1. Comprimir a pasta `nautic-squad/` em `nautic-squad.zip` (ou usar o zip gerado).
2. WordPress → **Aparência → Temas → Adicionar novo → Carregar tema** → ativar. (Requer WordPress 6.5+.)
3. **Definições → Leitura** → "A página inicial mostra: uma página estática" (qualquer página) — o template `front-page` é usado automaticamente.
4. **Aparência → Editor → Estilos** para afinar cores/tipos de letra; **Site → Logótipo** para carregar o logótipo oficial.
5. **Frota → Adicionar barco**: título, imagem de destaque, tipo (Vela/Motor), "Ficha técnica" (modelo, comprimento, capacidade, ano, marina) e a descrição. Os barcos aparecem sozinhos na página inicial e em `/frota`. A ordem é o campo "Ordem".
6. Criar as páginas `Sailing Academy` (slug `sailing-academy`) e `Política de privacidade` (slug `politica-de-privacidade`). Use o modelo "Página larga" e os padrões **Nautic Squad** no inseridor para montar páginas com o mesmo visual.

## O que é dinâmico

| Elemento | Como funciona |
|---|---|
| Cabeçalho | Transparente sobre o hero, fica em vidro fosco ao fazer scroll; barra de progresso de leitura |
| Hero | Título que aparece palavra a palavra, ondas e bolhas animadas, cartão em vidro a flutuar, parallax (se colocar imagem/vídeo em `.ns-hero__media`) |
| Secções | Entram com animação ao fazer scroll (classes `reveal`, `reveal-left`, `reveal-zoom`, `reveal-stagger` — podem ser aplicadas a qualquer bloco em *Avançado → Classes CSS*) |
| Números | Contadores animados (`data-count`) |
| Frota | Tipo de conteúdo "Barcos" com campos próprios (block bindings) — gerido no painel |
| FAQ | Bloco "Detalhes" nativo, com animação |
| Contacto | Formulário próprio, sem plugins: envia email para o endereço de *Definições → Geral*. Gancho `nautic_squad_contacto_enviado` pronto para ligar ao HubSpot/CRM |
| Acessibilidade | Respeita "reduzir movimento" do sistema; no editor todo o conteúdo fica visível |

## Cores (theme.json)

| Nome | Hex | Uso |
|---|---|---|
| Abismo | `#071A2C` | fundos escuros, texto |
| Oceano | `#0C3556` | gradientes, títulos |
| Mar | `#1673B8` | links, ícones |
| Turquesa | `#25C2CB` | destaques |
| Sol | `#FFB547` | botões / chamadas à ação |
| Espuma | `#F3F8FB` | fundos claros |

> ⚠️ A paleta é uma proposta náutica: não foi possível aceder ao site atual para extrair as cores exatas.
> Para usar as cores oficiais basta trocar os hex em `theme.json` (ou em Aparência → Editor → Estilos) — todo o tema se adapta.

## A confirmar antes de publicar

- Logótipo oficial e fotografias reais (barcos, saídas, marina) — o tema usa ilustrações SVG enquanto não houver fotos.
- Frota atual (a pré-visualização mostra Jeanneau Sun Odyssey 349, Beneteau Oceanis 37 e FIFTY FIFTY / Quicksilver Activ 875, com base em informação pública).
- Números da faixa de estatísticas (ex.: "2020").
- Preços dos planos (estão como "À medida" / "Partilhado").
- Textos da Sailing Academy e links das redes sociais.
- Tipos de letra: carregados do Google Fonts; para RGPD podem ser instalados localmente na Biblioteca de tipos de letra do WordPress.
