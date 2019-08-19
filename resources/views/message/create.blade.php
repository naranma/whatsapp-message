@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-center">Cadastro</h3>

                    <div class="card">
                        <div class="card-body">
                                <form action="{{ route('message.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        @php( $field = 'name' )
                                        <label for="{{ $field }}">Name</label>
                                        <input type="text" class="form-control @error($field) is-invalid @enderror" value="{{ old( $field ) }}" id="{{ $field }}" name="{{ $field }}" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        @php( $field = 'description' )
                                        <label for="{{ $field }}">Description</label>
                                        <input type="text" class="form-control @error($field) is-invalid @enderror" value="{{ old( $field ) }}" id="{{ $field }}" name="{{ $field }}" placeholder="Description">
                                    </div>
                                    <div class="form-group">
                                        @php( $field = 'phone' )
                                        <label for="{{ $field }}">Phone</label>
                                        <input type="text" class="form-control @error($field) is-invalid @enderror" value="{{ old( $field ) }}" id="{{ $field }}" name="{{ $field }}" placeholder="550000000000">
                                    </div>
                                    <a href="" class="btn btn-primary">Cancelar</a>
                                    <input type="submit"  class="btn btn-success" value="Salvar">
                                </form>
                        </div>
                    </div>
                
        </div>
    </div>
</div>
@endsection
