<?php
  require('top.php');
  require('./pdo.php');

  if(isset($_GET['id'])){
    $stmt=$pdo->prepare("SELECT * FROM customers where id=:id");
    $stmt->execute(array(
        ':id'=>$_GET['id']
    ));
    $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if($row==false){
        header('Location:customer.php');
        return;
    } 
  }
 ?>

<div class="body__overlay"></div>

        <!-- Start Product Details Area -->
        <section class="">
            <!-- Start Product Details Top -->
            <div>
                <div class="container" style="padding-top:4px;">
                 <div class="row">
                        <?php 
                            foreach($row as $rows){
                        ?>  
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div>
                                <!-- Start Product Big Images -->
                                <img src=<?php echo($rows['profile']) ?> width="50%" style="padding-left:20px;" alt="full-image"/>
                                <!-- End Product Big Images -->
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div>
                                <h2><?php echo($rows['name']);?></h2>
                                <br>
                                  <div>
                                    <h5 style="padding-bottom:5px;">Email Id : <?php echo($rows['email']);?></h5>
                                    <h5 style="padding-bottom:5px;">Account No. : <?php echo($rows['accountNo']);?></h5>
                                    <h5 style="padding-bottom:5px;">Current Bank Balance : $<?php echo($rows['balance']);?></h5>
                                  </div>
                            </div>
                            <br>
                            <a style="background-color:#33ceff;border:1px solid grey;border-radius:5px;margin-bottom:4px;"
                            href="transfer.php?id=<?php echo($rows['id']) ?>&&acNo=<?php echo($rows['accountNo']); ?>">Transfer Money</a>
                        </div>
                        <?php }?>
                        </div> 
                </div>
            </div>
        </section>
       

 <?php
  require('bottom.php');
 ?>