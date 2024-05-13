<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\fileExists;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated_data = $request->validated();

        $avatar = $validated_data['avatar'] ?? null;
        if (isset($avatar)) {
            $user = Auth::user();
            if (isset($user['avatar'])) {
                if (fileExists(public_path('storage/avatars/' . $user['avatar']))) {
                    File::delete(public_path('storage/avatars/' . $user['avatar']));
                }
            }
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars', $fileName, 'public');
        }
        $request->user()->fill($request->validated());
        if (isset($fileName)) {
            $request->user()->avatar = $fileName;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();
        // delete img
        if (fileExists(public_path('storage/avatars/' . $user->avatar))) {
            File::delete(public_path('storage/avatars/' . $user->avatar));
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
