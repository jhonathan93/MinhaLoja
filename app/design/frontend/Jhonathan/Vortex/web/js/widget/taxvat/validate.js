/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Vortex
 */

define([
    'jquery',
    'mage/url',
    'js_error'
], ($, url, error) => {
    'use strict';

    return {
        validateTaxvat: (e) => {
            $.ajax({
                url: url.build(`rest/V1/Authentication/${e.target.value.replace(/\D/g,'')}`),
                type: 'GET',
                dataType: 'json',
                showLoader: true
            }).done((result) => {
                result = JSON.parse(result);
                console.log(result);
            }).fail((error) => {
                console.log(error);
            });
        }
    }
});