
@extends('layouts.app')

@section('content')
      <div class="container">
      <div class="text-center">
        <a href="{{route('orders.create')}}" class="btn btn-outline-success font-weight-bold mb-5">Create order</a>
      </div>
          <table class="table table-bordered data-table text-center display compact">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">order user name</th>
                  <th scope="col">doctor name</th>
                  <!--<th scope="col">Description</th> -->
                  <th scope="col"> delivering address</th>
                  <th scope="col">Created At</th>
                  <th scope="col">status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                <tr>
                <th scope="row">{{ $order->id }}</th>
                  <td>{{ $order->order_user_name }}</td>
                  <td>{{ $order->doctor_name }}</td>
                 <!-- <td>{{ $order->description }}</td>-->
                 <td>{{ $order->delivering_address}}</td>
                 <td>{{ $order->created_at }}</td>
                 <td>{{ $order->status }}</td>

                <td>
                <a href="{{route('orders.show',['order' => $order->id])}}" class="btn btn-info btn-sm">View</a>
                <a href="{{route('orders.edit',['order' => $order->id])}}" class="btn btn-success btn-sm">edit</a>
                <form class="d-inline" method="POST" action="{{route('orders.show',['order' => $order->id])}}">
                @csrf
                @method('DELETE')
                      <button type="submit" onclick="return confirm('are you sure you want to delete this order')" class="btn btn-primary btn-sm btn-danger">delete</button>
                </form>
                </td>
                </tr>
              @endforeach
              </tbody>
            </table>
      </div>
@endsection
