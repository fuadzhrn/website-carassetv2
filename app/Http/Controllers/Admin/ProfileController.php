<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the admin profile edit form.
     */
    public function edit(): View
    {
        return view('admin.profile.edit');
    }

    /**
     * Update the authenticated admin's own profile.
     */
    public function update(UpdateAdminProfileRequest $request): RedirectResponse
    {
        $request->user()->forceFill($request->validated())->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
