<?php
$devID = "feeefab2-c43a-45b0-8355-e68265c3dfdd";
$appID = "KevinIur-a418-4ddf-9e7e-f7f59288fb83";
$certID = "2832cbf7-060a-44b8-9a1e-f54ac24ff11c";
$serverUrl = "https://api.ebay.com/ws/api.dll";

//Use this URL for sandbox mode: https://api.sandbox.ebay.com/ws/api.dll
//Use this URL for production mode: https://api.ebay.com/ws/api.dll
$userToken = "AgAAAA**AQAAAA**aAAAAA**4fCSVg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFl4KlC5iBogSdj6x9nY+seQ**1iEDAA**AAMAAA**1MpAby6J+6CY2QeVvsCRJ+1D/LzOY9InIewu0BZDqMdX9K2rln+tl0qS/a6miqiAa7xdmzYb9Cv//d4O6/1BcRmXDlu4W+CiiQE8Gs8FGydfdkC4r+TWxePHlDNsK7X6Xr4ubI26WgLUfb8kYmskwdbLNFfeDd7hX8SxeDjGVfZn4lYZVSWIvSVtAzTclMlCM2z+wG4OrAmdZiOhKlgap9c4OLEfUHbFo9W9Z29IXEpoVNitHW3GQJ0V5isadHuzPbBNXFq8lF7lmKuk5Qn26TRYWStEeSWm9g/wAwNcMXOncRAFfz0MF9sAHi2b0MvPbmZYsMXs/kwpGzWwGdP0QQoxYTa+fB7oIKtvONFdP8PJh9/SWQSLpICnOU1byQMYnLPP13smirnne6mjsUSJVYVSufRFtSoGeOMZnO2ZHMsPoDyDEsHKTgFub9featdpe5ThB4RSndqv+SHToXTSOG8GhRUy5FmgtDevogdyrbLyDQOWJ7PlYcP2fPOCY4uw2z1TC94c5ZU57+CAz91KNbFH2Ym8m1reoXMAKrfzRIC2h7yCLveVPWEt5iOzR8qDmBfKCIc1jB+xLmrmJI/DFgMwHbY9Z62n5KyFVwIYkGpsnmshdv86t2VBKo6N8KG5z02rzKq88yQN9PyJaGo0V1e1pDmA8P2Rr+KrvTng5ZYgKmc2lRP0Qa7gt2k8b0B5wnHFDQxoEABYtzSHU6TEMFzYfUiAOCvk3o1qFuxc6lBpOlKEWBwXWMQs+B2rR9Nh"; // – the Authentication Token representing the eBay user who is making the call.
$username = "vinciann"; //- Use  developer’s account’s user name , if you use sandbox mode otherwise merchant’s account’s username.

$siteID = 101;
$verb = 'GetSellerList'; //API call name
$StartTimeFrom = '2015-12-00T13:00:00.000Z';
$StartTimeTo = '2016-01-16T10:00:00.000Z';
$EntriesPerPage = '200';

$headers = array(
    'charset=UTF-8',
    'X-EBAY-API-COMPATIBILITY-LEVEL: 825',
    'X-EBAY-API-DEV-NAME: ' . $devID,
    'X-EBAY-API-APP-NAME: ' . $appID,
    'X-EBAY-API-CERT-NAME: ' . $certID,
    'X-EBAY-API-CALL-NAME: ' . $verb,
    'X-EBAY-API-SITEID: 101',
);

//Build the request Xml string
$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
    <RequesterCredentials>
        <eBayAuthToken>' . $userToken . '</eBayAuthToken>
    </RequesterCredentials>
    <UserID>' . $username . '</UserID>
    <GranularityLevel>CustomCode</GranularityLevel>
    <StartTimeFrom>' . $StartTimeFrom . '</StartTimeFrom>
    <StartTimeTo>' . $StartTimeTo . '</StartTimeTo>
    <Pagination>
        <EntriesPerPage>' . $EntriesPerPage . '</EntriesPerPage>
    </Pagination>
</GetSellerListRequest>';

//build eBay headers using variables passed via constructor
//initialise a CURL session
$connection = curl_init();
//set the server we are using (could be Sandbox or Production server)
curl_setopt($connection, CURLOPT_URL, $serverUrl);
//stop CURL from verifying the peer’s certificate
curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
//set the headers using the array of headers
curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
//set method as POST
curl_setopt($connection, CURLOPT_POST, 1);
//set the XML body of the request
curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
//set it to return the transfer as a string from curl_exec
curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
//Send the Request
$responseXml = curl_exec($connection);

//close the connection
curl_close($connection);

if (stristr($responseXml, 'HTTP 404') || $responseXml == "")
    die('<p>Error sending request</p>');


echo htmlentities($responseXml);