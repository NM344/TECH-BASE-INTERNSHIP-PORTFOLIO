<?php
	$dsn='データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS mission4_1"
." ("
. "id INT auto_increment primary key,"
. "name char(32),"
. "comment TEXT,"
. "date DATETIME,"
. "password char(32)"
.");";
$stmt = $pdo->query($sql);


if(!empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['password_post']) and empty($_POST['edit_number'])){
	$name = $_POST['name'];
	$comment = $_POST['comment'];
	$password_post = $_POST['password_post'];
	$date=date("Y/m/d H:i:s");
	$sql = $pdo -> prepare("INSERT INTO mission4_1 (id,name,comment,date,password) VALUES ('',:name,:comment,:date,:password)");
	$sql -> bindParam(':name',$name,PDO::PARAM_STR);
	$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql -> bindParam(':date',$date,PDO::PARAM_STR);
	$sql -> bindParam(':password',$password_post,PDO::PARAM_STR);
	$sql -> execute();
}

if(!empty($_POST['delete']) and !empty($_POST['password_delete'])){
	$delete = $_POST['delete'];
	$password_delete = $_POST['password_delete'];
	$sql = 'SELECT * FROM mission4_1'; 
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		if($row['id'] == $delete and $row['password'] == $password_delete){
			$sql = 'delete from mission4_1 where id=:id';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':id', $delete, PDO::PARAM_INT);
			$stmt->execute();
		}
	}
}

if(!empty($_POST['edit']) and !empty($_POST['password_edit'])){
	$edit = $_POST['edit'];
	$password_edit = $_POST['password_edit'];
	$sql = 'SELECT * FROM mission4_1'; 
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach($results as $row){
		if($row['id'] == $edit and $row['password'] == $password_edit){
		$value_number = $row['id'];
		$value_name = $row['name'];
		$value_comment = $row['comment'];
		}
	}
}

if(!empty($_POST['edit_number']) and !empty($_POST['name']) and !empty($_POST['comment'])){
$edit_number = $_POST['edit_number'];
$name_2 = $_POST['name'];
$comment_2 = $_POST['comment'];
$date=date("Y/m/d H:i:s");
$sql = 'SELECT * FROM mission4_1'; 
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
	foreach($results as $row){
		if($row['id'] == $edit_number){
		$id = $edit_number;
		$sql = 'update mission4_1 set name=:name,comment=:comment,date=:date where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name', $name_2, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment_2, PDO::PARAM_STR);
		$stmt->bindParam(':date', $date, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		}
	}
}
?>


<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_4-1</title>
	</head>
	
	<body>
		<form method="post" action="mission_4-1.php" >
			<label>名前</label><br>
			<input type="text"  name="name" placeholder="名前" value="<?php echo $value_name ?>"><br>
			<label>コメント</label><br>
			<input type="text"  name="comment" placeholder="コメント" value="<?php echo $value_comment ?>"><br>
			<label>パスワード</label><br>
			<input type="hidden"  name="edit_number" value="<?php echo $value_number ?>">
			<input type="text" name="password_post" placeholder="パスワード">
 			<input type="submit" value="送信"><br>
			<label>削除対象番号</label><br>
			<input type="text"  name="delete" placeholder="削除対象番号"><br>
			<input type="text" name="password_delete" placeholder="パスワード">
			<input type="submit" value="削除"><br>
			<label>編集対象番号</label><br>
			<input type="text"  name="edit" placeholder="編集対象番号"><br>
			<input type="text" name="password_edit" placeholder="パスワード">
			<input type="submit" value="編集"><br>
		</form>
	</body>
</html>

<?php
$sql = 'SELECT id,name,comment,date FROM mission4_1 order by id asc';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].',';
echo $row['date'].'<br>';
}
?>