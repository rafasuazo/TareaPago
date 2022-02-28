<h1>{{modeDsc}}</h1>
<hr>

<section class="container-m">
    <form action="index.php?page=mnt.intentopagos.intentopago&mode={{mode}}&id={{id}}" method="post">

        <input type="hidden" name="crsxToken" value="{{crsxToken}}">
        {{ifnot isInsert}}
        <fieldset class="row flex-center">
            <label for="id" class="col-5">Código</label>
            <input class="col-7" type="text" name="id" id="id" value="{{id}}" {{if isRead}} {{readonly}} {{endif isRead}}>
        </fieldset>
        {{endifnot isInsert}}

        <!--Si es verdadera, nos mostrará este campo en el formulario-->
        {{if isViewMode}}
        <fieldset class="row flex-center">
            <label for="fecha" class="col-5">Fecha</label>
            <input class="col-7" type="date" name="fecha" id="fecha" value="{{fecha}}" {{if isRead}} {{readonly}} {{endif isRead}}>
        </fieldset>
        {{endif isViewMode}}

        <fieldset class="row flex-center">
            <label for="cliente" class="col-5">Cliente</label>
            <input class="col-7" type="text" name="cliente" id="cliente" value="{{cliente}}" {{if isRead}} {{readonly}} {{endif isRead}}>
        </fieldset>

        <fieldset class="row flex-center">
            <label for="monto" class="col-5">Monto</label>
            <input class="col-7" type="text" name="monto" id="monto" value="{{monto}}" {{if isRead}} {{readonly}} {{endif isRead}}>
        </fieldset>

        <fieldset class="row flex-center">
            <label for="fechaVencimiento" class="col-5">Fecha de Vencimiento</label>
            <input class="col-7" type="date" name="fechaVencimiento" id="fechaVencimiento" value="{{fechaVencimiento}}" {{if isRead}} {{readonly}} {{endif isRead}}>
        </fieldset>

        <fieldset class="row flex-center">
            <label class="col-5" for="estado">Estado</label>
            <select class="col-7" name="estado" id="estado" {{if isRead}} {{readonly}} {{endif isRead}}>
                {{foreach estadoOpciones}}

                    <option value="{{value}}" {{selected}}>{{text}}</option>
                {{endfor estadoOpciones}}
            </select>
        </fieldset>

        <fieldset class="row flex-center">
            <button type="submit" name="btnConfirmar" class="btn primary">Confirmar</button>&nbsp;&nbsp;&nbsp;
            <button type="button" id="btnCancelar" class="btn danger">Cancelar</button>
        </fieldset>        
    </form>
</section>

<script>
    
    document.addEventListener("DOMContentLoaded", (e) => {

        let btnCancelar = document.getElementById("btnCancelar");
        btnCancelar.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=mnt.intentopagos.intentopagos");
        })
    });
</script>