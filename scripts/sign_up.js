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
            $("#nicknameInfo").text("* 请输入以字母开头，由字母、数字和下划线组成的昵称")
                .addClass("error");
            nicknameValid = false;
        } else if (isNicknameTaken(nickname)) {
            $("#nicknameInfo").text("* 此昵称已被注册，请换一个昵称")
                .addClass("error");
            nicknameValid = false;
        } else {
            $("#nicknameInfo").text("可以使用该昵称")
                .removeClass("error");
            nicknameValid = true;
        }
    }

    function validateEmail() {
        var pattern = /^[\w\.-]+@[\w-]+\.[\w\.-]+$/;
        var email = testInput($("#email").val());

        //检测邮箱是否合法
        if (!pattern.test(email)) {
            $("#emailInfo").text("* 请输入合法的邮箱")
                .addClass("error");
            emailValid = false;
        } else if (isEmailTaken(email)) {
            $("#emailInfo").text("* 此邮箱已被注册，请换一个邮箱")
                .addClass("error");
            emailValid = false;
        } else {
            $("#emailInfo").text("可以使用该邮箱")
                .removeClass("error");
            emailValid = true;
        }
    }

    function validatePassword() {
        var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/;
        var password = testInput($("#password").val());

        //检测密码是否为八位至十六位，且含大小写字母及数字
        if (!pattern.test(password)) {
            $("#passwordInfo").text("* 请输入8~16位，同时含大小写字母及数字的密码")
                .addClass("error");
            passwordValid = false;
        } else {
            $("#passwordInfo").text("可以使用该密码")
                .removeClass("error");
            passwordValid = true;
        }
    }

    function validatePasswordConfirmation() {
        var password = testInput($("#password").val());
        var passwordConfirmation = testInput($("#passwordConfirmation").val());

        if (password !== passwordConfirmation) {
            $("#passwordConfirmationInfo").text("* 请输入一致的密码")
                .addClass("error");
            passwordConfirmationValid = false;
        } else if (password === "" && passwordConfirmation === "") {
            $("#passwordConfirmationInfo").text("*")
                .addClass("error");
            passwordConfirmationValid = false;
        } else {
            $("#passwordConfirmationInfo").text("两次密码输入一致")
                .removeClass("error");
            passwordConfirmationValid = true;
        }
    }

    function validateForm() {
        if (nicknameValid && emailValid && passwordValid && passwordConfirmationValid){
            return true;
        } else {
            alert("请按要求填写所有带“*”项");
            return false;
        }
    }

    //绑定注册表格与事件
    $("#signUpForm").submit(function () {
        return validateForm();
    });
    $("#nickname").focusout(function () {
        validateNickname();
    });
    $("#email").focusout(function () {
        validateEmail();
    });
    $("#password").focusout(function () {
        validatePassword();
    });
    $("#passwordConfirmation").focusout(function () {
        validatePasswordConfirmation();
    });
});