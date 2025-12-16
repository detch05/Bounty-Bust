@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Inclui a barra lateral no layout da coluna --}}
            @include('partials.aside')

            {{-- Coluna Principal de Conteúdo --}}
            <div class="col-12 col-md-9">
                <div class="p-4">

                    {{-- ====================================== --}}
                    {{-- 1. DETALHES DA PERGUNTA (A BOUNTY) --}}
                    {{-- ====================================== --}}

                    <div class="card shadow-lg border-0 mb-5">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            {{-- TÍTULO DA BOUNTY --}}
                            <h1 class="h3 mb-0">{{ $bounty->title }}</h1>

                            {{-- RECOMPENSA --}}
                            <span class="badge bg-warning fs-5 p-2">{{ $bounty->reward }} pts</span>
                        </div>

                        <div class="card-body">
                            {{-- DESCRIÇÃO COMPLETA (content.description) --}}
                            <p class="card-text lead">{{ $bounty->content->description }}</p>

                            {{-- Tags (Se existirem) --}}
                            <div class="mt-4 border-top pt-3">
                                <strong class="me-2">Tags:</strong>
                                @if($bounty->tags && count($bounty->tags) > 0)
                                    @foreach($bounty->tags as $tag)
                                        <span class="badge" style="background-color: {{ $tag->color ?? '#007bff' }}; color: white;">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">Nenhuma tag atribuída.</span>
                                @endif
                            </div>
                        </div>

                        {{-- Footer com Metadados --}}
                        <div
                            class="card-footer bg-light d-flex justify-content-between align-items-center small text-muted">
                            <div>
                                <i class="bi bi-person-circle"></i>
                                Postado por: {{ $bounty->content->user->name ?? 'Anónimo' }}
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                @auth
                                    @if(Auth::id() === $bounty->content->user_id)
                                        <form action="{{ route('bounties.destroy', $bounty->id_content) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                        <a class="navlink text-dark fs-6"
                                            href="{{  route('bounties.edit', $bounty->id_content)  }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endif
                                @endauth
                                <i class="bi bi-calendar"></i>
                                Criado em: {{ $bounty->content->date }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ====================================== --}}
                {{-- 2. SECÇÃO DE RESPOSTAS --}}
                {{-- ====================================== --}}
                <h2 class="mb-4">{{ $bounty->answers->count() }} Respostas</h2>

                @forelse ($bounty->answers as $answer)
                    <div class="card mb-3 shadow-sm @if($answer->is_correct) border-success border-3 @else border-light @endif">
                        <div class="card-body">

                            {{-- Conteúdo da Resposta (usamos content.description da Answer) --}}
                            <p class="card-text">{{ $answer->content->description }}</p>

                            <div
                                class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center small text-muted">
                                <div>
                                    <i class="bi bi-person-fill"></i>
                                    Respondido por: {{ $answer->content->user->name ?? 'Anónimo' }}
                                </div>
                                <div>
                                    @if ($answer->is_correct)
                                        <span class="badge bg-success ms-3"><i class="bi bi-check-circle-fill"></i> Resposta
                                            Aceite</span>
                                    @endif
                                    <i class="bi bi-calendar"></i>
                                    {{ $answer->content->date }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle"></i> Sê o primeiro a responder a esta questão!
                    </div>
                @endforelse

                {{-- ====================================== --}}
                {{-- 3. FORMULÁRIO PARA SUBMETER NOVA RESPOSTA --}}
                {{-- ====================================== --}}
                @auth
                <h2 class="mt-5 mb-3">Submeter a Tua Resposta</h2>

                {{-- Assumimos que a rota para submeter a resposta é 'answers.store' --}}
                <form action="{{ route('answers.store') }}" method="POST">
                    @csrf

                    {{-- Campo escondido para ligar a resposta à Bounty --}}
                    <input type="hidden" name="bounty_id" value="{{ $bounty->id_content }}">

                    <div class="mb-3">
                        <label for="answerContent" class="form-label">A tua Solução Detalhada</label>
                        {{-- O campo 'description' aqui corresponde ao campo de conteúdo (media/description) que
                        definiste --}}
                        <textarea class="form-control" id="answerContent" name="description" rows="6" required></textarea>
                        @error('description')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Por favor, <a href="/login">inicia sessão</a> para submeter uma resposta.
                @endauth
            </div>
        </div>
    </div>
    </div>
@endsection