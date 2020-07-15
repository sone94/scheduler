@extends('layouts.master')


<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
    background-color: #FFF !important;
  }

</style>
</head>

@section('content')
    <div class="container" id="calendar-container">
    <div id="flash-response" style="display:none;">
        <div class="alert alert-danger invisible" role="alert" id="errorMsg">
          </div>
        <div class="alert alert-success alert-dismissible fade show invisible" id="successMsg">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    </div>
    <!-- <div class="alert flashs" role="alert">
    <strong id="message"></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div> -->

        <div id='calendar'></div>
    </div>

@endsection

    @section('scripts')
      <script src="{{ asset('assets/js/dashboard/calendar.js') }}"></script>
      <script>
       $token = "{{ csrf_token() }}";
      </script>
    @endsection



</html>
