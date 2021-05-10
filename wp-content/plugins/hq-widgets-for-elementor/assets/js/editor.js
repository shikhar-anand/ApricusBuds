(function ($) {

    'use strict';

    var HQ_Widgets_Elementor_Editor = {

        init: function () {
            if ('edit' === elementor.channels.dataEditMode.request('activeMode')) {
                HQ_Widgets_Elementor_Editor.elementorEditorPromoHqWidgets();
            }
        },

        elementorEditorPromoHqWidgets: function () {
            parent.document.addEventListener("mousedown", function (e) {
                var widgets = parent.document.querySelectorAll(".elementor-element--promotion");
                if (widgets.length > 0) {
                    for (var i = 0; i < widgets.length; i++) {
                        if (widgets[i].contains(e.target)) {
                            var dialog = parent.document.querySelector("#elementor-element--promotion__dialog");
                            var icon = widgets[i].querySelector(".icon > i");
                            if (icon.classList.toString().indexOf("hq-icon-") >= 0) {
                                dialog.querySelector(".dialog-buttons-action").style.display = "none";
                                e.stopImmediatePropagation();
                                if (dialog.querySelector(".hq-dialog-buttons-action") === null) {
                                    var button = document.createElement("a");
                                    var buttonText = document.createTextNode("UPGRADE TO PRO");
                                    button.setAttribute("href", "https://marmot.hqwebs.net/pricing/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=editor-promo-widget");
                                    button.setAttribute("target", "_blank");
                                    button.classList.add("dialog-button", "dialog-action", "dialog-buttons-action", "elementor-button", "elementor-button-success", "hq-dialog-buttons-action");
                                    button.appendChild(buttonText);
                                    dialog.querySelector(".dialog-buttons-action").insertAdjacentHTML("afterend", button.outerHTML);
                                } else {
                                    dialog.querySelector(".hq-dialog-buttons-action").style.display = "";
                                }
                            } else {
                                dialog.querySelector(".dialog-buttons-action").style.display = "";
                                if (dialog.querySelector(".hq-dialog-buttons-action") !== null) {
                                    dialog.querySelector(".hq-dialog-buttons-action").style.display = "none";
                                }
                            }
                            break;
                        }
                    }
                }
            });
        },
    };

    $(window).on('elementor:init', HQ_Widgets_Elementor_Editor.init);

    window.HQ_Widgets_Elementor_Editor = HQ_Widgets_Elementor_Editor;

}(jQuery));
