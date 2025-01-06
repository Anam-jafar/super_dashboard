// modalHandler.js

class ModalHandler {
    constructor(options = {}) {
        this.modalId = options.modalId;
        this.currentData = null;
        this.fetchUrl = options.fetchUrl;
        this.updateUrl = options.updateUrl;
        this.fieldMappings = options.fieldMappings || {};
        this.onSaveSuccess = options.onSaveSuccess || (() => location.reload());
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    }

    open(id = null) {
        if (id === null) {
            this.currentData = null;
            this.clearFields();
            document.getElementById(this.modalId).classList.remove('hidden');
            return;
        }

        fetch(`${this.fetchUrl}/${id}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                this.currentData = data;
                this.populateFields(data);
                document.getElementById(this.modalId).classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Failed to fetch details. Please try again.');
            });
    }

    close() {
        document.getElementById(this.modalId).classList.add('hidden');
        this.currentData = null;
    }

    refresh() {
        if (this.currentData?.id) {
            this.open(this.currentData.id);
        }
    }

    clearFields() {
        Object.values(this.fieldMappings).forEach(fieldId => {
            const element = document.getElementById(fieldId);
            if (element) element.value = '';
        });
    }

    populateFields(data) {
        Object.entries(this.fieldMappings).forEach(([key, fieldId]) => {
            const element = document.getElementById(fieldId);
            if (element) element.value = data[key] || '';
        });
    }

    getFormData() {
        const formData = {};
        Object.entries(this.fieldMappings).forEach(([key, fieldId]) => {
            const element = document.getElementById(fieldId);
            if (element) formData[key] = element.value;
        });
        return formData;
    }

    save() {
        const updatedData = this.getFormData();
        const url = this.currentData ? 
            `${this.updateUrl}/${this.currentData.id}` : 
            this.updateUrl;
        const method = this.currentData ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken
            },
            body: JSON.stringify(updatedData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(JSON.stringify(err));
                });
            }
            return response.json();
        })
        .then(data => {
            this.currentData = data;
            this.onSaveSuccess(data);
            this.close();
        })
        .catch(error => {
            console.error('Error saving data:', error);
            alert(`Failed to save details. Error: ${error.message}`);
        });
    }

    changeTab(event, tabName) {
        event.preventDefault();
        const tabContents = document.getElementsByClassName('tab-content');
        Array.from(tabContents).forEach(content => content.classList.add('hidden'));
        document.getElementById(tabName)?.classList.remove('hidden');

        const tabs = document.querySelectorAll('[role="tab"]');
        tabs.forEach(tab => {
            tab.setAttribute('aria-selected', 'false');
            tab.classList.remove('text-indigo-600', 'border-indigo-600');
            tab.classList.add('text-gray-500', 'border-transparent');
        });
        
        const currentTab = event.currentTarget;
        currentTab.setAttribute('aria-selected', 'true');
        currentTab.classList.remove('text-gray-500', 'border-transparent');
        currentTab.classList.add('text-indigo-600', 'border-indigo-600');
    }
}