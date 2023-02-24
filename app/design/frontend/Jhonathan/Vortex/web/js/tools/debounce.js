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
], ($, dob, address, taxvat) => {
    'use strict';

    const data = {
        debounceEvent: (fnc, wait, time) => {
            return function () {
                clearTimeout(time);
                time = setTimeout(() => {
                    fnc.apply(this, arguments);
                }, wait);
            }
        },

        trigger: (e) => {
            const fnc = {
                taxvat: taxvat.validateTaxvat
            }

            if (fnc[e.currentTarget.name] !== undefined) {
                if (e.target.value !== '') {
                    fnc[e.currentTarget.name](e);
                }
            } else {
                console.log("Esse input não tem nenhuma função de validação.")
            }
        }
    }

    return {
        listenerDebounce: (element) => {
            $(element).keyup(data.debounceEvent(data.trigger, 1000));
        }
    };
});
