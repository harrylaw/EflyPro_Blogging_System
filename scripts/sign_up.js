/**
 * Created by harry on 14/04/2017.
 */
$(document).ready(function () {
    var nicknameValid = false, emailValid = false, passwordValid = false, passwordConfirmationValid = false;

    function testInput(data) {
        return data.trim();
    }

    function isNicknameTaken(nickname) {
        var nicknameTaken = false;
        $.ajaxSetup({async: false});

        $.post("../view/query_handler.php", {query: "nickname", nickname: nickname},
            function (data) {
                if (data === "TAKEN") {
                    nicknameTaken = true;
                }
                else {
                    nicknameTaken = false;
                }
            }
            , "text");

        $.ajaxSetup({async: true});
        return nicknameTaken;
    }

    function isEmailTaken(email) {
        var emailTaken = false;
        $.ajaxSetup({async: false});

        $.post("../view/query_handler.php", {query: "email", email: email},
            function (data) {
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

    function validateNickname() {
        var pattern = /^[a-zA-Z]\w*$/;
        var nickname = testInput($("#nickname").val());

        //检测昵称是否只包含字母、数字和下划线，并以字母开头
        if (!pattern.test(nickname)) {
            $("#nicknameInfo").text("请输入以字母开头，由字母、数字和下划线组成的昵称");
            $("#nicknameField").removeClass("has-success").addClass("has-error");
            $("#nicknameInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            nicknameValid = false;
        } else if (isNicknameTaken(nickname)) {
            $("#nicknameInfo").text("此昵称已被注册，请换一个昵称");
            $("#nicknameField").removeClass("has-success").addClass("has-error");
            $("#nicknameInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            nicknameValid = false;
        } else {
            $("#nicknameInfo").text("");
            $("#nicknameField").removeClass("has-error").addClass("has-success");
            $("#nicknameInfoIcon").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            nicknameValid = true;
        }
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
        } else if (isEmailTaken(email)) {
            $("#emailInfo").text("此邮箱已被注册，请换一个邮箱");
            $("#emailField").removeClass("has-success").addClass("has-error");
            $("#emailInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            emailValid = false;
        } else {
            $("#emailInfo").text("");
            $("#emailField").removeClass("has-error").addClass("has-success");
            $("#emailInfoIcon").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            emailValid = true;
        }
    }

    function validatePassword() {
        var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/;
        var password = testInput($("#password").val());

        //检测密码是否为八位至十六位，且含大小写字母及数字
        if (!pattern.test(password)) {
            $("#passwordInfo").text("请输入8~16位，同时含大小写字母及数字的密码");
            $("#passwordField").removeClass("has-success").addClass("has-error");
            $("#passwordInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            passwordValid = false;
        } else {
            $("#passwordInfo").text("");
            $("#passwordField").removeClass("has-error").addClass("has-success");
            $("#passwordInfoIcon").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            passwordValid = true;
        }
    }

    function validatePasswordConfirmation() {
        var password = testInput($("#password").val());
        var passwordConfirmation = testInput($("#passwordConfirmation").val());

        if (password !== passwordConfirmation) {
            $("#passwordConfirmationInfo").text("请输入一致的密码");
            $("#passwordConfirmationField").removeClass("has-success").addClass("has-error");
            $("#passwordConfirmationInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            passwordConfirmationValid = false;
        } else if (password === "" && passwordConfirmation === "") {
            $("#passwordConfirmationInfo").text("");
            $("#passwordConfirmationField").removeClass("has-success").addClass("has-error");
            $("#passwordConfirmationInfoIcon").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            passwordConfirmationValid = false;
        } else {
            $("#passwordConfirmationInfo").text("");
            $("#passwordConfirmationField").removeClass("has-error").addClass("has-success");
            $("#passwordConfirmationInfoIcon").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            passwordConfirmationValid = true;
        }
    }

    function validateForm() {
        if (nicknameValid && emailValid && passwordValid && passwordConfirmationValid){
            $("#submit").attr("disabled", "disabled");
            return true;
        } else {
            alert("请按要求填写所有表单项");
            return false;
        }
    }

    //绑定注册表格与函数
    $("#signUpForm").submit(function () {
        return validateForm();
    });
    $("#nickname").focusout(validateNickname);
    $("#email").focusout(validateEmail);
    $("#password").focusout(validatePassword);
    $("#passwordConfirmation").focusout(validatePasswordConfirmation);
});