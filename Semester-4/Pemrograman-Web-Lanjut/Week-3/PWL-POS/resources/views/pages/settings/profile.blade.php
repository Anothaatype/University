@extends('layouts.main')

@section('title', 'Profile Settings')

@section('contents')
    <div class="row">
        {{-- Profile Picture --}}
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="fs-5 my-0">Profile Picture</p>
                </div>
                <form action="{{ route('settings.profile.update-profile-picture') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($user->profile_picture)
                            <div class="d-flex align-items-center justify-content-center rounded-circle mx-auto border"
                                style="width: 124px; height: 124px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center rounded-circle mx-auto border"
                                style="width: 124px; height: 124px; background-color: whitesmoke;">
                                <p class="my-0" style="font-size: 40px;">{{ auth()->user()->name[0] }}</p>
                            </div>
                        @endif
                        <div class="form-group mt-4">
                            <input type="file" class="form-control" name="profile_picture">
                            @error('profile_picture')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Update Profile Picture</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Account Informations --}}
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="fs-5 my-0">Account Informations</p>
                </div>
                <form action="">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username"
                                value="{{ $user->username }}">
                            @error('username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name"
                                value="{{ $user->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Level</label>
                            <select name="level_id" class="form-control">
                                <option value="">- Select level</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->level_id }}"
                                        {{ $user->level_id == $level->level_id ? 'selected' : '' }}>
                                        {{ $level->level_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Update Account Informations</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
