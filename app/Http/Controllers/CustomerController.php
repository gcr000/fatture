<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\InvoiceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        // salva il customer nel database senza il parametro new_customer
        $customer = Customer::create($request->except('new_customer'));

        if($request->group_id){
            $group = Group::find($request->group_id);
            $group->dimension += 1;
            $group->save();
        }

        if($request->new_customer)
            return redirect()
                ->back()
                ->with('new_customer', 'Cliente creato con successo');

        return redirect()
            ->route('customer.show', $customer)
            ->with('customer-created', 'Cliente creato con successo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.detail',[
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {

        if($request->group_id != 'null'){

            if($customer->group_id != $request->group_id){

                if($customer->group_id){
                    $old_group = Group::find($customer->group_id);
                    $old_group->dimension -= 1;
                    $old_group->save();
                }

                $new_group = Group::find($request->group_id);
                $new_group->dimension += 1;
                $new_group->save();

                $customer->group_id = $request->group_id;
                $customer->save();
            } else {
                $customer->update($request->except('group_id'));
            }

        } else {

                if($customer->group_id){
                    $old_group = Group::find($customer->group_id);
                    $old_group->dimension -= 1;
                    $old_group->save();
                }

                $customer->group_id = null;
                $customer->save();
        }

        $customer->update($request->except('group_id'));

        return redirect()
            ->route('customer.show', $customer)
            ->with('customer-updated', 'Cliente aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($customer_id)
    {
        $customer = Customer::find($customer_id);

        if(!$customer)
            return response()->json(['error' => 'Customer not found'], 404);

        // cancello tutti gli ordini associati al cliente
        $customer->invoices()->delete();

        $customer->delete();
        return redirect()
            ->back()
            ->with('customer-deleted', 'Cliente eliminato con successo');
    }


    public function search(Request $request)
    {
        $customers = Customer::where('surname', 'like', '%' . $request->term . '%')
            ->orWhere('email', 'like', '%' . $request->term . '%')
            ->orWhere('phone', 'like', '%' . $request->term . '%')
            ->orderBy('surname')
            ->get();

        $response = [];

        foreach ($customers as $customer) {
            $response[] = [
                'id' => $customer->id,
                'value' => $customer->surname . ' ' . $customer->name . ' (' . $customer->email . '  ' . $customer->phone . ')',
                'name' => $customer->name,
                'surname' => $customer->surname,
                'email' => $customer->email,
                'phone' => $customer->phone,
                //'last_orders' => $customer->last_invoices,
            ];
        }

        // return la risposta per autocomplete di jQuery
        return $response;
    }

    public function get_customer($customer_id)
    {
        $customer = Customer::find($customer_id);

        if(!$customer)
            return response()->json(['error' => 'Customer not found'], 404);

        return view('customers.detail',[
            'customer' => $customer
        ]);
    }

    public function send_invoice(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        if(!$customer)
            return response()->json(['error' => 'Customer not found'], 400);

        $amount = number_format($request->amount, 2, '.', '');
        $amount_letter = $request->amount_letter;
        $description = $request->description;

        $release_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->release_date)));
        $payment_deadline = date('Y-m-d', strtotime(str_replace('/', '-', $request->release_date) . ' + 30 days'));

        $customer_invoices_number = $customer->invoices()
                ->count() + 1;

        $customer_invoices_annual_number = Invoice::query()
                ->where('status', '!=', 'annullata')
                ->where('release_date', '>=', date('Y-01-01'))
                ->where('release_date', '<=', date('Y-12-31'))
                ->where('customer_id', $customer->id)
                ->count() + 1;

        $newInvoice = new Invoice();
        $newInvoice->user_id = Auth::user()->id;
        $newInvoice->customer_id = $customer->id;
        $newInvoice->amount = $amount;
        $newInvoice->amount_letter = $amount_letter;
        $newInvoice->description = $description;
        $newInvoice->release_date = $release_date;
        $newInvoice->payment_deadline = $payment_deadline;
        $newInvoice->status = 'in attesa';
        $newInvoice->customer_invoice_number = $customer_invoices_number;
        $newInvoice->customer_invoice_annual_number = $customer_invoices_annual_number;
        $newInvoice->save();

        $newInvoiceHistory = new InvoiceHistory();
        $newInvoiceHistory->invoice_id = $newInvoice->id;
        $newInvoiceHistory->customer_id = $customer->id;
        $newInvoiceHistory->user_id = Auth::user()->id;
        $newInvoiceHistory->status = 'in attesa';
        $newInvoiceHistory->save();

        return redirect(url('invoices/' . $newInvoice->id));
    }
}
