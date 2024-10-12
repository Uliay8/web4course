$(document).ready(function() {
    $('#cost-form').on('change keyup', function() {
        var operator = $('#operator').val();
        var city = $('#city').val();
        var time = $('#time').val();

        if (operator && city && time) {
            $.ajax({
                url: 'calculate.php',
                type: 'POST',
                data: {
                    operator: operator,
                    city: city,
                    time: time
                },
                success: function(response) {
                    $('#cost').text(response);
                }
            });
        } else {
            $('#cost').text('0.00');
        }
    });
});