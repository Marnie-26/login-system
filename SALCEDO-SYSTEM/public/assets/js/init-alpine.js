function data() {
  function getThemeFromLocalStorage() {
    // If user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'));
    }

    // Else return their preferences
    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    );
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value);
  }

  // Apply the theme immediately upon loading to prevent flashing
  const initialDarkTheme = getThemeFromLocalStorage();
  document.documentElement.classList.toggle('dark', initialDarkTheme);

  return {
    dark: initialDarkTheme,
    toggleTheme() {
      this.dark = !this.dark;
      setThemeToLocalStorage(this.dark);
      document.documentElement.classList.toggle('dark', this.dark);
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

    // Visitors Log
    isPagesMenuOpen1: false,
    togglePagesMenu1() {
      this.isPagesMenuOpen1 = !this.isPagesMenuOpen1;
    },

    // Keys Monitoring
    isPagesMenuOpen2: false,
    togglePagesMenu2() {
      this.isPagesMenuOpen2 = !this.isPagesMenuOpen2;
    },

    // Work Permit
    isPagesMenuOpen3: false,
    togglePagesMenu3() {
      this.isPagesMenuOpen3 = !this.isPagesMenuOpen3;
    },

    // Edit Visitor Modal
    isEditVisitorModalOpen: false,
    trapCleanup: null,
    editingGuest: {},

    openEditVisitorModal(guest) {
      this.editingGuest = guest;
      this.isEditVisitorModalOpen = true;
      this.trapCleanup = focusTrap(document.querySelector('#editVisitor'));
    },

    closeEditVisitorModal() {
      this.isEditVisitorModalOpen = false;

      setTimeout(() => {
        this.trapCleanup();
      }, 150);
    },

    // Delete Visitor Modal
    isDeleteVisitorModalOpen: false,
    currentGuestId: '',

    openDeleteVisitorModal(guestId) {
      this.isDeleteVisitorModalOpen = true;
      this.currentGuestId = guestId;
      this.trapCleanup = focusTrap(document.querySelector(`#deleteVisitor${guestId}`));
    },
    

    closeDeleteVisitorModal() {
      this.isDeleteVisitorModalOpen = false;
      this.currentGuestId = '';

      setTimeout(() => {
        this.trapCleanup();
      }, 150);
    },

     // Edit Key Modal
     isEditKeyModalOpen: false,
     trapCleanup: null,
     editingKey: {},
 
     openEditKeyModal(key) {
       this.editingKey = key;
       this.isEditKeyModalOpen = true;
       this.trapCleanup = focusTrap(document.querySelector('#editKey'));
     },
 
     closeEditKeyModal() {
       this.isEditKeyModalOpen = false;
 
       setTimeout(() => {
         this.trapCleanup();
       }, 150);
     },

    // Delete Key Modal
    isDeleteKeyModalOpen: false,
    currentKeyId: '',

    openDeleteKeyModal(keyId) {
      this.isDeleteKeyModalOpen = true;
      this.currentKeyId = keyId;
      this.trapCleanup = focusTrap(document.querySelector(`#deleteKey${keyId}`));
    },
    
    closeDeleteKeyModal() {
      this.isDeleteKeyModalOpen = false;
      this.currentKeyId = '';

      setTimeout(() => {
        this.trapCleanup();
      }, 150);
    },

     // Edit Work Permit Modal
     isEditPermitModalOpen: false,
     trapCleanup: null,
     editingPermit: {},
 
     openEditPermitModal(permit) {
       this.editingPermit = permit;
       this.isEditPermitModalOpen = true;
       this.trapCleanup = focusTrap(document.querySelector('#editPermit'));
     },
 
     closeEditPermitModal() {
       this.isEditPermitModalOpen = false;
 
       setTimeout(() => {
         this.trapCleanup();
       }, 150);
     },

    // Delete Work Permit Modal
    isDeletePermitModalOpen: false,
    currentPermitId: '',

    openDeletePermitModal(permitId) {
      this.isDeletePermitModalOpen = true;
      this.currentPermitId = permitId;
      this.trapCleanup = focusTrap(document.querySelector(`#deletePermit${permitId}`));
    },
    
    closeDeletePermitModal() {
      this.isDeletePermitModalOpen = false;
      this.currentPermitId = '';

      setTimeout(() => {
        this.trapCleanup();
      }, 150);
    },
  };
}
