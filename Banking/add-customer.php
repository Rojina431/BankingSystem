<?php
 session_start();
  require 'top.php';
  require 'pdo.php';
 
  if(isset($_POST['submit'])){
   $filename=$_FILES['profile']['name'];
   $tempname=$_FILES['profile']['tmp_name'];
   $image="images/product".$filename;
   move_uploaded_file($tempname,$image);
     $name=$_POST['name'];
     $accountNo=$_POST['accountNo'];
     $balance=$_POST['balance'];
     $email=$_POST['email']; 
     
     //check whether all field are filled or not
      if(strlen($name)<1||$image==""||strlen($accountNo)<1||strlen($balance)<1||strlen($email)<1){
        $_SESSION['error']="<span style='color:red'>&#42</span> field is required field";
        header('Location:add-customer.php');
        return;
     }else{
     //Check whether the account no already exists or not
     $stmt=$pdo->prepare("SELECT accountNo from customers where accountNo=:no");
     $stmt->execute(array(
         ':no'=>$accountNo
     ));
     $row=$stmt->fetch(PDO::FETCH_ASSOC);
     if($row==false){
     $add=$pdo->prepare("INSERT INTO customers (name,profile,email,accountNo,balance,date_) VALUES (:name,:image,:email,:accountNo,:balance,:date_time)");
     $add->execute(array(
        ':name'=>$name,
        ':image'=>$image,
        ':email'=>$email,
        ':accountNo'=>$accountNo,
        ':balance'=>$balance,
        ':date_time'=>date('Y-m-d h:m:s')
      ));
      header('Location:customer.php');
      return;
   }else{
      $_SESSION['error']="This customer already exists";
      header('Location:add-customer.php');
      return;
   }
   }
}
?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Add</strong><small> Customer</small></div>
                        <div class="card-body card-block">
                        <?php
                         if(isset($_SESSION['error'])){
                           echo ("<p style='color:red'>".$_SESSION['error']."</p>\n");
                           unset($_SESSION['error']);
                       }
                        ?>
                            <form method="post" enctype="multipart/form-data">
                           <div class="form-group"><label for="name" class="form-control-label">Customer Name</label><span style="color:red">&#42;</span><input placeholder="Enter name" type="text" id="name" name="name" class="form-control">
                           <div class="form-group"><label for="img" class="form-control-label">Image</label><?php echo("<span style='color:red'>&#42;</span>");?>
                           <input value="<?php echo $image ?>" type="file" id="img" name="profile" class="form-control">
                           <div class="form-group"><label for="email" class="form-control-label">Email Id</label><span style="color:red">&#42;</span><input placeholder="Enter email id" type="text" id="email" name="email" class="form-control">
                           <div class="form-group"><label for="account" class="form-control-label">Account No</label><span style="color:red">&#42;</span><input placeholder="Enter account no" type="text" id="account" name="accountNo" class="form-control">
                           <div class="form-group"><label for="balance" class="form-control-label">Bank Balance</label><span style="color:red">&#42;</span><input placeholder="Enter current bank balance" type="text" id="balance" name="balance" class="form-control">
                           <button class="btn-block  mt-3" style="height:40px ;background-color:#2E8B57" name="submit">
                           <span id="payment-button-amount" style="font-size:20px;color:white">Submit</span>
                           </button>
                           </div>
                         </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

<?php
  require('bottom.php');
?>