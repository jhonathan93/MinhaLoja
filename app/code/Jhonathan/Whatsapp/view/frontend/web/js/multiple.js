/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

define([
    'jquery'
], ($)=> {
    'use strict';

    $.widget('whatsapp.start', {
        options: {},

        _create: function () {
            console.log("TESTE")
        }
    });

    return $.whatsapp.start;
});
