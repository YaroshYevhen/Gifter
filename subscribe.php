<?php

require_once 'configuration.php';
$date = new DateTime('+14 day');
$email = $_GET['email'];
$password =$_GET['password'];
if(!$email) {
    die("Please enter a valid email");
}
if(!$password) {
    die("Please enter password");
}
$name = substr($email, 0, strrpos($email, '@'));

$url = 'https://wingifts.net/api/auth/register';
$user = array('email' => $email, 'password' => $password, 'password_confirmation' => $password, 'name' => $name);
$ch = curl_init($url);
$payload = json_encode($user);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$result = json_decode($result, 1);

if(!isset($result['id'])) {
    $url = 'https://wingifts.net/api/auth/login';
    $user = array('email' => $email, 'password' => $password, 'remember_me' => 1);
    $ch = curl_init($url);
    $payload = json_encode($user);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, 1);

    if(isset($result['access_token'])) {
        $url = "https://wingifts.net/api/auth/user";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $result['access_token']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, 1);
    }
}

if(isset($result['id'])) {
    $data = [
        'currency' => 'USD',
        'amount' => 4900,
        'sender_email' => $email,
        'response_url' => 'https://wingifts.net/ru/subscribe/' . $result['id'],
        'recurring_data' => [
            'start_time' => $date->format('Y-m-d'),
            'amount' => 1400,
            'every' => 30,
            'period' => 'day',
            'state' => 'y',
            'readonly' => 'y'
        ]
    ];

    $url = \Cloudipsp\Subscription::url($data);
    $data = $url->getData();
    $recurring_url = $data['checkout_url'];

    if (isset($recurring_url)) {
        header(sprintf('location: %s', $recurring_url));
        exit;
    }
} else {
    header(sprintf('location: %s', '/'));
    exit;
}

