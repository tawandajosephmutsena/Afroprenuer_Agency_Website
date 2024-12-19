<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with(['client', 'service'])
            ->where('status', true)
            ->latest('completion_date')
            ->get();

        return view('portfolio.index', compact('portfolios'));
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load(['client', 'service']);

        // Get related portfolios (same service or client)
        $relatedPortfolios = Portfolio::where('id', '!=', $portfolio->id)
            ->where(function($query) use ($portfolio) {
                $query->where('service_id', $portfolio->service_id)
                    ->orWhere('client_id', $portfolio->client_id);
            })
            ->where('status', true)
            ->limit(3)
            ->get();

        return view('portfolio.show', compact('portfolio', 'relatedPortfolios'));
    }


}