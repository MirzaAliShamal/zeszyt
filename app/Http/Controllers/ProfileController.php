<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
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
        // dd($my_profile->toArray());
        return view('profile.edit', compact('my_profile'));
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
}
