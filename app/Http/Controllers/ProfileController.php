<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileRequest;

class ProfileController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    public function update(ProfileRequest $request): \Illuminate\Http\RedirectResponse
    {
        $payload = $request->validated();

        if ($request->has('password') && $request->password != null) {
            $request->merge(['password' => bcrypt($request->password)]);
        } else {
            unset($payload['password']);
        }

        $user = auth()->user();
        $user->update($payload);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
