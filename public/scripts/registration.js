$(document).ready(function() {

    $("#eye_1").click(function() {
        if ($("#eye_1").hasClass("fa-eye")) {
            $("#eye_1").removeClass("fa-eye");
            $("#eye_1").addClass("fa-eye-slash");
            $("#password_1").attr("type", "text");
        } else {
            $("#eye_1").removeClass("fa-eye-slash");
            $("#eye_1").addClass("fa-eye");
            $("#password_1").attr("type", "password");
        }
    });

    $("#eye_2").click(function() {
        if ($("#eye_2").hasClass("fa-eye")) {

            $("#eye_2").removeClass("fa-eye");
            $("#eye_2").addClass("fa-eye-slash");
            $("#password_2").attr("type", "text");

        } else {

            $("#eye_2").removeClass("fa-eye-slash");
            $("#eye_2").addClass("fa-eye");
            $("#password_2").attr("type", "password");

        }
    });
});
    /*$("#login").submit(function (e) {
        e.preventDefault();
        let th = $(this);
        let msg = $(".message");
        let btn = th.find(".button");

        $.ajax({
            type: "POST",
            url: "./foo.php",
            data: th.serialize(),
            success: function () {
                msg.html('Всё ок');
            },
            error: function(er) {
                msg.html('ошибка отправки');
                console.log(er);
            }
        });
    });*/