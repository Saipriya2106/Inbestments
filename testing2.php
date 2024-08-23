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


    // Replace short and directional terms
    $shortToLong = array_combine($short, $long);
    $dirShortToLong = array_combine($dirShort, $dirLong);
    
    $allFormat = [];

    for ($i = 0; $i < count($searchTxtLowerArr); $i++) {
        $currentTerm = trim($searchTxtLowerArr[$i]);

        if (isset($shortToLong[$currentTerm])) {
            $temp = $searchTxtLowerArr;
            $temp[$i] = $shortToLong[$currentTerm];
            array_push($allFormat, join(' ', $temp));
            $allFormat = array_merge($allFormat, self::handlePunctuation($temp, $i, $short[$currentTerm]));
        }

        if (isset($dirShortToLong[$currentTerm])) {
            $temp = $searchTxtLowerArr;
            $temp[$i] = $dirShortToLong[$currentTerm];
            array_push($allFormat, join(' ', $temp));
            $allFormat = array_merge($allFormat, self::handlePunctuation($temp, $i, $dirShort[$currentTerm]));
        }
    }

    return array_unique($allFormat);
}

private static function handlePunctuation($temp, $index, $originalTerm)
{
    $allFormats = [];

    if (strpos($originalTerm, ".") !== false) {
        $tempDot = $temp;
        $tempDot[$index] = str_replace(".", "", $temp[$index]);
        array_push($allFormats, join(' ', $tempDot));
    } else {
        $tempDot = $temp;
        $tempDot[$index] = $temp[$index] . ".";
        array_push($allFormats, join(' ', $tempDot));
    }

    if (strpos($originalTerm, ",") !== false) {
        $tempComma = $temp;
        $tempComma[$index] = str_replace(",", "", $temp[$index]);
        array_push($allFormats, join(' ', $tempComma));
    } else {
        $tempComma = $temp;
        $tempComma[$index] = $temp[$index] . ",";
        array_push($allFormats, join(' ', $tempComma));
    }

    return $allFormats;

  
}
}

print_r("Hello");
print_r(Testing::FindInbestmentsPropertyID('3', '789 Oak St', 'Oakland', 'CA', '94607', 'N'));

/*

$searchTxtLower = trim(strtolower($Address));
    $searchTxtLowerArr = explode(' ', $searchTxtLower);

    $long = self::GetFullForm();
    $short = self::GetShortTerms();
    $dirLong = self::GetDirLong();
    $dirShort = self::GetDirShort();

    // Replace short and directional terms
    $shortToLong = array_combine($short, $long);
    $dirShortToLong = array_combine($dirShort, $dirLong);
    
    $allFormat = [];

    for ($i = 0; $i < count($searchTxtLowerArr); $i++) {
        $currentTerm = trim($searchTxtLowerArr[$i]);

        if (isset($shortToLong[$currentTerm])) {
            $temp = $searchTxtLowerArr;
            $temp[$i] = $shortToLong[$currentTerm];
            array_push($allFormat, join(' ', $temp));
            $allFormat = array_merge($allFormat, self::handlePunctuation($temp, $i, $short[$currentTerm]));
        }

        if (isset($dirShortToLong[$currentTerm])) {
            $temp = $searchTxtLowerArr;
            $temp[$i] = $dirShortToLong[$currentTerm];
            array_push($allFormat, join(' ', $temp));
            $allFormat = array_merge($allFormat, self::handlePunctuation($temp, $i, $dirShort[$currentTerm]));
        }
    }

    return array_unique($allFormat);
}

private static function handlePunctuation($temp, $index, $originalTerm)
{
    $allFormats = [];

    if (strpos($originalTerm, ".") !== false) {
        $tempDot = $temp;
        $tempDot[$index] = str_replace(".", "", $temp[$index]);
        array_push($allFormats, join(' ', $tempDot));
    } else {
        $tempDot = $temp;
        $tempDot[$index] = $temp[$index] . ".";
        array_push($allFormats, join(' ', $tempDot));
    }

    if (strpos($originalTerm, ",") !== false) {
        $tempComma = $temp;
        $tempComma[$index] = str_replace(",", "", $temp[$index]);
        array_push($allFormats, join(' ', $tempComma));
    } else {
        $tempComma = $temp;
        $tempComma[$index] = $temp[$index] . ",";
        array_push($allFormats, join(' ', $tempComma));
    }

    return $allFormats;

*/








/*
8$allFormatArray
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
    [4] => 789 oak street
    [5] => 789 oak st.
    [6] => 789 oak st,
    [7] => 789 oak street
    [8] => 789 oak st.
    [9] => 789 oak st,
    [10] => 789 oak street
    [11] => 789 oak st.
    [12] => 789 oak st,
    [13] => 789 oak street
    [14] => 789 oak st.
    [15] => 789 oak st,
    [16] => 789 oak street
    [17] => 789 oak st.
    [18] => 789 oak st,
)
$searchTxtLowerArray
(
    [0] => 789
    [1] => oak
    [2] => st
)
9$allFormatArray
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
    [4] => 789 oak street
    [5] => 789 oak st.
    [6] => 789 oak st,
    [7] => 789 oak street
    [8] => 789 oak st.
    [9] => 789 oak st,
    [10] => 789 oak street
    [11] => 789 oak st.
    [12] => 789 oak st,
    [13] => 789 oak street
    [14] => 789 oak st.
    [15] => 789 oak st,
    [16] => 789 oak street
    [17] => 789 oak st.
    [18] => 789 oak st,
    [19] => 789 oak street
    [20] => 789 oak st.
    [21] => 789 oak st,
)
$searchTxtLowerArray
(
    [0] => 789
    [1] => oak
    [2] => st
)
5$allFormatArray
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
    [4] => 789 oak street
    [5] => 789 oak st.
    [6] => 789 oak st,
    [7] => 789 oak street
    [8] => 789 oak st.
    [9] => 789 oak st,
    [10] => 789 oak street
    [11] => 789 oak st.
    [12] => 789 oak st,
    [13] => 789 oak street
    [14] => 789 oak st.
    [15] => 789 oak st,
    [16] => 789 oak street
    [17] => 789 oak st.
    [18] => 789 oak st,
    [19] => 789 oak street
    [20] => 789 oak st.
    [21] => 789 oak st,
    [22] => 789 oak street
    [23] => 789 oak st.
    [24] => 789 oak st,
)
$searchTxtLowerArray
(
    [0] => 789
    [1] => oak
    [2] => st
)
6$allFormatArray
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
    [4] => 789 oak street
    [5] => 789 oak st.
    [6] => 789 oak st,
    [7] => 789 oak street
    [8] => 789 oak st.
    [9] => 789 oak st,
    [10] => 789 oak street
    [11] => 789 oak st.
    [12] => 789 oak st,
    [13] => 789 oak street
    [14] => 789 oak st.
    [15] => 789 oak st,
    [16] => 789 oak street
    [17] => 789 oak st.
    [18] => 789 oak st,
    [19] => 789 oak street
    [20] => 789 oak st.
    [21] => 789 oak st,
    [22] => 789 oak street
    [23] => 789 oak st.
    [24] => 789 oak st,
)
$searchTxtLowerArray
(
    [0] => 789
    [1] => oak
    [2] => st
)
7$allFormatArray
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
    [4] => 789 oak street
    [5] => 789 oak st.
    [6] => 789 oak st,
    [7] => 789 oak street
    [8] => 789 oak st.
    [9] => 789 oak st,
    [10] => 789 oak street
    [11] => 789 oak st.
    [12] => 789 oak st,
    [13] => 789 oak street
    [14] => 789 oak st.
    [15] => 789 oak st,
    [16] => 789 oak street
    [17] => 789 oak st.
    [18] => 789 oak st,
    [19] => 789 oak street
    [20] => 789 oak st.
    [21] => 789 oak st,
    [22] => 789 oak street
    [23] => 789 oak st.
    [24] => 789 oak st,
    [25] => 789 oak street
    [26] => 789 oak st.
    [27] => 789 oak st,
)
$searchTxtLowerArray
(
    [0] => 789
    [1] => oak
    [2] => st
)
8$allFormatArray
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
    [4] => 789 oak street
    [5] => 789 oak st.
    [6] => 789 oak st,
    [7] => 789 oak street
    [8] => 789 oak st.
    [9] => 789 oak st,
    [10] => 789 oak street
    [11] => 789 oak st.
    [12] => 789 oak st,
    [13] => 789 oak street
    [14] => 789 oak st.
    [15] => 789 oak st,
    [16] => 789 oak street
    [17] => 789 oak st.
    [18] => 789 oak st,
    [19] => 789 oak street
    [20] => 789 oak st.
    [21] => 789 oak st,
    [22] => 789 oak street
    [23] => 789 oak st.
    [24] => 789 oak st,
    [25] => 789 oak street
    [26] => 789 oak st.
    [27] => 789 oak st,
)
$searchTxtLowerArray
(
    [0] => 789
    [1] => oak
    [2] => st
)
9$allFormatArray
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
    [4] => 789 oak street
    [5] => 789 oak st.
    [6] => 789 oak st,
    [7] => 789 oak street
    [8] => 789 oak st.
    [9] => 789 oak st,
    [10] => 789 oak street
    [11] => 789 oak st.
    [12] => 789 oak st,
    [13] => 789 oak street
    [14] => 789 oak st.
    [15] => 789 oak st,
    [16] => 789 oak street
    [17] => 789 oak st.
    [18] => 789 oak st,
    [19] => 789 oak street
    [20] => 789 oak st.
    [21] => 789 oak st,
    [22] => 789 oak street
    [23] => 789 oak st.
    [24] => 789 oak st,
    [25] => 789 oak street
    [26] => 789 oak st.
    [27] => 789 oak st,
    [28] => 789 oak street
    [29] => 789 oak st.
    [30] => 789 oak st,
)
$searchTxtLowerArray
(
    [0] => 789
    [1] => oak
    [2] => st
)
10$allFormatArray
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
    [4] => 789 oak street
    [5] => 789 oak st.
    [6] => 789 oak st,
    [7] => 789 oak street
    [8] => 789 oak st.
    [9] => 789 oak st,
    [10] => 789 oak street
    [11] => 789 oak st.
    [12] => 789 oak st,
    [13] => 789 oak street
    [14] => 789 oak st.
    [15] => 789 oak st,
    [16] => 789 oak street
    [17] => 789 oak st.
    [18] => 789 oak st,
    [19] => 789 oak street
    [20] => 789 oak st.
    [21] => 789 oak st,
    [22] => 789 oak street
    [23] => 789 oak st.
    [24] => 789 oak st,
    [25] => 789 oak street
    [26] => 789 oak st.
    [27] => 789 oak st,
    [28] => 789 oak street
    [29] => 789 oak st.
    [30] => 789 oak st,
)
$searchTxtLowerArray
(
    [0] => 789
    [1] => oak
    [2] => st
)
Array
(
    [0] => 789 oak st
    [1] => 789 oak street
    [2] => 789 oak st.
    [3] => 789 oak st,
)
**/


// Create associative arrays for quick lookup
