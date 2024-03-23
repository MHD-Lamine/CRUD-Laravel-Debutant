@extends('base')

@section('content')
    <h1>Mon blog</h1>
    @foreach ($posts as $post )
        <article>
            <h2>
                {{ $post->title }}
            </h2>
            <p class="small">
                @if($post->category->name)
                   </strong> Catégorie: <strong>{{ $post->category->name }}</strong>
                @endif

                @if (!$post->tags->isEmpty())

                    , Tags:
                    @foreach ($post->tags as $tag )

                        <span class="badge bg-secondary">
                            {{ $tag->name }}
                        </span>

                    @endforeach

                @endif
            </p>

            @if($post->image)

            <img src="{{$post->imageUrl() }}" alt="" style="height: 150px; width:100%; objet-fit:cover">

            @endif


            <p>{{ $post->content }}</p>
            <a href="{{ route("blog.show", ["slug"=>$post->slug, "id"=>$post->id]) }}" class="btn btn-primary">Lire la suite</a>
        </article>

    @endforeach
    {{ $posts->links() }}
@endsection
