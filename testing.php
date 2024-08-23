<?php 
class Testing{
    private static function GetShortTerms()
    {
        return array(
            'ave',
            'ave.','ave,',
            'blvd',
            'blvd.','blvd,',
            'br',
            'br.','br,',
            'cyn',
            'cyn.','cyn,',
            'ctr',
            'ctr.','ctr,',
            'cir',
            'cir.','cir,',
            'ct',
            'ct.','ct,',
            'cres',
            'cres.','cres,',
            'dr',
            'dr.','dr,',
            'expwy',
            'expwy.','expwy,',
            'fwy',
            'fwy.','fwy,',
            'hwy',
            'hwy.','hwy,',
            'info',
            'info.','info,',
            'intl',
            'intl.','intl,',
            'isl',
            'isl.','isl,',
            'jct',
            'jct.','jct,',
            'ln',
            'ln.','ln,',
            'lk',
            'lk.','lk,',
            'lp',
            'lp.','lp,',
            'mt',
            'mt.','mt,',
            'mtn',
            'mtn.','mtn,',
            'natl',
            'natl.','natl,',
            'pkwy',
            'pkwy.','pkwy,',
            'pl',
            'pl.','pl,',
            'plz',
            'plz.','plz,',
            'pt',
            'pt.','pt,',
            'r',
            'r.','r,',
            'rd',
            'rd.','rd,',
            'rte',
            'rte.','rte,',
            'sq',
            'sq.','sq,',
            'st',
            'st.','st,',
            'ter',
            'ter.','ter,',
            'thwy',
            'thwy.','thwy,',
            'tr',
            'tr.','tr,',
            'trl',
            'trl.','trl,',
            'tpk',
            'tpk.','tpk,',
            'wy',
            'wy.','wy,',
        );
    }

    private static function GetFullForm()
    {
        return array(
            'avenue',
            'avenue','avenue',
            'boulevard',
            'boulevard','boulevard',
            'bridge',
            'bridge','bridge',
            'canyon',
            'canyon','canyon',
            'center',
            'center','center',
            'circle',
            'circle','circle',
            'court',
            'court','court',
            'crescent',
            'crescent','crescent',
            'drive',
            'drive','drive',
            'expressway',
            'expressway','expressway',
            'freeway',
            'freeway','freeway',
            'highway',
            'highway','highway',
            'information',
            'information','information',
            'international',
            'international','international',
            'island',
            'island','island',
            'junction',
            'junction','junction',
            'lane',
            'lane','lane',
            'lake',
            'lake','lake',
            'loop',
            'loop','loop',
            'mount',
            'mount','mount',
            'mountain',
            'mountain','mountain',
            'national',
            'national','national',
            'parkway',
            'parkway','parkway',
            'place',
            'place','place',
            'plaza',
            'plaza','plaza',
            'port',
            'port','port',
            'river',
            'river','river',
            'road',
            'road','road',
            'route',
            'route','route',
            'square',
            'square','square',
            'street',
            'street','street',
            'terrace',
            'terrace','terrace',
            'thruway',
            'thruway','thruway',
            'trail',
            'trail','trail',
            'trail',
            'trail','trail',
            'turnpike',
            'turnpike','turnpike',
            'way',
            'way','way'
        );
    }

    private static function GetDirShort()
    {
        return array(
            'e',
            'e.','e,',
            'n',
            'n.','n,',
            'ne',
            'ne.','ne,',
            'nw',
            'nw.','nw,',
            's',
            's.','s,',
            'se',
            'se.','se,',
            'sw',
            'sw.','sw,',
            'w',
            'w.','w,'
        );
    }

    private static function GetDirLong()
    {
        return array(
            'east',
            'east','east',
            'north',
            'north','north',
            'northeast',
            'northeast','northeast',
            'northwest',
            'northwest','northwest',
            'south',
            'south','south',
            'southeast',
            'southeast','southeast',
            'southwest',
            'southwest','southwest',
            'west',
            'west', 'west'
        );
    }
static function FindInbestmentsPropertyID($InsightsPropertyID, $Address, $City, $State, $UnitNumber, $ZipCode)
{
    $searchTxtLower = trim(strtolower($Address));
    echo '1';
    echo '$searchTxtLower';
    print_r($searchTxtLower);
    $searchTxtLowerArr = explode(' ', $searchTxtLower);
    echo '2';
    echo '$searchTxtLowerArr';
    print_r($searchTxtLowerArr);
    $long = self::GetFullForm();
    $short = self::GetShortTerms();
    $dirLong = self::GetDirLong();
    $dirShort = self::GetDirShort();

    /* All short format */
    for ($i = 0; $i < count($searchTxtLowerArr); $i++) {
        for ($j = 0; $j < count($long); $j++) {
            if (trim($searchTxtLowerArr[$i]) == trim($long[$j])) {
                $searchTxtLowerArr[$i] = $short[$j];
            }
        }
        for ($j = 0; $j < count($dirLong); $j++) {
            if (trim($searchTxtLowerArr[$i]) == trim($dirLong[$j])) {
                $searchTxtLowerArr[$i] = $dirShort[$j];
            }
        }
    }
    echo '3';
    echo '$searchTxtLower';
    print_r($searchTxtLowerArr);

    /*Combine All format*/
    $allFormat = [join(' ', $searchTxtLowerArr)];
    echo '4';
    echo '$allFormat';
    print_r($allFormat);
    echo '$searchTxtLower';
    print_r($searchTxtLower);
    for ($i = 0; $i < count($searchTxtLowerArr); $i++) {
        $temp = $searchTxtLowerArr;
        $tempFull = $searchTxtLowerArr;
        $tempDot = $searchTxtLowerArr;
        $tempComma = $searchTxtLowerArr;
        for ($j = 0; $j < count($short); $j++) {
            if (is_string(trim($temp[$i]))){
                if (trim($temp[$i]) == trim($short[$j])) {
                    $tempFull[$i] = $long[$j];
                    array_push($allFormat, join(' ', $tempFull));
                   
                    if (strpos($temp[$i], ".") !== false) {
                        $tempDot[$i] = str_replace(".", "", $temp[$i]);
                        array_push($allFormat, join(' ', $tempDot));
                    }else{                            
                        $tempDot[$i] = $temp[$i].".";
                        array_push($allFormat, join(' ', $tempDot));
                    }

                    if (strpos($temp[$i], ",") !== false) {
                        $tempComma[$i] = str_replace(",", "", $temp[$i]);
                        array_push($allFormat, join(' ', $tempComma));                            
                    }else{
                        $tempComma[$i] = $temp[$i].",";
                        array_push($allFormat, join(' ', $tempComma));
                    }
                    break;
                }
            }
        }
        echo '5';
        echo '$allFormat';
        print_r($allFormat);
        echo '$searchTxtLower';
        print_r($searchTxtLowerArr);
        for ($j = 0; $j < count($dirShort); $j++) {
            if (is_string(trim($temp[$i]))){
                if (trim($temp[$i]) == trim($dirShort[$j])) {
                    $tempFull[$i] = $dirLong[$j];
                    array_push($allFormat, join(' ', $tempFull));

                    if (strpos($temp[$i], ".") !== false) {
                        $tempDot[$i] = str_replace(".", "", $temp[$i]);
                        array_push($allFormat, join(' ', $tempDot));
                    }else{
                        $tempDot[$i] = $temp[$i].".";
                        array_push($allFormat, join(' ', $tempDot));                            
                    }

                    if (strpos($temp[$i], ",") !== false) {
                        $tempComma[$i] = str_replace(",", "", $temp[$i]);
                        array_push($allFormat, join(' ', $tempComma));
                    }else{
                        $tempComma[$i] = $temp[$i].",";
                        array_push($allFormat, join(' ', $tempComma));                            
                    }
                    break;
                }
            }
        }
        echo '6';
        echo '$allFormat';
        print_r($allFormat);
        echo '$searchTxtLower';
        print_r($searchTxtLowerArr);
        for ($k = $i; $k < count($searchTxtLowerArr); $k++) {
            for ($j = 0; $j < count($short); $j++) {
                if (is_string(trim($temp[$k]))){
                    if (trim($temp[$k]) == trim($short[$j])) {
                        $tempFull[$k] = $long[$j];
                        array_push($allFormat, join(' ', $tempFull));

                        if (strpos($temp[$k], ".") !== false) {
                            $tempDot[$k] = str_replace(".", "", $temp[$k]);
                            array_push($allFormat, join(' ', $tempDot));
                        }else{
                            $tempDot[$k] = $temp[$k].".";
                            array_push($allFormat, join(' ', $tempDot));
                        }

                        if (strpos($temp[$k], ",") !== false) {
                            $tempComma[$k] = str_replace(",", "", $temp[$k]);
                            array_push($allFormat, join(' ', $tempComma));
                        }else{
                            $tempComma[$k] = $temp[$k].",";
                            array_push($allFormat, join(' ', $tempComma));                                
                        }
                        break;
                    }
                }
            }
            echo '7';
            echo '$allFormat';
            print_r($allFormat);
            echo '$searchTxtLower';
            print_r($searchTxtLowerArr);
            for ($j = 0; $j < count($dirShort); $j++) {
                if (is_string(trim($temp[$k]))){
                    if (trim($temp[$k]) == trim($dirShort[$j])) {
                        $tempFull[$k] = $dirLong[$j];
                        array_push($allFormat, join(' ', $tempFull));

                        if (strpos($temp[$k], ".") !== false) {
                            $tempDot[$k] = str_replace(".", "", $temp[$k]);
                            array_push($allFormat, join(' ', $tempDot));
                        }else{
                            $tempDot[$k] = $temp[$k].".";
                            array_push($allFormat, join(' ', $tempDot));
                            
                        }

                        if (strpos($temp[$k], ",") !== false) {
                            $tempComma[$i] = str_replace(",", "", $temp[$i]);
                            array_push($allFormat, join(' ', $tempComma));
                        }else{
                            $tempComma[$k] = $temp[$k].",";
                            array_push($allFormat, join(' ', $tempComma));
                            
                        }
                        break;
                    }
                }
            }
            echo '8';
            echo '$allFormat';
            print_r($allFormat);
            echo '$searchTxtLower';
            print_r($searchTxtLowerArr);
            for ($l = $k; $l < count($searchTxtLowerArr); $l++) {
                for ($j = 0; $j < count($short); $j++) {
                    if (is_string(trim($temp[$l]))){
                        if (trim($temp[$l]) == trim($short[$j])) {
                            $tempFull[$l] = $long[$j];
                            array_push($allFormat, join(' ', $tempFull));
                            
                            if (strpos($temp[$l], ".") !== false) {
                                $tempDot[$l] = str_replace(".", "", $temp[$l]);
                                array_push($allFormat, join(' ', $tempDot));
                            }else{
                                $tempDot[$l] = $temp[$l].".";
                                array_push($allFormat, join(' ', $tempDot));
                                
                            }
    
                            if (strpos($temp[$l], ",") !== false) {
                                $tempComma[$l] = str_replace(",", "", $temp[$l]);
                                array_push($allFormat, join(' ', $tempComma));
                            }else{
                                $tempComma[$l] = $temp[$l].",";
                                array_push($allFormat, join(' ', $tempComma));
                                
                            }
                            break;
                        }
                    }
                }
                echo '9';
                echo '$allFormat';
                print_r($allFormat);
                echo '$searchTxtLower';
                print_r($searchTxtLowerArr);
                /*
                for ($j = 0; $j < count($dirShort); $j++) {
                    if (is_string(trim($temp[$l]))){
                        if (trim($temp[$l]) == trim($dirShort[$j])) {
                            $tempFull[$l] = $dirLong[$j];
                            array_push($allFormat, join(' ', $tempFull));
                            
                            if (strpos($temp[$l], ".") !== false) {
                                $tempDot[$l] = str_replace(".", "", $temp[$l]);
                                array_push($allFormat, join(' ', $tempDot));
                            }else{
                                $tempDot[$l] = $temp[$l].".";
                                array_push($allFormat, join(' ', $tempDot));
                                
                            }
    
                            if (strpos($temp[$l], ",") !== false) {
                                $tempComma[$l] = str_replace(",", "", $temp[$l]);
                                array_push($allFormat, join(' ', $tempComma));
                            }else{
                                $tempComma[$l] = $temp[$l].",";
                                array_push($allFormat, join(' ', $tempComma));
                                
                            }
                            break;
                        }
                    }
                }*/
            }
        }
    }
    echo '10';
    echo '$allFormat';
    print_r($allFormat);
    echo '$searchTxtLower';
    print_r($searchTxtLowerArr);
    $allFormat = array_unique($allFormat);

   return $allFormat;
}
}

print_r("Hello");
print_r(Testing::FindInbestmentsPropertyID('3', '789 Oak St', 'Oakland', 'CA', '94607', 'N'));