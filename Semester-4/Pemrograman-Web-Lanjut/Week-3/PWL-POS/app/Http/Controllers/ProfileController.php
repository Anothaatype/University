<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilePictureRequest;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('level')->find(auth()->id());
        $levels = Level::all();
        $metadata = [
            'pageTitle' => 'Profile',
            'breadcrumbs' => [
                [
                    'name' => 'Settings',
                    'route' => 'settings.profile'
                ],
                [
                    'name' => 'Profile',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.settings.profile', compact('metadata', 'user', 'levels'));
    }

    public function updateProfilePicture(ProfilePictureRequest $request)
    {
        $user = User::find(auth()->id());

        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $filePath = $request->file('profile_picture')->store('user-profile', 'public');
        $user->update([
            'profile_picture' => $filePath
        ]);

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }
}
