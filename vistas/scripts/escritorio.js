function init(){


    $.post(
        "../ajax/noticias.php?op=listarParaBlog",function(r){
            $("#blogSection").html(r);
        })

}