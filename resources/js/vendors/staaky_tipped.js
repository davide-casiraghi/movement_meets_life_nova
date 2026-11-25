import Tipped from '@staaky/tipped';

window.Tipped = Tipped;

/**
 * We manage tooltips with
 * https://www.tippedjs.com/documentation
 *
 * Loaded by resources/js/app.js only on the pages with glossary terms
 **/

$(document).ready(function () {

    /**
     * Simple tooltip
     *
     * Example:
     * <span class="simple-tooltip" title="First tooltip">I have a tooltip</span>
     **/
    //Tipped.create('.simple-tooltip');

    /*Tipped.create('.tooltip-example', {
        //size: 'x-small',
        //showOn: 'click'
        inline: 'glossary-definition-33', //id of the content of the tooltip
        skin: 'light',
        radius: false,
        padding: false,
        position: 'topleft',
        size: 'large'
    });*/

    /**
     * Glossary Tooltip
     *
     **/
    $('.has-glossary-term').each(function (i) {

        let termFoundId = $(this).attr("data-termFoundId");
        let termClass = ".glossary-term-" + termFoundId;

        let definition = $(this).attr("data-definitionId");
        let definitionId = "glossary-definition-" + definition;

        Tipped.create(termClass, { //id of the element on which display the tooltip on hover
            inline: definitionId, //id of the content of the tooltip
            skin: 'light',
            radius: false,
            padding: false,
            position: 'topleft',
            size: 'large'
        });

    });

});