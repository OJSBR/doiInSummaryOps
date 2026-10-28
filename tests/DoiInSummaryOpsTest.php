<?php

/**
 * @file plugins/generic/doiInSummaryOps/tests/DoiInSummaryOpsTest.php
 *
 * Copyright (c) 2026 OJSBR (https://ojsbr.com)
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class DoiInSummaryOpsTest
 *
 * @brief The resolving URL of a DOI, the DOI read from a preprint, and the markup and
 *        assets added to the lists of preprints.
 */

namespace APP\plugins\generic\doiInSummaryOps\tests;

use APP\plugins\generic\doiInSummaryOps\DoiInSummaryOpsPlugin;
use PHPUnit\Framework\Attributes\CoversClass;
use PKP\tests\PKPTestCase;

#[CoversClass(DoiInSummaryOpsPlugin::class)]
class DoiInSummaryOpsTest extends PKPTestCase
{
    public function testEveryFormOfADoiBecomesItsResolvingUrl(): void
    {
        $this->assertSame('https://doi.org/10.1234/abc.5', DoiInSummaryOpsPlugin::resolvingUrl('10.1234/abc.5'));
        $this->assertSame('https://doi.org/10.1234/abc.5', DoiInSummaryOpsPlugin::resolvingUrl(' doi:10.1234/abc.5 '));
        $this->assertSame('https://doi.org/10.1234/abc.5', DoiInSummaryOpsPlugin::resolvingUrl('https://doi.org/10.1234/abc.5'));
        $this->assertSame(null, DoiInSummaryOpsPlugin::resolvingUrl('   '));
    }

    public function testASummaryCarriesNoScriptOfItsOwn(): void
    {
        // One script file for the page, not one inline script per preprint.
        $template = (string) file_get_contents(dirname(__DIR__) . '/templates/doi_summary.tpl');
        $this->assertStringNotContainsString('<script', $template);
        $this->assertStringContainsString('{$doiInSummaryOpsUrl|escape}', $template);
        $this->assertTrue(is_file(dirname(__DIR__) . '/js/doiInSummary.js'));
    }

    public function testTheDoiIsReadFromTheCurrentPublication(): void
    {
        $publication = new class () {
            public function getData($name)
            {
                return $name === 'doiObject' ? new class () {
                    public function getData($name)
                    {
                        return $name === 'doi' ? '10.5555/xyz' : null;
                    }
                } : null;
            }
        };
        $preprint = new class ($publication) {
            public function __construct(private $publication)
            {
            }

            public function getCurrentPublication()
            {
                return $this->publication;
            }
        };

        $this->assertSame('https://doi.org/10.5555/xyz', (new DoiInSummaryOpsPlugin())->getPreprintDoiUrl($preprint));
    }

    public function testAPreprintWithoutDoiShowsNothing(): void
    {
        $publication = new class () {
            public function getData($name)
            {
                return null;
            }

            public function getStoredPubId($type)
            {
                return null;
            }
        };
        $preprint = new class ($publication) {
            public function __construct(private $publication)
            {
            }

            public function getCurrentPublication()
            {
                return $this->publication;
            }
        };

        $this->assertSame(null, (new DoiInSummaryOpsPlugin())->getPreprintDoiUrl($preprint));
    }

    public function testTheAssetsAreOnlyAddedToReaderPages(): void
    {
        $templateMgr = new class () {
            public array $added = [];

            public function addStyleSheet($name, $url, $args = [])
            {
                $this->added[] = $name;
            }

            public function addJavaScript($name, $url, $args = [])
            {
                $this->added[] = $name;
            }
        };
        $plugin = new DoiInSummaryOpsPlugin();

        $plugin->addDoiAssets('TemplateManager::display', [$templateMgr, 'management/settings/website.tpl']);
        $this->assertSame([], $templateMgr->added, 'Nothing on editorial pages.');

        $plugin->addDoiAssets('TemplateManager::display', [$templateMgr, 'frontend/pages/indexServer.tpl']);
        $this->assertSame(['doiInSummaryOpsCSS', 'doiInSummaryOpsJS'], $templateMgr->added);
    }
}
