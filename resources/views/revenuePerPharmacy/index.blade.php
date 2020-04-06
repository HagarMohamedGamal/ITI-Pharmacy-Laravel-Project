
@extends('layouts.app')

@section('content')
      <div class="container m-5 mx-auto">
          <table class="table table-bordered data-table text-center display">
              <thead>
                <tr>
                  <th scope="col">Pharmacy ID</th>
                  <th scope="col">Total Orders</th>
                  <th scope="col">TotalRevenue</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td>{{ $pharmacy->id}}</td>
                    <td>{{ $pharmacy->orders->count() }}</td>
                    <td>{{ $pharmacy->orders->sum("price") }}</td>
                </tr>
              </tbody>
            </table>
      </div>
@endsection
