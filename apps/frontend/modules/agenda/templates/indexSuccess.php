<h3>Eventos</h3>
<div class="offset3 span5" id="listaEventos">

</div>
<div class="offset3 span5" id="editarEvento" style="display: none">

</div>

<script>
    $(document).ready(function(){
        
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
                    $(value).parent().html("<input type='text' class='labelData' value='"+content+"'>");
                }
                content = $(value).val();
                if(content){
                    actualizar =true;
                    arrayData[i] = content; 
                    i++;
                }
            });
            
            if(!actualizar){
            alert("asd");
                $("#botonEditar").css("display", "none");
                $("#botonActualizar").css("display", "inline");
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
                    var content = "<div class='row well'><button id='botonEditar' class='btn btn-primary'>Crear</button></div>";
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
                
                if(data.stateCode == "404"){
                    
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
</script>
