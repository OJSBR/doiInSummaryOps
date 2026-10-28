/**
 * @file plugins/generic/doiInSummaryOps/js/doiInSummary.js
 *
 * Copyright (c) 2015-2023 Lepidus Tecnologia
 * Copyright (c) 2026 OJSBR (https://ojsbr.com)
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Moves the DOI of each preprint summary into its metadata, right after the authors
 * (or after the title when the authors are hidden). Without JavaScript the DOI stays at
 * the end of the summary, where the core hook puts it.
 */
(function () {
	'use strict';

	function place() {
		var dois = document.querySelectorAll('.doiInSummary[data-doi-in-summary]');
		for (var i = 0; i < dois.length; i++) {
			var doi = dois[i];
			var summary = doi.closest('.obj_preprint_summary') || doi.parentNode;
			if (!summary) {
				continue;
			}
			var meta = summary.querySelector('.meta');
			var authors = meta ? meta.querySelector('.authors') : null;
			if (authors && authors.nextSibling !== doi) {
				authors.parentNode.insertBefore(doi, authors.nextSibling);
			} else if (!authors && meta && meta.firstChild !== doi) {
				meta.insertBefore(doi, meta.firstChild);
			} else if (!meta) {
				var title = summary.querySelector('.title, h2, h3, h4');
				if (title && title.parentNode && title.nextSibling !== doi) {
					title.parentNode.insertBefore(doi, title.nextSibling);
				}
			}
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', place);
	} else {
		place();
	}
})();
