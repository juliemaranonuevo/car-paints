@extends('layouts.master')
@section('page_title', $page['title'])
@section('content')
<h2 class="mt-5 text-center job-title">{{ $page['title'] }}</h2>
<div class="mt-5">
    <h3 class="ml-3">
        Paint Jobs in Progress
    </h3>
    <div class="row">
        <div class="col-md-8">
            <table class="table" id="progress">
                <thead class="font-weight-bold bg-light-gray" style="border: 1px solid #dddddd;">
                    <tr>
                        <td>Plate No.</td>
                        <td>Current Color</td>
                        <td>Target Color</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody class="table-bordered">
                    @php $count = 0; @endphp
                    @foreach ($cars as $key => $car)
                        @if ($car->status == 0)
                            @if ($count < 5)
                                <tr>
                                    <td>{{ $car->plate_no }}</td>
                                    <td class="text-capitalize">{{ $car->current_color }}</td>
                                    <td class="text-capitalize">{{ $car->target_color }}</td>
                                    <td class="text-center ">
                                        <a href="javascript:" class="mark-as-completed" id="{{ $car->id }}">
                                            <b>Mark as Completed</b>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            @php $count++; @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            <h3 class="ml-3 mt-5">
                Paint Queue
            </h3>
            <table class="table" id="queue">
                <thead class="font-weight-bold bg-light-gray" style="border: 1px solid #dddddd;">
                    <tr>
                        <td>Plate No.</td>
                        <td>Current Color</td>
                        <td>Target Color</td>
                    </tr>
                </thead>
                <tbody class="table-bordered">
                    @php $count = 0; @endphp
                    @foreach($cars as $key => $car)
                        @if ($car->status == 0)
                            @if ($count > 4)
                                <tr>
                                    <td>{{ $car->plate_no }}</td>
                                    <td class="text-capitalize">{{ $car->current_color }}</td>
                                    <td class="text-capitalize">{{ $car->target_color }}</td>
                                </tr>
                            @endif
                            @php $count++; @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table shop-performance" id="shopPerformance">
                <thead class="text-light main-bg">
                    <tr>
                        <th colspan="3">
                            SHOP PERFORMANCE
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-light-gray font-weight-bold">
                    <tr>
                        <td>Total Car Painted:</td>
                        <td>{{ count($cars->where('status', 1)) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Break down:</td>
                    </tr>
                    <tr>
                        <td><b class="pl-4">Blue</b></td>
                        <td>{{ count($cars->where('target_color', 'blue')->where('status', 1)) }}</td>
                    </tr>
                        <tr>
                        <td><b class="pl-4">Red</b></td>
                        <td>{{ count($cars->where('target_color', 'red')->where('status', 1)) }}</td>
                    </tr>
                        <tr>
                        <td><b class="pl-4">Green</b></td>
                        <td>{{ count($cars->where('target_color', 'green')->where('status', 1)) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).on('click', '.mark-as-completed', function(){
        var carId = this.id;
        swal({
            title: "Are you sure you want to complete?",
            text: 'Kindly wait for 5 seconds to reflect.',
            icon: "warning",
            buttons: ['No', 'Yes']
        }).then((willComplete) => {
            if (willComplete) {
                $.ajax({
                    url:"{{ route('update') }}",
                    type: 'POST',
                    data: {
                        'carId': carId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data) {
                        var time = setInterval(() => {

                            $("#progress").load(location.href + " #progress");
                            $("#queue").load(location.href + " #queue");
                            $("#shopPerformance").load(location.href + " #shopPerformance");
                            
                            swal({
                                title: 'Success!',
                                text: data.success,
                                icon: 'success',
                            });

                            clearInterval(time);
                            
                        }, 5000);
                    },
                });
            } else {
                return false;
            }
        });
    });
</script>
@endsection