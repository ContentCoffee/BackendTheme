(function ($, Drupal) {
    'use strict';

    Drupal.behaviors.backendtheme_maxlength = {
        attach: function (context) {
            $(context).find('.maxlength').once('backendtheme_maxlength').each(function () {
                $(this)
                    .add('.counter', $(this).parent())
                    .wrapAll('<div class="maxlength-wrapper" />');
            });
        },
    };

}(jQuery, Drupal));
