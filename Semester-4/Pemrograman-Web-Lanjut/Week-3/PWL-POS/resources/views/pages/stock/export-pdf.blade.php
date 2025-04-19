@extends('layouts.pdf')

@section('title', 'Items Data')

@section('table-title', 'ITEMS DATA REPORT')

@section('contents')
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Item Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $stock->item->item_name }}</td>
                    <td>{{ $stock->stock_qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
