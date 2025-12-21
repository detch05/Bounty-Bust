<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        // 1. Captura o termo de pesquisa 'q' da URL
        $query = $request->input('q');

        // 2. Inicia o Query Builder no Model Tag
        // **RECOMENDADO:** Ordenar as tags por nome para uma melhor UX
        $tagsQuery = Tag::query()->orderBy('name', 'asc');

        // 3. Aplica a lógica de pesquisa SE existir um termo 'q'
        if ($query) {
            // Pesquisa pelo nome da tag (usando ILIKE para PostgreSQL)
            $tagsQuery->where('name', 'ILIKE', "%{$query}%");
        }

        // 4. APLICA A PAGINAÇÃO (10 tags por página)
        $tags = $tagsQuery->paginate(10);

        // 5. Retorna a View
        return view('pages.content.tag.tags', [
            'tags' => $tags
        ]);
    }

    public function createForm()
    {
        return view('pages.content.tag.create_tag');
    }

    public function editForm($id)
    {
        $tag = Tag::findOrFail($id);
        return view('pages.content.tag.edit_tag', ['tag' => $tag]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45|unique:tag',
            'description' => 'required|string|max:150',
            'color' => 'required|size:7|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        Tag::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:45|unique:tag,name,' . $tag->id,
            'description' => 'required|string|max:150',
            'color' => 'required|size:7|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        $tag->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Tag updated successfully.');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }



    public function followTag($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        $tag->followers()->attach(auth()->id());
        return response()->json(['success' => true]);
    }

    public function unfollowTag($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        $tag->followers()->detach(auth()->id());
        return response()->json(['success' => true]);
    }
}
