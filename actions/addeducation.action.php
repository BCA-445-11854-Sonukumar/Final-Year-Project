
<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';


if($_POST){

$post=$_POST;

// echo "<pre>";
// print_r($post);



if($post['resume_id'] && $post['course'] && $post['institute'] && $post['started'] && $post['ended']){
$resumeid = array_shift($post);
$post2 = $post;
unset($post['slug']);
    $columns='';
    $values='';

   foreach($post as $index=>$value){
    $value=addslashes($value);
    $columns.=$index.',';
    $values.="'$value',";
   }

$columns.='resume_id';
$values.=$resumeid;





    try{
    
        $query = "INSERT INTO educations";
        $query.="($columns) ";
        $query.="VALUES($values)";

     
       
    // execute the query using whichever interface the Database class exposes
    if (isset($db)) {
        if (method_exists($db, 'query')) {
            $db->query($query);
        } elseif (method_exists($db, 'execute')) {
            $db->execute($query);
        } elseif (isset($db->conn) && is_object($db->conn) && method_exists($db->conn, 'query')) {
            $db->conn->query($query);
        } elseif (isset($db->connection) && is_object($db->connection) && method_exists($db->connection, 'query')) {
            $db->connection->query($query);
        } else {
            throw new Exception('Database object has no query/execute method.');
        }
    } else {
        throw new Exception('Database instance $db not found.');
    }

  $fn->setAlert('education added');
 $fn->redirect('../updateresume.php?resume='.$post2['slug']);


    }catch(Exception $error){
 $fn->setError($error->getMessage());
   $fn->redirect('../updateresume.php?resume='.$post2['slug']);
    }
   



}else{
     $fn->setError('please fill the form !');
      $fn->redirect('../updateresume.php?resume='.$post2['slug']);
    
}


}else{
     $fn->redirect('../updateresume.php?resume='.$post2['slug']);
}