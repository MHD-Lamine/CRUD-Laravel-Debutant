<form action="" method="post" class="vstack gap-2" enctype="multipart/form-data">
    @csrf
    @method($post->id ? 'PATCH':'POST')

    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="form-control" name="image" id="image" ">
        @error('image')
            {{ $message }}
        @enderror
    </div>
    <div class="form-group">
        <label for="title">Titre:</label>
        <input type="text" class="form-control" name="title" id="" value="{{ old('title', $post->title) }}">
        @error('title')
            {{ $message }}
        @enderror
    </div>
    <div>
        Slug: <input type="text" class="form-control" name="slug" id="" value="{{ old('slug', $post->slug) }}">
        @error('slug')
            {{ $message }}
        @enderror
    </div>
    <div>
        contenue: <textarea class="form-control" name="content" id="" >{{ old('content', $post->content) }}</textarea>
        @error('content')

        {{ $message }}

        @enderror
    </div>

    <div>
        Catégorie:
        <select class="form-control" name="category_id" id="category_id" >

            <option value=""> selectionner une catégorie</option>

            @foreach ($categories as $category )

            <option @selected(old('category_id', $post->category_id )==$category->id) value="{{ $category->id }}">{{ $category->name }}</option>

            @endforeach

        </select>
        @error('category_id')

        {{ $message }}

        @enderror
    </div>

    @php
        $tagId = $post->tags->pluck('id')
    @endphp

    <div>
        Tags:
        <select class="form-control" name="tags[]" id="tags" multiple>


            @foreach ($tags as $tag )

            <option @selected($tagId->contains($tag->id))  value="{{ $tag->id }}">{{ $tag->name }}</option>

            @endforeach

        </select>
        @error('tags')

        {{ $message }}

        @enderror
    </div>


    <button class="btn btn-primary">
        @if($post->id)

        Modifier

        @else

        Enregister

        @endif

    </button>
</form>
