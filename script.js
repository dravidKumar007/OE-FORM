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
                const form = document.forms['submit-to-google-sheet']
                fetch("https://script.google.com/macros/s/AKfycbxzL3RuE9SUUCvYD-JA6PJnUysoXwbQZKM2OTQ6YmicofpftjIw716Tedgm5GDBsLKlzQ/exec", { method: 'POST', body: new FormData(form)})
      .then(response =>{ console.log('Success!', response);})
      .catch(error => {console.error('Error!', error.message);alert('Error!', error.message);})
      window.open('done.html', '_self')      
                
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
            var time=new Date()
            console.log(time*1000)
            var currentTimestamp = timestamps.current_timestamp * 1000; // Multiply by 1000 to convert to milliseconds
            var disableTimestamp =( (timestamps.disable_timestamp * 1000)-12600000); // Multiply by 1000 to convert to milliseconds
            var arrivalTimestamp = ((timestamps.arrival_timestamp * 1000)-12600000); // Multiply by 1000 to convert to milliseconds
            console.log("current:"+timestamps.current_timestamp)
            console.log("disable:"+disableTimestamp)
            console.log("arrivalTimestamp:"+arrivalTimestamp)
            console.log((currentTimestamp < disableTimestamp))
            console.log((currentTimestamp >= arrivalTimestamp))
            console.log(!(currentTimestamp < disableTimestamp && currentTimestamp > arrivalTimestamp))
            if (!(currentTimestamp < disableTimestamp && currentTimestamp > arrivalTimestamp)) {
                $('#submitButton').prop('disabled', true); // Disable the submit button
    $('#submitButton').css('background-color', 'red'); // Change button color to red
    $('#submitButton').text('disabled'); // Change button text to "disabled"
    $('#submitButton').css('cursor', 'not-allowed');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching timestamps:', error);
        }
    });
});