@extends('layouts.pdf')

@section('title', 'Users Data')

@section('table-title', 'USERS DATA REPORT')

@section('contents')
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Name</th>
                <th>Username</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->level->level_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
