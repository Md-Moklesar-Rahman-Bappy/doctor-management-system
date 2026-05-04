/**
 * Reusable Medicine Search Module
 * Can be configured with different fields (dosage, time, duration)
 */
class MedicineSearch {
    constructor(config = {}) {
        this.container = config.container || '#medicines-container';
        this.onSelect = config.onSelect || null;
        this.searchDelay = config.searchDelay || 300;
        this.autocompleteUrl = config.autocompleteUrl || '/medicines/autocomplete';
        this.index = config.startIndex || 0;
        this.searchTimeout = null;
    }

    /**
     * Add a new medicine search row
     * @param {Object} options - Configuration for this row
     * @param {boolean} options.showDosage - Show dosage field
     * @param {boolean} options.showTime - Show time checkboxes (Morning/Afternoon/Night)
     * @param {boolean} options.showDuration - Show duration with days/months
     * @param {Object} options.existingData - Pre-filled data for edit mode
     */
    addRow(options = {}, existingData = null) {
        const container = document.querySelector(this.container);
        if (!container) {
            console.error('MedicineSearch: Container not found:', this.container);
            return;
        }

        const showDosage = options.showDosage !== false;
        const showTime = options.showTime || false;
        const showDuration = options.showDuration || false;
        const currentIndex = this.index++;

        let html = `<div class="card mb-3 medicine-search-row" data-index="${currentIndex}">` +
            '<div class="card-body p-3">' +
            '<div class="row g-3 align-items-center">';

        // Medicine Search Field
        html += '<div class="col-md-4">' +
            '<div class="input-group position-relative">' +
            '<span class="input-group-text bg-light border-end-0"><i class="fas fa-pills text-muted"></i></span>' +
            `<input type="text" class="form-control border-start-0 medicine-search-input" 
                placeholder="Search brand or generic name..." 
                onkeyup="window.medicineSearchInstance.search(this, event, ${currentIndex})">` +
            `<div class="medicine-dropdown position-absolute start-0 top-100 mt-1 w-100 shadow-lg bg-white rounded-3 border d-none" 
                style="z-index: 1050; max-height: 200px; overflow-y: auto;"></div>` +
            '</div>' +
            '</div>';

        // Dosage Field
        if (showDosage) {
            html += '<div class="col-md-2">' +
                '<input type="text" class="form-control medicine-dosage" placeholder="Dosage (e.g. 500mg)">' +
                '</div>';
        }

        // Time Checkboxes
        if (showTime) {
            html += '<div class="col-md-3">' +
                '<label class="form-label small text-muted mb-1">সময় (Time)</label>' +
                '<div class="medicine-time-checkboxes d-flex gap-3">' +
                '<div class="form-check">' +
                '<input class="form-check-input medicine-time-morning" type="checkbox" value="morning">' +
                '<label class="form-check-label small">Morning(সকাল)</label>' +
                '</div>' +
                '<div class="form-check">' +
                '<input class="form-check-input medicine-time-afternoon" type="checkbox" value="afternoon">' +
                '<label class="form-check-label small">Afternoon(দুপুর)</label>' +
                '</div>' +
                '<div class="form-check">' +
                '<input class="form-check-input medicine-time-night" type="checkbox" value="night">' +
                '<label class="form-check-label small">Night(রাত)</label>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        // Duration Field
        if (showDuration) {
            html += '<div class="col-md-3">' +
                '<label class="form-label small text-muted mb-1">Duration</label>' +
                '<div class="input-group">' +
                `<input type="number" class="form-control medicine-duration-value" placeholder="7" min="1">` +
                '<div class="input-group-text">' +
                `<div class="form-check form-check-inline">` +
                `<input class="form-check-input medicine-duration-type" type="radio" name="duration_type_${currentIndex}" value="days" checked>` +
                '<label class="form-check-label small">Days</label>' +
                '</div>' +
                `<div class="form-check form-check-inline">` +
                `<input class="form-check-input medicine-duration-type" type="radio" name="duration_type_${currentIndex}" value="months">` +
                '<label class="form-check-label small">Months</label>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        html += '</div>';

        // Action Buttons
        html += '<div class="mt-2 d-flex gap-2 align-items-center">' +
            `<button type="button" class="btn btn-sm btn-primary" onclick="window.medicineSearchInstance.addMedicine(this, ${currentIndex})">` +
            '<i class="fas fa-check me-1"></i> Add Medicine</button>' +
            `<button type="button" class="btn btn-sm btn-outline-danger" onclick="window.medicineSearchInstance.removeRow(this)">` +
            '<i class="fas fa-times"></i></button>' +
            '</div>';

        // Selected Medicine Display
        html += '<div class="selected-medicine mt-2 d-none"><span class="badge bg-success"></span></div>';

        // Hidden Fields
        html += `<input type="hidden" class="medicine-id" value="">` +
            `<input type="hidden" class="medicine-name" value="">` +
            `<input type="hidden" class="medicine-dosage-hidden" value="">` +
            `<input type="hidden" class="medicine-time-hidden" value="">` +
            `<input type="hidden" class="medicine-duration-hidden" value="">`;

        html += '</div></div>';

        container.insertAdjacentHTML('beforeend', html);

        // If editing with existing data, fill the row
        if (existingData) {
            this.fillRow(currentIndex, existingData);
        }
    }

    /**
     * Search medicines (called from input onkeyup)
     */
    search(input, event, index) {
        if (event.key === 'Enter') return;
        
        const term = input.value.trim();
        const row = input.closest('.medicine-search-row');
        const dropdown = row.querySelector('.medicine-dropdown');

        if (term.length < 2) {
            dropdown.classList.add('d-none');
            return;
        }

        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            fetch(this.autocompleteUrl + '?term=' + encodeURIComponent(term))
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        dropdown.innerHTML = data.data.map(m => {
                            const brandHtml = this.highlightText(m.brand_name, term);
                            const strengthHtml = m.strength ? ` - ${m.strength}` : '';
                            const genericHtml = m.generic_name ? 
                                `<div class="small text-muted">${this.highlightText(m.generic_name, term)}</div>` : '';
                            
                            return `<div class="px-3 py-2 hover-bg-light cursor-pointer" 
                                onclick="window.medicineSearchInstance.select(this, ${index}, '${m.id}', '${this.escapeJs(m.brand_name)}', '${this.escapeJs(m.generic_name || '')}', '${this.escapeJs(m.strength || '')}')">
                                <div class="fw-medium">${brandHtml}${strengthHtml}</div>
                                ${genericHtml}
                            </div>`;
                        }).join('');
                        dropdown.classList.remove('d-none');
                    } else {
                        dropdown.innerHTML = '<div class="px-3 py-2 text-muted">No medicines found</div>';
                        dropdown.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    console.error('Medicine search error:', err);
                });
        }, this.searchDelay);
    }

    /**
     * Select a medicine from dropdown
     */
    select(element, index, id, brandName, genericName, strength) {
        const row = element.closest('.medicine-search-row');
        const displayName = brandName + (genericName ? ' (' + genericName + ')' : '') + (strength ? ' - ' + strength : '');
        
        row.querySelector('.medicine-id').value = id;
        row.querySelector('.medicine-name').value = brandName;
        row.querySelector('.selected-medicine span').textContent = displayName;
        row.querySelector('.selected-medicine').classList.remove('d-none');
        row.querySelector('.medicine-search-input').classList.add('d-none');
        row.querySelector('.medicine-dropdown').classList.add('d-none');
    }

    /**
     * Add medicine to form (disable inputs)
     */
    addMedicine(button, index) {
        const row = button.closest('.medicine-search-row');
        const name = row.querySelector('.medicine-name').value;

        if (!name) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Error', 'Please select a medicine first', 'error');
            } else {
                alert('Please select a medicine first');
            }
            return;
        }

        // Get dosage
        const dosageInput = row.querySelector('.medicine-dosage');
        if (dosageInput) {
            row.querySelector('.medicine-dosage-hidden').value = dosageInput.value;
            dosageInput.disabled = true;
        }

        // Get time checkboxes
        const timeCheckboxes = row.querySelectorAll('.medicine-time-checkboxes input[type="checkbox"]:checked');
        if (timeCheckboxes.length > 0) {
            const timeValues = Array.from(timeCheckboxes).map(cb => cb.value);
            const timeDisplay = timeValues.map(t => {
                if (t === 'morning') return 'Morning(সকাল)';
                if (t === 'afternoon') return 'Afternoon(দুপুর)';
                if (t === 'night') return 'Night(রাত)';
                return t;
            }).join(' + ');
            
            row.querySelector('.medicine-time-hidden').value = JSON.stringify({ 
                values: timeValues, 
                display: timeDisplay 
            });
            
            row.querySelectorAll('.medicine-time-checkboxes input').forEach(cb => cb.disabled = true);
        }

        // Get duration
        const durationValue = row.querySelector('.medicine-duration-value');
        if (durationValue) {
            const durationTypeRadio = row.querySelector('.medicine-duration-type:checked');
            const durationType = durationTypeRadio ? durationTypeRadio.value : 'days';
            const durationDisplay = durationValue.value + ' ' + (durationType === 'days' ? 'days' : 'months');
            
            row.querySelector('.medicine-duration-hidden').value = JSON.stringify({ 
                value: durationValue.value, 
                type: durationType, 
                display: durationDisplay 
            });
            
            durationValue.disabled = true;
            row.querySelectorAll('.medicine-duration-type').forEach(r => r.disabled = true);
        }

        // Disable add button
        button.disabled = true;

        // Update remove button to just remove row
        const removeBtn = row.querySelector('.btn-outline-danger');
        if (removeBtn) {
            removeBtn.onclick = function() { row.remove(); };
        }

        // Call onSelect callback if provided
        if (this.onSelect) {
            this.onSelect(row, {
                id: row.querySelector('.medicine-id').value,
                name: row.querySelector('.medicine-name').value,
                dosage: row.querySelector('.medicine-dosage-hidden').value,
                time: row.querySelector('.medicine-time-hidden').value,
                duration: row.querySelector('.medicine-duration-hidden').value
            });
        }
    }

    /**
     * Remove a row
     */
    removeRow(button) {
        const row = button.closest('.medicine-search-row');
        row.remove();
    }

    /**
     * Fill row with existing data (for edit mode)
     */
    fillRow(index, data) {
        const row = document.querySelector(`.medicine-search-row[data-index="${index}"]`);
        if (!row) return;

        row.querySelector('.medicine-id').value = data.id || '';
        row.querySelector('.medicine-name').value = data.name || '';
        row.querySelector('.selected-medicine span').textContent = data.displayName || data.name;
        row.querySelector('.selected-medicine').classList.remove('d-none');
        row.querySelector('.medicine-search-input').classList.add('d-none');

        if (data.dosage) {
            const dosageInput = row.querySelector('.medicine-dosage');
            if (dosageInput) {
                dosageInput.value = data.dosage;
                dosageInput.disabled = true;
                row.querySelector('.medicine-dosage-hidden').value = data.dosage;
            }
        }

        // Fill time if exists
        if (data.time) {
            const timeData = typeof data.time === 'string' ? JSON.parse(data.time) : data.time;
            if (timeData.values) {
                timeData.values.forEach(val => {
                    const cb = row.querySelector(`.medicine-time-${val}`);
                    if (cb) cb.checked = true;
                });
                row.querySelector('.medicine-time-hidden').value = JSON.stringify(timeData);
                row.querySelectorAll('.medicine-time-checkboxes input').forEach(cb => cb.disabled = true);
            }
        }

        // Fill duration if exists
        if (data.duration) {
            const durData = typeof data.duration === 'string' ? JSON.parse(data.duration) : data.duration;
            if (durData.value) {
                const durInput = row.querySelector('.medicine-duration-value');
                if (durInput) {
                    durInput.value = durData.value;
                    durInput.disabled = true;
                }
                const durRadio = row.querySelector(`.medicine-duration-type[value="${durData.type || 'days'}"]`);
                if (durRadio) durRadio.checked = true;
                row.querySelectorAll('.medicine-duration-type').forEach(r => r.disabled = true);
                row.querySelector('.medicine-duration-hidden').value = JSON.stringify(durData);
            }
        }

        // Disable add button
        const addBtn = row.querySelector('.btn-primary');
        if (addBtn) addBtn.disabled = true;
    }

    /**
     * Get all medicines data from the form
     */
    getMedicinesData() {
        const medicines = [];
        document.querySelectorAll('.medicine-search-row').forEach(row => {
            const name = row.querySelector('.medicine-name').value;
            if (name) {
                medicines.push({
                    id: row.querySelector('.medicine-id').value,
                    name: name,
                    dosage: row.querySelector('.medicine-dosage-hidden').value,
                    time: row.querySelector('.medicine-time-hidden').value,
                    duration: row.querySelector('.medicine-duration-hidden').value
                });
            }
        });
        return medicines;
    }

    /**
     * Highlight matching text with <strong> tags
     */
    highlightText(text, term) {
        if (!term || !text) return text;
        try {
            const regex = new RegExp(`(${this.escapeRegex(term)})`, 'gi');
            return text.replace(regex, '<strong>$1</strong>');
        } catch (e) {
            return text;
        }
    }

    /**
     * Escape regex special characters
     */
    escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    /**
     * Escape string for JavaScript string literal
     */
    escapeJs(string) {
        if (!string) return '';
        return string.replace(/'/g, "\\'").replace(/"/g, '\\"');
    }
}
