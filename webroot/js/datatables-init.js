/**
 * DataTables Initialization Module
 * Reusable DataTables setup with column filtering functionality
 * Extracted from individual template files for better maintainability
 */

/**
 * Initialize a DataTable with standard configuration and column filters
 * @param {string} tableId - The ID of the table element (without #)
 * @param {Object} options - Configuration options
 * @param {string} options.searchPlaceholder - Placeholder text for search box
 * @param {string} options.entityName - Name of the entity for info text (e.g., "cars", "bookings")
 * @param {Array} options.nonSortableColumns - Column indices that should not be sortable
 * @param {Array} options.defaultOrder - Default sort order, e.g., [[0, 'desc']]
 */
function initDataTable(tableId, options = {}) {
    // Wait for DOM and dependencies to be ready
    if (typeof $ === 'undefined' || typeof $.fn.dataTable === 'undefined') {
        console.warn('jQuery or DataTables not loaded');
        return null;
    }

    const $table = $('#' + tableId);
    if ($table.length === 0) {
        console.warn('Table not found: ' + tableId);
        return null;
    }

    // Default options
    const defaults = {
        searchPlaceholder: 'Search...',
        entityName: 'entries',
        nonSortableColumns: [],
        defaultOrder: [[0, 'desc']]
    };

    // Merge options
    const config = Object.assign({}, defaults, options);

    // Initialize DataTable
    const table = $table.DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: config.searchPlaceholder,
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ " + config.entityName,
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        columnDefs: [{
            orderable: false,
            targets: config.nonSortableColumns
        }],
        order: config.defaultOrder,
        initComplete: function() {
            initColumnFilters(tableId, this.api());
        }
    });

    return table;
}

/**
 * Initialize column filter dropdowns for a DataTable
 * @param {string} tableId - The table ID
 * @param {Object} api - DataTables API instance
 */
function initColumnFilters(tableId, api) {
    const $table = $('#' + tableId);

    // Build dropdown filters for filterable columns
    $table.find('thead th.filterable').each(function() {
        const $th = $(this);
        const columnIndex = $th.data('column');
        const column = api.column(columnIndex);
        const $dropdown = $th.find('.column-dropdown');
        const $filterIcon = $th.find('.filter-icon');

        // Clear any existing options
        $dropdown.empty();

        // Add "All" option
        $dropdown.append('<div class="filter-option" data-value="">All</div>');

        // Populate with unique values
        column.data().unique().sort().each(function(d) {
            const text = $('<div>').html(d).text().trim();
            if (text) {
                $dropdown.append('<div class="filter-option" data-value="' + escapeHtml(text) + '">' + escapeHtml(text) + '</div>');
            }
        });

        // Toggle dropdown ONLY on filter icon click
        $filterIcon.off('click').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            const wasVisible = $dropdown.is(':visible');
            $('.column-dropdown').hide();
            if (!wasVisible) {
                $dropdown.show();
            }
            return false;
        });

        // Apply filter on option click
        $dropdown.off('click', '.filter-option').on('click', '.filter-option', function(e) {
            e.stopPropagation();
            const val = $(this).data('value');

            // Use contains search for better matching
            if (val) {
                column.search(val, false, false).draw();
            } else {
                column.search('').draw();
            }
            $dropdown.hide();

            // Update icon to show active filter
            if (val) {
                $filterIcon.addClass('filter-active');
            } else {
                $filterIcon.removeClass('filter-active');
            }
        });
    });

    // Close dropdowns when clicking outside
    $(document).off('click.dtFilter').on('click.dtFilter', function(e) {
        if (!$(e.target).closest('.column-dropdown, .filter-icon').length) {
            $('.column-dropdown').hide();
        }
    });
}

/**
 * Escape HTML to prevent XSS
 * @param {string} text - Text to escape
 * @returns {string} Escaped text
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Auto-initialize on page load if tables exist
window.addEventListener('load', function() {
    // Check for common table IDs and auto-initialize if they exist
    const tableConfigs = {
        'carsTable': {
            searchPlaceholder: 'Search cars...',
            entityName: 'cars',
            nonSortableColumns: [0, 8, 9],
            defaultOrder: [[1, 'asc']]
        },
        'bookingsTable': {
            searchPlaceholder: 'Search bookings...',
            entityName: 'bookings',
            nonSortableColumns: [7, 8],
            defaultOrder: [[0, 'desc']]
        },
        'reviewsTable': {
            searchPlaceholder: 'Search reviews...',
            entityName: 'reviews',
            nonSortableColumns: [6],
            defaultOrder: [[0, 'desc']]
        },
        'maintenancesTable': {
            searchPlaceholder: 'Search maintenance records...',
            entityName: 'records',
            nonSortableColumns: [5, 6],
            defaultOrder: [[3, 'desc']]
        },
        'usersTable': {
            searchPlaceholder: 'Search users...',
            entityName: 'users',
            nonSortableColumns: [],
            defaultOrder: [[0, 'desc']]
        },
        'paymentsTable': {
            searchPlaceholder: 'Search payments...',
            entityName: 'payments',
            nonSortableColumns: [],
            defaultOrder: [[0, 'desc']]
        },
        'invoicesTable': {
            searchPlaceholder: 'Search invoices...',
            entityName: 'invoices',
            nonSortableColumns: [],
            defaultOrder: [[0, 'desc']]
        },
        'carCategoriesTable': {
            searchPlaceholder: 'Search categories...',
            entityName: 'categories',
            nonSortableColumns: [],
            defaultOrder: [[0, 'asc']]
        }
    };

    // Auto-initialize tables that exist on the page
    Object.keys(tableConfigs).forEach(function(tableId) {
        if ($('#' + tableId).length > 0 && !$.fn.DataTable.isDataTable('#' + tableId)) {
            initDataTable(tableId, tableConfigs[tableId]);
        }
    });
});
