<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
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
    public function store(Request $request)
    {
        $group = new Group();
        $group->name = strtoupper($request->name);
        if(Group::query()->where('name', strtoupper($group->name))->exists()) {
            return redirect()->route('groups.index')->with('error', 'Gruppo già esistente');
        }
        $group->save();

        return redirect()->route('groups.index')->with('success', 'Gruppo creato con successo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $group->name = strtoupper($request->name);
        if(Group::query()->where('name', strtoupper($group->name))->exists()) {
            return redirect()->route('groups.index')->with('error', 'Gruppo già esistente');
        }
        $group->save();
        return redirect()->route('groups.index')->with('success', 'Gruppo modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($group_id)
    {
        $customers = Customer::query()
            ->where('group_id', $group_id)
            ->get();

        foreach ($customers as $customer) {
            $customer->group_id = null;
            $customer->save();
        }

        $group = Group::find($group_id);
        $group->delete();

        return redirect()->route('groups.index');
    }

    public function manage_customer(Request $request){

        $customer_id = $request->customer_id;
        $group_id = $request->group_id;
        $action = $request->action;

        $customer = Customer::find($customer_id);
        $group = Group::find($group_id);

        if(!$group)
            return redirect()->route('customers.index')->with('error', 'Seleziona un gruppo');

        if(!$customer)
            return redirect()->route('customers.index')->with('error', 'Seleziona un cliente');

        // se action è add,
        // se il cliente ha già un gruppo, decremento la dimensione del vecchio gruppo
        // incremento la dimensione del nuovo gruppo
        // assegno il nuovo gruppo al cliente

        if($action == 'add'){
            if($customer->group_id){
                $old_group = Group::find($customer->group_id);
                $old_group->dimension -= 1;
                $old_group->save();
            }

            $group->dimension += 1;
            $group->save();

            $customer->group_id = $group_id;
            $customer->save();
        } else {
            // se action è remove
            // se il cliente ha un gruppo, decremento la dimensione del vecchio gruppo
            // assegno null al gruppo del cliente
            if($customer->group_id){
                $old_group = Group::find($customer->group_id);
                $old_group->dimension -= 1;
                $old_group->save();
            }

            $customer->group_id = null;
            $customer->save();
        }


    }
}
