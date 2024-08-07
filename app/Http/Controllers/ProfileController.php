<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ContactDetail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $my_profile = User::where('id', Auth::user()->id)->first();

        $contact = ContactDetail::latest()->first();
        $categories = [
            'działalność-nierejestrowa' => 'Działalność nierejestrowa',
            'jednoosobowa-działalność-gospodarcza' => 'Jednoosobowa działalność gospodarcza',
            'spółka-cywilna' => 'Spółka cywilna',
            'spółka-jawna' => 'Spółka jawna',
            'spółka-komandytowo-akcyjna' => 'Spółka komandytowo-akcyjna',
            'spółka-z-o.-o.' => 'Spółka z o. o.',
            'spółka-akycjna' => 'Spółka akycjna',
        ];

        return view('profile.edit', compact('my_profile', 'contact', 'categories'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        User::where('id', Auth::user()->id)->update([
            'company_name' => $request->company_name,
            'form_of_organization' => $request->form_of_organization,
            'form_of_income_taxes' => $request->form_of_income_taxes,
            'contact_with_us' => $request->contact_with_us
        ]);

        return redirect()->route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function profileUpdatePassword(Request $request)
    {
        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.edit');
    }

    public function profileUpdateContact(Request $request)
    {
        ContactDetail::create($request->all());
        return redirect()->route('profile.edit');
    }
}

// hours worked: 175.5+10.28+6.66+9.5 = 201.94
// overtiming: 1.5+1.28 = 2.78
// total hours: 192.4 + 2.78 = 204.72