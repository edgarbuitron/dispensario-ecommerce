@extends("layouts.client")

@section("title", "Preguntas Frecuentes")

@section("content")
<div class="container py-5">
    <h1 class="mb-5">Preguntas Frecuentes</h1>

    <div class="accordion" id="faqAccordion">
        @foreach($faqs as $index => $faq)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button @if($index != 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                        {{ $faq["question"] }}
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse @if($index == 0) show @endif" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ $faq["answer"] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
