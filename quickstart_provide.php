<?php 

require_once __DIR__.'/admin/vendor/autoload.php';
// require __DIR__ . '/vendor/autoload.php';

// if (php_sapi_name() != 'cli') {
//     throw new Exception('This application must be run on the command line.');
// }

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object   
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    // $tokenPath = __DIR__ . '/token.json';
    // if (file_exists($tokenPath)) {
    //     $accessToken = json_decode(file_get_contents($tokenPath), true);
    //     $client->setAccessToken($accessToken);
    // }

    // // If there is no previous token or it's expired.
    // if ($client->isAccessTokenExpired()) {
    //     // Refresh the token if possible, else fetch a new one.
    //     if ($client->getRefreshToken()) {
    //         $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    //     } else {
    //         // Request authorization from the user.
    //         $authUrl = $client->createAuthUrl();
    //         printf("Open the following link in your browser:\n%s\n", $authUrl);
    //         print 'Enter verification code: ';
    //         $authCode = trim(fgets(STDIN));

    //         // Exchange authorization code for an access token.
    //         $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    //         $client->setAccessToken($accessToken);

    //         // Check to see if there was an error.
    //         if (array_key_exists('error', $accessToken)) {
    //             throw new Exception(join(', ', $accessToken));
    //         }
    //     }
    //     // Save the token to a file.
    //     if (!file_exists(dirname($tokenPath))) {
    //         mkdir(dirname($tokenPath), 0700, true);
    //     }
    //     file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    // }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1S_tgK4meGLaKv5OobmpG5c6KK4jo4BbL7DEH2yjP2yg/edit#gid=0
$spreadsheetId = '1S_tgK4meGLaKv5OobmpG5c6KK4jo4BbL7DEH2yjP2yg';

$range = 'Name list IT Security!A2:AB';
$rows  = $service->spreadsheets_values->get($spreadsheetId, $range,['majorDimension' => 'ROWS']);

if (empty($rows)) {
    print "No data found.\n";
} else {
    foreach ($rows['values'] as $row) {
        /*
         * If first column is empty, consider it an empty row and skip (this is just for example)
         */
        if (empty($row[0])) {
            break;
        }

        $data[] = [
            'col_a' => $row[0],
            'col_b' => $row[1],
            'col_c' => $row[2],
            'col_d' => $row[3],
            'col_e' => $row[4],
            'col_f' => $row[5],
            'col_g' => $row[6],
            'col_h' => $row[7],
            'col_i' => $row[8],
            'col_j' => $row[9],
            'col_k' => $row[10],
            'col_l' => $row[11],
            'col_m' => $row[12],
            'col_n' => $row[13],
            'col_o' => $row[14],
            'col_p' => $row[15],
            'col_q' => $row[16],
            'col_r' => $row[17],
            'col_s' => $row[18],
            'col_t' => $row[19],
            'col_u' => $row[20],
            'col_v' => $row[21],
            'col_w' => $row[22],
            'col_x' => $row[23],
            'col_y' => $row[24],
            'col_z' => $row[25],
            'col_aa' => $row[26],
            'col_ab' => $row[27],
        ];
    }
}

print_r(json_encode($data));