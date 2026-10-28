# DOI in Summary for OPS

[![OPS](https://img.shields.io/badge/OPS-3.5-brightgreen)](https://pkp.sfu.ca/ops/)
[![Version](https://img.shields.io/badge/version-3.5.0.0-blue)](version.xml)
[![License](https://img.shields.io/badge/license-GPL--3.0-lightgrey)](LICENSE)

**⬇️ Install package:** [OPS 3.5](https://github.com/OJSBR/doiInSummaryOps/releases/download/3.5.0.0/doiInSummaryOps-3.5.0.0.tar.gz), or browse all [Releases](../../releases).

A generic plugin for **Open Preprint Systems (OPS)** that shows each preprint's **DOI URL**
in the lists of preprints: the server home page, the section pages and every other list built
from `frontend/objects/preprint_summary.tpl`.

> **Maintained by [OJSBR](https://ojsbr.com).** OPS version of [`doiInSummary`](https://github.com/OJSBR/doiInSummary)
> (OJS), which OJSBR adapted for OJS 3.5 from the original plugin by **Lepidus Tecnologia**.
> For OJS, use [`doiInSummary`](https://github.com/OJSBR/doiInSummary); this one is for OPS only.

## Why OPS needs it

The OPS 3.5 `preprint_summary.tpl` still looks for the DOI in `$pubIdPlugins`. DOIs moved to the
core in 3.4, that list no longer has a DOI plugin, so the core block never shows a DOI in the
lists of preprints. The preprint page itself already shows the DOI.

## Compatibility & branches

| OPS version | Branch | Plugin release |
|-------------|--------|----------------|
| OPS 3.5.x   | [`stable-3_5_0`](../../tree/stable-3_5_0) *(default)* | 3.5.0.0 |

## Installation

1. Install via **Settings → Website → Plugins → Upload A New Plugin**, or extract the folder
   into `plugins/generic/` so you get `plugins/generic/doiInSummaryOps/`. Do not rename the folder.
2. Enable **DOI in summary** under the *Generic* plugins list.
3. DOIs must be enabled for preprints in **Settings → Distribution → DOIs**. Preprints without a DOI show nothing.

## How it works (technical)

- The `Templates::Archive::Preprint` hook (end of each preprint summary) appends the DOI. The
  handler accepts both `TemplateManager` and `Smarty_Internal_Template`. The DOI is read from the
  current publication (`doiObject`, then the stored pub-id) and shown as its resolving URL
  (`https://doi.org/...`), whatever form it was stored in.
- One script for the page (`js/doiInSummary.js`) moves every DOI into the metadata of its preprint,
  right after the authors (or first, when the authors are hidden). Without JavaScript the DOI stays
  at the end of the summary.
- The block uses the classes `doi doiInSummary`, so themes that style the core `.doi` block style it too.

## Languages

en, pt_BR, pt, es, fr, fr_CA, it, de, ca, gl.

## Credits & authorship

- Original `doiInSummary` plugin: **Lepidus Tecnologia** (2015-2023), GPL v3.
- OJS 3.5 adaptation and this OPS version: **OJSBR** (2026).

---

# DOI no sumário para OPS

Plugin genérico para o **Open Preprint Systems (OPS)** que mostra o **DOI** de cada preprint nas
listas de preprints: página inicial do servidor, páginas das seções e qualquer outra lista feita
com `frontend/objects/preprint_summary.tpl`.

O OPS 3.5 ainda procura o DOI em `$pubIdPlugins`, que desde o 3.4 não tem mais o DOI (ele passou ao
núcleo). Por isso o bloco do próprio OPS nunca aparece nas listas. A página do preprint já mostra o DOI.

Instalação: envie o pacote em **Configurações → Website → Plugins → Enviar um novo plugin** (ou extraia
em `plugins/generic/doiInSummaryOps/`, sem renomear a pasta) e ative **DOI no sumário**. Os DOIs precisam
estar ligados para preprints em **Configurações → Distribuição → DOIs**.

Para OJS, use o [`doiInSummary`](https://github.com/OJSBR/doiInSummary). Este é só para OPS.
