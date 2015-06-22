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
    var params = getUrlParams();

    if (params) {
        var groupDiv = $('#' + params.group);
        var sectionDiv = groupDiv.closest('.section-config');


        if (!sectionDiv.hasClass('active')) {
            sectionDiv.find('#' + params.group + '-head').click();
        }
        var fieldValueDiv = groupDiv.find('#' + params.group + '_' + params.field);
        var fieldNameDiv  = groupDiv.find("label[for='" + params.group + '_' + params.field + "']");
        fieldValueDiv.focus();

        var y = $(window).scrollTop();
        $(window).scrollTop(y+250);

        fieldValueDiv.effect("highlight", {color: '#c8f7c5'}, 3000);
        fieldNameDiv.effect("highlight", {color: '#c8f7c5'}, 3000);
    }
});

function getUrlParams() {
    var url = window.location;

    var pathArray = url.pathname.split('/');


    var index = pathArray.indexOf('group');
    var params = {};
    if(index >= 0 && index < pathArray.length - 1) {
        params.group = pathArray[index + 1];

        index = pathArray.indexOf('field');

        if (index >= 0 && index < pathArray.length - 1)
            params.field = pathArray[index + 1];

        return params;
    }

    return null;
}