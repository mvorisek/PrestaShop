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
function add_unknown_gender()
{
    $res = true;

    // creates the new gender
    $id_type = 2;
    $res &= Db::getInstance()->execute('
		INSERT INTO `' . _DB_PREFIX_ . 'gender` (`type`)
		VALUES (' . (int) $id_type . ')');

    // retrieves its id
    $id_gender = Db::getInstance()->Insert_ID();

    // inserts lang values
    $languages = Db::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'lang`');
    $lang_names = [
        'en' => 'Unknown',
        'de' => 'Unbekannte',
        'es' => 'Desconocido',
        'fr' => 'Inconnu',
        'it' => 'Sconosciuto',
    ];

    foreach ($languages as $lang) {
        $name = (isset($lang_names[$lang['iso_code']]) ? $lang_names[$lang['iso_code']] : 'Unknown');
        $res &= Db::getInstance()->execute('
			INSERT INTO `' . _DB_PREFIX_ . 'gender_lang` (`id_gender`, `id_lang`, `name`) VALUES
				(' . (int) $id_gender . ', ' . (int) $lang['id_lang'] . ', \'' . pSQL($name) . '\')');
    }

    // for all clients where id gender is 0, sets the new id gender
    $res &= Db::getInstance()->execute('
		UPDATE `' . _DB_PREFIX_ . 'customers`
		SET `id_gender` = ' . (int) $id_gender . '
		WHERE `id_gender` = 0');
}
