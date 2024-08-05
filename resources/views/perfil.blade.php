@extends('layouts.app')

@section('content')
    <div class="content" style="height: 100%">
        <div class="container-fluid" style="height: 100%">
            <div class="row">
                <div class="col-md-8">
                    <div class="card" style="height: 100%">
                        <div class="card-header">
                            <h4 class="card-title">Editar Perfil</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('editar_perfil', ['id' => Auth::user()->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 pl-1">
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image</label>
                                            <input type="file" class="form-control" name="profile_image">
                                        </div>
                                    </div>
                                    <div class="col-md-3 px-1">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Nombre de usuario" value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Correo electrónico</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Correo electrónico" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info btn-fill pull-right">Actualizar Perfil</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-user" style="height: 100%">
                        <div class="card-image">
                            <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400"
                                alt="...">
                        </div>
                        <div class="card-body">
                            <div class="author">
                                <a href="#">
                                    <img class="avatar border-gray" src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="...">
                                    <h5 class="title">{{ $user->name }}</h5>
                                </a>
                                <p class="description">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
