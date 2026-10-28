# DOI in Summary: OPS plugin

[![OPS](https://img.shields.io/badge/OPS-3.5-brightgreen)](https://pkp.sfu.ca/ops/)
[![Version](https://img.shields.io/badge/version-3.5.0.1-blue)](version.xml)
[![License](https://img.shields.io/badge/license-GPL--3.0-lightgrey)](LICENSE)

**⬇️ Install package:** [OPS 3.5](https://github.com/OJSBR/doiInSummaryOps/releases/download/3.5.0.1/doiInSummaryOps-3.5.0.1.tar.gz), or browse all [Releases](../../releases).

A generic plugin for **Open Preprint Systems (OPS)** that shows each preprint's **DOI URL** in
the lists of preprints: the server home page, the section pages and every other list built from
`frontend/objects/preprint_summary.tpl`.

> **Maintained by [OJSBR](https://ojsbr.com).** OPS version of [`doiInSummary`](https://github.com/OJSBR/doiInSummary),
> which OJSBR adapted for OJS 3.5 from the original plugin by **Lepidus Tecnologia**. See the
> [Credits & authorship](#credits--authorship) section below. For OJS, use
> [`doiInSummary`](https://github.com/OJSBR/doiInSummary).

## Compatibility & branches

| OPS version | Branch | Plugin release |
|-------------|--------|----------------|
| OPS 3.5.x   | [`stable-3_5_0`](../../tree/stable-3_5_0) *(default)* | 3.5.0.1 |

## The problem

The OPS 3.5 `preprint_summary.tpl` still looks for the DOI in `$pubIdPlugins`. DOIs moved to the
core in OPS 3.4 and that list no longer holds a DOI plugin, so the block of the core template never
shows a DOI in the lists of preprints. The preprint page itself already shows it. The OJS plugin
does not help here: it hooks into the issue table of contents, which OPS does not have.

## Installation

1. Install via **Settings → Website → Plugins → Upload A New Plugin**, or extract the folder
   into `plugins/generic/` so you get `plugins/generic/doiInSummaryOps/`. Do not rename the folder.
2. Enable **DOI in summary** under the *Generic* plugins list.
3. DOIs must be enabled for preprints in **Settings → Distribution → DOIs**. A preprint without a
   DOI shows nothing.

## How it works (technical)

- The `Templates::Archive::Preprint` hook, at the end of each preprint summary, appends the DOI;
  the handler accepts both `TemplateManager` and `Smarty_Internal_Template`. The DOI is read from
  the current publication (`doiObject`, then the stored pub-id) and shown as its resolving URL
  (`https://doi.org/...`), whatever form it was stored in.
- One script for the page (`js/doiInSummary.js`, `addJavaScript`) moves every DOI into the metadata
  of its preprint, right after the authors (first, when the authors are hidden). Without JavaScript
  the DOI stays at the end of the summary. No inline script per preprint.
- The block carries the classes `doi doiInSummary`, so a theme that styles the `.doi` block of the
  core template styles it too.

## Tests

- **PHPUnit** (`tests/*Test.php`, on `PKP\tests\PKPTestCase`): the class against the installed PKP,
  the plugin found by PKP's plugin registry, the resolving URL of every DOI form, the DOI read from
  the current publication, nothing for a preprint without DOI, the summary markup without inline
  script, the assets added to reader pages only, and the 38 translations. From the OPS root:

  ```bash
  lib/pkp/lib/vendor/bin/phpunit --configuration lib/pkp/tests/phpunit.xml --no-coverage "$PWD/plugins/generic/doiInSummaryOps/tests"
  ```

- **Cypress** (`cypress/tests/functional/DoiInSummaryOps.cy.js`, run by
  [pkp-github-actions](https://github.com/pkp/pkp-github-actions) on every push): enables the
  plugin. With `withDois=1` and published preprints with DOIs on the page `listPath` (default: the
  server home page) it also checks that each DOI appears once, as a resolving link, right after the
  authors, with the script loaded once.
- Verified on OPS 3.5.0.5.

Tests are kept in the repository and are not part of the release package.

## Credits & authorship

- **Maintained by** [OJSBR](https://ojsbr.com): OJS 3.5 adaptation and this OPS version.
- **Original work:** `doiInSummary` by **Lepidus Tecnologia**
  (<https://github.com/lepidus/doiInSummary>), © Lepidus Tecnologia 2015-2023.
- Distributed under the **GNU GPL v3**, consistent with the original licensing.

## AI use

Generative AI (Claude, by Anthropic) was used to write and run tests, improve the code and bring
it in line with PKP standards. Every change is reviewed and tested by OJSBR, which is responsible
for the published releases.

## Contributing

Issues and pull requests are welcome.

## License

Distributed under the **GNU GPL v3**. See [`LICENSE`](LICENSE) and `docs/COPYING`.

---

## 🇧🇷 Português

Plugin genérico para o **Open Preprint Systems (OPS)** que exibe a **URL do DOI** de cada
preprint nas listas de preprints: página inicial do servidor, páginas das seções e qualquer outra
lista feita com `frontend/objects/preprint_summary.tpl`.

> **Mantido pela [OJSBR](https://ojsbr.com).** Versão para OPS do
> [`doiInSummary`](https://github.com/OJSBR/doiInSummary), que a OJSBR adaptou para OJS 3.5 a
> partir do plugin original da **Lepidus Tecnologia**. Veja a seção
> [Créditos e autoria](#créditos-e-autoria) abaixo. Para OJS, use o
> [`doiInSummary`](https://github.com/OJSBR/doiInSummary).

### O problema

O `preprint_summary.tpl` do OPS 3.5 ainda procura o DOI em `$pubIdPlugins`. Desde o OPS 3.4 o DOI
faz parte do núcleo e essa lista não tem mais plugin de DOI, então o bloco do próprio OPS nunca
mostra o DOI nas listas de preprints. A página do preprint já mostra. O plugin do OJS não resolve:
ele se encaixa no sumário da edição, que o OPS não tem.

### Instalação

Instale em **Configurações → Website → Plugins → Enviar um novo plugin**, ou extraia a
pasta em `plugins/generic/` (ficando `plugins/generic/doiInSummaryOps/`); não renomeie a pasta.
Depois ative o **DOI no sumário** na lista de plugins *Genéricos*. Os DOIs precisam estar ligados
para preprints em **Configurações → Distribuição → DOIs**.

### Compatibilidade e branches

| Versão do OPS | Branch | Release do plugin |
|---------------|--------|-------------------|
| OPS 3.5.x     | [`stable-3_5_0`](../../tree/stable-3_5_0) *(padrão)* | 3.5.0.1 |

### Testes

PHPUnit em `tests/` (sobre `PKP\tests\PKPTestCase`) e Cypress em `cypress/tests/functional/`
(rodado pelo [pkp-github-actions](https://github.com/pkp/pkp-github-actions) a cada push), com os
comandos da seção em inglês. A suíte cobre a classe contra o PKP instalado, o plugin encontrado pelo
registro de plugins, a URL de resolução de cada forma de DOI, o DOI lido da publicação atual, nada
para preprint sem DOI, o resumo sem script inline, os arquivos só nas páginas do leitor e as 38
traduções; o Cypress, com DOIs, confere cada DOI uma vez, como link, logo depois dos autores.
Verificado no OPS 3.5.0.5.

Os testes ficam no repositório e não fazem parte do pacote da release.

### Créditos e autoria

- **Mantido pela** [OJSBR](https://ojsbr.com): adaptação para OJS 3.5 e esta versão para OPS.
- **Trabalho original:** `doiInSummary` da **Lepidus Tecnologia**
  (<https://github.com/lepidus/doiInSummary>), © Lepidus Tecnologia 2015-2023.
- Distribuído sob a **GNU GPL v3**, coerente com o licenciamento original.

### Uso de IA

Foi usada IA generativa (Claude, da Anthropic) para escrever e rodar testes, melhorar o código e
alinhá-lo aos padrões da PKP. Toda mudança é revisada e testada pela OJSBR, que responde pelas
releases publicadas.

### Licença

Distribuído sob a **GNU GPL v3**. Veja [`LICENSE`](LICENSE) e `docs/COPYING`.
