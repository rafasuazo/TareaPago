<h1>{{modeDsc}}</h1>
<hr>

<section class="container-m">
    <form action="index.php?page=mnt.categorias.categoria&mode={{mode}}&catid={{catid}}" method="post">

        <input type="hidden" name="crsxToken" value="{{crsxToken}}">
        {{ifnot isInsert}}
        <fieldset class="row flex-center">
            <label for="catid" class="col-5">Código</label>
            <input class="col-7" type="text" name="catid" id="catid" value="{{catid}}" placeholder="" >
        </fieldset>
        {{endifnot isInsert}}

        <fieldset class="row flex-center">
            <label for="catnom" class="col-5">Categoría</label>
            <input class="col-7" type="text" name="catnom" id="catnom" value="{{catnom}}" placeholder="" >
        </fieldset>

        <fieldset class="row flex-center">
            <label class="col-5" for="catest">Estado</label>
            <select class="col-7" name="catest" id="catest">
                {{foreach catestOptions}}

                    <option value="{{value}}" {{selected}}>{{text}}</option>
                {{endfor catestOptions}}
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
            window.location.assign("index.php?page=mnt.categorias.categorias");
        })
    });
</script>