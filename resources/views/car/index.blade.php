@extends('layouts.master')
@section('page_title', $page['title'])
@section('content')
<h2 class="job-title text-center mt-5">{{ $page['title'] }}</h2>
<div class="mt-5">
    <div class="row justify-content-center">
        <img 
            src="{{ asset('/img/Default Car.png') }}" 
            id="currentCarImage"
        >
        <img 
            src="{{ asset('/img/Shape 1.png') }}" 
            height="55" 
            width="60" 
            class="mr-5 p-2 mt-5 ml-5"
        >
        <img 
            src="{{ asset('/img/Default Car.png') }}" 
            id="targetCarImage"
        >
    </div>
</div>
<div class="mt-5">
    <h3 class="car-details">Car Details</h3>
    <form method="POST" id="store">
        @csrf
        <table class="form">
            <tr>
                <td>Plate No.</td>
                <td class="input">
                    <input type="text" class="form-control" name="plateNo" id="plateNo" required>
                </td>
            </tr>
            <tr >
                <td>Current Color</td>
                <td class="input">
                    <select name="currentColor" id="currentColor" class="form-control" required>
                        <option value=""></option>
                        <option value="red">red</option>
                        <option value="green">green</option>
                        <option value="blue">blue</option>
                    </select>
                </td >
            </tr>
            <tr >
                <td>Target Color</td>
                <td class="input">
                    <select name="targetColor" id="targetColor" class="form-control" required>
                        <option value=""></option>
                        <option value="red">red</option>
                        <option value="green">green</option>
                        <option value="blue">blue</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn main-bg pl-5 pr-5 mt-2 text-light btn-submit">
            Submit
        </button>
    </form>
</div>
@endsection
@section('script')
<script>
    var cars = [
        '/img/Red Car.png', 
        '/img/Blue Car.png', 
        '/img/Green Car.png', 
        '/img/Default Car.png'
    ];

    $(document).on('change','#currentColor', function() {
        var color = $(this).val();
        var imageId = '#currentCarImage';
        toChangeColor(color, imageId);
    });

    $(document).on('change','#targetColor', function() {
        var color = $(this).val();
        var imageId = '#targetCarImage';
        toChangeColor(color, imageId);
    });

    $(document).on('click','.close', function() {
        $('.alert-message').removeClass('alert-success show');
    });

    function toChangeColor(color, imageId) {
        if (color == "red") {

            $(imageId).attr('src', cars[0]);

        } else if (color == "blue") {

            $(imageId).attr('src', cars[1]);

        } else if (color == "green") {

            $(imageId).attr('src', cars[2]);

        } else {

            $(imageId).attr('src', cars[3]);

        }
    }

    $('#store').on('submit', function(event) {
        event.preventDefault();
        $('.btn-submit').prop('disabled', true);
        var currentColor = $('#currentColor').val();
        var targetColor = $('#targetColor').val();

        if (currentColor === targetColor) {

            swal({
                title: 'Error!',
                text: 'Invalid! Current and target color must not be the same.',
                icon: 'error',
            });

            $('.btn-submit').prop('disabled', false);
            $('.alert-message').removeClass('alert-success show');
            $('.alert-message').addClass('alert-warning show');

        } else {

            $.ajax({
                url:"{{ route('store') }}",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType:"json",
                success:function(data) {

                    if (data.success) {
                        
                        $('#currentCarImage').attr('src', cars[3]);
                        $('#targetCarImage').attr('src', cars[3]);
                        $('#store')[0].reset();
                        
                        swal({
                            title: 'Success!',
                            text: data.success,
                            icon: 'success',
                        });

                    } else if (data.error) {

                        swal({
                            title: 'Error!',
                            text: data.error,
                            icon: 'error',
                        });

                    }

                    $('.btn-submit').prop('disabled', false);

                }
            });

        }
    });

</script>
@endsection
