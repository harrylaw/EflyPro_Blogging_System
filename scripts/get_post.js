/**
 * Created by harry on 08/05/2017.
 */
$(document).ready(function () {
    function testInput(data) {
        return data.trim();
    }
    function validateCommentForm() {
        if (isCommentEmpty()) {
            alert("评论不能为空！");
            return false;
        } else if (isCommentOversized()) {
            alert("评论不能超过限制字数！");
            return false;
        } else {
            $("#submit").attr("disabled", "disabled");
            return true;
        }
    }
    function isCommentEmpty() {
        var comment = testInput($("#comment_content").val());
        return !Boolean(comment);
    }
    function isCommentOversized() {
        var comment = testInput($("#comment_content").val());
        return comment.length > max_size;
    }
    function countWords() {
        var words_count = testInput($("#comment_content").val()).length;
        var remaining_size = max_size - words_count;
        $("#words_count").html("还可以输入：" + remaining_size + "字");
    }

    //绑定表格与函数、入口
    var max_size = 255;
    $("#commentForm").submit(function () {
        return validateCommentForm();
    });
    $("#comment_content").keyup(countWords)
        .change(countWords); //用鼠标复制时字数统计也会改变
});