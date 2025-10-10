@extends('layouts.app')
@section('title', 'SJL')
@section('content')
<main class="blog-page">
    <section class="common-banner-section">
        <div class="common-banner-content">
            <h2>Blog</h2>
            <p>
                Discover our story and the passion behind our work. We are committed to providing excellence
                and creativity. Explore our mission and the values that guide everything we do.</p>
        </div>
    </section>


    <section class="blog-section common-section">
        <div class="container">
            <div class="row g-4">
                @forelse($blog_data as $post)
                <?php //print_r($post->id);die; ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="blog-detial-box">
                        <a href="{{ route('blog.detail', $post->slug) }}">
                            <div class="blog-img">
                                @if(!empty($post->cover_image))
                                <img src="{{env('ADMIN_BASE_URL') }}{{ $post->cover_image ?? asset('assets/image/logo-dark.svg') }}" alt="{{ $post->title }}">
                                @else
                                <img src="{{ asset('assets/image/logo-dark.svg') }}" alt="{{ $post->title }}">
                                @endif
                            </div>
                        </a>
                        <div class="blog-content">
                        <div class="blog-detail-box">
                            <h6>{{ $post->title }}</h6>
                            <?php 
                                echo \Illuminate\Support\Str::limit($post->content, 140) 
                            ?>
                        </div>
                            <div class="read-more-btn">
                                <a href="{{ route('blog.detail', $post->slug) }}">
                                    <button class="btn common-primary-btn">Read More</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-primary text-center">No blog posts yet.</div>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="row mt-4">
                <nav aria-label="Blog pages" class="product-pagination d-flex justify-content-center custom-pagination">
                    {{-- If your app uses Tailwind (default), use this: --}}
                    {{-- {{ $blog_data->onEachSide(1)->links() }} --}}

                    {{-- If your site uses Bootstrap, use the Bootstrap views: --}}
                    {{ $blog_data->onEachSide(1)->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
    </section>



</main>
@endsection