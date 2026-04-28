<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about(GeneralSettings $settings)
    {
        $this->configureSeo('Tentang Kami', 'Pelajari lebih lanjut tentang visi, misi, dan tim di balik karya editorial kami.', null, 'AboutPage');

        return view('pages.about', [
            'settings' => $settings,
        ]);
    }

    public function contact(GeneralSettings $settings)
    {
        $this->configureSeo('Kontak', 'Hubungi tim redaksi kami untuk pertanyaan, kerja sama, dan informasi lebih lanjut.', null, 'ContactPage');

        return view('pages.contact', [
            'settings' => $settings,
        ]);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim. Kami akan membalasnya sesegera mungkin.');
    }

    public function privacy(GeneralSettings $settings)
    {
        $this->configureSeo('Kebijakan Privasi', 'Kebijakan mengenai cara kami mengatur dan memproses data Anda untuk keamanan privasi penuh.', null, 'WebPage');

        return view('pages.privacy', [
            'settings' => $settings,
        ]);
    }

    public function disclaimer(GeneralSettings $settings)
    {
        $this->configureSeo('Penafian (Disclaimer)', 'Pernyataan pelepasan tanggung jawab atas batasan informasi dalam platform editorial kami.', null, 'WebPage');

        return view('pages.disclaimer', [
            'settings' => $settings,
        ]);
    }

    public function tos(GeneralSettings $settings)
    {
        $this->configureSeo('Syarat & Ketentuan', 'Syarat dan ketentuan layanan (TOS) penggunaan website kami.', null, 'WebPage');

        return view('pages.tos', [
            'settings' => $settings,
        ]);
    }
}
