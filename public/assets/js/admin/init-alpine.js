function data() {
  function getThemeFromLocalStorage() {
    if (window.FlightHoursTheme) {
      return window.FlightHoursTheme.isDark();
    }

    if (window.localStorage.getItem('dark') !== null) {
      return JSON.parse(window.localStorage.getItem('dark'));
    }

    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    );
  }

  function applyThemeClass(isDark) {
    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.classList.toggle('theme-dark', isDark);
    document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
    document.documentElement.dataset.theme = isDark ? 'dark' : 'light';
  }

  return {
    dark: getThemeFromLocalStorage(),
    init() {
      applyThemeClass(this.dark);
    },
    toggleTheme() {
      this.dark = !this.dark;

      if (window.FlightHoursTheme) {
        window.FlightHoursTheme.set(this.dark);
      } else {
        window.localStorage.setItem('dark', JSON.stringify(this.dark));
        applyThemeClass(this.dark);
      }
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen;
    },
    closeSideMenu() {
      this.isSideMenuOpen = false;
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false;
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen;
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false;
    },
    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen;
    },
  };
}
