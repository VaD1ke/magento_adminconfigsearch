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
    var searchSettings = $('#search-settings');
    searchSettings.autocomplete({
        autoFocus: true,
        appendTo: '#config-fields-search',
        source: function (request, response) {
            var configData = $.map(ConfigSingleton.getConfigArray(), function (item) {
                return {
                    label: item.label,
                    field: item.value,
                    value: item.translations,
                    path: item.path,
                    url: item.url,
                    comment: item.comment,
                    switchable: item.switchable,
                    fieldValue: item.field,
                    breadcrumbs: item.breadcrumbs,
                    translations: item.translations,
                    commentTranslation: item.commentTranslation
                };
            });

            var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term.trim() ), 'i' );
            response($.grep(configData, function(item) {
                    return matcher.test(item.label) ||  matcher.test(item.translations)
                        || matcher.test(item.comment) || matcher.test(item.commentTranslation);
                })

            );
        },
        select: function (event, ui) {
            location.href = ui.item.url;
        },
        minLength: 3
    }).data('ui-autocomplete')._renderItem = function (ul, item) {
        var fieldText = item.field;

        var fieldValue;

        var label = $('<div>').addClass('autocomplete-menu-item-label').append(item.translations);
        var breadcrumbs = $('<div>').addClass('autocomplete-menu-item-breadcrumb').append(item.breadcrumbs);

        if (!item.switchable) {
            label.addClass('with-value');
            var allowedFieldLength = 20;

            if (fieldText.length > allowedFieldLength) {
                fieldValue = $('<div>').addClass('autocomplete-menu-item-value')
                    .attr('title', fieldText).append(fieldText.substr(0, allowedFieldLength) + '...');
            } else {
                fieldValue = $('<div>').addClass('autocomplete-menu-item-value').append(fieldText);
            }
        }

        var li = $('<li>').append(label).append(fieldValue).append(breadcrumbs);

        if (item.switchable) {
            var toggleCheckbox = $('<input />').attr('id', 'myonoffswitch').attr('name', 'onoffswitch')
                .attr('type', 'checkbox').addClass('onoffswitch-checkbox');

            toggleCheckbox.prop('checked', item.fieldValue == true);

            var toggleSwitch = $('<div>').attr('data-field-path', item.path).addClass('onoffswitch')
                .append(toggleCheckbox)
                .append(
                '<label class="onoffswitch-label" for="myonoffswitch">' +
                '<span class="onoffswitch-inner"></span>' +
                '<span class="onoffswitch-switch"></span>' +
                '</label>'
            );

            li.append(toggleSwitch);
        }
        return li.addClass('autocomplete-menu-item').appendTo( ul );
    };
});
