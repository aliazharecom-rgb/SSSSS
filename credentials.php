<?php
/*
All sensitive credentials stored here.
*/

error_reporting(0);

$databaseHost = "localhost";
$databaseUsername = "root";
$databasePassword = "";
$databaseName = "umar_auth";

$mysqlRequireSSL = false; // in case the MySQL server requires SSL


$logwebhook = ""; // discord webhook which receives login logs and keys created

$adminwebhook = ""; // discord webhook which receives admin actions

$redisServers = []; // URLs to purge redis keys from each server (used on live UMAR AUTH website only)

$redisPass = "";

$keyauthStatsToken = ""; // discord bot token for UMAR AUTH Stats

$webhookun = "UMAR AUTH Logs"; // webhook username

$adminwebhookun = "UMAR AUTH Admin Logs"; // admin webhook's username

$awsAccessKey = ""; // used for AWS SES to send emails

$awsSecretKey = ""; // used for AWS SES to send emails
