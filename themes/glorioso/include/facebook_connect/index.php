<fb:dashboard>
</fb:dashboard>
   <fb:tabs>
      <fb:tab-item title='Benvenuto' selected = 'true' />
      <fb:tab-item href='http://www.parrocchiasanlino.org/index.php?mod=facebook' title='APPLICAZIONE' />
      <fb:tab-item href='suggerimenti.php' title='SUGGERIMENTI' />
   </fb:tabs>
<div style="float:right;">
<fb:bookmark></fb:bookmark>
</div>

<?php
// Copyright 2007 Facebook Corp.  All Rights Reserved.
//
// Application: Consulta di Pastorale Giovanile Prefettura 33 Roma
// File: 'index.php'
//   This is a sample skeleton for your application.
//

       try{
            $appfriends = file_get_contents(
    'https://api.facebook.com/method/friends.getAppUsers?' .
    'format=json&access_token=117247878295018|219dccf0f444d1fe183717bf-648770986|oB-KyMi6B9tDGYCX1QPzYy4srxw');
            $appfriends = explode(",",    preg_replace("(^\[|\]$)", "", $appfriends)
    );
        }
        catch(Exception $o){
            print_r($o);
        }

$string = "<span>Ciao!</span><br />";
$string .= "<span>Benvenuto alla pagina Facebook della Parrocchia San Lino!</span><br />";
$string .= "<span>Per il momento questa pagina � molto essenziale; col tempo potr� migliorare. Intanto visita direttamente questa applicazione <a href='http://www.parrocchiasanlino.org/index.php?mod=facebook'>QUI</a>.</span><br />";
$string .= "<span>I tuoi suggerimenti sono benvenuti. Puoi scriverli <a href='http://apps.facebook.com/parrocchiasanlino/suggerimenti.php'>QUI</a>.</span><br /><br />";
$string .= "<span>Visita<a href='http://www.facebook.com/group.php?gid=50430815024'> qui </a>il gruppo facebook della parrocchia di San Lino!</span><br />";
$string .= "<span>(La bacheca di questo gruppo la trovate anche sul sito parrocchiale seguendo il link di cui sopra ossia<a href='http://www.parrocchiasanlino.org/index.php?mod=facebook'> qui </a></span><br /><br />";
$string = utf8_encode($string);

echo "<div style=\"float:right;margin:3px;\"><fb:iframe scrolling=\"no\" frameborder=\"0\" src=\"http://www.facebook.com/connect/connect.php?id=117247878295018&connections=5&stream=0&locale=it_IT\" allowtransparency=\"true\" style=\"border: none; width: 300px; height:200px;\"></fb:iframe><div style=\"font-size:8px; padding-left:10px\"><a href=\"http://apps.facebook.com/parrocchiasanlino\">Parrocchia San Lino</a> su Facebook</div></div>";
echo "<div style=\"border:1px groove LightGrey;padding:15px; height:200px;\">".$string;

echo "</div>";

$howmanyfriends=sizeof($appfriends);

echo "<br /><center>";
echo "<div style=\"display:table-cell;border:groove 1px Blue;background-color:LightGray;padding:0px;text-align:center;\">";
echo "<div style=\"display:table-cell;border:groove 3px White;background-color:LightGray;padding:5px;text-align:center;margin:-1px;\">";
echo "<span style=\"color:DarkRed;\">Hai <b>$howmanyfriends</b> amici Facebook che utilizzano questa applicazione:</span>";
echo "<br /><br /><table><tr>";
foreach($appfriends as $appfriend){
  echo "<td style='border:1px DarkBlue outset;padding:1px;text-align:center;'><fb:profile-pic uid=\"$appfriend\" size=\"square\"></fb:profile-pic><br /><fb:name uid=\"$appfriend\" firstnameonly=true></fb:name></td>";
}
echo "</tr></table>";
echo "<span style=\"color:DarkRed;\">Iscriviti anche tu! Aggiunge l'applicazione Parrocchia San Lino.</span>";
echo "</div></div></center><br /><br />";
?>


<div>
<fb:fbml>
<fb:request-form
action="grazie.php"
method="POST"
invite="true" 
type="Parrocchia San Lino - Diocesi di Roma"
content="Connettiti anche tu! <?php echo htmlentities("<fb:req-choice url=\"http://apps.facebook.com/parrocchiasanlino/\" label=\"Connettiti a Parrocchia San Lino - ROMA\">") ?>" >
<fb:multi-friend-selector showborder="false" actiontext="Invita i tuoi amici ad usare Parrocchia San Lino - Diocesi di Roma." exclude_ids="<?php echo $listappfriends ?>" />
</fb:request-form>
</fb:fbml>
</div>