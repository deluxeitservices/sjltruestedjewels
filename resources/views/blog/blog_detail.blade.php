@extends('layouts.app')
@section('title', $post->title ?? 'Blog')
@section('content')
<main class="blog-detail-page">
  <section class="common-banner-section blog-detail-banner">
    <div class="common-banner-content">
      <h2>Blog Detail</h2>
      <p>Discover our story and the passion behind our work.</p>
    </div>
  </section>

  <section class="blog-detail-page common-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <h2 class="common-title main-title-blog-detail">{{ $post->title }}</h2>

          <span class="date">
            {{ \Carbon\Carbon::parse($post->added_date)->format('F d, Y') }}
          </span>

          <div class="blog-detail-img">
            @php
              $img = env('ADMIN_BASE_URL').$post->cover_image ?: asset('assets/image/logo-dark.svg');
            @endphp
            @if(!empty($post->cover_image))
            <img src="{{ $img }}" class="img-fluid">
            @else
            <img src="{{ asset('assets/image/logo-dark.svg') }}" alt="No image" class="img-fluid">
            @endif
          </div>

          <div class="common-blog-detail">
            {{-- Render HTML content from DB --}}
            {!! $post->content ?? $post->body ?? '' !!}
          </div>

        </div>
      </div>
    </div>
  </section>

  {{-- Recent posts --}}
  <section class="blog-section common-section">
    <div class="container">
      <div class="row"><div class="col-md-12"><h4 class="common-title">Recent Blogs</h4></div></div>
      <div class="row">
        @forelse($recent as $r)
          <div class="col-lg-4 col-md-6 col-12">
            <div class="blog-detial-box">
              <a href="{{ route('blog.detail', $r->slug) }}">
                <div class="blog-img">
                  @php
                    $thumb = env('ADMIN_BASE_URL').$r->cover_image ?: asset('assets/image/placeholder-thumb.jpg');
                  @endphp

                  @if(!empty($r->cover_image))
                  <img src="{{ $thumb }}" alt="{{ $r->title }}">
                  @else
                  <img src="{{ asset('assets/image/logo-dark.svg') }}" alt="No image" class="img-fluid">
                  @endif
                </div>
              </a>
              <div class="blog-content">
                <h6>{{ $r->title }}</h6>
                <div class="read-more-btn">
                  <a href="{{ route('blog.detail', $r->slug) }}">
                    <button class="btn common-primary-btn">Read More</button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12"><p class="text-muted">No recent posts.</p></div>
        @endforelse
      </div>
    </div>
  </section>

  {{-- Contact / CTA section (unchanged) --}}
  
</main>
@endsection
