/**
 * Oggetto Admin Config Search extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Admin Config Search module to newer versions in the future.
 * If you wish to customize the Oggetto Search module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @copyright  Copyright (C) 2015 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
"use strict";
jQuery(function($) {
    $('#config-fields-search').submit(function (event) {
        var ul = $('#config-fields-search').find('ul');

        var li = ul.children().first();

        if (li.length) {
            var input = $('#search-settings');
            var downKeyEvent = $.Event("keydown");
            downKeyEvent.keyCode = $.ui.keyCode.DOWN;

            var enterKeyEvent = $.Event("keydown");
            enterKeyEvent.keyCode = $.ui.keyCode.ENTER;

            input.trigger(downKeyEvent);
            input.trigger(enterKeyEvent);
        }

        event.preventDefault();
    }).on('focus', '#search-settings', function () {
        var ul = $(this).closest('#config-fields-search').find('ul');
        if (!ul.is(':visible')) {
            ul.show();
        }
    });
});
