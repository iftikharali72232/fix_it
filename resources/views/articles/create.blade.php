@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Create New Article</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Service</label>
                            <select name="service_id" class="form-select" required>
                                <option value="" selected disabled>Choose Service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Text</label>
                            <textarea name="text" class="form-control" rows="5" placeholder="Write article content" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Gallery Images</label>
                            <input type="file" name="gallery_images[]" class="form-control" multiple>
                            <small>Upload multiple images.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Article</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
