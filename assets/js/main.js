
	$(document).ready(function () {

		$("#operator").change(function(){
	    if ($("#operator").val() == "divide") {
				$.validator.addMethod("greaterThanZero", function(value) {
				    return parseFloat(value) > 0;
				}, "Warning! You cannot divide by zero.");
	    }
		});

    $('#calc').validate({
      rules: {
        a: {
          required: true,
          number: true
        },
        b: {
          required: true,
          number: true,
          greaterThanZero: true
        }
      }
    });

    $('#calculate').click(function(){
      $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'classes/calculator.php',
        data: 'a=' + $('#left_operand').val() + '&b=' + $('#right_operand').val() + '&operator=' + $('#operator').val(),
        success: function(response){
          $('#info').html(
            response['a'] + ' ' + response['operator'] + ' ' + response['b'] + ' = ' + response['result']
          );                    
          $('#result').html(
            response['result']
          );
        }
      });
      return false;
    });

	});