$(document).ready(function() {

    $("#eye").click(function() {
        if ($("#eye").hasClass("fa-eye")) {
            $("#eye").removeClass("fa-eye");
            $("#eye").addClass("fa-eye-slash");
            $("#password").attr("type", "text");
        } else {
            $("#eye").removeClass("fa-eye-slash");
            $("#eye").addClass("fa-eye");
            $("#password").attr("type", "password");
        }
    });

});