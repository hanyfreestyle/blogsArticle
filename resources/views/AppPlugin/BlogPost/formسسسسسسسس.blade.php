<!DOCTYPE html>
<html>
<head>
    <title>Autocomplete Search using jQuery UI in Laravel 9</title>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ defAdminAssets('jqueryui/jquery-ui.min.css') }}">


    <!-- Script -->
    <script src="{{defAdminAssets('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{defAdminAssets('jqueryui/jquery-ui.min.js')}}"></script>



</head>
<body>

<!-- For defining autocomplete -->
<input type="text" id='employee_search'>

<!-- For displaying selected option value from autocomplete suggestion -->
<input type="text" id='employeeid' readonly>

<!-- Script -->
<script type="text/javascript">

  
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#employee_search" ).autocomplete({
            source: function( request, response ) {
                // Fetch data
                $.ajax({
                    url:"{{route('employees.getEmployees')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                $('#employee_search').val(ui.item.label); // display the selected text
                $('#employeeid').val(ui.item.value); // save selected id to input
                return false;
            }
        });

    });
</script>
</body>
</html>
