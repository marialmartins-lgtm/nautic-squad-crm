# Mudar o site da Nautic Squad da Wix para WordPress

Guia passo a passo. Tempo estimado: 1–2 horas, sem o site ficar em baixo.

---

## O que já se sabe sobre o domínio (consulta pública ao DNS, 25/11/2026)

| Registo | Valor atual | O que significa |
|---|---|---|
| Servidores de nomes (NS) | `ns1/ns2/ns3.dnscpanel.com` | O DNS é gerido num **alojamento com cPanel** (não na Wix) |
| Email (MX) | `mail.nauticsquad.com` · SPF com `spf.mailbox.pt` | O email **sales@nauticsquad.com** está nesse alojamento |
| Site (A) `nauticsquad.com` | `185.230.63.107` | Aponta para a **Wix** |
| Site (CNAME) `www` | `www126.wixdns.net` | Aponta para a **Wix** |

**Conclusão:** para mudar o site basta alterar **2 registos** (A e www).
**Não mexer nos registos MX, TXT (SPF/DKIM) nem `mail.`** — o email continua a funcionar como hoje.

> Confirme com o fornecedor do cPanel se o vosso plano inclui **alojamento web** (não só email).
> Se incluir, o WordPress pode ficar no mesmo sítio — é o caminho mais simples.

---

## Passo 1 — Alojamento WordPress

Requisitos: **PHP 8.1+**, **MySQL/MariaDB**, **HTTPS (Let's Encrypt)**. O tema foi testado em WordPress 7.1.

- **Opção A (recomendada):** o alojamento cPanel atual, se tiver espaço web. Em cPanel → *Softaculous* ou *WordPress Manager* → Instalar WordPress em `nauticsquad.com`.
- **Opção B:** um alojamento WordPress gerido (ex.: PTisp, Amen, SiteGround, Hostinger…). Nesse caso, o DNS continua no cPanel e só se apontam os 2 registos para o novo servidor.

Durante a instalação, escolha o idioma **Português (Portugal)** e guarde o utilizador/palavra-passe de administrador.

## Passo 2 — Instalar o tema

1. Painel WordPress → **Aparência → Temas → Adicionar novo → Carregar tema**.
2. Escolha `nautic-squad.zip` (está nesta pasta) → **Instalar** → **Ativar**.
3. Aparece um aviso azul no topo do painel: clique em **Importar conteúdo da Nautic Squad**.
   Em segundos ficam criados:
   - a **Frota** (Oceanbliss, Oceanescape, Oceanvibes, Oceanfun, Fifty Fifty) com fotos, ficha técnica e descrição;
   - as páginas **Sailing Club**, **Sailing Academy** e **Power Club**;
   - a **página inicial**, o título do site e o ícone;
   - um **rascunho** da Política de privacidade (o texto legal tem de ser preenchido por vós).

## Passo 3 — Afinar antes de publicar

- **Definições → Geral → Endereço de email da administração:** ponha `sales@nauticsquad.com` — é para aí que vão os pedidos do formulário de contacto.
- **Plugin de envio de email (recomendado):** instale *WP Mail SMTP* e configure com a conta `sales@nauticsquad.com` (servidor `mail.nauticsquad.com`). Sem isto, alguns emails do formulário podem ir para spam.
- **Páginas → Política de privacidade:** preencher e publicar.
- **Fotos em alta resolução (opcional):** abrir cada secção no editor e trocar a imagem, ou substituir os ficheiros em `assets/img/` (ver README).
- **Vídeo na abertura (opcional):** ficheiro `hero.mp4` em `assets/video/`.

Para ver o site antes de mudar o domínio, use o endereço temporário que o alojamento fornece
(ou o plugin *Maintenance* para o mostrar só a quem tem sessão iniciada).

## Passo 4 — Apontar o domínio (a "mudança" propriamente dita)

No cPanel → **Zone Editor** (Editor de Zona DNS) de `nauticsquad.com`:

| Registo | Antes (Wix) | Depois |
|---|---|---|
| `nauticsquad.com` — **A** | `185.230.63.107` | IP do servidor WordPress |
| `www` — **CNAME** | `www126.wixdns.net` | `nauticsquad.com` |

- Não altere **MX**, **TXT**, **mail**, **autodiscover** nem outros registos.
- A propagação demora de minutos a algumas horas. Durante esse tempo, uns visitantes veem a Wix e outros o WordPress — é normal.
- Depois de propagar, ative **HTTPS** no alojamento (cPanel → *SSL/TLS Status* → *Run AutoSSL*).
- Na Wix: em *Domínios*, desligue o domínio do site Wix para não haver conflito.

## Passo 5 — Depois da mudança

- **Endereços antigos:** o tema já redireciona os links da Wix (`/en/...`, `/home`, `/copy-of-sailing-club` → `/power-club/`, etc.), para não perder posições no Google.
- **Google Search Console:** adicione `https://nauticsquad.com/wp-sitemap.xml` como sitemap.
- **Formulários Microsoft Forms:** as ligações atuais (visita, informações, adesão) continuam no site, na secção Contactos.
- **WhatsApp / chat:** se quiserem manter o botão "Questions? Talk to us", instale um plugin de WhatsApp (ex.: *Click to Chat*).
- **Versão em inglês:** o site atual tem PT/EN. Pode acrescentar-se depois com o plugin *Polylang* (o tema é compatível; os textos dos padrões teriam de ser traduzidos).
- **Cancelar o plano Wix** só depois de confirmar que tudo funciona (pelo menos 1–2 semanas).

## Checklist final

- [ ] WordPress instalado com HTTPS
- [ ] Tema ativo e conteúdo importado
- [ ] Email de administração = sales@nauticsquad.com e WP Mail SMTP configurado
- [ ] Formulário de contacto testado (o email chegou?)
- [ ] Política de privacidade publicada
- [ ] DNS: A e www apontados; MX intactos; email continua a funcionar
- [ ] Sitemap submetido no Google Search Console
- [ ] Plano Wix cancelado (no fim)
