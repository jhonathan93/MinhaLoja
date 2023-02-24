/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Vortex
 */

define([
    'jquery',
    'js_mask',
    'js_trigger',
    'underscore'
], ($, mask, trigger, _)=> {
    'use strict';

    $.widget('jhonathan.start', {
        options: {
            element : '',
            mask: '',
            validate: ''
        },

        _create: function () {
            _.map(this.options.mask, (value, index) => {
                if (!_.isEmpty(value)) {
                    this.setMask(this.options.element[index], value);
                }
            });

            _.map(this.options.validate, (value, index) => {
                if (_.isEqual(value, 'true')) {
                    trigger.addListener(this.options.element[index]);
                }
            });
        },

        setMask: (element, mask) => {
            $(element).mask(mask);
        }
    });

    return $.jhonathan.start;
});
