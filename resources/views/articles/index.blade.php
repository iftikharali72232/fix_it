@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4>Articles List</h4>
                    <a href="{{ route('articles.create') }}" class="btn btn-primary float-end">Create New Article</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Service</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->service->service_name }}</td>
                                    <td>
                                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $articles->links() }} <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
