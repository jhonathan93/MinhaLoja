/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Vortex
 */

define([
    'jquery',
    'js_error'
], ($, error) => {
    'use strict';

    const data = {
        validateDate: (stringData) => {
            let regExpCaracter = /[^\d]/;
            let regExpEspaco = /^\s+|\s+$/g;

            if(stringData.length !== 10) {
                return false;
            }

            let splitData = stringData.split('/');

            if(splitData.length !== 3) {
                return false;
            }

            splitData[0] = splitData[0].replace(regExpEspaco, '');
            splitData[1] = splitData[1].replace(regExpEspaco, '');
            splitData[2] = splitData[2].replace(regExpEspaco, '');

            if ((splitData[0].length !== 2) || (splitData[1].length !== 2) || (splitData[2].length !== 4)) {
                return false;
            }

            if (regExpCaracter.test(splitData[0]) || regExpCaracter.test(splitData[1]) || regExpCaracter.test(splitData[2])) {
                return false;
            }

            let dia = parseInt(splitData[0],10);
            let mes = parseInt(splitData[1],10) - 1;
            let ano = parseInt(splitData[2],10);

            let novaData = new Date(ano, mes, dia);

            let hoje = new Date();

            if (novaData > hoje) {
                return false;
            }

            if ((novaData.getDate() !== dia) || (novaData.getMonth() !== mes) || (novaData.getFullYear() !== ano)) {
                return false;
            } else {
                return true;
            }
        }
    }

    return {
        validateDob : (element) => {
            if (data.validateDate(element.target.value)) {
                error.removeError(element);
            } else {
                error.createError(element, 'Data de nascimento é inválida.');
            }
        }
    };
});
