@extends('networking::layout.main')

@section('content')

<table class="table table-responsive table-bordered">
    <thead class="bg-primary">
      <tr class="text-center">
         <th>Endpoint Url</th>
         <th>Response Status Code</th>
         <th>Request  Body</th>
         <th>Response Body</th>
         <th>Response Cookies</th>
         <th>Response Headers</th>
         <th>Request  Headers</th>
         <th>Time Elapsed</th>
         </tr>
         </thead>
         <tbody class="bg-success">

         @if(!empty($requests))

             @foreach($requests->getCollection()->all() as $request)
                <tr>
                <td>{{$request->url}}</td>
                <td>{{$request->status_code}}</td>
                <td>{{ $request->request_body }}</td>
                <td>{{$request->response_body}}</td>
                <td>{{$request->cookies}}</td>
                <td>{{$request->response_headers}}</td>
                <td>{{$request->request_headers}}</td>
                <td>{{$request->time_elapsed }}</td>
                </tr>
             @endforeach
             {{ $requests->links()}}
         @endif

       </tbody>
</table>
  {{ $requests->links()}}
@stop