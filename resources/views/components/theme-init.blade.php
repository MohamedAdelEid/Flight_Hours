<script>
(function () {
    var key = 'dark';

    function stored() {
        var value = localStorage.getItem(key);
        if (value === null) return null;
        try { return JSON.parse(value); } catch (e) { return value === 'true'; }
    }

    var dark = stored();
    if (dark === null) {
        dark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    var root = document.documentElement;
    root.classList.toggle('dark', dark);
    root.classList.toggle('theme-dark', dark);
    root.style.colorScheme = dark ? 'dark' : 'light';
    root.dataset.theme = dark ? 'dark' : 'light';
})();
</script>
