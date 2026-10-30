<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings'         => 'required|array',
            'logo'             => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'favicon'          => 'nullable|image|mimes:png,ico,jpg|max:1024',
            'footer_logo'      => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);

        foreach ($request->input('settings', []) as $key => $value) {
            WebsiteSetting::set($key, $value);
        }

        if ($request->hasFile('logo')) {
            $oldLogo = WebsiteSetting::get('logo');
            if ($oldLogo) Storage::disk('public')->delete($oldLogo);
            $path = $request->file('logo')->store('settings', 'public');
            WebsiteSetting::set('logo', $path);
        }

        if ($request->hasFile('favicon')) {
            $oldFav = WebsiteSetting::get('favicon');
            if ($oldFav) Storage::disk('public')->delete($oldFav);
            $path = $request->file('favicon')->store('settings', 'public');
            WebsiteSetting::set('favicon', $path);
        }

        if ($request->hasFile('footer_logo')) {
            $old = WebsiteSetting::get('footer_logo');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('footer_logo')->store('settings', 'public');
            WebsiteSetting::set('footer_logo', $path);
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}
