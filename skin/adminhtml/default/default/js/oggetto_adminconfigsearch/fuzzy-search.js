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
function searchFuzzy (source, request) {
    var accuracy = 1;

    var labelArr   = source.split(' ');
    var requestArr = request.split(' ');

    var a = FuzzySet(labelArr);
    var result = 0;

    var wordMatcher;

    for (var i = 0; i < requestArr.length; i++) {
        result = a.get(requestArr[i]);

        if (result && result[0][0] >= 0.6) {
            accuracy += result[0][0];
        } else {
            wordMatcher = new RegExp(requestArr[i], 'i');
            if (wordMatcher.test(source)) {
                accuracy += 0.7;
            } else {
                return false;
            }

        }
    }

    accuracy /= requestArr.length;

    return accuracy >= 0.7;
}
