<?php
    // タイムゾーンを設定
    date_default_timezone_set('Asia/Tokyo');

    // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
    if(isset($_GET['ym'])) {
        $ym = $_GET['ym'];
    } else {
        $ym = date('Y-m');
    }

    //タイムスタンプの作成
    $timestamp = strtotime($ym . '-01');

    echo $ym;
    //フォーマットのチェック
    if($timestamp === false) {
        $ym = date('Y-m');
        $timestamp = strtotime($ym . '-01');
    }

    //本日の年月日
    $today = date('Y-m-j');

    //その月の年と月
    $calendar_title = date('Y年n月', $timestamp);

    //その月に何日あるか
    $day_count = date('t', $timestamp);

    //曜日
    $youbi = date('w',mktime(0,0,0,date('m',$timestamp),1,date('Y',$timestamp)));

    //前月と翌月の年月
    $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
    $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

    //カレンダーを形成するデータ
    $weeks = [];

    //週のデータ
    $week = '';

    //第１週目：空のセルを追加
    $week .= str_repeat('<td></td>',$youbi);

    for($day=1;$day<=$day_count;$day++, $youbi++) {
        $date = $ym . '-' . $day;
        //本日かどうかの判定 本日の場合クラスを付与
        if($today == $date) {
            $week .= '<td class="today">' . $day;
        } else {
            $week .= '<td>' . $day;
        }
        $week .= '</td>';

        //週の終わりの場合
        if($youbi % 7 == 6 || $day == $day_count) {
            //月の終わりの場合
            if($day == $day_count) {
                $week .= str_repeat('<td></td>',6 - ($youbi % 7));
            }

            $weeks[] = '<tr>' . $week . '</tr>';

            //リセット
            $week = '';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHPカレンダー</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container">
            <div class="calendar_title">
                <a href="?ym=<?php echo $prev; ?>" class="prev btn btn-light">前月へ</a><?php echo $calendar_title;?><a href="?ym=<?php echo $next; ?>" class="next btn btn-light">翌月へ</a>
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>日</th>
                    <th>月</th>
                    <th>火</th>
                    <th>水</th>
                    <th>木</th>
                    <th>金</th>
                    <th>土</th>
                </tr>
                <?php
                    foreach($weeks as $week) {
                        echo $week;
                    }
                ?>
            </table>
        </div>
    </body>
</html>