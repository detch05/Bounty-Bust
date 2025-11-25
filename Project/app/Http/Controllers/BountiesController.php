<?php

namespace App\Http\Controllers;

use App\Models\Bounty;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BountiesController extends Controller
{
    public function index(Request $request)
    {
        // 1. Captura o termo de pesquisa 'q' da URL
        $query = $request->input('q');

        // 2. Inicia o Query Builder no Model Bounty
        $bountiesQuery = Bounty::query();

        // 3. LIGA a tabela 'content' (essencial para ordenar e pesquisar na descrição)
        // Usamos o JOIN para eficiência, pois estamos a ordenar por uma coluna ligada.
        $bountiesQuery->join('content', 'bounty.id_content', '=', 'content.id');

        // 4. Ordena os resultados (ex: pela data mais recente)
        // Nota: Assumimos que a data é a coluna 'date' da tabela 'content'.
        $bountiesQuery->orderBy('content.date', 'desc');

        // 5. Aplica a lógica de pesquisa SE existir um termo 'q'
        if ($query) {
            // Pesquisa nos títulos e na descrição do conteúdo (usando ILIKE para PostgreSQL insensível)
            $bountiesQuery->where('title', 'ILIKE', "%{$query}%")
                          ->orWhere('content.description', 'ILIKE', "%{$query}%");
        }

        // 6. Paginação (usa paginate() no Query Builder)
        $bounties = $bountiesQuery->paginate(15); 
        
        // 7. Retorna a View
        return view('pages.bounties', [
            'bounties' => $bounties
        ]);
    }


    public function create()
    {
        return view('pages.create_bounty');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:60'],
            'description' => ['required', 'string', 'max:10000'], // Campo Content
            'reward' => ['required', 'numeric', 'min:1', 'max:200'],
            //'media' => ['nullable', 'string'],
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
        $bounty->media = /*$request->media ??*/ null; 
        $bounty->reward = $request->reward;
        
        $bounty->save();
        
        return redirect()->route('bounties.index')->with('success', 'Bounty criado com sucesso!');
    }
}
