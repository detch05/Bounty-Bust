<?php

namespace App\Http\Controllers;

use App\Models\Bounty;
use App\Models\Content;
use Illuminate\Http\Request;



class StaticController extends Controller
{
    public function index()
    {
        $featured_bounties = Bounty::orderByDesc('reward')
            ->orderBy(Content::select('updated_at')->whereColumn('content.id', 'bounty.id_content'))
            ->take(3)
            ->get();

        $featuredIds = $featured_bounties->pluck('id_content');
        $bounties = Bounty::with(['user', 'tags'])
            ->withCount('answers')
            ->whereNotIn('id_content', $featuredIds)
            ->orderByDesc('reward')
            ->orderByDesc('answers_count')
            ->orderByDesc(
                Content::select('updated_at')
                    ->whereColumn('content.id', 'bounty.id_content')
            )
            ->get();

        return view('pages.home', compact('bounties', 'featured_bounties'));
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

}
