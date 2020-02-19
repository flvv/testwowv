<?php 
#ini_set('error_reporting', E_ALL);
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
include 'config/db.php';  

# Добавление новой Роли
 	if (isset($_POST['user_role'])) {
	    try{
	        $queryNewRole = "INSERT INTO user_role SET rolename=:user_role";
	        $stmt = $connection->prepare($queryNewRole);

	        $name=htmlspecialchars(strip_tags($_POST['user_role']));
	        $stmt->bindParam(':user_role', $name);

	        if($stmt->execute()){
	            echo "Роль: " . $name . " Добавлена! ";
	        } else {
	            echo "Ошибка записи";
	        }
	        
	    }
	    
	    catch(PDOException $exception){
	        die('ERROR: ' . $exception->getMessage());
	    }

 	}
# Добавление нового Пользователя
 	if (isset($_POST['user']) && isset($_POST['role']) ) {
	    try{
	     
	        $queryUserRole = "INSERT INTO user SET username=:user, role_id=:role";
	        $stmt = $connection->prepare($queryUserRole);
	 
	        $nameUser=htmlspecialchars(strip_tags($_POST['user']));
	        $roleUser=htmlspecialchars(strip_tags($_POST['role']));

	        $stmt->bindParam(':user', $nameUser);
	        $stmt->bindParam(':role', $roleUser);

	        if($stmt->execute()){
	            echo " Добавлено! ";
	        } else {
	            echo "Ошибка записи";
	        }

	    }
	     
	    catch(PDOException $exception){
	        die('ERROR: ' . $exception->getMessage());
	    }
 		
 	}

# Чтение из базы
$queryRead = "SELECT username, rolename FROM user u LEFT JOIN user_role ur ON u.role_id = ur.id;";
$stmt = $connection->prepare($queryRead);
$stmt->execute();

$num = $stmt->rowCount();
if($num>0){

	echo "<table>";
    echo "<tr>";
        echo "<th>Имя</th>";
        echo "<th>Роль</th>";
    echo "</tr>";

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	    $data = $stmt->fetchAll();
	   // var_dump($data);
	    foreach( $data as $task )
	        {
	        	echo '<tr>
	                <td> '. $task['username'] .' </td>
	                <td> '. $task['rolename'] .' </td>
	            </tr>';
	        }
	} 

	echo "</table>"; 

} else { 
	echo "Записи не найдены."; 
}

#Вывод списка
$stmtList = $connection->prepare('select rolename, id From user_role;');
$stmtList->execute();
$dataSelectList = $stmtList->fetchAll();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>test task - crud</title>
	<meta name="description" contents="">
	<meta name="author" content="github:flvv">
</head>
<body>
	<div class="main">
		
        <div class="stage_two">
		    
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <table>
                    <tr>
                        <td>Добавить роль</td>
                        <td><input type='text' name='user_role' /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Сохранить' />
                        </td>
                    </tr>
                </table>
            </form>
		    
		</div>

		<div class="stage_three">
			
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <table>
                    <tr>
                        <td>Пользователь</td>
                        <td><input type='text' name='user' /></td>
                    </tr>
                    <tr>
                        <td>Роль</td>
                        <td>
						<select name="role">
						<?php foreach ($dataSelectList as $rowListSelect){ 
						  echo '<option value="'.$rowListSelect["id"].'">'.$rowListSelect["rolename"].'</option>';
						}
						?>
						</select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Сохранить' />
                            
                        </td>
                    </tr>
                </table>
            </form>

		</div>
		
	</div>
</body>
