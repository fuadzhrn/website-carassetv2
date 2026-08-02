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

    private function module(string $title, string $description, string $status): View
    {
        return view('admin.placeholders.module', compact('title', 'description', 'status'));
    }
}
