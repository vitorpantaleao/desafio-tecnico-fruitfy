<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\ContactsRequest;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index()
    {
        $contacts = Contact::paginate(10);
        
        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts
        ]);
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return Inertia::render('Contacts/Create');
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(ContactsRequest $request)
    {
        Contact::create($request->validated());
        
        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        return Inertia::render('Contacts/Show', [
            'contact' => $contact
        ]);
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit(Contact $contact)
    {
        return Inertia::render('Contacts/Edit', [
            'contact' => $contact
        ]);
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(ContactsRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        
        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
} 