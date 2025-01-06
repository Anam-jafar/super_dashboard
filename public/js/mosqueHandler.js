
// mosqueHandler.js
const mosqueModal = new ModalHandler({
    modalId: 'mosqueModal',
    fetchUrl: '/mais/get_mosque_detail',
    updateUrl: '/mais/update/mosques',
    fieldMappings: {
        name: 'modalName',
        con1: 'modalContact',
        cate: 'modalCategory',
        cate1: 'modalGroup',
        sta: 'modalStatus',
        mel: 'modalEmail',
        hp: 'modalPhone',
        addr: 'modalAddress1',
        addr1: 'modalAddress2',
        addr2: 'modalAddress3',
        pcode: 'modalPcode',
        city: 'modalCity',
        state: 'modalState',
        country: 'modalCountry',
        rem1: 'modalCustomerLink',
        rem2: 'modalAppCode',
        rem3: 'modalCenterId'
    }
});

// Global functions for mosque page
window.openModal = (id) => mosqueModal.open(id);
window.closeModal = () => mosqueModal.close();
window.refreshModal = () => mosqueModal.refresh();
window.updateMosque = () => mosqueModal.save();
window.changeTab = (event, tabName) => mosqueModal.changeTab(event, tabName);