<?php

session_start();

//1.外部ファイル読み込み＆DB接続
//※htdocsと同じ階層に「includes」を作成してfuncs.phpを入れましょう！
include("funcs.php");
sessChk();
$pdo = db_con();


//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("**********:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .= '<p>';
    $view .= '<a href="user_update_view.php?id='.$result["id"].'">';
    $view .= $result["name"] . "," . $result["lid"];
    $view .= '</a>';
    $view .= '　';//削除ボタンとのスペース用
    $view .= '<a href="delete_user.php?id='.$result["id"].'">';
    $view .= '[ 削除 ]';
    $view .= '</p>';

    // $view .='<tr><td>'.$res["id"].'</td><td>'.$res["name"].'</td><td>'.$res["url"].'</td><td>'.$res["naiyou"].'</td><td>'.$res["indate"].'<br>'.'</td></tr>'; // .=はjsでいう+=　代入ではなく、追加となる

  }
// '<tr><td>'$res["id"]."</td><td>".$res["name"]."<br>"</td></tr>"; ","
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User一覧表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index_user.php">User登録画面へ</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
<!-- テーブルの場合はdiv → tableに変更する -->
    <div class="container jumbotron">
    <?php echo $view; ?>
    </div>
    <!-- <table>タグを入れる</table> -->
</div>
<!-- Main[End] -->

</body>
</html>
