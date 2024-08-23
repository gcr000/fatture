<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {

        return view('invoices.detail',[
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $amount = number_format($request->amount, 2, '.', '');
        $amount_letter = $request->amount_letter;
        $description = $request->description;

        $release_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->release_date)));

        $invoice->update([
            'amount' => $amount,
            'amount_letter' => $amount_letter,
            'description' => $description,
            'release_date' => $release_date
        ]);

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('invoice-updated', 'Fattura aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function create_pdf($invoice){

        define('EURO', chr(128));
        $pdf = app('Fpdf');
        $pdf->AddPage();

        // Set line width
        $pdf->SetLineWidth(0.2);
        $pdf->SetDrawColor(210, 210, 210);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Line(12, 40, 198, 40);

        // vertical line centered
        $pdf->Line(80, 12, 80, 40);

        $num_ricevuta = $invoice->customer_invoice_annual_number . '/' . date('Y');
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->SetTextColor(70, 104, 88);
        $pdf->Text(85, 22, 'RICEVUTA n. ');
        $pdf->Text(157, 22, $num_ricevuta);


        // line
        $pdf->SetLineWidth(0.1);
        $pdf->Line(145, 23, 195, 23);
        $pdf->Line(103, 36, 195, 36);


        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Text(85, 35, 'data');
        $pdf->Text(157, 34, date('d/m/Y', strtotime($invoice->release_date)));


        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Text(12, 50, 'Ricevuto da');
        $pdf->Line(38, 51, 198, 51);
        $pdf->Text(45, 50, strtoupper($invoice->customer->name . ' ' . $invoice->customer->surname));

        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Text(12, 62, EURO);
        $pdf->SetFont('Arial', 'B', 12);

        // set fill color to #496D70
        $pdf->SetFillColor(73, 109, 112);
        $pdf->Rect(20, 55, 175, 10, 'F');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Text(100, 68, '(IN LETTERE)');
        $pdf->ln(45);
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, '-- ' . strtolower($invoice->amount_letter) . ' --', 0, 1, 'C');
        $pdf->SetTextColor(0,0,0);

        // add Rect
        $pdf->SetLineWidth(0.1);
        $pdf->SetDrawColor(210, 210, 210);
        $pdf->Rect(10, 10, 190, 140, 'D');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(70, 104, 88);
        $pdf->Text(12, 74, 'Per');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Line(23, 76, 110, 76);
        $pdf->Line(23, 86, 110, 86);
        $pdf->Line(23, 96, 110, 96);
        $pdf->Line(23, 106, 110, 106);

        $pdf->ln(12);
        $pdf->Cell(20);
        $pdf->MultiCell(70, 10, utf8_decode($invoice->description), 0, 'C');

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Text(22, 122, 'TOTALE ' . EURO);

        $pdf->SetFillColor(73, 109, 112);
        $pdf->Rect(92, 115, 18, 10, 'F');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Text(93, 123, ',');
        $amount_parts = explode('.', $invoice->amount);
        $pdf->SetTextColor(70, 104, 88);
        $pdf->Text(80, 122, $amount_parts[0]);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Text(95, 122, $amount_parts[1]);

        $pdf->SetTextColor(70, 104, 88);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Text(87, 128, '(IN CIFRE)');


        $pdf->SetLineWidth(0.2);
        $pdf->Line(23, 142, 110, 142);
        $pdf->Text(52, 145, 'Firma del ricevente');

        // angolo in alto a sinistra
        $pdf->Line(120, 76, 125, 76);
        $pdf->Line(120, 76, 120, 81);

        // angolo in alto a destra
        $pdf->Line(185, 76, 180, 76);
        $pdf->Line(185, 76, 185, 81);

        // angolo in basso a sinistra
        $pdf->Line(120, 142, 125, 142);
        $pdf->Line(120, 142, 120, 137);

        // angolo in basso a destra
        $pdf->Line(185, 142, 180, 142);
        $pdf->Line(185, 142, 185, 137);

        $pdf->Text(146, 107, 'Soggetta');
        $pdf->Text(143, 112, 'a bollo vigente');

        return $pdf;

    }

    public function preview_pdf(Invoice $invoice)
    {

        $pdf = $this->create_pdf($invoice);
        $pdf->Output();
    }

    public function update_status(Request $request){

        $invoice = Invoice::find($request->invoice_id);
        $invoice->status = $request->status;
        $invoice->save();

        $newInvoiceHistory = new InvoiceHistory();
        $newInvoiceHistory->invoice_id = $invoice->id;
        $newInvoiceHistory->customer_id = $invoice->customer_id;
        $newInvoiceHistory->user_id = Auth::user()->id;
        $newInvoiceHistory->status = $request->status;
        $newInvoiceHistory->save();

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('invoice-updated', 'Fattura aggiornata con successo');
    }

    public function send_email(Request $request){
        $invoice = Invoice::find($request->invoiceId);

        // creo il pdf e lo salvo in una cartella temporanea
        $pdf = $this->create_pdf($invoice);
        $pdf->Output(public_path('pdf/invoice_' . $invoice->id . '.pdf'), 'F');

        // invio l'email
        $to_name = $invoice->customer->name;
        $to_email = $invoice->customer->email;
        $data = array('name'=> $to_name, 'body' => 'This is the body of the email');
        \Mail::send('emails.invoice', $data, function($message) use ($to_name, $to_email, $invoice) {
            $message->to($to_email, $to_name)
                    ->subject('Fattura n. ' . $invoice->customer_invoice_annual_number . '/' . date('Y'));
            $message->from('no-reply@gmail.com','Fatture');
            $message->attach(public_path('pdf/invoice_' . $invoice->id . '.pdf'));
        });

        // cancello il pdf
        unlink(public_path('pdf/invoice_' . $invoice->id . '.pdf'));

        // aggiorno lo stato della fattura
        $invoice->status = 'inviata';
        $invoice->save();

        return response()->json([
            'status' => 'success'
        ]);

    }

    public function invoice_destroy($invoice_id){
        $invoice = Invoice::find($invoice_id);
        $invoice->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function status_invoice_send()
    {
        return view('invoices.status_invoice_send');
    }

    public function search_by_status($status)
    {
        $invoices = Invoice::with(['customer'])->where('status', $status)->get();

        return response()->json([
            'invoices' => $invoices
        ]);
    }
}
