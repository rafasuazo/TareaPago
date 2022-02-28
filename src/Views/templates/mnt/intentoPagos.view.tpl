<h1>Pagos</h1>
<hr>
<table>
    <thead>
        <tr>
            <td>Código</td>
            <td>Fecha</td>
            <td>Cliente</td>
            <td>Monto</td>
            <td>Vence</td>
            <td>Estado</td>
            <td><a href="index.php?page=mnt.intentopagos.intentopago&mode=INS&id=0">Nuevo</a></td>
        </tr>
    </thead>
    <tbody>
        {{foreach pagos}}
        <tr>
            <td>{{id}}</td>
            <td>{{fecha}} &nbsp;&nbsp;&nbsp;</td>
            <td>
                <a href="index.php?page=mnt.intentopagos.intentopago&mode=DSP&id={{id}}">{{cliente}}</a>
                &nbsp;&nbsp;&nbsp;
            </td>
            <td>{{monto}} &nbsp;&nbsp;&nbsp;</td>
            <td>{{fechaVencimiento}} &nbsp;&nbsp;&nbsp;</td>
            <td>{{estado}}</td>
            <td>
                <a href="index.php?page=mnt.intentopagos.intentopago&mode=UPD&id={{id}}">Editar</a>&nbsp;&nbsp;
                <a href="index.php?page=mnt.intentopagos.intentopago&mode=DEL&id={{id}}">Eliminar</a>
            </td>
        </tr>
        {{endfor pagos}}
    </tbody>
</table>