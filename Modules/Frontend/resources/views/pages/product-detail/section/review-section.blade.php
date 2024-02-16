   <section id="review-section" class="row justify-content-between">

       @if (count($reviews) == 0)
           <h5 class="text-center  mb-5 fst-italic">No reviews</h5>
       @endif
       @foreach ($reviews as $review)
           @component('frontend::components.review', [
               'title' => $review['title'],
               'comment' => $review['comment'],
               'rating' => $review['rating'],
               'reviewImages' => $review['reviewImages'],
               'created_at' => date('d-m-Y', strtotime($review['created_at'])),
               'user' => $review['user'],
           ])
           @endcomponent
       @endforeach


   </section>
