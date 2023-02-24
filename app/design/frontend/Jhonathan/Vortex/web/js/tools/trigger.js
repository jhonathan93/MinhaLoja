/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Vortex
 */

define([
    'jquery',
    'js_dob',
    'js_postcode',
    'js_taxvat',
    'js_error',
    'mage/translate',
    'underscore'
], ($, dob, postCode, taxvat, error, __, _) => {
    'use strict';

    const fnc = {
        dob : dob.validateDob,
        postcode: postCode.searchAddress,
        taxvat: taxvat.validateTaxvat
    }

    const scale = {
        dob: 10,
        postcode: 9,
        cpf: 14,
        cnpj: 18,
    }

    const data = {
        eventKey: (input) => {
            $(input).keyup(e => {
                if (_.isEqual(e.currentTarget.name, 'taxvat')) {
                    if (_.isEqual(e.target.value.length, scale[$(input).attr('mask')])) {
                        data.removeError(e);
                        fnc[e.currentTarget.name](e);
                    } else {
                        data.removeError(e);
                    }
                } else {
                    if (_.isEqual(e.target.value.length, scale[e.currentTarget.name])) {
                        data.removeError(e);
                        fnc[e.currentTarget.name](e);
                    } else {
                        data.removeError(e);
                    }
                }
            });
        },

        eventBlur: (input) => {
            $(input).blur(e => {
                if (_.isEqual(e.currentTarget.name, 'taxvat')) {
                    if (e.target.value.length < scale[$(input).attr('mask')]) {
                        data.createError(e, 'O documento informado está incompleto.');
                    }
                } else {
                    if (e.target.value.length < scale[e.currentTarget.name]) {
                        data.createError(e, 'O campo informado está incompleto.');
                    }
                }
            });
        },

        removeError: (e) => {
            error.removeError(e);
        },

        createError: (e, msg) => {
            error.createError(e, msg);
        },
    }

    return {
        addListener: (element) => {
            data.eventKey(element);
            data.eventBlur(element);
        }
    };
});
