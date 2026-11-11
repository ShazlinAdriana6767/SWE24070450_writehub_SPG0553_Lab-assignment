<?php
/**
 * Student Name : Noor Shazlin Adriana Binti Ahmad Kamal
 * Student ID   : SWE24070450
 */

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::livewire('articles', 'pages::articles.index')->name('articles.index');
    Route::livewire('articles/create', 'pages::articles.create')->name('articles.create');
    Route::livewire('articles/{article}/edit', 'pages::articles.edit')->name('articles.edit');
});

require __DIR__.'/settings.php';