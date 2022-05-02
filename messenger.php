<?php
session_start();
include("connection.php");
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        
        .grpbutton{
            cursor:pointer;
            width:fit-content;
        }
        .grpbutton:hover{
            background-color : black;
        }
        .button-87 {
  margin: 10px;
  padding: 15px 30px;
  text-align: center;
  text-transform: uppercase;
  transition: 0.5s;
  background-size: 200% auto;
  color: white;
  border-radius: 10px;
  display: block;
  border: 0px;
  font-weight: 700;
  box-shadow: 0px 0px 14px -7px #f09819;
  background-image: linear-gradient(45deg, #FF512F 0%, #F09819  51%, #FF512F  100%);
  cursor: pointer;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-87:hover {
  background-position: right center;
  /* change the direction of the change here */
  color: #fff;
  text-decoration: none;
}

.button-87:active {
  transform: scale(0.95);
}
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        
        var a;
        var element;
        var temp;
        function getmembers(){
            var elem = document.getElementById("members");
            <?php
            if(isset($_SESSION['crn'])){
                $crn = $_SESSION['crn'];
                $query = $mysqli->query("SELECT users.username FROM enrolled,users WHERE enrolled.crn=$crn AND users.id=enrolled.student_id");
                while($obj = $query->fetch_object()){
                    ?>
                    temp = document.createElement("p");
                    temp.innerHTML = "<?php echo($obj->username) ?>";
                    elem.append(temp);
                    <?php
                }
            }
            
             ?>

        }
        <?php
        function resultToArray($result) {
                $rows = array();
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                
                }
                return $rows;
            }
            ?>
        
        function showchat(){
            var msgdiv = document.getElementById("msgs");
            
            <?php
            if(isset($_SESSION['crn'])){
                $crn = $_SESSION['crn'];
                
                $query1 = $mysqli1->query("SELECT users.username,messages.msg,messages.datentime FROM messages,users WHERE users.id = messages.student_id AND messages.crn = $crn ORDER BY messages.datentime desc");
                $rows = resultToArray($query1);
                foreach($rows as $row){
                    $i=0;
                    ?>
                    element = document.createElement("p");
                    element.setAttribute("class","message");
                    <?php
                    foreach($row as $r){
                        if($i==0){
                            // $r is the username
                            ?>
                            element.innerHTML+= '<?php echo($r) ?>' + ": ";
                            <?php
                        }
                        elseif($i==1){
                            // $r is the message
                            ?>
            element.innerHTML+= "<?php echo($r) ?>";
                            <?php
                        }elseif($i==2){
                            //$r os the datetime
                        }
                        else{
                            break;
                        }
                        $i+=1;
                    }
                    ?>
                    msgdiv.append(element)
                    <?php

                } 
            }
                
                 ?>

        }
       function changecrn(crn){
            var form = document.getElementById("changecrn");
            var input = document.getElementById("newcrn");
            input.value = crn;
            form.submit();
       }
        function showgrps(){
            var sec = document.getElementById("groups");
            <?php 
            
        
            $query = $mysqli->query("SELECT crn FROM enrolled WHERE student_id = $id");
        
            $rows = resultToArray($query);
            foreach($rows as $row){
                foreach($row as $r){
                    $f = $r;
                    ?>


                    a = document.createElement("div");
                    a.innerHTML = <?php echo($r) ?>;
                    a.setAttribute("onclick","changecrn(<?php echo($r) ?>)")
                    a.setAttribute("class","button-87")
                    
                    sec.append(a)
                    <?php
                }
            }
         ?>
        
        }
        
        
    </script>
</head>
<body onload="showgrps();showchat();getmembers()">
    
    <div style="width:fit-content">
        <h1>Welcome <?php echo($_SESSION['username']) ?></h1>
        <form action="signout.php" method="post">
                <input type="submit" value="sign out">
            </form>
        <section>
            <!-- In this section we add crns -->
            <form action="addcrn.php" method='post'>
                <input type="text" placeholder="crn" name="crn" required>
                <select name="semester">
                    <option value="Fall 2022">Fall 2022</option>
                    <option value="Summer 2022">Summer 2022</option>
                </select>
                <input type="submit" value="add class" >
            </form>
        </section>
        

        <section id="groups">
            <!-- In this section we list the classes -->
            
        </section>
    </div>
    <div style="position:fixed;top:0px;left:450px;">
        
        <!-- Here we list the messages in the selected group -->
        <div id="textbox">
        <?php
        if(isset($_SESSION['crn'])){
            
            ?>
            <h2>Chatting on <?php echo($_SESSION['crn']) ?></h2>
            <div id="msgs" style="height:350px;overflow-y:auto;width:400px;overflow-x:auto;"></div>
            <form action="sendmsg.php" method="post">
                <input type="text" placeholder="message" name="msg" required>
                <input type="submit" value="send">
            </form>
            <form action="deletecrn.php" method="post">
                <input type="submit" value="delete group">
            </form>

        <?php
        }
        ?>
        </div>
    </div>
    <div id="members" style="position:fixed;top:0px;left:1000px;">
        <h2>Members</h2>

    </div>
    <form action="changecrn.php" id="changecrn" method="post" style="display:none;">
        <input type="text" name="newcrn" id="newcrn">
    </form>
    
</body>
</html>