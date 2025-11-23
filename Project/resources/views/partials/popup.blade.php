<section id="message">
    @if(session()->has('success'))
        <article class="success">{{ session('success') }}</article>
    @endif

    @if(session()->has('error'))
        <article class="error">{{ session('error') }}</article>
    @endif
</section>