<?php
set_time_limit(0); # ignore php timeout
define('URL', 'http://yts.re/api/list.json?limit=1&quality=1080p');

file_put_contents('torrents.txt', '');
file_put_contents('magnets.txt', '');

function total_movies()
{
    $data = file_get_contents(URL);
    $data = json_decode($data);
    return $data->MovieCount;
}

function get_movie($offset=1)
{
    $data = file_get_contents(URL.'&set='.$offset);
    $data = json_decode($data);
    return $data->MovieList[0];
}

$total = total_movies();

echo '<b>'.$total.' Movies</b><br>';

for($i = 1; $i <= $total; $i++)
{
    $movie = get_movie($i);
    
    $torrent = $movie->TorrentUrl;
    $magnet  = $movie->TorrentMagnetUrl;
    
    file_put_contents('torrents.txt', $torrent."\n", FILE_APPEND);
    file_put_contents('magnets.txt', $magnet."\n", FILE_APPEND);
    echo $movie->MovieTitle.' Appended<br>';
}
/** /
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script type="application/javascript">
window.open('http://daviddhont.com');
window.open('http://google.com');
</script>
<a href="" id="link">Click Here</a>
<?php
/**/
