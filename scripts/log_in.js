/**
 * Created by harry on 18/04/2017.
 */
$(document).ready(function () {
    var emailValid = false, passwordValid = false;

    function testInput(data) {
        return data.trim();
    }

    function isEmailTaken(email) {
        var emailTaken = false;
        $.ajaxSetup({async: false});

        $.post("../view/query_handler.php", {query: "email", email: email},
            function (data, status) {
                if (data === "TAKEN") {
                    emailTaken = true;
                }
                else {
                    emailTaken = false;
                }
            }
        , "text");

        $.ajaxSetup({async: true});
        return emailTaken;
    }

    function validateEmail() {
        var pattern = /^[\w\.-]+@[\w-]+\.[\w\.-]+$/;
        var email = testInput($("#email").val());

        //检测邮箱是否合法
        if (!pattern.test(email)) {
            $("#emailInfo").text("请输入合法的邮箱");
            $("#emailField").removeClass("has-success").addClass("has-error");
            $("#emailInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            emailValid = false;
        } else if (!isEmailTaken(email)) {
            $("#emailInfo").html("此邮箱尚未被注册，现在 <a href='sign_up.php'>注册</a>");
            $("#emailField").removeClass("has-success").addClass("has-error");
            $("#emailInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            emailValid = false;
        } else {
            $("#emailField").removeClass("has-error").addClass("has-success");
            $("#emailInfoIcon").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            $("#emailInfo").text("");
            emailValid = true;
        }
    }

    function validatePassword() {
        var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/;
        var password = testInput($("#password").val());

        //检测密码是否为八位至十六位，且含大小写字母及数字
        if (!pattern.test(password)) {
            $("#passwordField").removeClass("has-success").addClass("has-error");
            $("#passwordInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            $("#passwordInfo").text("密码为8~16位，同时含大小写字母及数字的组合");
            passwordValid = false;
        } else {
            $("#passwordInfo").text("");
            $("#passwordField").removeClass("has-error").addClass("has-success");
            $("#passwordInfoIcon").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            passwordValid = true;
        }
    }

    function validateForm() {
        if (emailValid && passwordValid) {
            $("#submit").attr("disabled", "disabled");
            return true;
        } else {
            alert("请按要求填写所有表单项");
            return false;
        }
    }

    //绑定登录表格与函数
    $("#logInForm").submit(function () {
        return validateForm();
    });
    $("#email").focusout(validateEmail);
    $("#password").focusout(validatePassword);
});