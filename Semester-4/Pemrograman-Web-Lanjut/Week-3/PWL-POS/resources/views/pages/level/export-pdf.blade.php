@extends('layouts.pdf')

@section('title', 'Levels Data')

@section('table-title', 'LEVELS DATA REPORT')

@section('contents')
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Code</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($levels as $level)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $level->level_code }}</td>
                    <td>{{ $level->level_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
