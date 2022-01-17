<?php
$kaubad=simplexml_load_file("nimetus.xml");
// otsing nimetuse järgi

function searchByName($query){
    global $kaubad;
    $result=array();
    foreach ($kaubad->kaup as $kaup){
        if(substr(strtolower($kaup->nimetus), 0,strlen($query))==
        strtolower($query)){
            array_push($result, $kaup);
        }
    }
    return $result;
}

// andmete lisamine xml-i
if(isset($_POST['submit'])){

    $xmlDoc=new DOMDocument("1.0", "UTF-8");
    $nimi=$_POST['nimi'];
    $hind=$_POST['hind'];
    $vaasta=$_POST['vaasta'];
    $grupp=$_POST['grupp'];
    $kirjeldus=$_POST['kirjeldus'];

    $xml_kaubad=$kaubad->addChild('kaup');
    $xml_kaubad->addChild('nimetus', $nimi);
    //addchild('xml struktuur', $nimi - tekts väli)
    $xml_kaubad->addChild('hind', $hind);


    $xml_kaubagrupp=$xml_kaubad->addChild('kaubagrupp');
    $xml_kaubagrupp->addChild('grupinimi', $grupp);
    $xml_kaubagrupp->addChild('kirjeldus', $kirjeldus);

    $xmlDoc->loadXML($kaubad->asXML(), LIBXML_NOBLANKS);
    $xmlDoc->preserveWhiteSpace=false;
    $xmlDoc->formatOutput=true;
    $xmlDoc->save('nimetus.xml');
    header("refresh: 0;");


}

?>

<!Doctype html>
<html>
<head>
    <title>XML andmed</title>
</head>
<body>
<h1>XML failist andmed</h1>
<form action="?" method="post">
    <label for="otsing">Otsing</label>
    <input type="text" name="otsing" id="otsing" placeholder="nimetus">
    <input type="submit" value="Otsi">
</form>
<?php
if(!empty($_POST['otsing'])){
    $result=searchByName($_POST['otsing']);
    foreach ($result as $kaup){
        echo "<li>".$kaup->nimetus;
        echo", " . $kaup->vaasta;
        echo", " . $kaup->kaubagrupp->grupinimi;
        echo", " . $kaup->kaubagrupp->kirjeldus;
        echo", " . $kaup->hind. '</li>';

    }
}
?>
<table>
    <tr>
        <th>Kaubanimetus</th>
        <th>Hind</th>
        <th>Väljastamise aasta</th>
        <th>Kaubagrupp</th>

    </tr>
    <?php
    foreach ($kaubad->kaup as $kaup){
        echo "<tr>";
        echo "<td>". ($kaup->nimetus). "</td>";
        echo "<td>". ($kaup->hind). "</td>";
        echo "<td>". ($kaup->vaasta). "</td>";
        echo "<td>". ($kaup->kaubagrupp->grupinimi). "</td>";
        echo "<td>". ($kaup->kaubagrupp->kirjeldus). "</td>";

        echo "</tr>";
    }
    ?>
</table>
<h1>Andmete lisamine xml faili sisse</h1>
<form action="" method="post">
    <table>
        <tr>
            <td><label for="nimi">Kauba nimetus</label></td>
            <td><input type="text" id="nimi" name="nimi"></td>
        </tr>
        <tr>
            <td><label for="hind">Hind</label></td>
            <td><input type="text" id="hind" name="hind"></td>
        </tr>
        <tr>
            <td><label for="vaasta">Vaasta</label></td>
            <td><input type="text" id="vaasta" name="vaasta"></td>
        </tr>
        <tr>
            <td><label for="grupinimi">Kaubagrupp -> grupinimi</label></td>
            <td><input type="text" id="grupinimi" name="grupp"></td>
        </tr>
        <tr>
            <td><label for="kirjeldus">Kaubagrupp -> kirjeldus</label></td>
            <td><input type="text" id="kirjeldus" name="kirjeldus"></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="lisa" name="submit" id="submit">
            </td>
        </tr>
    </table>
</form>
<h1>RSS Rich Summary Site uudised</h1>
<h2>RSS uudised  lehelt</h2>
<ul></ul>

<?php
$feed=simplexml_load_file('https://rus.err.ee/rss');
$linkide_arv=10;
$loendur=1;

foreach ($feed->channel->item as $item){
    echo "<li>";
    echo "<a href='$item->link' target='_blank'> $item->title <a/>";
    echo "</li>";
    $loendur++;
}
?>
</body>
</html>

