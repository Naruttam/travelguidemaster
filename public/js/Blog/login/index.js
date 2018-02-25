$(window).on('load',function(){
    $('#myModal').modal('show');
});

$(document).ready(function(){
    /*$("#myBtn").click(function(){
        $("#myModal").modal();
    });*/

    $('#myModal').modal({
	    backdrop: 'static',
	    keyboard: false
	});

});