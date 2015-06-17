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
    $('.ui-autocomplete').on('click', '.onoffswitch', function(e) {
        var form = $(this).closest('#config-fields-search');
        var fieldPath = $(this).data('field-path');
        var checkbox = $(this).children('.onoffswitch-checkbox');
        $.ajax({
            url: form.data('url-switch'),
            dataType: 'json',
            method: 'post',
            data: {path: fieldPath},
            success: function(data) {
                ConfigSingleton.setConfigValue(data.path, data.value);
                checkbox.prop('checked', data.value == true);
            },
            error: function() {
                var label = $(this).find('.onoffswitch-inner');
                label.addClass('error');
            }

        });

        e.preventDefault();
        e.stopPropagation();
    })
});