<?php

    ob_start();
    session_start();
    include('functions.php');
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                if (isset($_POST['username']) && isset($_POST['password'])) {

                    $conn = connectDB();  

                          function getUserIpAddr(){
                     
                             if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
                                $ip = $_SERVER['HTTP_CLIENT_IP'];
                             }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
                                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                             }else{
                                $ip = $_SERVER['REMOTE_ADDR'];
                             }
                              return $ip;
                             } 

                    $ip_addr = getUserIpAddr();
                    //echo( " " . 'User Real IP - '. " " .$ip_addr);
                    
                    $query1 = "SELECT* FROM ban WHERE banner_ip  = '".$ip_addr."'";
                    $result = mysqli_query($conn, $query1); 
                    $number = mysqli_num_rows($result);
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $test = $username;
                    $count = 0;
                    if ($number > 0) {

                       
                        echo '<script type="text/javascript">
                        function appear1(){

                        alert("Indirizzo IP bannato. ");
                         setTimeout("appear2()",10);


                          }
                           function appear2(){

                            window.location.assign("login.php");
                               }

                         appear1()
                         </script>';
                        //header('Location: login.php');

                    }else{

                       
                         $handle = fopen("bypass1.txt", "r");
                         if ($handle) {
                            trim($test," ");
                            $test = preg_replace('/\s+/', '', $test);
                            
                         while (($line = fgets($handle)) !== false) {
                                                        trim($line," ");
                            $line = preg_replace('/\s+/', '', $line);
                            
                             if(strpos($test,$line) !== false){

                              $count = $count +1;
                            
                             
                               } 
                            }
                            if ($count > 0) {
                                 $queryban = "INSERT INTO ban(banner_ip) VALUES ('$ip_addr')";
                               if(mysqli_query($conn, $queryban)){

                                 echo '<script type="text/javascript">
                                function appear3(){

                                alert("Tentata esecuzione sql injection, indirizzo ip bannato. ");
                                setTimeout("appear4()",10);


                                 }
                                 function appear4(){

                                     window.location.assign("login.php");
                                     }

                                  appear3()
                                 </script>';

                               
                                }
                            }

                            fclose($handle);
                         } 
                    $username = $_POST['username']?mysqli_real_escape_string($conn,($_POST['username'])):false;
                    
                   
                    

                    $query = "SELECT * FROM users WHERE email = '".$username."' AND password = '".$password."' ";

                    _dbgWrite('arrivato');

                    $stmt = mysqli_query( $conn, $query);
                    $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC);

                    if( $stmt === false ) {
                         die( print_r( mysqli_errors(), true));
                    }

                    if(!empty($row)) {

                        $stmt = mysqli_query( $conn, $query);

                        while(!empty($row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC))){

                            echo($row['id'] . " " . $row['email'] . " " . $row['password'] . " " . $row['name'] . " " . $row['surname'] . " " . $row['comp_name']);
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['comp_name'] = $row['comp_name'];
                            _dbgWrite($_SESSION['comp_name']);
                        }

                        header('Location: index.php');
                    } 
                 }
                }
                break;

            case 'addUser':
                if (isset($_POST['user_email']) && isset($_POST['user_name']) && isset($_POST['user_surname']) && isset($_GET['piva']) && isset($_GET['id'])) {

                    $user_email = $_POST['user_email'];
                    $user_name = $_POST['user_name'];
                    $user_surname = $_POST['user_surname'];

                    $json = json_encode(array('user_email' => $user_email, 'user_name' => $user_name, 'user_surname' => $user_surname, 'az_id' => $_GET['id']));



                    $curl = curl_init();
                    //imposto vari parametri per la POST verso i WS
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'http://www.progettoweb.it/ws/public/index.php/addUser',
                        CURLOPT_USERAGENT => 'Codular Sample cURL Request',
                    ));
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                            'Content-Type:application/json;charset=UTF-8',
                            'Content-Length: ' . strlen($json))
                    );

                    curl_setopt($curl, CURLOPT_POST, true);
                    $resp = curl_exec($curl);
                    curl_close($curl);


                    if ($resp == null) {
                        header('Location: azienda.php?rg=' .$_GET['rg'] .'&piva=' .$_GET['piva'].'&id='.$_GET['id'].'&error=not_compilati');
                        break;
                    }

                    header('Location: azienda.php?rg=' .$_GET['rg'] .'&piva=' .$_GET['piva'].'&id='.$_GET['id']);
                    break;
                }

            case 'addUcUser':
                if (isset($_POST['uc_email']) && isset($_POST['uc_name']) && isset($_POST['uc_surname']) && isset($_POST['uc_pwd'])) {

                    $uc_email = $_POST['uc_email'];
                    $uc_name = $_POST['uc_name'];
                    $uc_surname = $_POST['uc_surname'];
                    $uc_pwd = $_POST['uc_pwd'];

                    $json = json_encode(array('uc_email' => $uc_email, 'uc_name' => $uc_name, 'uc_surname' => $uc_surname, 'uc_pwd' => $uc_pwd, 'uc_idaz' => $_SESSION['uc_idaz']));



                    $curl = curl_init();
                    //imposto vari parametri per la POST verso i WS
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'http://www.progettoweb.it/ws/public/index.php/addUcUser',
                        CURLOPT_USERAGENT => 'Codular Sample cURL Request',
                    ));
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                            'Content-Type:application/json;charset=UTF-8',
                            'Content-Length: ' . strlen($json))
                    );

                    curl_setopt($curl, CURLOPT_POST, true);
                    $resp = curl_exec($curl);
                    curl_close($curl);


                    if ($resp == null) {
                        header('Location: index.php?error=utente');
                        break;
                    }

                    header('Location: index.php');
                    break;
                }

            case 'addAzienda':
                if (isset($_POST['az_ragsoc']) && isset($_POST['az_piva'])) {

                    $az_ragsoc = $_POST['az_ragsoc'];
                    $az_piva = $_POST['az_piva'];

                    $json = json_encode(array('az_ragsoc' => $az_ragsoc, 'az_piva' => $az_piva, 'az_idforn' => $_SESSION['uc_idaz']));


                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'http://www.progettoweb.it/ws/public/index.php/addAzienda',
                        CURLOPT_USERAGENT => 'Codular Sample cURL Request',
                    ));
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                            'Content-Type:application/json;charset=UTF-8',
                            'Content-Length: ' . strlen($json))
                    );

                    curl_setopt($curl, CURLOPT_POST, true);
                    $resp = curl_exec($curl);
                    curl_close($curl);


                    //parsifico il JSON e creo le relative variabili di sessione
                    if ($resp == null) {
                        header('Location: index.php?error=azienda');
                        break;
                    }

                    header('Location: index.php');

                }

            case 'updateUser':
                if (isset($_POST['uc_email']) && isset($_POST['uc_name']) && isset($_POST['uc_surname'])) {

                    $uc_email = $_POST['uc_email'];
                    $uc_name = $_POST['uc_name'];
                    $uc_surname = $_POST['uc_surname'];
                    $uc_id = $_SESSION['uc_id'];

                    $json = json_encode(array('uc_email' => $uc_email, 'uc_name' => $uc_name, 'uc_surname' => $uc_surname, 'uc_id' => $uc_id));



                    $curl = curl_init();
                    //imposto vari parametri per la POST verso i WS
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'http://www.progettoweb.it/ws/public/index.php/updateUser',
                        CURLOPT_USERAGENT => 'Codular Sample cURL Request',
                    ));
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                            'Content-Type:application/json;charset=UTF-8',
                            'Content-Length: ' . strlen($json))
                    );

                    curl_setopt($curl, CURLOPT_POST, true);
                    $resp = curl_exec($curl);
                    curl_close($curl);


                    if ($resp == null) {
                        header('Location: user.php?error=utente');
                        break;
                    }

                    header('Location: user.php');
                }

            case 'updatePwd':
                if (isset($_POST['uc_pwd']) && isset($_POST['uc_pwd2'])) {

                    $uc_pwd = $_POST['uc_pwd'];
                    $uc_pwd2 = $_POST['uc_pwd2'];
                    $uc_id = $_SESSION['uc_id'];

                    $json = json_encode(array('uc_pwd' => $uc_pwd, 'uc_pwd2' => $uc_pwd2, 'uc_id' => $uc_id));



                    $curl = curl_init();
                    //imposto vari parametri per la POST verso i WS
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'http://www.progettoweb.it/ws/public/index.php/updatePwd',
                        CURLOPT_USERAGENT => 'Codular Sample cURL Request',
                    ));
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                            'Content-Type:application/json;charset=UTF-8',
                            'Content-Length: ' . strlen($json))
                    );

                    curl_setopt($curl, CURLOPT_POST, true);
                    $resp = curl_exec($curl);
                    curl_close($curl);


                    if ($resp == null) {
                        header('Location: user.php?error=pwd');
                        break;
                    }

                    header('Location: user.php?ok=pwd');
                }
        }
    } else {
    
    }
   




    ?>
