/**
 * ConstantMVC — front-end behaviour
 * ----------------------------------------
 * Small, dependency-free JavaScript that powers the in-page CRUD modals. There
 * is no build step and no framework here on purpose — it stays readable.
 *
 * Server-side validation (core/Validator.php) is always the source of truth;
 * the browser's built-in HTML5 validation (required / type=email / maxlength,
 * generated from the Schema) is just a fast first check.
 */
(function () {
    'use strict';

    // --- Modal open/close ---------------------------------------------------
    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        const firstInput = modal.querySelector('input');
        if (firstInput) firstInput.focus();
    }

    function closeModal(modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Open buttons: <button data-open="modal-add">
    document.querySelectorAll('[data-open]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            openModal(btn.getAttribute('data-open'));
        });
    });

    // Close on the ✕/Cancel buttons, on backdrop click, and on Escape.
    document.querySelectorAll('[data-modal]').forEach(function (modal) {
        modal.querySelectorAll('[data-close]').forEach(function (btn) {
            btn.addEventListener('click', function () { closeModal(modal); });
        });
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal(modal); // clicked the backdrop, not the panel
        });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[data-modal]:not(.hidden)').forEach(closeModal);
        }
    });

    // --- Edit: fill the modal from the clicked row --------------------------
    const editForm = document.getElementById('form-edit');
    document.querySelectorAll('[data-edit]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = btn.getAttribute('data-id');
            const person = JSON.parse(btn.getAttribute('data-person') || '{}');
            editForm.setAttribute('action', 'update?id=' + encodeURIComponent(id));
            Object.keys(person).forEach(function (name) {
                const input = editForm.querySelector('[name="' + name + '"]');
                if (input) input.value = person[name];
            });
            openModal('modal-edit');
        });
    });

    // --- Delete: point the confirmation form at the right record ------------
    const deleteForm = document.getElementById('form-delete');
    document.querySelectorAll('[data-delete]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = btn.getAttribute('data-id');
            deleteForm.setAttribute('action', 'delete?id=' + encodeURIComponent(id));
            const label = document.getElementById('delete-label');
            if (label) label.textContent = btn.getAttribute('data-label') || 'this person';
            openModal('modal-delete');
        });
    });

    // --- Re-open a modal after a failed server-side validation --------------
    const reopen = window.__reopen || { mode: '', id: '' };
    if (reopen.mode === 'add') {
        openModal('modal-add');
    } else if (reopen.mode === 'edit') {
        editForm.setAttribute('action', 'update?id=' + encodeURIComponent(reopen.id));
        openModal('modal-edit');
    }

    // --- Footer year --------------------------------------------------------
    const year = document.getElementById('year');
    if (year) year.textContent = '© ' + new Date().getFullYear() + ' ConstantMVC';
})();
