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
            data.removeLoading(element);
            data.setLoading(element, message);
        },

        setLoading: (element, message) => {
            $(element.currentTarget.parentNode.parentNode).append(`
                <span class="jsLoading">
                    <div class="loadingio-spinner-spinner-xcby7boi3eb"><div class="ldio-1s1elez4pny">
                    <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                    </div></div>
                    ${message}
                </span>
            `);
        },

        removeLoading: (element) => {
            let loading = $(element.currentTarget.offsetParent).find('span.jsLoading');
            if (loading) {
                $(loading).remove();
            }
        },
    };

    return {
        createLoading: (element, message) => {
            data.init(element, message);
        },

        removeLoading: (element) => {
            data.removeLoading(element);
        },
    };
});
