// branchHandler.js
const branchModal = new ModalHandler({
    modalId: 'branchModal',
    fetchUrl: '/mais/get_branche_detail',
    updateUrl: '/mais/update/branches',
    fieldMappings: {
        name: 'modalName',
        sname: 'modalSname',
        schcat: 'modalSchcat',
        tel: 'modalTel',
        mel: 'modalMel',
        url: 'modalUrl',
        addr: 'modalAddr',
        addr2: 'modalAddr2',
        addr3: 'modalAddr3',
        daerah: 'modalDaerah',
        poskod: 'modalPoskod',
        state: 'modalState',
        country: 'modalCountry'
    }
});

// Global functions for branch page
window.openModal = (id) => branchModal.open(id);
window.closeModal = () => branchModal.close();
window.refreshModal = () => branchModal.refresh();
window.updateBranch = () => branchModal.save();
window.changeTab = (event, tabName) => branchModal.changeTab(event, tabName);