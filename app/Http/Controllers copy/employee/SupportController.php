<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Employee;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tickets = SupportTicket::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.dashboard.support',compact('tickets'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->status = 'deny';
        $ticket->save();
        return redirect()->route('employee.support.index')->with('success', 'Ticket has been denied successfully.');
    }
}
