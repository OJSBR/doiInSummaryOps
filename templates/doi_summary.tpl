{**
 * plugins/generic/doiInSummaryOps/templates/doi_summary.tpl
 *
 * Copyright (c) 2015-2023 Lepidus Tecnologia
 * Copyright (c) 2026 OJSBR (https://ojsbr.com)
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * The DOI of a preprint in a list of preprints. js/doiInSummary.js moves it under the authors.
 *}
<div id="doi_preprint-{$doiInSummaryOpsPreprintId|escape}" class="doi doiInSummary" data-doi-in-summary="{$doiInSummaryOpsPreprintId|escape}">
    <strong>
        {capture assign=translatedDOI}{translate key="doi.readerDisplayName"}{/capture}
        {translate key="semicolon" label=$translatedDOI}
    </strong>
    <a href="{$doiInSummaryOpsUrl|escape}" rel="noopener noreferrer">
        {$doiInSummaryOpsUrl|escape}
    </a>
</div>
