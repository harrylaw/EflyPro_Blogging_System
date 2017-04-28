/**
 * Created by harry on 27/04/2017.
 */
$(document).ready(function () {
    function testInput(data) {
        return data.trim();
    }
    function validateForm() {
        if (isTitleValid() && isContentValid()) {
            return true;
        } else {
            alert("请填写所有带*项");
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

    $("#addPostForm").submit(function () {
        return validateForm();
    });
});