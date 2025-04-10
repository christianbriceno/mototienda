<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DownloadInvoiceController extends Controller
{
    /**
     * download invoice
     *
     * @param Invoice $invoice
     * @return void
     */
    public function download(Request $request, Invoice $invoice)
    {
        // $pdf = Pdf::loadView('invoices.pdf.invoice', compact('invoice'));
        $pdf = Pdf::loadView('invoices.pdf.invoice-without-iva', compact('invoice'));
        return $pdf->download('invoice' . $invoice->id);
    }

    /**
     * print invoice
     *
     * @param Request $request
     * @return void
     */
    public function print(Request $request, Invoice $invoice)
    {
        // $pdf = Pdf::loadView('invoices.pdf.invoice', compact('invoice'));
        $pdf = Pdf::loadView('invoices.pdf.invoice-without-iva', compact('invoice'));
        return $pdf->stream('invoice' . $invoice->id);
    }
}
