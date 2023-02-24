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
        searchAddress: (e) => {
            $.ajax({
                url: url.build(`rest/V1/viacep/${e.target.value}`),
                type: 'GET',
                dataType: 'json',
                showLoader: true
            }).done((result) => {
                result = JSON.parse(result);

                $('input#street_1').val(result.logradouro);
                $('input#street_4').val(result.bairro);
                $('input#city').val(result.localidade);
                $('select#country').val('BR').change();
                $('select#region_id').val(result.uf);
            }).fail((error) => {
                console.log(error);
            });
        }
    };
});
