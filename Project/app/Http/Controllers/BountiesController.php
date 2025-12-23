<?php

namespace App\Http\Controllers;

use App\Models\Bounty;
use App\Models\Comment;
use App\Models\Content;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BountiesController extends Controller
{
    public function index(Request $request)
    {
        // Filters: search, tag, status, sort
        $search = $request->input('q');
        $tag = $request->input('tag');

        // Base query joining content for ordering and description search
        $bountiesQuery = Bounty::query()
            ->with(['content.user', 'tags'])
            ->join('content', 'bounty.id_content', '=', 'content.id');

        // Search by title or description
        if ($search) {
            $bountiesQuery->where(function($q) use ($search) {
                $q->where('bounty.title', 'ILIKE', "%{$search}%")
                  ->orWhere('content.description', 'ILIKE', "%{$search}%");
            });
        }

        // Tag filter by tag name using EXISTS subquery to avoid duplicate rows
        if (!empty($tag)) {
            $bountiesQuery->whereExists(function($q) use ($tag) {
                $q->select(DB::raw(1))
                  ->from('bounty_tag')
                  ->join('tag', 'tag.id', '=', 'bounty_tag.tag_id')
                  ->whereColumn('bounty_tag.bounty_id', 'bounty.id_content')
                  ->where('tag.name', 'ILIKE', '%' . $tag . '%');
            });
        }

        $bountiesQuery->orderBy('content.created_at', 'desc');


        // Paginate and preserve filters in links
        $bounties = $bountiesQuery->paginate(15)->appends($request->query());

        // 7. Retorna a View
        return view('pages.content.bounty.bounties', [
            'bounties' => $bounties
        ]);
    }


    public function create()
    {
        return view('pages.content.bounty.create_bounty');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:60'],
            'description' => ['required', 'string', 'max:10000'], // Campo Content
            'reward' => ['required', 'numeric', 'min:1', 'max:200'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer','exists:tag,id'],
            'bountyImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
        // Array de mensagens personalizadas
        'reward.max' => 'A recompensa máxima permitida é de 200 pontos. Por favor, ajuste o valor.',
        'reward.min' => 'A recompensa mínima deve ser 1.',
        ]);

        $content = Content::create([
            'description' => $request->description,
            'user_id' => Auth::id(), // ID do utilizador logado
            'version' => 1,          // Primeira versão
            'rating' => 0,           // Rating inicial
        ]);

        $bounty = new Bounty();

        // CAMPOS DA TABELA BOUNTY:
        $bounty->id_content = $content->id; // CHAVE CRÍTICA: ID do Content recém-criado
        $bounty->title = $request->title;
        $bounty->reward = $request->reward;

        $bounty->save();

        if($request->hasFile('bountyImage')){
            $bounty->handleBountyIMG($request->file('bountyImage'));
        }

        // Sync tags if provided (keeps many-to-many relationship in bounty_tag)
        if ($request->has('tags')) {
            $bounty->tags()->sync($request->input('tags', []));
        }

        return redirect()->route('bounties.index')->with('success', 'Bounty criado com sucesso!');
    }

    public function getBounty($id)
    {
        $bounty = Bounty::with('content')->findOrFail($id);
        return $bounty;
    }

    public function editBounty($id){
        $bounty= $this->getBounty($id);
        return view('pages.content.bounty.edit_bounty', compact('bounty'));
    }

    public function update($id,Request $request){
        $this->validate($request,[
            'title' => ['required', 'string', 'max:60'],
            'description' => ['required', 'string', 'max:10000'],
            'reward' => ['required', 'numeric', 'min:1', 'max:200'],
            'tags' => ['nullable','array'],
            'tags.*' => ['integer','exists:tag,id'],
            'bountyImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $bounty = Bounty::with('content')->findOrFail($id);

        $bounty->title = $request->title;
        $bounty->reward = $request->reward;
        $bounty->save();

        $bounty->content->description = $request->description;
        $bounty->content->version += 1;
        $bounty->content->updated_at = now();
        $bounty->content->save();

        if($request->hasFile('bountyImage')){
            $bounty->handleBountyIMG($request->file('bountyImage'));
        }

        if ($request->has('tags')) {
            $bounty->tags()->sync($request->input('tags', []));
        }

        return redirect()->route('bounties.index', $bounty->id_content)->with('success', 'Bounty updated successfully!');
    }


    public function show(Bounty $bounty)
    {
        // Eager load answers with their content and the content's user
        $bounty->load(['content', 'answers.content.user']);
        $bounty->content->increment('views', 1, []);

        $comments = Comment::with(['user','content'])
        ->where('bounty_id', $bounty->id_content)
        ->get();

        return view('pages.content.bounty.show1_bounty', [
            'bounty' => $bounty,
            'comments' => $comments
        ]);
    }


    public function destroy($id){
        $bounty = Bounty::with('content')->findOrFail($id);
        $bounty->delete();

        return redirect()->route('bounties.index')->with('success', 'Bounty deleted successfully.');
    }
}
