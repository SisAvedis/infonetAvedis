var tabla;
var idcategoria;
//Funcion que se ejecuta al inicio
function init()
{
    mostrarform(false);
    listar();

    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    })

    //Cargamos los items al select categoria
   
	
    $("#imagenmuestra").hide();
}

//funcion limpiar
function limpiar()
{
    $("#codigo").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#cantidad").val("");
    $("#idcategoria").val("");
    $("#idcategoria").selectpicker('refresh');
    $("#idsubcategoria").val("");
    $("#idsubcategoria").selectpicker('refresh');
    $("#idunidad").val("1");
    $("#idunidad").selectpicker('refresh');

    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");

    $("#print").hide();

    $("#idarticulo").val("");

}

//funcion mostrar formulario
function mostrarform(flag)
{
    limpiar();

    if(flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
		//obtenersubcategorias(idcategoria);
	}
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").hide();
    }
}

//Funcion cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
    location.reload();
}



//Funcion listar
function listar()
{
    tabla = $('#tblistado')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
                "ajax":{
                    url: '../ajax/maestroInternos.php?op=listar',
                    type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();
}

//funcion para guardar o editar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    
    $.ajax({
        url: "../ajax/maestroInternos.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {
            //console.log("succes");
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();

        },
        error: function(error)
        {
            console.log("error: " + error);
        } 
    });

    limpiar();
}

function mostrar(numero)
{
    mostrarform(true);
	
	$.post(
        "../ajax/maestroInternos.php?op=mostrar",
        {numero:numero},
        function(data,status)
        {
            data = JSON.parse(data);
            

         
            $("#nombre").val(data.nombre);
            $("#numero").val(data.numero);
            $("#sector").val(data.sector);
           
          

        }
    );
	
	
}


//funcion para descativar articulo
function desactivar(numero)
{
    bootbox.confirm("¿Estas seguro de desactivar el Interno?",function(result){
        if(result)
        {
            $.post(
                "../ajax/maestroInternos.php?op=desactivar",
                {numero:numero},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });
}

function activar(numero)
{
    bootbox.confirm("¿Estas seguro de activar el Interno?",function(result){
        if(result)
        {
            $.post(
                "../ajax/maestroInternos.php?op=activar",
                {numero:numero},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });
}

function generarbarcode()
{
    var codigo = $("#codigo").val();
    if (codigo !== ''){
		JsBarcode("#barcode",codigo, {format: "CODE128",ean128: true});
		$("#print").show();
	}
}

function imprimir()
{
    $("#print").printArea();
}

function obtenersubcategorias(idcategoria)
{
	//Cargamos los items al select Subcategoria
	$.post(
		"../ajax/subcategoria.php?op=selectSubCategorias",
		{idcategoria:idcategoria},
		function (data) 
		{
			$("#idsubcategoria").html(data);
			$('#idsubcategoria').selectpicker('refresh');
		}
	)
}

init();

$('#idcategoria').on('change', function() {
	idcategoria = $(this).val();
	
	//Cargamos los items al select subcategoria
	$.post(
		"../ajax/subcategoria.php?op=selectSubCategorias&idcategoria="+idcategoria,
		function (r) 
		{
			$("#idsubcategoria").html(r);
			$('#idsubcategoria').prop('selectedIndex', 0);
			idsubcategoria = $('select[name=idsubcategoria] option').filter(':selected').val();
			$('#idsubcategoria').selectpicker('refresh');
		}
	)
	
});

$('#idarticulo').on('change', function() {
	idarticulo = $(this).val();
});