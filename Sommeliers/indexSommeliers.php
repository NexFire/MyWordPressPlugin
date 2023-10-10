<?php
/**
 * @package Sommeliers
 * @version 0.0.1
 */
/*
Plugin Name: Sommeliers
Plugin URI: https://github.com/NexFire/getSommelier
Description: This is the Get Sommelier plug-in that is in my assignment
Author: Maximilian Tyx
Version: 0.0.1
Author URI: https://github.com/NexFire
*/


//form for [getSommeliers]
function loadForm(){
    wp_enqueue_style('custom-css', plugins_url('style.css', __FILE__));
    wp_enqueue_script('your-plugin-script', plugins_url('script.js', __FILE__), array('jquery'), '1.0', true);
    $nonce = wp_create_nonce('save_arraybuffer_nonce');
    wp_localize_script('your-plugin-script', 'dataObject', array(
        'nonce' => $nonce,
    ));
    include "header.php";
}
function loadDashBoardTab(){
    $icon_base64 = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IS0tIFVwbG9hZGVkIHRvOiBTVkcgUmVwbywgd3d3LnN2Z3JlcG8uY29tLCBHZW5lcmF0b3I6IFNWRyBSZXBvIE1peGVyIFRvb2xzIC0tPgo8c3ZnIHdpZHRoPSI4MDBweCIgaGVpZ2h0PSI4MDBweCIgdmlld0JveD0iMCAwIDY0IDY0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiBhcmlhLWhpZGRlbj0idHJ1ZSIgcm9sZT0iaW1nIiBjbGFzcz0iaWNvbmlmeSBpY29uaWZ5LS1lbW9qaW9uZSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ieE1pZFlNaWQgbWVldCI+PHBhdGggZD0iTTE1LjEgMjIuMUMxNiAzMC4xIDIzLjMgMzcgMzIgMzdjOS40IDAgMTcuMS04IDE3LjEtMTYuN3YtLjJjLTkuOC0xLjMtMjIuMSA1LjgtMzQgMiIgZmlsbD0iIzk2MTYyMyI+PC9wYXRoPjxwYXRoIGQ9Ik01NCAyMC40QzU0IDkgNDguMyAyIDQ4LjMgMkgxNS43UzEwIDkuMSAxMCAyMC40YzAgMTAuOCA5LjMgMjAuOSAyMC45IDIxLjVjLS4xIDYuMy0uNyAxMi44LTIuMiAxNS4xYy0yLjIgMy4yLTkuOCAxLjYtOS44IDVoMjYuMmMwLTMuNC03LjYtMS44LTkuOC01Yy0xLjUtMi4zLTIuMS04LjgtMi4yLTE1LjFDNDQuNyA0MS4zIDU0IDMxLjMgNTQgMjAuNE0zMiAzOS4zYy05LjggMC0xNy45LTcuOC0xOC45LTE2LjdjLS4xLS42LS4xLTEuMy0uMS0xLjljMC05LjkgNC45LTE1LjkgNC45LTE1LjloMjguMnM0LjggNiA0LjkgMTUuN3YuMmMwIDkuNi04LjUgMTguNi0xOSAxOC42IiBvcGFjaXR5PSIuOCIgZmlsbD0iI2ExYjhjNyI+PC9wYXRoPjwvc3ZnPg==';
    $icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;
    add_menu_page(
        "Sommeliers",
        "Sommeliers",
        "manage_options",
        "add-sommelier",
        "loadForm",
        $icon_data_uri
    );
}
add_action("admin_menu","loadDashBoardTab");
function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

function save_arraybuffer_callback() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'save_arraybuffer_nonce')) {
        echo json_encode(array('success' => false, 'message' => 'Permission denied.'));
        die();
    }

    // Initialize the WordPress filesystem
    if (!function_exists('wp_filesystem')) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
    }
    WP_Filesystem();

    // Get the ArrayBuffer from the AJAX request
    if (isset($_FILES['file'])) {
        foreach ($_FILES as $key => $value) {
            error_log( print_r("Key: $key, Value: $value",TRUE));
        }
        $fileReference = wp_handle_upload($_FILES['file'], array('test_form' => false));
        if (!empty($fileReference['file'])) {
            $servername = "localhost";
            $username = "api";
            $password = "apipassword";
            $databaseName="wordPressTest1";
            $conn = mysqli_connect($servername, $username, $password,$databaseName);
            if ($conn->connect_error) {
                error_log(print_r("Fuck up here",TRUE));
                $data=["status"=>500,"message"=>"No connection to database"];
                echo json_encode($data);
            }
            else{
                $sql="INSERT INTO Sommeliers (Jmeno,Email,Mobil,Popis,FotoUrl) VALUES ('".$_POST["name"]."','".$_POST["email"]."','".$_POST["mobil"]."','".$_POST["popis"]."','".$fileReference["url"]."')";
                $result = mysqli_query($conn,$sql);
                if($result){
                    $data=["status"=>200,"message"=>"Data in the database"];
                    echo json_encode($data);
                }
                else{
                    $data=["status"=>500,"message"=>"Incorrect query"];
                    echo json_encode($data);
                }
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to save the file.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'No ArrayBuffer data received.'));
    }
    // Always exit to avoid extra output
    wp_die();
}

add_action('wp_ajax_save_arraybuffer', 'save_arraybuffer_callback');
add_action('wp_ajax_nopriv_save_arraybuffer', 'save_arraybuffer_callback');
?>
