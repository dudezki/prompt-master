<div class="row">
    <div class="col-md-8" >
        <h4>Sample Generation</h4>
        <div class="row" style="overflow-y: auto; max-height: 85vh;">
            @for ($i = 0; $i < $columns; $i++)
                <div class="col-md-{{ 12 / $columns }}">
                    @for ($j = 0; $j < $cardsPerColumn; $j++)
                        @php
                            $index = $i * $cardsPerColumn + $j;
                        @endphp
                        @if (isset($cards[$index]))
                            <div class="card mb-3">
                                <img src="{{url('/card/'.$cards[$index]->id)}}" class="card-img-top" alt="Card image">
                            </div>
                        @endif
                    @endfor
                </div>
            @endfor
        </div>
    </div>

    <div class="col-md-4">
        <div class="d-flex flex-column">
            <span class="text-muted">Positive Prompt</span>
            <div class="form-control border bg-black position-relative" style="min-height: 150px;">
                <a href="javascript:void(0);" class="btn btn-secondary btn-sm prompt-copy position-absolute top-0 end-0 m-1 d-none">
                    <i class="bi bi-copy"></i>
                </a>
                <span class="prompt-content">
                    {{ $prompt->positive_prompt ?? '' }}
                </span>
            </div>
        </div>

        <div class="d-flex flex-column">
            <span class="text-muted">Negative Prompt</span>
            <div class="form-control border bg-black position-relative" style="min-height: 100px;">
                <a href="javascript:void(0);" class="btn btn-secondary btn-sm prompt-copy position-absolute top-0 end-0 m-1 d-none">
                    <i class="bi bi-copy"></i>
                </a>
                <span class="prompt-content">
                    {{ $prompt->negative_prompt ?? '' }}
                </span>
            </div>
        </div>
    </div>
</div>
