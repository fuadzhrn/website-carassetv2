<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ModulePlaceholderController extends Controller
{
    public function seo(): View
    {
        return $this->module(
            title: 'SEO',
            description: 'Kelola meta title dan meta description setiap halaman.',
            status: 'Belum tersedia — akan dibangun pada tahap SEO.',
        );
    }

    public function messages(): View
    {
        return $this->module(
            title: 'Pesan Masuk',
            description: 'Kelola pesan konsultasi yang dikirim dari website.',
            status: 'Belum tersedia — form konsultasi belum diaktifkan.',
        );
    }

    private function module(string $title, string $description, string $status): View
    {
        return view('admin.placeholders.module', compact('title', 'description', 'status'));
    }
}
