<?php

namespace App\Http\Controllers;

use App\Models\Bounty;
use App\Models\Content;
use Illuminate\Http\Request;



class StaticController extends Controller
{
        public function index(){
            $query = Bounty::with(['user','tags'])
            ->withCount('answers')
            ->orderByDesc('reward')
            ->orderByDesc('answers_count')
            ->orderByDesc(
                 Content::select('date')
                ->whereColumn('content.id', 'bounty.id_content')
            );

            $bounties = $query->paginate(20);
            return view('pages.home',compact('bounties'));
        }

    public function login(){
        return view('pages.auth.login');
    }

    public function register(){
        return view('pages.auth.register');
    }

}
