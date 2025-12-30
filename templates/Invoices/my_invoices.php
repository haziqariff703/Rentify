<?php

/**
 * My Invoices - Private Banking Executive Edition
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invoice> $invoices
 */

// Calculate financial summary
$totalOutstanding = 0;
$totalSpendYTD = 0;
$nextDueDate = null;

foreach ($invoices as $invoice) {
    if (strtolower($invoice->status) === 'unpaid') {
        $totalOutstanding += $invoice->amount;
        if ($nextDueDate === null || $invoice->due_date < $nextDueDate) {
            $nextDueDate = $invoice->due_date ?? $invoice->created;
        }
    }
    if (strtolower($invoice->status) === 'paid') {
        $totalSpendYTD += $invoice->amount;
    }
}
?>

<style>
    /* Google Fonts - Montserrat (Bold & Punchy) + Inter */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800;900&display=swap');

    /* ========================================
       PAGE WRAPPER
       ======================================== */
    .invoices-executive-wrapper {
        background-color: #f1f5f9;
        min-height: 100vh;
        margin-top: -3rem;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* ========================================
       MERCEDES HERO HEADER
       ======================================== */
    .mercedes-header {
        background-image:
            linear-gradient(to bottom, 
                rgba(15, 23, 42, 0.95) 0%,
                rgba(15, 23, 42, 0.90) 40%,
                rgba(15, 23, 42, 0.60) 100%),
            url('<?= $this->Url->image('my_mercedes.jpg') ?>');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        padding: 80px 0 100px;
        position: relative;
        text-align: center;
    }

    .header-eyebrow {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.25em;
        color: rgba(147, 197, 253, 0.6);
        margin-bottom: 12px;
    }

    .header-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 3rem;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        color: #ffffff;
        margin: 0;
    }

    @media (min-width: 768px) {
        .header-title {
            font-size: 4.5rem;
        }
    }

    /* ========================================
       UNIFIED STATS CONTAINER
       ======================================== */
    .stats-container {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        max-width: 900px;
        margin: -4rem auto 40px;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        padding: 28px 0;
        position: relative;
        z-index: 10;
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-divider {
        width: 1px;
        height: 50px;
        background-color: #e2e8f0;
    }

    .stat-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 2rem;
        font-weight: 900;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-value.text-emerald {
        color: #059669;
    }

    .stat-value.text-red {
        color: #dc2626;
    }

    .stat-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #94a3b8;
    }

    /* ========================================
       CONTROLS BAR
       ======================================== */
    .controls-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px 0;
    }

    .search-input {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 18px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        width: 280px;
        color: #334155;
        transition: all 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
    }

    .search-input::placeholder {
        color: #94a3b8;
    }

    .download-btn {
        background: transparent;
        border: 1px solid #0f172a;
        color: #0f172a;
        border-radius: 10px;
        padding: 12px 24px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .download-btn:hover {
        background: #0f172a;
        color: #ffffff;
    }

    /* ========================================
       WHITE TABLE CONTAINER (LEDGER)
       ======================================== */
    .ledger-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    /* Scroll Wrapper */
    .table-scroll-wrapper {
        max-height: 450px;
        overflow-y: auto;
    }

    .table-scroll-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: #334155;
    }

    /* ========================================
       TABLE STYLING - LEDGER THEME
       ======================================== */
    .invoices-table {
        width: 100%;
        border-collapse: collapse;
    }

    .invoices-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .invoices-table thead th {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #64748b;
        padding: 18px 24px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .invoices-table thead th.text-right {
        text-align: right;
    }

    .invoices-table tbody tr {
        transition: background 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .invoices-table tbody tr:hover {
        background: #fafbfc;
    }

    .invoices-table tbody tr:last-child {
        border-bottom: none;
    }

    .invoices-table tbody td {
        font-family: 'Montserrat', sans-serif;
        color: #334155;
        padding: 20px 24px;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    /* Invoice Number - Monospace Blue Link */
    .invoice-number {
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        font-weight: 700;
        color: #2563eb;
        text-decoration: none;
    }

    .invoice-number:hover {
        text-decoration: underline;
    }

    /* Car Name + Date */
    .invoice-car {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .invoice-trip-date {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* Amount - Monospace Right Aligned */
    .invoice-amount {
        font-family: 'Courier New', monospace;
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        text-align: right;
    }

    /* ========================================
       STATUS BADGES - OUTLINE STYLE
       ======================================== */
    .status-outline {
        padding: 5px 14px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
        background: transparent;
    }

    .status-outline.paid {
        border: 1.5px solid #10b981;
        color: #10b981;
    }

    .status-outline.unpaid {
        border: 1.5px solid #ef4444;
        color: #ef4444;
    }

    .status-outline.cancelled {
        border: 1.5px solid #94a3b8;
        color: #94a3b8;
    }

    /* ========================================
       ACTION BUTTONS
       ======================================== */
    .pay-btn {
        background: #0f172a;
        border: none;
        color: #ffffff;
        border-radius: 8px;
        padding: 10px 20px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pay-btn:hover {
        background: #1e293b;
        color: #ffffff;
    }

    .icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .icon-btn:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .invoices-empty {
        text-align: center;
        padding: 80px 20px;
    }

    .invoices-empty i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .invoices-empty h4 {
        font-family: 'Playfair Display', serif;
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .invoices-empty p {
        color: #64748b;
    }

    /* ========================================
       CONTENT SECTION
       ======================================== */
    .content-section {
        padding: 0 0 60px;
        background: #f8fafc;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .summary-cards {
            flex-direction: column;
            padding: 0 20px;
            gap: 16px;
        }

        .summary-card {
            min-width: 100%;
        }

        .controls-bar {
            flex-direction: column;
            gap: 16px;
            padding: 20px;
        }

        .search-input {
            width: 100%;
        }

        .header-title {
            font-size: 2rem;
        }

        .invoices-table thead {
            display: none;
        }

        .invoices-table tbody tr {
            display: block;
            margin: 15px;
            background: #ffffff;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .invoices-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .invoices-table tbody td:last-child {
            border-bottom: none;
        }

        .invoices-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.6rem;
            letter-spacing: 1px;
        }
    }
</style>

<!-- Executive Invoices Wrapper -->
<div class="invoices-executive-wrapper">

    <!-- Mercedes Hero Header -->
    <div class="mercedes-header">
        <div class="container">
            <div class="header-eyebrow">Billing & Payments</div>
            <h1 class="header-title">My Invoices</h1>
        </div>
    </div>

    <!-- Unified Stats Container -->
    <div class="container">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-value <?= $totalOutstanding > 0 ? 'text-red' : 'text-emerald' ?>">
                    RM <?= number_format($totalOutstanding, 2) ?>
                </div>
                <div class="stat-label">Outstanding Due</div>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <div class="stat-value">
                    RM <?= number_format($totalSpendYTD, 2) ?>
                </div>
                <div class="stat-label">Total Spend YTD</div>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <div class="stat-value">
                    <?= $nextDueDate ? $nextDueDate->format('M d, Y') : '—' ?>
                </div>
                <div class="stat-label">Next Due Date</div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="container">
            <!-- Controls Bar -->
            <div class="controls-bar">
                <input type="text" class="search-input" placeholder="🔍  Search invoices..." id="invoiceSearch" onkeyup="filterInvoices()">
                <button class="download-btn">
                    <i class="fas fa-file-pdf"></i> Download Statement (PDF)
                </button>
            </div>

            <?php if (!empty($invoices) && count($invoices) > 0): ?>
                <!-- Ledger Table Card -->
                <div class="ledger-card">
                    <div class="table-scroll-wrapper">
                        <table class="invoices-table" id="invoicesTable">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Car / Trip</th>
                                    <th class="text-right">Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="invoiceTableBody">
                                <?php foreach ($invoices as $invoice): ?>
                                    <tr class="invoice-row">
                                        <td data-label="Invoice #">
                                            <a href="<?= $this->Url->build(['action' => 'viewInvoices', $invoice->id]) ?>" class="invoice-number">
                                                #<?= h($invoice->invoice_number) ?>
                                            </a>
                                        </td>
                                        <td data-label="Car / Trip">
                                            <?php if ($invoice->booking && $invoice->booking->car): ?>
                                                <div class="invoice-car">
                                                    <?= h($invoice->booking->car->brand ?? '') ?> <?= h($invoice->booking->car->car_model) ?>
                                                </div>
                                                <div class="invoice-trip-date">
                                                    <?php if ($invoice->booking->start_date && $invoice->booking->end_date): ?>
                                                        <?= $invoice->booking->start_date->format('M d') ?> - <?= $invoice->booking->end_date->format('M d, Y') ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="invoice-amount" data-label="Amount">
                                            RM <?= number_format($invoice->amount, 2) ?>
                                        </td>
                                        <td data-label="Status">
                                            <?php
                                            $statusClass = match (strtolower($invoice->status)) {
                                                'paid' => 'paid',
                                                'unpaid' => 'unpaid',
                                                'cancelled' => 'cancelled',
                                                default => 'cancelled'
                                            };
                                            ?>
                                            <span class="status-outline <?= $statusClass ?>">
                                                <?= h($invoice->status) ?>
                                            </span>
                                        </td>
                                        <td data-label="Actions">
                                            <?php if (strtolower($invoice->status) === 'unpaid'): ?>
                                                <?= $this->Html->link(
                                                    'Pay Now',
                                                    ['action' => 'viewInvoices', $invoice->id],
                                                    ['class' => 'pay-btn']
                                                ) ?>
                                            <?php else: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-file-pdf"></i>',
                                                    ['action' => 'viewInvoices', $invoice->id],
                                                    ['class' => 'icon-btn', 'escape' => false, 'title' => 'View PDF']
                                                ) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <!-- No Results Row (Hidden by default) -->
                                <tr id="noResultsRow" style="display: none;">
                                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                                        <i class="fas fa-search" style="font-size: 1.5rem; margin-bottom: 10px; display: block;"></i>
                                        No invoices found matching your search.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    <nav>
                        <ul class="pagination"><?= $this->Paginator->numbers() ?></ul>
                    </nav>
                </div>

            <?php else: ?>
                <!-- Empty State -->
                <div class="ledger-card">
                    <div class="invoices-empty">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <h4>No Invoices Found</h4>
                        <p>You have no pending bills or payment history.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Enhanced Invoice Search Filter
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('invoiceSearch');
        const tableBody = document.getElementById('invoiceTableBody');
        const noResultsRow = document.getElementById('noResultsRow');
        const invoiceRows = tableBody.querySelectorAll('.invoice-row');

        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase().trim();
            let visibleCount = 0;

            invoiceRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show "No results" row if all invoices are hidden
            if (visibleCount === 0 && filter !== '') {
                noResultsRow.style.display = '';
            } else {
                noResultsRow.style.display = 'none';
            }
        });

        // Clear search on Escape key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                invoiceRows.forEach(row => row.style.display = '');
                noResultsRow.style.display = 'none';
            }
        });
    });
</script>