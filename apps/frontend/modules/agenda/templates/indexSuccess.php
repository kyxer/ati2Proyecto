<h3>Eventos</h3>
<div class="offset2 span8" id="listaEventos">

</div>
<div class="offset3 span5" id="editarEvento" style="display: none">

</div>

<script>
    $(document).ready(function(){
        //Funcion que carga el inicio buscando los enventos que existen
        init();

        $("#formEditar").live("submit", function(event){
            event.preventDefault();
            var data = $(".labelData");
            var actualizar = false;
            var arrayData = new Array();
            var i = 0;
            $.each(data, function(key, value){
                var content = $(value).html();
                if(content){
                    if(i==1){
                        var clase="fecha";
                    }else{
                        var clase="";
                    }
                    i++;
                    $(value).parent().html("<input type='text' class='labelData "+clase+"' value='"+content+"'>");
                }
                content = $(value).val();
                if(content){
                    actualizar =true;
                    arrayData[i] = content; 
                    i++;
                }
            });

            if(!actualizar){
                $("#botonEditar").css("display", "none");
                $("#botonActualizar").css("display", "inline");
                $(".fecha").datepicker({dateFormat: 'yy-mm-dd',showOtherMonths: true,
                    selectOtherMonths: true});

            }else{

                $.ajax({
                    url: "http://ati2proyecto/api.php/agenda/actualizar",
                    dataType: "json",
                    data: {"nombre": arrayData[0], "fecha": arrayData[1], "id": $("#labelId").html()},
                    success: function(data) {

                        if(data.stateCode =="200"){

                            alert("Actualizado Con exito");
                            $("#listaEventos").css("display", "block");
                            $("#editarEvento").css("display", "none");
                            init();
                        }

                        if(data.stateCode == "404"){

                        }

                    },
                    error: function(){
                        alert("ERROR");
                    }
                });

            }
        });

        $("#formCrear").live("submit", function(event){
            event.preventDefault();
            var nombre = $("#nombreEvento").val();
            var fecha = $("#fechaEvento").val();

            $.ajax({
                url: "http://ati2proyecto/api.php/agenda/crear",
                dataType: "json",
                data: {"nombre": nombre, "fecha": fecha},
                success: function(data) {

                    if(data.stateCode =="200"){

                        alert("Evento Creado con exito Con exito");
                        $("#listaEventos").css("display", "block");
                        $("#editarEvento").css("display", "none");
                        init();
                    }

                    if(data.stateCode == "404"){

                    }

                },
                error: function(){
                    alert("ERROR");
                }
            });


        });
    });

    function getEvento(id){

        $.ajax({
            url: "http://ati2proyecto/api.php/agenda/editar",
            dataType: "json",
            data: {"id": id},
            success: function(data) {

                if(data.stateCode =="200"){
                    $("#listaEventos").css("display", "none");


                    var content = "<form id='formEditar' action='agenda/actualizar' class='form-horizontal'><fieldset>";
                    content += "<legend>Editar Evento</legend>";
                    content += "<div class='control-group'><label class='control-label'>Nombre</label>";
                    content += "<label class='control-label' id='labelId' style='display:none'>"+data.id+"</label><div class='controls'>"
                    content += "<label class='control-label labelData'>"+data.nombre+"</label></div></div>";
                    content += "<div class='control-group'><label class='control-label'>Fecha</label><div class='controls'>";
                    content += "<label class='control-label labelData' >"+data.fecha+"</label></div></div>";
                    content += "<div class='form-actions'><button id='botonEditar' class='btn btn-primary'>Editar</button>";
                    content += "<button id='botonActualizar' style='display:none' class='btn btn-primary'>Actualizar</button>";
                    content += "<input type='button' class='btn' onclick='ocultarEditar()' value='Atras' /></div></fieldset></form>";
                    $("#editarEvento").html(content);
                    $("#editarEvento").css("display", "block");
                }

                if(data.stateCode == "404"){
                    alert("Error");
                }

            },
            error: function(){
                alert("ERROR");
            }
        });

    }

    function ocultarEditar(){
        $("#editarEvento").css("display", "none");
        $("#listaEventos").css("display", "block");

    }

    function init(){
        $.ajax({
            url: "http://ati2proyecto/api.php/agenda/listar",
            dataType: "json",
            success: function(data) {

                if(data.stateCode =="200"){
                    var content = "<div class='row well'><button id='botonCrear' onClick='crearEvento()' class='btn btn-primary'>Crear</button>";
                    content += "<button id='botonDia' onClick='eventosDia()' class='btn btn-info'>Eventos Del Dia</button>";
                    content += "<button id='botonSemana' onClick='eventosSemana()' class='btn btn-success'>Eventos De la Semana</button>";
                    content += "<button id='botonSiete' onClick='eventosSiete()' class='btn btn-warning'>Eventos 7 dias</button>";
                    content += "<button id='botonMes' onClick='eventosMes()' class='btn btn-danger'>Eventos Mes</button></div>";
                    content += "<table class='table table-striped'>";
                    content += "<thead><tr>";
                    content += "<th>#</th>";
                    content += "<th>Nombre</th>";
                    content += "<th>Fecha</th><th></th>";
                    content +="</tr></thead><tbody>";
                    $.each(data.eventos, function(key, value){
                        //alert(key + "  "+ value.nombre);
                        content += "<tr><td>"+key+"</td>";
                        content += "<td><a onclick='getEvento(\""+value.id+"\")'>"+value.nombre+"</a></td>";
                        content += "<td>"+value.fecha+"</td>";
                        content += "<td><a onclick='eliminarEvento(this, \""+value.id+"\" )'>Eliminar</a></td></tr>";
                    });
                    content +="</tbody></table>";

                    $("#listaEventos").html(content);
                }
                
               

                if(data.stateCode == "201"){
                    var content = "<div class='row well'><button id='botonCrear' onClick='crearEvento()' class='btn btn-primary'>Crear</button>";
                    content += "<button id='botonDia' onClick='eventosDia()' class='btn btn-info'>Eventos Del Dia</button>";
                    content += "<button id='botonSemana' onClick='eventosSemana()' class='btn btn-success'>Eventos De la Semana</button>";
                    content += "<button id='botonSiete' onClick='eventosSiete()' class='btn btn-warning'>Eventos 7 dias</button>";
                    content += "<button id='botonMes' onClick='eventosMes()' class='btn btn-danger'>Eventos Mes</button></div>";
                     $("#listaEventos").html(content);
                }

            },
            error: function(){
                alert("ERROR");
            }
        });
    }

    function eliminarEvento(element, id){
        if (confirm("Esta seguro de eliminar el evento?")){
            $.ajax({
                url: "http://ati2proyecto/api.php/agenda/eliminar",
                dataType: "json",
                data: {"id": id},
                success: function(data) {

                    if(data.stateCode =="200"){
                        $(element).parent().parent().remove();
                    }

                    if(data.stateCode == "404"){
                        alert("El elemento no existe");
                    }

                },
                error: function(){
                    alert("ERROR");
                }
            });

        }
    }

    function crearEvento(){
        $("#listaEventos").css("display", "none");

        var content = "<form id='formCrear' action='agenda/crear' class='form-horizontal'><fieldset>";
        content += "<legend>Crear Evento</legend>";
        content += "<div class='control-group'><label class='control-label'>Nombre</label>";
        content += "<div class='controls'>";
        content += "<input  id='nombreEvento' type='text' /></div></div>";
        content += "<div class='control-group'><label class='control-label'>Fecha</label><div class='controls'>";
        content += "<input  type='text' class='fecha' id='fechaEvento' /></div></div>";
        content += "<div class='form-actions'><button id='botonEditar' class='btn btn-primary'>Crear</button>";
        content += "<input type='button' class='btn' onclick='ocultarEditar()' value='Atras' /></div></fieldset></form>";
        $("#editarEvento").html(content);
        $(".fecha").datepicker({dateFormat: 'yy-mm-dd',showOtherMonths: true,
            selectOtherMonths: true});
        $("#editarEvento").css("display", "block");

    }

    function eventosDia(){
        $.ajax({
            url: "http://ati2proyecto/api.php/agenda/dia",
            dataType: "json",
            success: function(data) {

                if(data.stateCode =="200"){

                    var content = "<table class='table table-striped'>";
                    content += "<thead><tr>";
                    content += "<th>#</th>";
                    content += "<th>Nombre</th>";
                    content += "<th>Fecha</th><th></th>";
                    content +="</tr></thead><tbody>";
                    $.each(data.eventosDia, function(key, value){
                        //alert(key + "  "+ value.nombre);
                        content += "<tr><td>"+key+"</td>";
                        content += "<td><a onclick='getEvento(\""+value.id+"\")'>"+value.nombre+"</a></td>";
                        content += "<td>"+value.fecha+"</td>";
                        content += "<td><a onclick='eliminarEvento(this, \""+value.id+"\" )'>Eliminar</a></td></tr>";
                    });
                    content +="</tbody></table>";
                    content += "<br><input type='button' class='btn' onclick='ocultarEditar()' value='Atras' />";
                    $("#editarEvento").html(content);
                    $("#listaEventos").css("display","none");
                    $("#editarEvento").css("display","block");
                }

                if(data.stateCode=="201"){
                    var content = "<h3>No hay Eventos disponibles para la fecha "+data.fecha+"</h3>"
                    content += "<br><input type='button' class='btn' onclick='ocultarEditar()' value='Atras' />";
                    $("#editarEvento").html(content);
                    $("#listaEventos").css("display","none");
                    $("#editarEvento").css("display","block");

                }

                if(data.stateCode == "404"){
                    alert("No encontrado");
                }

            },
            error: function(){
                alert("ERROR");
            }
        });

    }

    function eventosSemana(){
        $.ajax({
            url: "http://ati2proyecto/api.php/agenda/semana",
            dataType: "json",
            success: function(data) {

                if(data.stateCode =="200"){

                    var content = "<table class='table table-striped'>";
                    content += "<thead><tr>";
                    content += "<th>#</th>";
                    content += "<th>Nombre</th>";
                    content += "<th>Fecha</th><th></th>";
                    content +="</tr></thead><tbody>";
                    $.each(data.eventosSemana, function(key, value){
                        //alert(key + "  "+ value.nombre);
                        content += "<tr><td>"+key+"</td>";
                        content += "<td><a onclick='getEvento(\""+value.id+"\")'>"+value.nombre+"</a></td>";
                        content += "<td>"+value.fecha+"</td>";
                        content += "<td><a onclick='eliminarEvento(this, \""+value.id+"\" )'>Eliminar</a></td></tr>";
                    });
                    content +="</tbody></table>";
                    content += "<br><input type='button' class='btn' onclick='ocultarEditar()' value='Atras' />";
                    $("#editarEvento").html(content);
                    $("#listaEventos").css("display","none");
                    $("#editarEvento").css("display","block");
                }

                if(data.stateCode=="201"){
                    var content = "<h3>No hay Eventos disponibles para la semana "+data.fecha+"</h3>"
                    content += "<br><input type='button' class='btn' onclick='ocultarEditar()' value='Atras' />";
                    $("#editarEvento").html(content);
                    $("#listaEventos").css("display","none");
                    $("#editarEvento").css("display","block");

                }

                if(data.stateCode == "404"){
                    alert("No encontrado");
                }

            },
            error: function(){
                alert("ERROR");
            }
        });

    }

    function eventosSiete(){
        $.ajax({
            url: "http://ati2proyecto/api.php/agenda/siete",
            dataType: "json",
            success: function(data) {

                if(data.stateCode =="200"){

                    var content = "<table class='table table-striped'>";
                    content += "<thead><tr>";
                    content += "<th>#</th>";
                    content += "<th>Nombre</th>";
                    content += "<th>Fecha</th><th></th>";
                    content +="</tr></thead><tbody>";
                    $.each(data.eventosSiete, function(key, value){
                        //alert(key + "  "+ value.nombre);
                        content += "<tr><td>"+key+"</td>";
                        content += "<td><a onclick='getEvento(\""+value.id+"\")'>"+value.nombre+"</a></td>";
                        content += "<td>"+value.fecha+"</td>";
                        content += "<td><a onclick='eliminarEvento(this, \""+value.id+"\" )'>Eliminar</a></td></tr>";
                    });
                    content +="</tbody></table>";
                    content += "<br><input type='button' class='btn' onclick='ocultarEditar()' value='Atras' />";
                    $("#editarEvento").html(content);
                    $("#listaEventos").css("display","none");
                    $("#editarEvento").css("display","block");
                }

                if(data.stateCode=="201"){
                    var content = "<h3>No hay Eventos disponibles para dentro de Siete dias</h3>"
                    content += "<br><input type='button' class='btn' onclick='ocultarEditar()' value='Atras' />";
                    $("#editarEvento").html(content);
                    $("#listaEventos").css("display","none");
                    $("#editarEvento").css("display","block");

                }

                if(data.stateCode == "404"){
                    alert("No encontrado");
                }

            },
            error: function(){
                alert("ERROR");
            }
        });

    }

    function eventosMes(){
        $.ajax({
            url: "http://ati2proyecto/api.php/agenda/mes",
            dataType: "json",
            success: function(data) {

                if(data.stateCode =="200"){

                    var content = "<table class='table table-striped'>";
                    content += "<thead><tr>";
                    content += "<th>#</th>";
                    content += "<th>Nombre</th>";
                    content += "<th>Fecha</th><th></th>";
                    content +="</tr></thead><tbody>";
                    $.each(data.eventosMes, function(key, value){
                        //alert(key + "  "+ value.nombre);
                        content += "<tr><td>"+key+"</td>";
                        content += "<td><a onclick='getEvento(\""+value.id+"\")'>"+value.nombre+"</a></td>";
                        content += "<td>"+value.fecha+"</td>";
                        content += "<td><a onclick='eliminarEvento(this, \""+value.id+"\" )'>Eliminar</a></td></tr>";
                    });
                    content +="</tbody></table>";
                    content += "<br><input type='button' class='btn' onclick='ocultarEditar()' value='Atras' />";
                    $("#editarEvento").html(content);
                    $("#listaEventos").css("display","none");
                    $("#editarEvento").css("display","block");
                }

                if(data.stateCode=="201"){
                    var content = "<h3>No hay Eventos disponibles para este mes</h3>"
                    content += "<br><input type='button' class='btn' onclick='ocultarEditar()' value='Atras' />";
                    $("#editarEvento").html(content);
                    $("#listaEventos").css("display","none");
                    $("#editarEvento").css("display","block");

                }

                if(data.stateCode == "404"){
                    alert("No encontrado");
                }

            },
            error: function(){
                alert("ERROR");
            }
        });

    }
</script>
