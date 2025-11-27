<?php
include 'includes/connection.php';
$res = mysqli_query($conn, "SELECT id,name,email,approved FROM alumni ORDER BY id DESC");
echo "<pre>";
while($r = mysqli_fetch_assoc($res)){
  echo "id={$r['id']}  name={$r['name']}  email={$r['email']}  approved={$r['approved']}\n";
}
echo "</pre>";