/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Vortex
 */

define([
    'jquery'
], ($) => {
    'use strict';

    const data = {
        init: (element, message) => {
            data.removeError(element);
            data.setMessage(element, message);
        },

        setMessage: (element, message) => {
            data.clean(element);
            $(element.currentTarget.parentNode.parentNode).append(`
                <div for="firstname" generated="true" class="mage-error" id="firstname-error">${message}</div>
            `);
        },

        removeError: (element) => {
            let error = $(element.currentTarget.parentNode.parentNode).find('.mage-error');
            if (error) {
                $(error).remove();
            }
        },

        clean: (element) => {
            $(element.currentTarget).val('');
        },
    };

    return {
        createError: (element, message) => {
            data.init(element, message);
        },

        removeError: (element) => {
            data.removeError(element);
        },
    };
});
