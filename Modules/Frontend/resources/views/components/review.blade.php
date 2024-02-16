<div class="col-lg-5">
    <div class="review_content">
        <div class="clearfix add_bottom_10">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex">
                    @for ($i = 0; $i < $rating; $i++)
                        <span class="rating"><i class="icon-star voted"></i></span>
                    @endfor
                    <em>{{ $rating }}/5</em></span>
                </div>
                <div class="d-flex flex-column">
                    <em>
                        {{ $user['name'] }}
                    </em>
                    <em class="">Published {{ $created_at }}</em>
                </div>

            </div>

        </div>
        <h4>"{{ $title }}"</h4>
        <div class="d-flex" style="gap:0.8rem">
            @foreach ($reviewImages as $reviewImage)
                <img class="rounded" width="100" height="100"
                    src="{{ asset('storage/' . $reviewImage['image_path']) }}" alt="">
            @endforeach
        </div>
        <p class="mt-2">{{ $comment }}</p>
    </div>
</div>
