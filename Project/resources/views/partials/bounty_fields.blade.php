@php

    $title = $title ?? '';
    $description = $description ?? '';
    $reward = $reward ?? '';

@endphp

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
        rows="5" required>{{ old('description', $description) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="reward" class="form-label">Reward</label>
    <input type="number" class="form-control @error('reward') is-invalid @enderror" id="reward" name="reward"
        value="{{ old('reward', $reward) }}" required>
    @error('reward')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="tagSearch" class="form-label">Tags</label>
    @php $allTags = \App\Models\Tag::all(); @endphp
    @php
        $initialTags = old(
            'tags',
            isset($bounty) && method_exists($bounty, 'tags') ? $bounty->tags->pluck('id')->toArray() : [],
        );
    @endphp

    <style>
        /* Small local styles to make the tag picker match site style */
        .bounty-tags {
            background: transparent;
        }

        .bounty-tags .tag-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: .25rem .45rem;
            border-radius: 999px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            font-weight: 600;
            border: 1px solid rgba(0, 0, 0, 0.04);
            cursor: pointer;
        }

        .bounty-tags .tag-chip.light {
            color: #222;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .bounty-tags .list-group-item {
            cursor: pointer;
        }

        /* ensure suggestions dropdown has white background for better contrast */
        .bounty-tags #tagSuggestions {
            background: #fff;
            color: #212529;
        }

        .bounty-tags #tagSuggestions .list-group-item {
            background: #fff;
            color: #212529;
        }

        .bounty-tags .input-group .form-control {
            min-height: 42px;
            padding-left: 2.5rem;
        }

        .bounty-tags .input-group.position-relative .search-icon {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }
    </style>

    <div id="tag-input" class="border rounded p-2 bounty-tags">
        <div class="d-flex align-items-center mb-2">
            <div id="tag-chips" class="d-flex flex-wrap gap-1"></div>
        </div>

        <div class="input-group position-relative">
            <input id="tagSearch" type="text" class="form-control" placeholder="Search your tags" autocomplete="off">
            <i class="bi bi-search search-icon" aria-hidden="true"></i>
        </div>

        <div id="tagSuggestions" class="list-group mt-2 d-none rounded shadow-sm"
            style="max-height:200px; overflow:auto;"></div>
    </div>

    {{-- Hidden container for selected tag inputs (submitted as tags[]) --}}
    <div id="selectedTagsContainer">
        @foreach ($initialTags as $t)
            <input type="hidden" name="tags[]" value="{{ $t }}">
        @endforeach
    </div>


    <div class="form-group d-flex flex-column mb-3 mt-3">
        <label for="bountyImage"></label>
        <input type="file" id="imageSelection" name="bountyImage">
    </div>

    <div class="bountyImagePreview d-flex justify-content-center">
        <img id="preview" src="" alt="Image preview" width="320" height="240">
    </div>


    <script>
        (function() {
            const ALL_TAGS = @json(
                $allTags->map(function ($t) {
                    return ['id' => $t->id, 'name' => $t->name, 'color' => $t->color];
                }));
            const selected = new Map();
            const initial = @json($initialTags);
            const maxTags = 5;

            const chipsEl = document.getElementById('tag-chips');
            const searchEl = document.getElementById('tagSearch');
            const suggestionsEl = document.getElementById('tagSuggestions');
            const hiddenContainer = document.getElementById('selectedTagsContainer');

            function createChip(tag) {
                const span = document.createElement('span');
                // Use badge styling consistent with the site
                span.className = 'badge rounded-pill d-inline-flex align-items-center';
                span.style.backgroundColor = tag.color || '#0d6efd';
                span.style.color = '#fff';
                span.style.padding = '0.35rem 0.6rem';
                span.innerHTML = `<span class="me-2">${tag.name}</span>`;

                // pick style depending on background luminance
                try {
                    const col = tag.color || '#0d6efd';
                    const isLight = (c => {
                        if (!c || c[0] !== '#') return false;
                        const r = parseInt(c.substr(1, 2), 16);
                        const g = parseInt(c.substr(3, 2), 16);
                        const b = parseInt(c.substr(5, 2), 16);
                        const lum = 0.2126 * r + 0.7152 * g + 0.0722 * b;
                        return lum > 200;
                    })(col);
                    if (isLight) {
                        span.classList.add('light');
                    }
                } catch (e) {}

                // make whole chip clickable to remove
                span.addEventListener('click', function() {
                    removeTag(tag.id);
                });

                // improve accessible keyboard interaction
                span.setAttribute('role', 'button');
                span.setAttribute('tabindex', '0');
                span.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        removeTag(tag.id);
                    }
                });
                return span;
            }

            function renderChips() {
                chipsEl.innerHTML = '';
                for (const tag of selected.values()) {
                    chipsEl.appendChild(createChip(tag));
                }
            }

            function updateHiddenInputs() {
                hiddenContainer.innerHTML = '';
                for (const tag of selected.values()) {
                    const inp = document.createElement('input');
                    inp.type = 'hidden';
                    inp.name = 'tags[]';
                    inp.value = tag.id;
                    hiddenContainer.appendChild(inp);
                }
                // hidden inputs updated; no visual counter needed
            }

            function addTag(id) {
                if (selected.size >= maxTags) return;
                if (selected.has(String(id))) return;
                const tag = ALL_TAGS.find(t => t.id == id);
                if (!tag) return;
                selected.set(String(tag.id), tag);
                renderChips();
                updateHiddenInputs();
            }

            function removeTag(id) {
                selected.delete(String(id));
                renderChips();
                updateHiddenInputs();
            }

            function showSuggestions(query) {
                const q = String(query).trim().toLowerCase();
                const results = ALL_TAGS.filter(t => t.name.toLowerCase().includes(q) && !selected.has(String(t.id)))
                    .slice(0, 10);
                suggestionsEl.innerHTML = '';
                if (results.length === 0) {
                    suggestionsEl.classList.add('d-none');
                    return;
                }
                for (const r of results) {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className =
                        'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
                    item.innerHTML =
                        `<span>${r.name}</span> <span class="badge" style="background:${r.color||'#6c757d'}">&nbsp;</span>`;
                    item.addEventListener('click', function() {
                        addTag(r.id);
                        searchEl.value = '';
                        suggestionsEl.classList.add('d-none');
                    });
                    suggestionsEl.appendChild(item);
                }
                suggestionsEl.classList.remove('d-none');
            }

            // Initialize from initial array
            (function init() {
                if (Array.isArray(initial)) {
                    initial.slice(0, maxTags).forEach(id => {
                        const tag = ALL_TAGS.find(t => t.id == id);
                        if (tag) selected.set(String(tag.id), tag);
                    });
                }
                renderChips();
                updateHiddenInputs();
            })();

            searchEl.addEventListener('input', function(e) {
                const v = e.target.value;
                if (v.length === 0) {
                    suggestionsEl.classList.add('d-none');
                    return;
                }
                showSuggestions(v);
            });

            searchEl.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const q = this.value.trim();
                    if (!q) return;
                    // If exact match exists, add that tag; otherwise ignore
                    const match = ALL_TAGS.find(t => t.name.toLowerCase() === q.toLowerCase());
                    if (match) addTag(match.id);
                    this.value = '';
                    suggestionsEl.classList.add('d-none');
                } else if (e.key === 'Backspace' && this.value.length === 0) {
                    // remove last
                    const keys = Array.from(selected.keys());
                    if (keys.length) removeTag(keys[keys.length - 1]);
                }
            });

            document.addEventListener('click', function(e) {
                if (!document.getElementById('tag-input').contains(e.target)) {
                    suggestionsEl.classList.add('d-none');
                }
            });

        })();
    </script>
</div>

<button type="submit" class="btn btn-primary">Submit</button>
