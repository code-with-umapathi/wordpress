<?php

/**
 * Plugin Name: Custom Rest API
 * Description: This is custom rest api
 * Version: 1.0
 * Author: Code With Umapathi
 */

if(!defined('ABSPATH')){
    exit;
}

//regiseter rest routs
add_action('rest_api_init', function(){
    register_rest_route('/codewith/v1', 'get', [
        'methods' => 'GET',
        'callback' => 'get_data',
        'permission_callback' => '__return_true'
    ]);
    register_rest_route('/codewith/v1', 'list', [
        'methods' => 'GET',
        'callback' => 'get_all_items',
        'permission_callback' => '__return_true'
    ]);
    register_rest_route('/codewith/v1', 'insert', [
        'methods' => 'POST',
        'callback' => 'insert_data',
        'permission_callback' => '__return_true'
    ]);
    register_rest_route('/codewith/v1', 'update', [
        'methods' => 'PUT',
        'callback' => 'update_data',
        'permission_callback' => '__return_true'
    ]);
    register_rest_route('/codewith/v1', 'delete', [
        'methods' => 'DELETE',
        'callback' => 'delete_data',
        'permission_callback' => '__return_true'
    ]);
});

function get_data(){
    return new WP_REST_Response(['message' => 'API connnected successfully']);
}

function get_all_items(){
    global $wpdb;
    $table = $wpdb->prefix . 'crud';
    $result = $wpdb->get_results("select * from $table");
    if(empty($result)){
        return new WP_Error('list_failed', 'Data not exists', []);
    }
    return new WP_REST_Response(['data' => $result]);
}

function insert_data(){
    global $wpdb;
    $table = $wpdb->prefix . 'crud';
    $name = 'Test';
    $email = 'test@testmail.com';
    $message = 'test data';
    $result = $wpdb->insert($table, ['name' => $name, 'email' => $email, 'description' => $message]);
    if($result === false){
        return new WP_Error('insert_failed', $wpdb->last_error);
    }
    return new WP_REST_Response(['message' => 'inserted successfully']);
}

function update_data(){
    global $wpdb;
    $table = $wpdb -> prefix . 'crud';
    $name = 'Test';
    $email = 'test@testmail.com';
    $message = 'test datas';
    $id = 8;
    $result = $wpdb->update($table, ['name' => $name, 'email' => $email, 'description' => $message], ['id' => $id]);
    if($result === false){
        return new WP_Error('insert_failed', $wpdb->last_error);
    }
    return new WP_REST_Response(['message' => 'updated successfully']);
}


function delete_data(){
    global $wpdb;
    $table = $wpdb -> prefix . 'crud';
    $id = 8;
    $result = $wpdb->delete($table, ['id' => $id]);
    if(!$result){
        return new WP_Error('delete_failed', $wpdb->last_error);
    }
    return new WP_REST_Response(['message' => 'deleted successfully']);
}