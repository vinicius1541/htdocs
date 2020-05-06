<?php


// Timezone
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    $ym = date('Y-m'); //esta formatação para não dar ruim no banco pelo _POST
}

// Check formatação
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Today
$today = date('Y-m-j', time());

// Título do calendário
$calendar = strtoupper(date('M / y', $timestamp));

// Prev & next month link     | strotime('salto', formatação)
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

// Dias no mês
$day_count = date('t', $timestamp);

// transforma dia da semana extenso em numeral 1 a 7
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
//$str = date('w', $timestamp);


// Create Calendar!!
$weeks = array(); //determina o tipo da variável
$week = ''; //inicia elemento vazio                     | não sei pq assim esses dois mas foi o que consegui.

// Adiciona semanas
$week .= str_repeat('<td></td>', $str); //adiciona célula em branco até começar a semana

for ($day = 1; $day <= $day_count; $day++, $str++) {  // adiciona datas com formato ano-mes-dia

    $date = $ym . '-' . $day;

    if ($today == $date) {  //verifica se é o dia atual e se for, marca em amarelo
        $week .= '<td class="today"><h6 class="diatabela">' . $day .'</h6>';
    } else {
        $week .= '<td><h6 class="diatabela">' . $day . '</h6>';
    }
    $week .= '</td>';

    // verifica fim da semana ou dos dias do mês corrente
    if ($str % 7 == 6 || $day == $day_count) {  //chegando no sábado começa nova linha

        if ($day == $day_count) {
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }

        $weeks[] = '<tr>' . $week . '</tr>'; //quebra em nova linha

        // nova linha de semana se não acabou o mês
        $week = '';
    } 
} ?>
<h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <a href="?ym=<?php echo $today; ?>"><?php echo $calendar; ?></a> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
<table class="table table-dark table-bordered">
    <tr>
        <th>Dom</th>
        <th>Seg</th>
        <th>Ter</th>
        <th>Qua</th>
        <th>Qui</th>
        <th>Sex</th>
        <th>Sab</th>
    </tr>
    <?php
    foreach ($weeks as $week) {
        echo $week;
    }
    ?>
</table>


<?php
/*

use App\Controller\ControllerConsulta;

$cons = new ControllerConsulta();
$curentMonth = $cons->monthPT_BR();
?>

<table class="table table-bordered table-dark calendar">

    <td class="table-default tab_btn"><?php echo $cons->prev(); ?></td>
    <td colspan="5" class="bg-info "><?php echo $curentMonth; ?></th>
    <td class="table-default tab_btn">></td>
    <tr class="table-active">
        <th>DOM</th>
        <th>SEG</th>
        <th>TER</th>
        <th>QUA</th>
        <th>QUI</th>
        <th>SEX</th>
        <th>SÁB</th>

    </tr>
    <tr>
        <td>
            <h6 class='diatabela'></h6>teste
        </td>
        <td>
            <h6 class='diatabela'></h6>teste
        </td>
        <td>
            <h6 class='diatabela'>1</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>2</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>3</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>4</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>5</h6>teste
        </td>
    </tr>
    <tr>
        <td>
            <h6 class='diatabela'>6</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>7</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>8</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>9</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>10</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>11</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>12</h6>teste
        </td>
    </tr>
    <tr>
        <td>
            <h6 class='diatabela'>13</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>14</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>15</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>16</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>17</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>18</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>19</h6>teste
        </td>
    </tr>
    <tr>
        <td>
            <h6 class='diatabela'>20</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>21</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>22</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>23</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>24</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>25</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>26</h6>teste
        </td>
    </tr>
    <tr>
        <td>
            <h6 class='diatabela today'>27</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>28</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>29</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>30</h6>teste
        </td>
        <td>
            <h6 class='diatabela'>31</h6>teste
        </td>
        <td>
            <h6 class='diatabela'></h6>teste
        </td>
        <td>
            <h6 class='diatabela'><?php echo $cons->buscaLastDay();?></h6>teste
        </td>
    </tr>
</table>*/
