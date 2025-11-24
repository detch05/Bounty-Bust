<?php

namespace App\Http\Controllers;

use App\Models\Bounty;
use Illuminate\Http\Request;

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
}
