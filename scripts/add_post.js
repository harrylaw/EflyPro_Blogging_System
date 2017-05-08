/**
 * Created by harry on 27/04/2017.
 */
$(document).ready(function () {
    function testInput(data) {
        return data.trim();
    }
    function validateForm() {
        if (isTitleValid() && isContentValid()) {
            $("#submit").attr("disabled", "disabled");
            return true;
        } else {
            alert("请填写所有表单项");
            return false;
        }
    }
    function isTitleValid() {
        var title = testInput($("#title").val());
        return Boolean(title);
    }
    function isContentValid() {
        var content = testInput($("#post_content").val());
        return Boolean(content);
    }

    //绑定表格与函数
    $("#addPostForm").submit(function () {
        return validateForm();
    });
});