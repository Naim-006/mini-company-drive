<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanySettingRequest;
use App\Models\CompanySetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanySettingController extends Controller
{
    /**
     * Show the company settings edit form.
     */
    public function edit(): View
    {
        $settings = CompanySetting::current();

        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update the company settings.
     */
    public function update(CompanySettingRequest $request): RedirectResponse
    {
        $settings = CompanySetting::current();
        $settings->update($request->validated());

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Company information and settings have been updated successfully.');
    }
}
