$(document).ready(function() {
    $('#Dept, #year').change(function() {
        var dept = $('#Dept').val();
        var year = $('#year').val();
        $.ajax({
            type: 'POST',
            url: 'getSubjects.php',
            data: {dept: dept, year: year},
            success: function(response) {
                $('#subject').html(response);
            },error:function(response){
                alert(xhr.responseText);
            }
        });
    });

    // Intercept form submission
    $('#myForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Perform AJAX request
        var formData = $(this).serialize(); // Serialize form data
        $.ajax({
            type: 'POST',
            url: 'students.php', // Change to the appropriate URL
            data: formData,
            success: function(response) {
                // Handle success response
                console.log(response);
                window.open('done.html','_self');
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert(xhr.responseText);
            }
        });
    });

    $.ajax({
        type: 'GET',
        url: 'get_timestamps.php',
        dataType: 'json',
        success: function(timestamps) {
            var currentTimestamp = timestamps.current_timestamp * 1000; // Multiply by 1000 to convert to milliseconds
            var disableTimestamp = timestamps.disable_timestamp * 1000; // Multiply by 1000 to convert to milliseconds
            var arrivalTimestamp = timestamps.arrival_timestamp * 1000; // Multiply by 1000 to convert to milliseconds
            console.log("current:"+currentTimestamp)
            console.log("disable:"+disableTimestamp)
            console.log("arrivalTimestamp:"+arrivalTimestamp)
            if (currentTimestamp < disableTimestamp && currentTimestamp >= arrivalTimestamp) {
                $('#submitButton').prop('disabled', true);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching timestamps:', error);
        }
    });
});