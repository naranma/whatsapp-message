@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="card">
                            <div class="card-header no-border">
                              <h3 class="card-title">Messages</h3>

                              <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                    
                                        <a href="{{ route('message.create') }}" class="btn btn-success btn-sm mr-4">Add message</a>
                                         
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                              <table class="table table-hover">
                               <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Active</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($messages as $message)
                                        <tr>
                                            <td>{{ $message->id }}</td>
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->description }}</td>
                                            <td>{{ $message->phone }}</td>
                                            <td>{{ $message->status }}</td>
                                            <td>{{ $message->active }}</td>
                                            <td class="d-inline-flex">
                                                <a href="{{ route('message.show', $message->id) }}" class="btn btn-outline-info btn-sm">show</a>
                                                <a href="{{ route('message.edit', $message->id) }}" class="btn btn-outline-success btn-sm ml-2">Edit</a>
                                                <form class="ml-2" action="{{ route('message.destroy', $message->id) }}" method="POST" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" value="{{ $message->id }}">
                                                    <button onclick="return confirm('Excluir message?')" type="submit" class="btn btn-outline-danger btn-sm">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>
                                @endforeach
                              </tbody></table>
                            </div>
                            <!-- /.card-body -->
                    </div>
                
        </div>
    </div>
</div>
@endsection
