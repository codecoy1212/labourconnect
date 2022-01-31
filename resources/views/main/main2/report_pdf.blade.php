<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report - PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body  style="background-color:#e6e6e6">



<div class="container shadow mb-4 mt-4 bg-white rounded" style="font-size:14px; padding:40px; width: 700px; background-color:#ffffff" >

    <div class="row pb-3 border-bottom border-dark">
        <div class="col-8">
            <div><b> Client Name: </b>{{$final[0][0]}}</div>
            <div><b> Job Location: </b>{{$final[0][1]}} </div>
            <div><b> Date: {{$final[0][2]}} - {{$final[0][3]}}</b> </div>
        </div>
        <div class="col-4">
          <img src="public/storage/pdf_logo.png" alt="logo" height="70px">
        </div>
    </div>

    @for ($i = 1; $i < count($final);$i++)
        <div class="row pt-4">
            <div class="col-12">
                <div class="mb-2"><b> Employee Name: </b>{{$final[$i][0]}} </div>

                    {{-- <div> {{$item[0]}}: {{$item[1]}}</div> --}}
                <table class="table table-sm table-bordered ">
                    <thead  style="height: 20px">
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Day</th>
                            <th scope="col">Working Hours</th>
                            <th scope="col">Role</th>
                            <th scope="col">Signature</th>
                        </tr>
                        </thead>
                    <tbody>
                        @for ($k = 0; $k < count($final[$i][1]);$k++)
                            <tr>
                                <td>{{$final[$i][1][$k][0]}}</td>
                                <td>{{$final[$i][1][$k][1]}}</td>
                                <td>{{$final[$i][1][$k][2]}}</td>
                                <td>{{$final[$i][1][$k][3]}}</td>
                                <td>{{$final[$i][1][$k][4]}}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>

                <div class="mb-2"> Total Hours: </div>

                @foreach ($final[$i][2] as $item)
                    <div> {{$item[0]}}: {{$item[1]}}</div>
                @endforeach

            </div>
        </div>
    @endfor





    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
