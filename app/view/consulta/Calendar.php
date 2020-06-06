<?php
// Timezone
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
    if(empty($ym)){
        header('Location: ' . DIRPAGE . 'consulta?ym=' . date('Y-m'));
    }
} else {
    $ym = date('Y-m'); //esta formatação para não dar ruim no banco pelo _POST
    header('Location: ' . DIRPAGE . 'consulta?ym=' . $ym);

}

// Check formatação
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Today
$today = date('Y-m-j', time());
$todayExplode = explode("-", rtrim($today),FILTER_SANITIZE_URL);
if($todayExplode[2]<10){
    $todayExplode[2] = '0'.$todayExplode[2];
    $today = $todayExplode[0]. '-'. $todayExplode[1].'-'.$todayExplode[2];
}
// Título do calendário
$calendar = strtoupper(date('M / Y', $timestamp));

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

// Adiciona semanas                |           os <h6> fazem os dias ficarem no canto superior esq
$week .= str_repeat('<td></td>', $str); //adiciona célula em branco até começar a semana

$dateArray = explode("-", rtrim($ym), FILTER_SANITIZE_URL); #serve para quebrar o texto em array usando o delimitador '-'
$contArray=count($dateArray);
if($contArray==1){
    header('Location: ' . DIRPAGE . 'consulta?ym=' . date('Y-m'));
}
$implodeArray = $dateArray[0].'-'.$dateArray[1];
for ($day = 1; $day <= $day_count; $day++, $str++) {  // adiciona datas com formato ano-mes-dia
    if($day < 10){
        $day='0'.$day;
    }
    if($contArray==3){
        $dateAtual = $implodeArray . '-' . $day;
    }else{
        $date = $ym;
        $dateAtual=$ym . '-' . $day;
    }
    if ($today == $dateAtual) {  //verifica se é o dia atual e se for, marca em amarelo
        $week .= '<td class="today"><a style="text-decoration: none;color: inherit" href="' . DIRPAGE . "consulta/cadastro/" . $implodeArray . '-' . $day. '"><h6 class="diatabela">' . $day . '</h6></a>';
    } else {
        $week .= '<td><a style="text-decoration: none; color: inherit" href="' . DIRPAGE . "consulta/cadastro/" . $implodeArray . '-' . $day. '"><h6 class="diatabela">' . $day . '</h6></a>';
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
<h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <a href="?ym=<?php echo date('M / Y'); ?>"><?php echo $calendar; ?></a> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
<table class="table table-dark table-bordered">
    <tr>
        <th><div type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Some tooltip text!">Dom</div></th>
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
