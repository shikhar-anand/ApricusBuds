class HQWidgetThemeCountdownTimer extends elementorModules.frontend.handlers.Base {

    getDefaultSettings() {
        return {
            selectors: {
                wrapper: '.countdown-timer-widget',
                timer: '.countdown-timer',
                message: '.countdown-message'
            }
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $wrapper: this.$element.find(selectors.wrapper),
            $timer: this.$element.find(selectors.timer),
            $message: this.$element.find(selectors.message)
        };
    }

    bindEvents() {
        let timerSettings = this.getElementSettings();
        let options = {};
        if (timerSettings.timer_mode == 'date') {
            // End Date Mode
            options.dateAndTime = timerSettings.dateAndTime;
        } else {
            // Interval Mode
            options.hours = timerSettings.days * 24 + timerSettings.hours;
            options.minutes = timerSettings.minutes;
            options.seconds = timerSettings.seconds;
        }
        // Labels Format
        if (timerSettings.labelsFormat) {
            options.labelsFormat = true;
        }
        // Display Format
        let displayFormat = '';
        if (timerSettings.show_days) {
            displayFormat += 'D';
        }
        if (timerSettings.show_hours) {
            displayFormat += 'H';
        }
        if (timerSettings.show_minutes) {
            displayFormat += 'M';
        }
        if (timerSettings.show_seconds) {
            displayFormat += 'S';
        }
        options.displayFormat = displayFormat.length ? displayFormat : 'DHMS';
        options.timeUp = () => {
            if (timerSettings.expire_show_type == 'message') {
                // Show Expire message
                this.elements.$message.html(timerSettings.expire_message);
            } else {
                // Redirect to URL
                if (!elementorFrontend.isEditMode()) {
                    var link_url = timerSettings.expire_redirect_link.url;
                    if (timerSettings.expire_redirect_link.is_external == 'on') {
                        window.open(link_url);
                    } else {
                        window.location.href = link_url;
                    }
                } else {
                    this.elements.$wrapper.html('You can not redirect url from elementor Editor!');
                }
            }
        }

        this.elements.$timer.countdowntimer(options);
    }

    timeisUp(message) {
        this.elements.$message.html(message);
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetThemeCountdownTimer, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-countdown-timer.default', addHandler);
});