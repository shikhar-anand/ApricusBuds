class HQWidgetNavMenu extends elementorModules.frontend.handlers.Base {

    getDefaultSettings() {
        return {
            selectors: {
                wrapper: '.hq-nav-menu-wrapper',
                menu: '.hc-offcanvas',
                toggle: '.hq-nav-menu-trigger'
            }
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $wrapper: this.$element.find(selectors.wrapper),
            $menu: this.$element.find(selectors.menu),
            $toggle: this.$element.find(selectors.toggle)
        };
    }

    bindEvents() {
        let settings = this.getElementSettings();

        if (settings.nav_menu === '0') {
            return;
        }

        this.tabKeyNavigationSupport();

        if ('yes' === settings.toggle_menu) {

            let breakpoint = +settings.breakpoint || 0,
                    levelOpen = settings.menu_level_open ? settings.menu_level_open : 'none',
                    customToggle = null;

            if ('yes' === settings.custom_toggle_selector && this.getValue('toggle_selector').length) {
                customToggle = this.getValue('toggle_selector');
            } else if (this.elements.$toggle.length) {
                customToggle = this.elements.$toggle;
            }

            this.elements.$wrapper.hcOffcanvasNav({
                bodyInsert: 'none',
                disableAt: breakpoint,
                customToggle: customToggle,
                position: settings.sidebar_position || 'left',
                levelOpen: levelOpen,
                levelSpacing: this.getValue('level_spacing', 20),
                levelTitles: settings.level_titles ? true : false,
                disableBody: this.getValue('disable_body', true, 'yes'),
                closeOnClick: this.getValue('close_on_click', true, 'yes'),
                insertClose: this.getValue('insert_close', false, 'yes'),
                insertBack: this.getValue('insert_back', false, 'yes'),
                labelClose: this.getValue('label_close', 'Close'),
                labelBack: settings.label_back || ''
            });
        }
        
        this.elements.$wrapper.removeClass('hidden');
    }

    tabKeyNavigationSupport() {
        var links, i, len;

        if (!this.elements.$menu.length) {
            return false;
        }

        links = this.elements.$menu.find('a');

        // Each time a menu link is focused or blurred, toggle focus.
        jQuery.each(links, function (i, link) {
            jQuery(link).on('focus', toggleFocus);
            jQuery(link).on('blur', toggleFocus);
        });

        //Sets or removes the .focus class on an element.
        function toggleFocus() {
            var self = this;

            // Move up through the ancestors of the current link until we hit .primary-menu.
            while (-1 === self.className.indexOf('hc-offcanvas')) {
                // On li elements toggle the class .focus.
                if ('li' === self.tagName.toLowerCase()) {
                    self.classList.toggle('focus');
                }
                self = self.parentElement;
            }
        }
    }

    getValue(key, defaultValue = false, equal = null) {
        let settings = this.getElementSettings();
        if (typeof settings[key] !== 'undefined') {
            if (equal !== null) {
                if (settings[key] === equal) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return settings[key];
            }
        }
        return defaultValue;
    }
}
;

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetNavMenu, {
            $element
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-nav-menu.default', addHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/hqpro-theme-advanced-nav-menu.default', addHandler);
});