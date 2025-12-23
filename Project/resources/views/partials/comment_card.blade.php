@foreach ($comments->whereNull('parent_id') as $comment)
    @include('partials.comment_item', ['comment' => $comment])
@endforeach
