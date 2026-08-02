// Fixed-slot repeater reordering — swaps field VALUES between adjacent
// [data-repeater-row] elements inside the same [data-repeater-group].
// Rows themselves never move in the DOM; only input/textarea/select
// values and checkbox states are exchanged, so slot names/errorKeys
// (and any position-locked icon/index in the section presenter) stay put.
(function () {
    function fieldsOf(row) {
        return Array.from(row.querySelectorAll('input, textarea, select'));
    }

    function swapRows(rowA, rowB) {
        const fieldsA = fieldsOf(rowA);
        const fieldsB = fieldsOf(rowB);

        if (fieldsA.length !== fieldsB.length) {
            return;
        }

        fieldsA.forEach((fieldA, index) => {
            const fieldB = fieldsB[index];

            if (fieldA.type === 'checkbox' || fieldA.type === 'radio') {
                const checkedA = fieldA.checked;
                fieldA.checked = fieldB.checked;
                fieldB.checked = checkedA;
                return;
            }

            const valueA = fieldA.value;
            fieldA.value = fieldB.value;
            fieldB.value = valueA;
        });
    }

    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-repeater-move]');

        if (!button) {
            return;
        }

        const row = button.closest('[data-repeater-row]');
        const group = button.closest('[data-repeater-group]');

        if (!row || !group) {
            return;
        }

        const rows = Array.from(group.querySelectorAll('[data-repeater-row]'));
        const index = rows.indexOf(row);
        const direction = button.getAttribute('data-repeater-move');
        const targetIndex = direction === 'up' ? index - 1 : index + 1;

        if (targetIndex < 0 || targetIndex >= rows.length) {
            return;
        }

        swapRows(row, rows[targetIndex]);
    });
})();
