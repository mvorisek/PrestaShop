<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace LegacyTests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use PrestaShop\PrestaShop\Adapter\Configuration;

class AssetsCoreTest extends TestCase
{
    private $stylesheetManager;
    private $javascriptManager;

    private $listCSS;
    private $listJS;

    private $testsPath;

    protected function setUp()
    {
        parent::setUp();

        $this->testsPath = '/tests-legacy/resources/assets/';

        $this->stylesheetManager = new \StylesheetManager(
            [$this->testsPath, 'css'],
            new Configuration()
        );
        $this->javascriptManager = new \JavascriptManager(
            [$this->testsPath, 'css'],
            new Configuration()
        );

        $this->stylesheetManager->register('theme-ok-1', '/theme.css', 'all', 10, false);
        $this->stylesheetManager->register('theme-fail-1', '/themee.css', 'all', 10, false);
        $this->stylesheetManager->register('theme-ok-2', 'theme.css', 'all', 10, false);
        $this->stylesheetManager->register('theme-fail-2', 'themee.css', 'all', 10, false);
        $this->stylesheetManager->register('theme-ok-3', '/css/custom.css', 'all', 10, false);
        $this->stylesheetManager->register('theme-fail-3', '/css/customm.css', 'all', 10, false);
        $this->stylesheetManager->register('theme-ok-4', 'css/custom.css', 'all', 10, false);
        $this->stylesheetManager->register('theme-fail-4', 'css/customm.css', 'all', 10, false);

        $this->javascriptManager->register('corejs-ok-1', '/core.js', 'bottom', 10, false, false);
        $this->javascriptManager->register('corejs-fail-1', '/coree.js', 'bottom', 10, false, false);
        $this->javascriptManager->register('corejs-ok-2', 'core.js', 'bottom', 10, false, false);
        $this->javascriptManager->register('corejs-fail-2', 'coree.js', 'bottom', 10, false, false);
        $this->javascriptManager->register('corejs-ok-3', '/js/core.js', 'bottom', 10, false, false);
        $this->javascriptManager->register('corejs-fail-3', '/js/coree.js', 'bottom', 10, false, false);
        $this->javascriptManager->register('corejs-ok-4', 'js/core.js', 'bottom', 10, false, false);
        $this->javascriptManager->register('corejs-fail-4', 'js/coree.js', 'bottom', 10, false, false);

        $this->listCSS = $this->stylesheetManager->getList()['external'];
        $this->listJS = $this->javascriptManager->getList()['bottom']['external'];
    }

    /**
     * @dataProvider isAssetsDataProvider
     */
    public function testIsAssets($id, $toBeFound, $expectedPath, $type)
    {
        $found = false;
        $expectedAsset = false;
        if ('css' === $type) {
            foreach ($this->listCSS as $asset) {
                if ($asset['id'] === $id) {
                    $found = true;
                    $expectedAsset = $asset;
                }
            }
        } elseif ('js' === $type) {
            foreach ($this->listJS as $asset) {
                if ($asset['id'] === $id) {
                    $found = true;
                    $expectedAsset = $asset;
                }
            }
        }

        $this->assertSame($toBeFound, $found);

        if ($toBeFound) {
            $this->assertSame($expectedAsset['path'], $this->testsPath . $expectedPath);
        }
    }

    // --- providers ---
    public function isAssetsDataProvider()
    {
        return [
            ['theme-ok-1', true, 'theme.css', 'css'],
            ['theme-fail-1', false, false, 'css'],
            ['theme-ok-2', true, 'theme.css', 'css'],
            ['theme-fail-2', false, false, 'css'],
            ['theme-ok-3', true, 'css/custom.css', 'css'],
            ['theme-fail-3', false, false, 'css'],
            ['theme-ok-4', true, 'css/custom.css', 'css'],
            ['theme-fail-4', false, false, 'css'],

            ['corejs-ok-1', true, 'core.js', 'js'],
            ['corejs-fail-1', false, false, 'js'],
            ['corejs-ok-2', true, 'core.js', 'js'],
            ['corejs-fail-2', false, false, 'js'],
            ['corejs-ok-3', true, 'js/core.js', 'js'],
            ['corejs-fail-3', false, false, 'js'],
            ['corejs-ok-4', true, 'js/core.js', 'js'],
            ['corejs-fail-4', false, false, 'js'],
        ];
    }
}
