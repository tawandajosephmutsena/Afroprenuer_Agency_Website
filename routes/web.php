<?php

use App\Models\Article;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\LeadController;

// Home routes
 Route::get('/', function () {
    $articles = Article::latest()->take(3)->get();
   return view('home', compact('articles'));
 });

 //Route::view('/', 'home')->name('home');



// Static pages
Route::view('/about', 'about')->name('about');
Route::view('/casestudy', 'casestudy')->name('casestudy');
Route::view('/contact', 'contact')->name('contact');

Route::view('/flow', 'flow')->name('flow');


// Service routes
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

// Portfolio routes
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolio}', [PortfolioController::class, 'show'])->name('portfolio.show');

// Article routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');






Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');