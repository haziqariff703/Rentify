/**
 * Invoice View JavaScript
 * Handles PDF download functionality.
 * 
 * Requires: html2pdf.js CDN loaded
 * Requires: window.RentifyData.invoiceNumber
 * 
 * @file webroot/js/views/Invoices/view.js
 */
function downloadPDF() {
    const element = document.getElementById('invoice-to-print');
    const invoiceNumber = window.RentifyData?.invoiceNumber || 'Invoice';

    const opt = {
        margin: 0,
        filename: 'Invoice_' + invoiceNumber + '.pdf',
        image: {
            type: 'jpeg',
            quality: 0.98
        },
        html2canvas: {
            scale: 2,
            useCORS: true
        },
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        }
    };

    html2pdf().set(opt).from(element).save();
}
