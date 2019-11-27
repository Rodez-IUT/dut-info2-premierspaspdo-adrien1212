<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>all users </title>
	</head>
	<body>
	
	<?php
		$host = 'localhost';
		$db   = 'my_activities';
		$user = 'root';
		$pass = 'root';
		$charset = 'utf8mb4';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		try {
			 $pdo = new PDO($dsn, $user, $pass, $options);
		} catch (PDOException $e) {
			 throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
	?>
	
	<form action="all_users.php" method="post">
	  <div>
		<label for="name">Entrer la premiere lettre : </label>
		<input type="text" name="name" id="name">
	  </div>
	  <div>
		<label for="email">Selectionner status </label>
		<select name="status">
			<option value="1">Waiting for account validation</option>
			<option value="2">Active account</option>
			<option value="3">Waiting for account deletion</option>
		</select>
	  </div>
	  <div class="form-example">
		<input type="submit" value="ok">
	  </div>
	</form>
	
	<?php
		$leNom = $_POST['name'] . "%";
		$leStatus = $_POST['status'];
	?>

	<?php
		$stmt = $pdo->prepare("SELECT users.id as user_id, username, email, name 
		                     FROM users 
							 JOIN status 
							 ON users.status_id = status.id 
							 WHERE username LIKE ?
							 AND status.id = ?
							 
							 ORDER BY username");

		$stmt->execute([$leNom, $leStatus]);
	?>
		<table>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Email</th>
				<th>Status</th>
			</tr>
			
			<?php 
				while ($row = $stmt->fetch()) {
					echo "<tr>";
					echo "<td> $row[user_id]</td>";
					echo "<td> $row[username]</td>";
					echo "<td> $row[email] </td>";
					echo "<td> $row[name] </td>";
					if($_POST['status'] != 3) {
						echo "<td><a href=\"all_users.php?status_id=3&user_id=$leNom&action=askDeletion\">Ask Deletion</a></td>";
					}
					
					echo "</tr>";
				}
			?>
		</table>
		
	</body>
</html> 