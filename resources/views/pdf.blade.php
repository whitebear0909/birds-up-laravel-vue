<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Laravel PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
      table{
        font-size:6px; 
        white-space: nowrap;
        padding:1px; 
        border-collapse: collapse;
        padding:0;
        margin:0;
        border-color : black;
      }
    </style>
  </head>
  
  <body>
    @php $firstRow = $data->first();  @endphp 
    <h2 class="mb-3">Course Metrics</h2>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            @foreach ($firstRow as $key => $value)
              <th>{{ $key }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $row)
          <tr>
            @foreach ($row as $key => $value)
              <td>{{ $value }}</td>
            @endforeach
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </body>
</html>