(function () {
    var STORAGE_KEY = 'dark';

    function parseStored(value) {
        if (value === null) {
            return null;
        }

        try {
            return JSON.parse(value);
        } catch (error) {
            return value === 'true';
        }
    }

    function prefersDark() {
        return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    function isDark() {
        var stored = parseStored(window.localStorage.getItem(STORAGE_KEY));

        if (stored !== null) {
            return !!stored;
        }

        return prefersDark();
    }

    function applyTheme(dark) {
        var root = document.documentElement;

        root.classList.toggle('dark', dark);
        root.classList.toggle('theme-dark', dark);
        root.style.colorScheme = dark ? 'dark' : 'light';
        root.dataset.theme = dark ? 'dark' : 'light';
    }

    function setTheme(dark) {
        window.localStorage.setItem(STORAGE_KEY, JSON.stringify(!!dark));
        applyTheme(!!dark);
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: !!dark } }));
    }

    applyTheme(isDark());

    window.FlightHoursTheme = {
        isDark: isDark,
        set: setTheme,
        toggle: function () {
            setTheme(!document.documentElement.classList.contains('dark'));
        },
    };
})();
