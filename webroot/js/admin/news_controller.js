function editNews() {
    var newsSelect = document.getElementById("newsSelect");
    var newsId = newsSelect.options[newsSelect.selectedIndex].value;
    var userData = 'news_id=' + newsId;
    $.ajax({
        url : "/admin/get_news",
        data : userData,
        type : "POST",
        success : function(response) {
            var obj = JSON.parse(response);
            $( "#dialog" ).dialog({ width: 800, height: 600, position: 'top' });
            $("#delete_id").val(obj.id);
            $("#edit_id").val(obj.id);
            $("#edit_title").val(obj.title);
            $("#edit_description").html(obj.description);
            $("#edit_body").html(obj.body);
            if (obj.type == 1) {
                $("#edit_is_top").prop('checked', true);
            }
            else {
                $("#edit_is_top").prop('checked', false);
            }
        },
        error : function(xhr, status, error) {
            alert("error");
        }
    });
}