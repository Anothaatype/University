@extends('layouts.pdf')

@section('title', 'Items Data')

@section('table-title', 'ITEMS DATA REPORT')

@section('contents')
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Buy Price</th>
                <th>Sell Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->category->category_name }}</td>
                    <td>{{ $item->item_buy_price }}</td>
                    <td>{{ $item->item_sell_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
