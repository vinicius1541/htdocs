<?php use App\Controller\ControllerConsulta;
            $cons = new ControllerConsulta();
?>

<table class="table table-bordered table-dark calendar">

    <td class="table-default tab_btn"><</td>
    <td colspan="3" class="bg-info "><?php echo $cons->monthPT_BR(); ?></th>
    <td class="table-default tab_btn">></td>
        <tr class="table-active">
            <th>SEGUNDA</th>
            <th>TERÇA</th>
            <th>QUARTA</th>
            <th>QUINTA</th>
            <th>SEXTA</th>
        </tr>
        <tr>
            <td>teste</td>
            <td>teste</td>
            <td>teste</td>
            <td>teste</td>
            <td>teste</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
</table>