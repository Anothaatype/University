@extends('layouts.pdf')

@section('title', 'Categories Data')

@section('table-title', 'CATEGORIES DATA REPORT')

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
            @foreach ($categories as $category)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $category->category_code }}</td>
                    <td>{{ $category->category_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
