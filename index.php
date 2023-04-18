<?php

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

$remote_file_path = "/root/scripts/mon.out";
$content = '';

$serverArr = array(
    [
        'host' => '10.0.0.13',
        'port' => 22,
        'user' => 'root',
        'pass' => 'BScg846291##',
    ],
    [
        'host' => '10.0.0.11',
        'port' => 22,
        'user' => 'root',
        'pass' => 'BScg846291##',
    ],
    [
        'host' => '10.1.0.9',
        'port' => 22,
        'user' => 'root',
        'pass' => 'BScg1234!',
    ],
    [
        'host' => '42.1.60.248',
        'port' => 8288,
        'user' => 'root',
        'pass' => 'zo8NjWtmAH6z81ER91',
    ]
);

include( 'header.php' );

echo '<div class="container-fluid">';
echo '<div class="row no-glutter">';

// var_dump( $serverArr[0]['host'] );

for( $i = 0; $i <= 3; $i++ ) {
    $host = $serverArr[$i]['host'];
    $port = $serverArr[$i]['port'];
    $user = $serverArr[$i]['user'];
    $pass = $serverArr[$i]['pass'];

    $conn = ssh2_connect( $host, $port );
    ssh2_auth_password( $conn, $user, $pass );

    $stream = ssh2_exec( $conn, 'cat ' . $remote_file_path );
    stream_set_blocking( $stream, true );
    $stream_out = ssh2_fetch_stream( $stream, SSH2_STREAM_STDIO );

    // $output = json_encode( stream_get_contents( $stream_out ) );
    $output = json_decode( str_replace( 'DISK1-/', 'DISK1', str_replace( '5MINLOAD', 'L5MLOAD', str_replace( '1MINLOAD', 'L1MLOAD', stream_get_contents( $stream_out ) ) ) ) );
    // $output = stream_get_contents( $stream_out );

    // $output = str_replace( '\\', '', $temp );
    // print_r( $output[0]->HOSTNAME );
    // var_dump( $output );

    if( $output->CPUUSED > 85 || $output->CPUWAIT > 85 || $output->MEMUSED > 85 || $output->SWPUSED > 85 || $output->L1MLOAD > 10 || $output->DISK1 > 85 ) {
        $img = 'https://content.presentermedia.com/content/animsp/00013000/13449/cylinder_siren_anim_md_nwm_v2.gif';
    } else {
        $img = 'images/Support-logo.jpg';
    }

    if ( $output->L1MLOAD < 5 ) { 
        $l1mLoadColor = '#60ff00';
    } elseif ( $output->L1MLOAD < 10 ) { 
        $l1mLoadColor = '#fff000';
    } else { 
        $l1mLoadColor = '#e74c3c';
    } 

    if ( $output->L5MLOAD < 5 ) { 
        $l5mLoadColor = '#60ff00';
    } elseif ( $output->L5MLOAD < 10 ) { 
        $l5mLoadColor = '#fff000';
    } else { 
        $l5mLoadColor = '#e74c3c';
    } 

    if ( $output->HTTPDMEM < 5 ) { 
        $htmemColor = '#60ff00';
    } elseif ( $output->HTTPDMEM < 10 ) { 
        $htmemColor = '#fff000';
    } else { 
        $htmemColor = '#e74c3c';
    } 

    if ( $output->HTTPDHIT < 3600 ) { 
        $hthitsColor = '#60ff00';
    } elseif ( $output->HTTPDHIT < 7200 ) { 
        $hthitsColor = '#fff000';
    } else { 
        $hthitsColor = '#e74c3c';
    } 

    if ( $output->MYSQLMEM < 100 ) { 
        $mysqlmColor = '#60ff00';
    } elseif ( $output->MYSQLMEM < 200 ) { 
        $mysqlmColor = '#fff000';
    } else { 
        $mysqlmColor = '#e74c3c';
    } 

    $content .= '<div class="col p-md-3 pb-5">';
    $content .= '<div class="card" style="width: 100%;">';
    $content .= '<img src="' . $img . '" class="card-img-top mx-auto" />';
    $content .= '<div class="card-body">';
    $content .= '<h1 class="text-center">' . $output->HOSTNAME . '</h1>';
    $content .= '<div class="row px-0 py-md-3 py-0">';
    $content .= '<div class="col-6 col-md-3"><i class="fa-solid fa-clock-rotate-left"></i> Update:</div>';
    $content .= '<div class="col-6 col-md-3">' . $output->TIMERUN . '</div>';
    $content .= '<div class="col-6 col-md-4"><i class="fa-solid fa-clock-rotate-left"></i> Uptime:</div>';
    $content .= '<div class="col-6 col-md-2">' . $output->UPTIME . '</div>';
    $content .= '</div>';
    $content .= '<div class="row px-0 py-md-3 py-0">';
    $content .= '<div class="col-6 col-md-3"><i class="fa-solid fa-microchip"></i> CPU Usage:</div>';
    $content .= '<div class="col-6 col-md-3">' . $output->CPUUSED . '</div>';
    $content .= '<div class="col-6 col-md-4"><i class="fa-solid fa-microchip"></i> CPU Wait:</div>';
    $content .= '<div class="col-6 col-md-2">' . $output->CPUWAIT . '</div>';
    $content .= '</div>';
    $content .= '<div class="row px-0 py-md-3 py-0">';
    $content .= '<div class="col-6 col-md-3"><i class="fa-solid fa-memory"></i> RAM Usage:</div>';
    $content .= '<div class="col-6 col-md-3">' . $output->MEMUSED . '</div>';
    $content .= '<div class="col-6 col-md-4"><i class="fa-solid fa-right-left"></i> SWAP Usage:</div>';
    $content .= '<div class="col-6 col-md-2">' . $output->SWPUSED . '</div>';
    $content .= '</div>';
    $content .= '<div class="row px-0 py-md-3 py-0">';
    $content .= '<div class="col-6 col-md-3"><i class="fa-solid fa-bars-progress"></i> 1 Min Load:</div>';
    $content .= '<div class="col-6 col-md-3"><span style="color: ' . $l1mLoadColor . ';">' . $output->L1MLOAD . '</span></div>';
    $content .= '<div class="col-6 col-md-4"><i class="fa-solid fa-bars-progress"></i> 5 Min Load:</div>';
    $content .= '<div class="col-6 col-md-2"><span style="color: ' . $l5mLoadColor . ';">' . $output->L5MLOAD . '</span></div>';
    $content .= '</div>';
    $content .= '<div class="row px-0 pt-md-3 pb-md-4 pt-0 pb-4 border-bottom">';
    $content .= '<div class="col-6 col-md-3"><i class="fa-solid fa-hard-drive"></i> Disk Usage [/]:</div>';
    $content .= '<div class="col-6 col-md-3">' . $output->DISK1 . '%</div>';

    if( isset( $output->DISK2 ) && $output->DISK2 != '' && $output->DISK2 != 0 ) {
        $content .= '<div class="col-6 col-md-4"><i class="fa-solid fa-hard-drive"></i> Disk Usage [/home]:</div>';
        $content .= '<div class="col-6 col-md-2">' . $output->DISK2 . '%</div>';
    }

    $content .= '</div>';

    if( isset( $output->HTCPU ) && $output->HTCPU != '' ) {
        $content .= '<div class="row px-0 pt-4 pb-md-3">';
        $content .= '<div class="col-6 col-md-3"><i class="fa-solid fa-cloud-arrow-down"></i> HTTP CPU%:</div>';
        $content .= '<div class="col-6 col-md-3">' . $output->HTCPU . ' MB</div>';
        $content .= '<div class="col-6 col-md-4"><i class="fa-solid fa-memory"></i> HTTP RAM:</div>';
        $content .= '<div class="col-6 col-md-2"><span style="color: ' . $htmemColor . ';">' . $output->HTMEM . ' MB</span></div>';
        $content .= '</div>';
        $content .= '<div class="row px-0 py-md-3 py-0">';
        $content .= '<div class="col-6 col-md-3"><i class="fa-solid fa-cloud-bolt"></i> HTTP Hits:</div>';
        $content .= '<div class="col-6 col-md-3"><span style="color: ' . $hthitsColor . ';">' . $output->HTHITS . '</span></div>';
        $content .= '<div class="col-6 col-md-4"><i class="fa-solid fa-arrows-spin"></i> HTTP Process:</div>';
        $content .= '<div class="col-6 col-md-2">' . $output->HTSSS . '</div>';
        $content .= '</div>';
    }

    if ( ( isset( $output->MYSQLC ) && $output->MYSQLC != '' ) || ( isset( $output->MYSQLM ) && $output->MYSQLM != '' ) ) {
        if( $output->MYSQLC == '' ) {
        $mysqlc = 0;
        } else {
        $mysqlc = $output->MYSQLC;
        }

        if( $output->MYSQLM == '' ) {
        $mysqlm = 0;
        } else {
        $mysqlm = $output->MYSQLM;
        }

        $content .= '<div class="row px-0 py-md-3 py-0">';
        $content .= '<div class="col-6 col-md-3"><i class="fa-solid fa-memory"></i> MySQL CPU%:</div>';
        $content .= '<div class="col-6 col-md-3">' . $mysqlc . '%</div>';
        $content .= '<div class="col-6 col-md-4"><i class="fa-solid fa-right-left"></i> MySQL RAM:</div>';
        $content .= '<div class="col-6 col-md-2"><span style="color: ' . $mysqlmColor . ';">' . $mysqlm . ' MB</span></div>';
        $content .= '</div>';
    }

    $content .= '</div>';
    $content .= '</div>';
    $content .= '</div>';

    echo $content;

    $content = '';
    $output = '';
}

echo '</div>';
echo '</div>';

include( 'footer.php' );

?>