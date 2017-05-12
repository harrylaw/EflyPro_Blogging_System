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
    function createCategory() {
        var category_name = testInput($("#new_category").val());
        if (category_name) {
            $.post("../view/create_category", {category_name: category_name},
                function (data, status) {
                    if (data === "SUCCEED") {
                        alert("分类创建成功！");
                    } else if (data === "FAILED" ) {
                        alert("分类创建失败！此分类已存在。");
                    } else {
                        alert("分类创建失败！服务器出错，请联系技术人员。");
                    }
                    location.reload();
                }
                , "text");
        } else {
            alert("分类名不能为空！");
        }
    }

    //绑定表格与函数
    $("#addPostForm").submit(function () {
        return validateForm();
    });
    $("#create_category_btn").click(createCategory);
});