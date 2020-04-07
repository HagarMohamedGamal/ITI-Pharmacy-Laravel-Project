
@extends('layouts.app')

@section('content')
      <div class="container m-5 mx-auto">
          <table class="table table-bordered data-table text-center display">
              <thead>
                <tr>
                  <th scope="col">Pharmacy ID</th>
                  <th scope="col">Pharmacy Name</th>
                  <th scope="col">Total Orders</th>
                  <th scope="col">TotalRevenue</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pharmacies as $pharmacy)
                <tr>
                    <td>{{ $pharmacy->id}}</td>
                    <td>{{ $pharmacy->pharmacy_name->name}}</td>
                    <td>{{ $pharmacy->orders->count() }}</td>
                    <td>{{ $pharmacy->orders->sum("price") }}</td>

                </tr>
              @endforeach
              </tbody>
            </table>
      </div>
@endsection
