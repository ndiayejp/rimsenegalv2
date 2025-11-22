$(function() {
    $('.deleteRecord').on('click',function(e){
        e.preventDefault(); 
        id = $(this).data("id")
        const token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
             url: "/propertyImage/"+id,
             type:"DELETE",
             data: {
                "id": id,
                "_token": token,
            },
            success: function (e){
                 console.log(e)
            }
        })
    })
});