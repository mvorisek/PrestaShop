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
require('module-alias/register');

const {expect} = require('chai');

const helper = require('@utils/helpers');
const files = require('@utils/files');
const loginCommon = require('@commonTests/loginBO');

// Import pages
const LoginPage = require('@pages/BO/login');
const DashboardPage = require('@pages/BO/dashboard');
const TranslationsPage = require('@pages/BO/international/translations');
const {Languages} = require('@data/demo/languages');

// Import test context
const testContext = require('@utils/testContext');

const baseContext = 'functional_BO_international_localization_translations_exportLanguage';

let browserContext;
let page;

// Init objects needed
const init = async function () {
  return {
    loginPage: new LoginPage(page),
    dashboardPage: new DashboardPage(page),
    translationsPage: new TranslationsPage(page),
  };
};

describe('Export languages in translations page', async () => {
  // before and after functions
  before(async function () {
    browserContext = await helper.createBrowserContext(this.browser);
    page = await helper.newTab(browserContext);

    this.pageObjects = await init();
  });

  after(async () => {
    await helper.closeBrowserContext(browserContext);
  });

  // Login into BO and go to translations page
  loginCommon.loginBO();

  it('should go to translations page', async function () {
    await testContext.addContextItem(this, 'testIdentifier', 'goToTranslationsPage', baseContext);

    await this.pageObjects.dashboardPage.goToSubMenu(
      this.pageObjects.dashboardPage.internationalParentLink,
      this.pageObjects.dashboardPage.translationsLink,
    );

    const pageTitle = await this.pageObjects.translationsPage.getPageTitle();
    await expect(pageTitle).to.contains(this.pageObjects.translationsPage.pageTitle);
  });

  const tests = [
    {
      args:
        {
          testIdentifier: 'sortByIdDesc', language: Languages.english, theme: 'classic',
        },
    },
    {
      args:
        {
          testIdentifier: 'sortByIdDesc', language: Languages.french, theme: 'classic',
        },
    },
  ];

  tests.forEach((test) => {
    it(`Export language '${test.args.language.name}' for theme '${test.args.theme}'`, async function () {
      await testContext.addContextItem(
        this,
        'testIdentifier',
        `exportLanguage${test.args.language.name}Theme${test.args.theme}`,
        baseContext,
      );

      const filePath = await this.pageObjects.translationsPage.exportLanguage(test.args.language.name, test.args.theme);

      const doesFileExist = await files.doesFileExist(filePath);
      await expect(doesFileExist, `File '${filePath}' was not downloaded`).to.be.true;
    });
  });
});