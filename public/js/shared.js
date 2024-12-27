// public/js/shared.js
class DataManager {
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
        this.currentId = null;
    }

    async openModal(id, modalId) {
        this.currentId = id;
        const modal = document.getElementById(modalId);
        const form = document.getElementById('editForm');
        
        try {
            const response = await fetch(`${this.baseUrl}/details/${id}`);
            const data = await response.json();
            
            if (data.error) {
                alert(data.error);
                return;
            }

            // Set form values
            Object.keys(data).forEach(key => {
                if (form[key]) {
                    form[key].value = data[key] || '';
                }
            });
            
            modal.classList.remove('hidden');
        } catch (error) {
            console.error('Error fetching details:', error);
        }
    }

    closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        this.currentId = null;
    }

    async saveChanges() {
        const form = document.getElementById('editForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch(`${this.baseUrl}/update/${this.currentId}`, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            alert('Changes saved successfully!');
            this.updateTableRow(result);
        } catch (error) {
            console.error('Error saving changes:', error);
            alert('Failed to save changes!');
        }
    }

    updateTableRow(data) {
        const row = document.querySelector(`tr[data-id="${data.id}"]`);
        if (row) {
            const cells = row.getElementsByTagName('td');
            Object.keys(data).forEach((key, index) => {
                if (cells[index]) {
                    cells[index].textContent = data[key];
                }
            });
        }
    }

    refreshData() {
        if (this.currentId) {
            this.openModal(this.currentId);
        }
    }

    updatePagination(recordsPerPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('recordsPerPage', recordsPerPage);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }
}

// Tab management
function initializeTabs() {
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => changeTab(e, tab.dataset.target));
        });
        
        // Activate first tab
        if (tabs.length > 0) {
            tabs[0].click();
        }
    });
}

function changeTab(event, tabName) {
    event.preventDefault();
    const tabContents = document.getElementsByClassName('tab-content');
    Array.from(tabContents).forEach(content => content.classList.add('hidden'));
    document.getElementById(tabName)?.classList.remove('hidden');
    
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        const isSelected = tab.dataset.target === tabName;
        tab.classList.toggle('text-blue-700', isSelected);
        tab.classList.toggle('border-l', isSelected);
        tab.classList.toggle('border-t', isSelected);
        tab.classList.toggle('border-r', isSelected);
        tab.classList.toggle('rounded-t', isSelected);
        tab.classList.toggle('text-blue-500', !isSelected);
    });
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    const firstTab = document.querySelector('.tab');
    if (firstTab) {
        firstTab.click();
    }
});