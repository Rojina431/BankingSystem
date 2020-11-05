<?php
 session_start();
 require('top.php');
 require('./pdo.php');
 if(isset($_GET['id'])&&$_GET['acNo']&&isset($_POST['submit'])){
     $sendername=$_POST['name'];
     $senderAcNo=$_GET['acNo'];
     $recievername=$_POST['recname'];
     $recieverAcNo=$_POST['recaccountNo'];
     $balancesend=$_POST['balance'];

     //check if all fields are filled or not
     if(strlen($sendername)<1||strlen($senderAcNo)<1||strlen($recievername)<1||strlen($recieverAcNo)<1||strlen($balancesend)<1){
        $_SESSION['error']="<span style='color:red'>&#42</span> field is required field";
        header('Location:transfer.php?id='.$_GET['id'].'&&acNo='.$senderAcNo.'');
        return;
     }
     $stmt=$pdo->prepare('SELECT * from customers where accountNo=:AcNo and name=:name');
     $stmt->execute(array(
         ':AcNo'=>$senderAcNo,
         ':name'=>$sendername
     ));
     $row=$stmt->fetch(PDO::FETCH_ASSOC);

     //to check whether sender account no is valid or not
     if($row==false){
          $_SESSION['error']="Sender Account does not exists";
          header('Location:transfer.php?id='.$_GET['id'].'&&acNo='.$senderAcNo.'');
        return;
     }else{
         if($senderAcNo!==$_POST['accountNo']){//to check if you redirecting to transfer page through the account detail havin same account as thaat of sender account
            $_SESSION['error']="Sender Account No does not match"; 
            header('Location:transfer.php?id='.$_GET['id'].'&&acNo='.$senderAcNo.'');
            return;
         }else{
            if($row['balance']<$balancesend){//to check whether you have bank balance more than or equal to the sending balance
                $_SESSION['error']="Your bank balance is less than the balance you want to send";
                header('Location:transfer.php?id='.$_GET['id'].'&&acNo='.$senderAcNo.'');
                return;
            }else{
               //check reciever account
            $rstmt=$pdo->prepare('SELECT * from customers where accountNo=:AcNo and name=:name');
            $rstmt->execute(array(
            ':AcNo'=>$recieverAcNo,
            ':name'=>$recievername
           ));
          $rrow=$rstmt->fetch(PDO::FETCH_ASSOC);
   
          //to check whether sender account no is valid or not
           if($rrow==false){
             $_SESSION['error']="Reciever Account does not exists";
             header('Location:transfer.php?id='.$_GET['id'].'&&acNo='.$senderAcNo.'');
             return;
          }else{
           if($senderAcNo===$recieverAcNo){//to check if you are sending money to your own account or others
            $_SESSION['error']="Choose account different from sender account";
            header('Location:transfer.php?id='.$_GET['id'].'&&acNo='.$senderAcNo.'');
            return;
           }else{//for matching all criteria
            $rbalance=$rrow['balance']+$balancesend;
            $balance=$row['balance']-$balancesend;
           $uStmt=$pdo->prepare('UPDATE customers SET balance=:balance where accountNo=:AcNo ');
           $uStmt->execute(array(
               ':balance'=>$rbalance,
               ':AcNo'=>$recieverAcNo
           ));
           $uStmt=$pdo->prepare('UPDATE customers SET balance=:balance where accountNo=:AcNo');
               $uStmt->execute(array(
                   ':balance'=>$balance,
                   ':AcNo'=>$senderAcNo
           ));
           $_SESSION['success']="Successful transction done from '".$senderAcNo."' to '".$recieverAcNo."' ";
           header('Location:customer.php');
           return;
           }      
         }
         }
         }
    }
}
?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Transfer</strong><small>Money</small></div>
                        <div class="card-body card-block">
                        <?php
                         if(isset($_SESSION['error'])){
                           echo ("<p style='color:red'>".$_SESSION['error']."</p>\n");
                           unset($_SESSION['error']);
                       }
                        ?>
                            <form method="post">
                           <div class="form-group"><label for="name" class="form-control-label">Sender Name</label><span style="color:red">&#42;</span><input placeholder="Enter sender name" type="text" id="name" name="name" class="form-control">
                           <div class="form-group"><label for="account" class="form-control-label">Sender Account No</label><span style="color:red">&#42;</span><input placeholder="Enter sender account no" type="text" id="account" name="accountNo" class="form-control">
                           <div class="form-group"><label for="recname" class="form-control-label">Reciever Name</label><span style="color:red">&#42;</span><input placeholder="Enter reciever name" type="text" id="recname" name="recname" class="form-control">
                           <div class="form-group"><label for="recaccount" class="form-control-label">Reciever Account No</label><span style="color:red">&#42;</span><input placeholder="Enter reciever account no" type="text" id="recaccount" name="recaccountNo" class="form-control">
                           <div class="form-group"><label for="price" class="form-control-label">Balance To Transfer</label><span style="color:red">&#42;</span><input placeholder="Enter balance to be transferred" type="text" id="balance" name="balance" class="form-control">
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