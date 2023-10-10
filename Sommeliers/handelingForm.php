<?php
/*
    $servername = "localhost";
    $username = "api";
    $password = "apipassword";
    $databaseName="wordPressTest1";
    // Create connection
    foreach ($_POST as $key => $value) {
        error_log( print_r("Key: $key, Value: $value",TRUE));
    }
    header("Content-Type: application/json");
    //try{
        $conn = mysqli_connect($servername, $username, $password,$databaseName);
        if ($conn->connect_error) {
            error_log(print_r("Fuck up here",TRUE));
            $data=["status"=>500,"message"=>"No connection to database"];
            echo json_encode($data);
        }
        else{
            error_log(print_r("Will send query",TRUE)); 
            error_log(print_r($_POST["foto"],TRUE)); 
            
            if (!defined('ABSPATH')) {
                require_once('/Users/maximiliantyx/Desktop/programming/Job/WordPress/wordpress/wp-load.php');
            }
            if ( ! function_exists( 'WP_Filesystem' ) ) {
                error_log(print_r("Ajhoj tady jsme",TRUE));
                require_once(ABSPATH.'/wp-admin/includes/file.php');
            }
            // Initialize the WordPress filesystem
            WP_Filesystem();
            $file_path = WP_CONTENT_DIR . '/uploads/profilovky/profilovka.png';
            $arraybuffer_data =  $_POST['foto'];
            global $wp_filesystem;
            if ( $wp_filesystem ) {
                if ( $wp_filesystem->put_contents( $file_path, $arraybuffer_data, FS_CHMOD_FILE ) ) {
                    // File saved successfully
                    error_log( print_r('File saved successfully.',TRUE));
                } else {
                    // Failed to save the file
                    error_log( print_r( 'Failed to save the file.',TRUE));
                }
            } else {
                // Failed to initialize the filesystem
                error_log(print_r( 'Failed to initialize the filesystem.',TRUE));
            }
            $file_path = WP_CONTENT_DIR . '/uploads/profilovky/profilovka.png';

            // Get the upload directory information
            $upload_dir = wp_get_upload_dir();

            // Check if the file exists
            if (file_exists($file_path)) {
                // Construct the URL to the file
                $file_url = $upload_dir['baseurl'] . '/profilovky/profilovka.png';

                error_log(print_r('File URL: ' . $file_url,TRUE));
            } else {
                // File doesn't exist
                error_log(print_r('File does not exist.',TRUE));
            }
            $sql = 
                INSERT INTO Sommeliers (Jmeno,Email,Mobil,Popis,Foto) VALUES ("$_POST["name"]","$_POST["email"]","$_POST["mobil"]","$_POST["popis"]",base64_encode($_POST["foto"]));
                SQL;
            $result = mysqli_query($conn,$sql);
            error_log(print_r("After query",TRUE)); 
            if($result){
                $data=["status"=>200,"message"=>"Data in the database"];
                echo json_encode($data);
            }
            else{
                $data=["status"=>500,"message"=>"Incorrect query"];
                echo json_encode($data);
            }
            
        }
        */
        
    //}
    /*
    catch(Exception $e){
        echo json_encode("Ahoj");
    }
    */

    // Add this in your theme's functions.php or a custom plugin

    // Register the AJAX action





?>