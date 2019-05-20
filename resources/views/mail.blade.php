<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #666;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #e9a32d;
  color: white;
}
</style>
</head>
<body>
<h3>Shift was Successfully Closed and We picked up a reports for you to take a look.</h3>
<h3>Date : {{$fetchMonthlyreports[0]['date']}}</h2>
<h3>Shift : {{ $fetchMonthlyreports[0]['user_shift'] === 1 ? 'Morning Shift' : 'Evening Shift' }}</h2>
<h3>Total Revenue : Rs.{{$revenue['revenue_amount']}}</h2>
    <br>
<table id="customers">
  <tr>
    <th>Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
  </tr>
  @foreach($fetchMonthlyreports as $data)
  <tr>
    <td>{{$data->products_name}}</td>
    <td><i class="fa fa-inr" aria-hidden="true"></i>{{$data->product_price}}</td>
    <td>{{$data->product_quantity}}</td>
    <td><i class="fa fa-inr" aria-hidden="true"></i>{{$data->product_total}}</td>
  </tr>
  @endforeach
</table>

</body>
</html>