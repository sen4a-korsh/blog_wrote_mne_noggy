@extends('layouts.main')

@section('content')

    <main class="blog-post">
        <div class="container">
            <h1 class="edica-page-title aos-init aos-animate" data-aos="fade-up">{{ $post->title }}</h1>
            <p class="edica-blog-post-meta aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                • {{ $postDate->format('F'). ' '. $postDate->format('d') . ', ' . $postDate->format('Y'). ' • ' . $postDate->format('H:i') }} • {{ $post->comments->count() }}  Comments
            </p>
            <section class="blog-post-featured-img aos-init aos-animate text-center" data-aos="fade-up" data-aos-delay="300">
                <img src="{{ Storage::url($post->preview_image) }}" alt="featured image" style="max-height: 700px">
            </section>
            <section class="post-content">
                <div class="row">
                    <div class="col-lg-9 mx-auto">
                        {!! $post->content !!}
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-lg-9 mx-auto">
                    <section class="py-3 text-right">
                        @auth()
                            <form action="{{ route('post.like.store', $post->id) }}" method="post">
                                @csrf
                                <span style="color: black">{{ $post->liked_users_count }}</span>
                                <button type="submit" class="border-0 bg-transparent">
                                    <i class=" {{ auth()->user()->likedPosts->contains($post->id) ? 'fas' : 'far' }}  fa-heart"></i>
                                </button>
                            </form>
                        @endauth
                        @guest()
                            <div>
                                <span style="color: black">{{ $post->liked_users_count }}</span>
                                <i class="far fa-heart"></i>
                            </div>
                        @endguest
                    </section>
                    @if($relatedPosts->count() > 0)
                    <section class="related-posts">
                        <h2 class="section-title mb-4 aos-init" data-aos="fade-up">Related Posts</h2>
                        <div class="row">
                            @foreach($relatedPosts as $relatedPost)
                                <div class="col-md-4 aos-init" data-aos="fade-right" data-aos-delay="100">
                                    <a href="{{ route('post.show', $relatedPost->id) }}">
                                        <img src="{{ Storage::url($relatedPost->preview_image) }}" alt="related post" height="200px" width="200px" class="post-thumbnail">
                                        <p class="post-category">{{ $relatedPost->category->title }}</p>
                                        <h5 class="post-title">{{ $relatedPost->title }}</h5>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif
                    <section class="comment-section mb-5">
                        <h2 class="section-title mb-5 aos-init" data-aos="fade-up">Comments ({{ $post->comments->count() }})</h2>
                        @auth()
                        <form action="{{ route('post.comment.store', $post->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12 aos-init" data-aos="fade-up">
                                    <label for="comment" class="sr-only">Comment</label>
                                    <textarea name="message" id="comment" class="form-control" placeholder="Comment" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 aos-init" data-aos="fade-up">
                                    <input type="submit" value="Send Comment" class="btn btn-warning">
                                </div>
                            </div>
                        </form>
                        @endauth
                    </section>

                    <section class="comment-section">
                        @foreach($post->comments->sortByDesc('created_at') as $comment)
                            <div class="card-comment">
                                <div class="comment-text">
                                    <hr>
                                    <span class="username">
                                      <h5>{{ $comment->user->name }}</h5>
                                      <span class="text-muted float-right">{{ $comment->created_at->diffForHumans() }}</span>
                                    </span>
                                    <p>
                                       {{ $comment->message }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </section>
                </div>
            </div>
        </div>
    </main>

@endsection
