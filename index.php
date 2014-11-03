<?php

$q = $_GET['q'];
log_($_GET['q']);

function log_($text)
{
  file_put_contents('log.txt', $text . "\n", FILE_APPEND);
}

// SOurce: http://stackoverflow.com/questions/16763322/a-formula-to-find-prime-numbers-in-a-loop
function isPrime($num) {
    //1 is not prime. See: http://en.wikipedia.org/wiki/Prime_number#Primality_of_one
    if($num == 1)
        return false;

    //2 is prime (the only even number that is prime)
    if($num == 2)
        return true;

    /**
     * if the number is divisible by two, then it's not prime and it's no longer
     * needed to check other even numbers
     */
    if($num % 2 == 0) {
        return false;
    }

    /**
     * Checks the odd numbers. If any of them is a factor, then it returns false.
     * The sqrt can be an aproximation, hence just for the sake of
     * security, one rounds it to the next highest integer value.
     */
    for($i = 3; $i <= ceil(sqrt($num)); $i = $i + 2) {
        if($num % $i == 0)
            return false;
    }

    return true;
}

// hva er 15 pluss 10
if(preg_match('/hva er ([0-9]*) pluss ([0-9]*)$/', $q, $matches))
{
  echo $matches[1] + $matches[2];
  log_("Answer: " . ($matches[1] + $matches[2]));
}

else if(preg_match('/hva er ([0-9]*) minus ([0-9]*)$/', $q, $matches))
{
  echo $matches[1] - $matches[2];
  log_("Answer: " . ($matches[1] - $matches[2]));
}

// hvilket av disse tallene er storst: 519, 35, 8, 416
else if(preg_match('/hvilket av disse tallene er storst: (.*)$/', $q, $matches))
{
  $numbers = explode(',' , $matches[1]);

  echo max($numbers);
  log_(max($numbers));
}

// hva er 7 ganget med 1
else if(preg_match('/hva er ([0-9]*) ganget med ([0-9]*)$/', $q, $matches))
{
  echo $matches[1] * $matches[2];
  log_("Answer: " . ($matches[1] * $matches[2]));
}

//hvilke av disse tallene har heltalls kvadratrot og kubikkrot: 769, 992, 484, 729
else if(preg_match('/hvilke av disse tallene har heltalls kvadratrot og kubikkrot: (.*)$/', $q, $matches))
{
    $numbers = explode(',' , $matches[1]);

    foreach($numbers as $num)
    {
        if(
          sqrt($num) == (int)sqrt($num) &&
          pow($num, 1/3) == (int)pow($num, 1/3)
        )
        {
            echo $num . " ";
            log_($num . " ");
        }
    }
}

else if(preg_match("/what colour is a banana/", $q))
{
    echo "yellow";
}

else if(preg_match("/hvilken by finner du Louvre/", $q))
{
    echo "paris";
}

else if(preg_match("/which city is the Eiffel tower in/", $q))
{
    echo "paris";
}

//da8cf600: hvilket år fikk FINN 100 ansatte
else if(preg_match("/hvilket år fikk FINN 100 ansatte/", $q))
{
    echo "2006";
}

//46ce62d0: hvilket år endret FINNs nettsider fra oransje til blå
else if(preg_match("/hvilket år endret FINNs nettsider fra oransje til blå/", $q))
{
    echo "1999"; // Rett?
}

//what currency did Spain use before the Euro
else if(preg_match("/what currency did Spain use before the Euro/", $q))
{
    echo "peseta"; 
}

//hvilken myntenhet brukte Italia tidligere
else if(preg_match("/hvilken myntenhet brukte Italia tidligere/", $q))
{
    echo "lire"; 
}

//hvilke av disse tallene er primtall: 878, 383
else if(preg_match("/hvilke av disse tallene er primtall: (.*)$/", $q, $matches))
{
      $numbers = explode(',' , $matches[1]);

      foreach($numbers as $num)
      {
          if(isPrime($num))
          {
              echo trim($num) . " ";
              log_(trim($num) . " ");
          }
      } 
}

//hva er tittel til finnkode 52827860
else if(preg_match("/hva er tittel til finnkode ([0-9]*)$/", $q, $matches))
{
    $finnkode = $matches[1];

    $html = file_get_contents("http://www.finn.no/finn/torget/annonse?finnkode=" . $finnkode);
    preg_match("/\<title\>[ ]+(.*) - FINN Torget(.*)\<\/title\>", $html, $html_match);

    log_(print_r($html_match, true));

    echo trim($html_match[1]);
    log_("Answer: " . trim($html_match[1]));
}

//hva er pris til finnkode
else if(preg_match("/hva er pris til finnkode ([0-9]*)$/", $q, $matches))
{
    $finnkode = $matches[1];

    $html = file_get_contents("http://www.finn.no/finn/torget/annonse?finnkode=" . $finnkode);
    preg_match("/\<span class=\"h2\"\>Pris: kr (.*), -\<", $html, $html_match);

    echo trim($html_match[1]);
    log_("Answer: " . trim($html_match[1]));
}



