@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1>Edit post: {{ $post->title }}</h1>
            </div>
            <div class="col-2">
                <form id="delete-form" class="text-right" action="{{route('admin.posts.destroy', $post)}}" method="POST">
                    @csrf {{-- il token di sicurezza va sempre messo nei form --}}
                    @method('DELETE')
                    <button for="delete-form" class="btn btn-danger" type="submit" >Delete</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container">
        <form id="edit" action="{{ route('admin.posts.update', $post) }}" method="POST"> 
        {{-- gli passo anche il parametro $post perché deve sapere quale post andare a modificare --}}
            @csrf 
            @method('PUT')

            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title)}}" placeholder="Enter Title">
            
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value=""> -- none -- </option> 
                    {{-- ci devo mettere il value vuoto così lo considera come nullo, se non ce lo metto non funge --}}
                    @foreach ($categories as $category)
                    <option {{ old('category_id', optional($post->category)->id ) == $category->id ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>  
                    {{-- Con optional if the given object is null, properties and methods will return null instead of causing an error --}}
                    @endforeach
                </select>

                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Title</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="Enter content" cols="30" rows="10">{{ old('content', $post->content) }}</textarea>
              
                @error('content')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="published_at">Publication date</label>
                <input type="date" class="form-control @error('puclished_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at') ? : Str::substr($post->published_at, 0, 10)  }}" placeholder="Enter Title">
                {{-- The Str::substr method returns the portion of string specified by the start and length parameters: --}}
              
                @error('puclished_at')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
  
            <button for="edit" type="submit" class="btn btn-primary">Save changes</button>
            {{-- con for=edit specifico che questo bottone si riferisce al form cin id=edit --}}
          </form>
    </div>

@endsection