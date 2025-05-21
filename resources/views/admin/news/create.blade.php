@extends('admin.layouts.app')
@section('title', __('Create News'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Create News</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.news.store') }}">
            @csrf
            <div class="row mb-3">
                <label for="title" class="col-md-2 col-form-label text-md-end">{{ __('Title') }}</label>

                <div class="col-md-10">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="category" class="col-md-2 col-form-label text-md-end">{{ __('Category') }}</label>

                <div class="col-md-10">
                    <select class="form-select" name="category" aria-label="Default select example">
                        <option value="news">News</option>
                        <option value="event">Event</option>
                        <option value="update">Update</option>
                    </select>

                    @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="image" class="col-md-2 col-form-label text-md-end">{{ __('Thumbnail') }}</label>

                <div class="col-md-10">
                    <input id="image" type="text" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="published_at" class="col-md-2 col-form-label text-md-end">{{ __('Published At') }}</label>

                <div class="col-md-10">
                    <input id="published_at" type="date" class="form-control @error('published_at') is-invalid @enderror" name="published_at" value="{{ old('published_at', now()->format('Y-m-d')) }}" required>

                    @error('published_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="active" class="col-md-2 col-form-label text-md-end">{{ __('Active') }}</label>

                <div class="col-md-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked>
                        <label class="form-check-label" for="active">
                            Active
                        </label>
                    </div>

                    @error('active')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="content" class="col-md-2 col-form-label text-md-end">{{ __('Content') }}</label>

                <div class="col-md-10">
                    <textarea id="summernote" rows="10" class="form-control" name="content"></textarea>

                    @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-10 offset-md-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create News') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')

@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.js"></script>

    <script>
        $('#summernote').summernote({
            placeholder: 'Hello iSRO-CMS v2',
            tabsize: 2,
            height: 400,
            codeviewFilter: false, // allows raw HTML
            codeviewIframeFilter: true
        });
    </script>

    <script>
        const checkbox = document.getElementById('active');

        checkbox.addEventListener('change', function () {
            checkbox.value = this.checked ? '1' : '0';
        });
    </script>
@endpush
