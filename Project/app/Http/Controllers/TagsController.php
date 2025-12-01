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
}
