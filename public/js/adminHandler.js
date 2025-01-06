// adminHandler.js
const adminModal = new ModalHandler({
    modalId: 'adminModal',
    fetchUrl: '/mais/getAdminDetails',
    updateUrl: '/mais/updateAdmin',
    fieldMappings: {
        name: 'name',
        syslevel: 'syslevel',
        ic: 'ic',
        sysaccess: 'sysaccess',
        hp: 'hp',
        jobstart: 'jobstart',
        mel: 'mel',
        status: 'status'
    }
});

// Global functions for admin page
window.openModal = (id) => adminModal.open(id);
window.closeModal = () => adminModal.close();
window.refreshData = () => adminModal.refresh();
window.saveChanges = () => adminModal.save();
