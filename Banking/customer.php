<?php
  session_start();
  require('top.php');
  require('./pdo.php');
?>


<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Customers</h4>
                           <a class="box-title" style="color:black;" href="add-customer.php">Add Customers</a>
                        </div>
                        <div>
                        <?php
                         if(isset($_SESSION['success'])){
                           echo ("<p style='color:green'>".$_SESSION['success']."</p>\n");
                           unset($_SESSION['success']);
                       }
                        ?>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h"> 
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       <th class="avatar">Profile</th>
                                       <th>ID</th>
                                       <th>Customer Name</th>
                                       <th>Customer Email</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php 
                                    $count=0;
                                    $stmt=$pdo->prepare("SELECT * FROM customers");
                                    $stmt->execute();
                                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                        $count=$count+1;
                                   ?>
                                    <tr>
                                       <td class="serial"><?php echo($count);?></td>
                                       <td class="avatar">
                                          <div class="round-img">
                                             <a href='customer-detail.php?id=<?php echo($row['id']);?>'><img class="rounded-circle" src=<?php echo ($row['profile']);?> alt=""></a>
                                          </div>
                                       </td>
                                       <td><?php echo($row['id']);?></td>
                                       <td> <span class="name"><?php echo($row['name']);?></span> </td>
                                       <td> <span class="product"><?php echo($row['email']);?></span> </td>
                                    </tr>
                                   <?php }
                                   ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
          </div>
          
<?php
  require('bottom.php');
?>     