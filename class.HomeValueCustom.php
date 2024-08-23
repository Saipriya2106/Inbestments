<?php
class HomeValueCustom
{
    public static function GetLevelFilters()
    {
        $LevelFilters = array();

        /* Stage 1 Level 1 to 8 */
        $LevelFilters[1] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[2] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[3] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        /* 
        Level 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, ... : will have the average value of the previous three levels, 
        e.g. Level 4 will be the average of Level 1, 2, 3
        
        Level 4.1, 12.1, 20.1, 28.1, 36.1, ... : will have the average value of the previous three levels, 
        e.g. Level 4.1 will be the average of Level 1.1, 2.1, 3.1
        */

        $LevelFilters[9] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[10] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[11] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[17] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[18] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[19] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[25] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[26] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[27] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[33] = array('distance' => 0.5, 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[34] = array('distance' => 0.5, 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[35] = array('distance' => 0.5, 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[41] = array('distance' => 0.5, 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[42] = array('distance' => 0.5, 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[43] = array('distance' => 0.5, 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[49] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[50] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[51] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[57] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[58] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[59] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[65] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[66] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[67] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[73] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[74] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[75] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[81] = array('distance' => 0.5, 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[82] = array('distance' => 0.5, 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[83] = array('distance' => 0.5, 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[89] = array('distance' => 0.5, 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[90] = array('distance' => 0.5, 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[91] = array('distance' => 0.5, 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[97] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[98] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[99] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[105] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[106] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[107] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[113] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[114] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[115] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[121] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[122] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[123] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[129] = array('distance' => 0.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[130] = array('distance' => 0.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[131] = array('distance' => 0.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[137] = array('distance' => 0.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[138] = array('distance' => 0.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[139] = array('distance' => 0.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[145] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[146] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[147] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[153] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[154] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[155] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[161] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[162] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[163] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[169] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[170] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[171] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[177] = array('distance' => 0.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[178] = array('distance' => 0.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[179] = array('distance' => 0.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[185] = array('distance' => 0.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[186] = array('distance' => 0.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[187] = array('distance' => 0.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[193] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[194] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[195] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[201] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[202] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[203] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[209] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[210] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[211] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[217] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[218] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[219] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[225] = array('distance' => 0.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[226] = array('distance' => 0.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[227] = array('distance' => 0.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[233] = array('distance' => 0.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[234] = array('distance' => 0.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[235] = array('distance' => 0.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);
        
        $LevelFilters[241] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[242] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[243] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);
        
        $LevelFilters[249] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[250] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[251] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[257] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[258] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[259] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[265] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[266] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[267] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[273] = array('distance' => 1, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[274] = array('distance' => 1, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[275] = array('distance' => 1, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[281] = array('distance' => 1, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[282] = array('distance' => 1, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[283] = array('distance' => 1, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[289] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[290] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[291] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[297] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[298] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[299] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[305] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[306] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[307] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[313] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[314] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[315] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[321] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[322] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[323] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[329] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[330] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[331] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[337] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[338] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[339] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[345] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[346] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[347] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[353] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 40);
        $LevelFilters[354] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 40);
        $LevelFilters[355] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 40);

        $LevelFilters[361] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[362] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[363] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[369] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[370] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[371] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[377] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 40);
        $LevelFilters[378] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 40);
        $LevelFilters[379] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 40);

        $LevelFilters[385] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[386] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[387] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[393] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[394] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[395] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[401] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 40);
        $LevelFilters[402] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 40);
        $LevelFilters[403] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 40);


        $LevelFilters[409] = array('distance' => 1, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[410] = array('distance' => 1, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[411] = array('distance' => 1, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'text_mining_exclusion' => true);

        $LevelFilters[417] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[418] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[419] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'text_mining_exclusion' => true);

        $LevelFilters[425] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[426] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[427] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'text_mining_exclusion' => true);

        $LevelFilters[433] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 40, 'text_mining_exclusion' => true);
        $LevelFilters[434] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 40, 'text_mining_exclusion' => true);
        $LevelFilters[435] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 40, 'text_mining_exclusion' => true);


        $LevelFilters[441] = array('distance' => 1.5, 'sold_within' => 730, 'status' => 'Sold', 'square_foot_per' => 100, 'text_mining_exclusion' => true);
        $LevelFilters[442] = array('distance' => 1.5, 'sold_within' => 730, 'status' => 'Sold,Pending', 'square_foot_per' => 100, 'text_mining_exclusion' => true);
        $LevelFilters[443] = array('distance' => 1.5, 'sold_within' => 730, 'status' => 'all', 'square_foot_per' => 100, 'text_mining_exclusion' => true);

        $LevelFilters[449] = array('distance' => 3, 'sold_within' => 730, 'status' => 'Sold', 'square_foot_per' => 100, 'text_mining_exclusion' => true);
        $LevelFilters[450] = array('distance' => 3, 'sold_within' => 730, 'status' => 'Sold,Pending', 'square_foot_per' => 100, 'text_mining_exclusion' => true);
        $LevelFilters[451] = array('distance' => 3, 'sold_within' => 730, 'status' => 'all', 'square_foot_per' => 100, 'text_mining_exclusion' => true);

        return $LevelFilters;
    }

    public static function GetMlsHasStyle()
    {
        $Obj = new SqlManager();
        $Obj->AddTbls('mls_master');
        $Obj->AddFlds(array('originating_system_name'));        
        $Obj->AddTblCond('has_style', 0);
        $MlsData = $Obj->GetMultiple();
        $MlsSources = array();
        if (isset($MlsData) && is_array($MlsData)) {
            foreach ($MlsData as $item) {
                if (isset($item['originating_system_name'])) {
                    $MlsSources[] = $item['originating_system_name'];
                }
            }
        }
        return $MlsSources;
    }

    public static function GetPreviousMonthData($InsightsPropertyID, $CurrentMonth, $CurrentYear)
    {
        $Date = strtotime($CurrentYear.'-'.$CurrentMonth.'-01');
        $Month = date('m', strtotime('-1 month', $Date));
        $Year = date('Y', strtotime('-1 month', $Date));

        $Obj = new SqlManager();
        $Obj->AddTbls('insights_est_price_mls');
        $Obj->AddFlds(array('est_price', 'pcomp_criteria_id'));
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('est_month', $Month);
        $Obj->AddFldCond('est_year', $Year);
        $Obj->AddFldCond('is_best', 'Y');
        return $Obj->GetSingle();
    }

    public static function GetPreviousMonthRData($InsightsPropertyID, $CurrentMonth, $CurrentYear)
    {
        $Date = strtotime($CurrentYear.'-'.$CurrentMonth.'-01');
        $Month = date('m', strtotime('-1 month', $Date));
        $Year = date('Y', strtotime('-1 month', $Date));

        $Obj = new SqlManager();
        $Obj->AddTbls('insights_est_rent_mls');
        $Obj->AddFlds(array('est_monthly_rent', 'rcomp_criteria_id'));
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('est_month', $Month);
        $Obj->AddFldCond('est_year', $Year);
        $Obj->AddFldCond('is_best', 'Y');
        return $Obj->GetSingle();
    }

    public static function UpdateInsightsMain($Data, $InsightsPropertyID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_main'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->Update();
    }

    private static function GetHomeValueByRangeForAMonth($Row, $M, $Y)
    {
        $SoldPriceTolerance = HVUtils::CalculateTolerance($Row['sold_price'], 5);
        $SoldPriceHigh = $Row['sold_price'] + $SoldPriceTolerance;

        $Query = "SELECT ep.id, ep.est_price FROM tbl_insights_est_price_mls ep WHERE ep.insights_property_id = ".$Row['insights_property_id']." AND ep.est_month = '".$M."' AND ep.est_year = ".$Y." AND est_price BETWEEN '".$Row['sold_price']."' AND '".$SoldPriceHigh."' AND ep.pcomp_criteria_id!=10000  ORDER BY ep.est_price DESC LIMIT 1";

        $Obj = new SqlManager();
        return $Obj->GetQuery($Query);
    }

    public static function UpdatePricePropertiesAsBest($M, $Y)
    {
        /* For properties which has sold price */
       /* $QueryForSP = "SELECT 
        TIMESTAMPDIFF(MONTH, mls.sold_date, DATE('".$Y."-".$M."-01')) sold_within,
        mls.sold_price,
        im.guid,
        im.insights_property_id
        FROM tbl_insights_main im, tbl_property_details_mls mls 
        WHERE 
        im.inbestments_property_id = mls.id 
        ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND mls.sold_price > 0 AND `status` = 'Sold'
        AND mls.sold_date IS NOT NULL AND mls.sold_date != '0000-00-00 00:00:00' AND mls.sold_date != '1800-01-01 00:00:00'
        AND im.insights_property_id NOT IN(
        SELECT ep.insights_property_id FROM tbl_insights_est_price_mls ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y." AND ep.is_best = 'Y'
        )
        AND im.insights_property_id IN(
        SELECT ep.insights_property_id FROM tbl_insights_est_price_mls ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y."
        )

        HAVING
        sold_within BETWEEN 0 AND 6
        ";
       */
        // Custom Updated
        $QueryForSP = "SELECT 
        TIMESTAMPDIFF(MONTH, mls.sold_date, DATE('".$Y."-".$M."-01')) sold_within,
        mls.sold_price,
        mls.id AS insights_property_id
        FROM tbl_property_details_mls mls 
        WHERE 
         mls.sold_price > 0 AND `status` = 'Sold'
          ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND mls.sold_date IS NOT NULL AND mls.sold_date != '0000-00-00 00:00:00' AND mls.sold_date != '1800-01-01 00:00:00'
        AND mls.id NOT IN(
        SELECT ep.insights_property_id FROM tbl_insights_est_price_mls ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y." AND ep.is_best = 'Y'
        )
        AND mls.id IN(
        SELECT ep.insights_property_id FROM tbl_insights_est_price_mls ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y."
        )
        AND mls.id IN (SELECT icfs1.insights_property_id 
                        FROM tbl_insights_cron_function_status   icfs1
                        WHERE icfs1.cron_function_name='".CONFIG_PROCESS_HOME_VALUE_CUSTOM."'  AND icfs1.cron_function_status_flag='Y' 
                        AND icfs1.month=". $M ." AND  icfs1.year=". $Y ."  ) 
        AND mls.id NOT IN (SELECT icfs1.insights_property_id 
                        FROM tbl_insights_cron_function_status   icfs1
                        WHERE icfs1.cron_function_name='".CONFIG_GET_UPDATE_PRICE_PROPERTIES_AS_BEST_CUSTOM."'  AND icfs1.cron_function_status_flag='Y' 
                        AND icfs1.month=". $M ." AND  icfs1.year=". $Y ."  ) 
        HAVING
        sold_within BETWEEN 0 AND 6
            ORDER BY mls.id DESC
        LIMIT 65
        "; 
        echo 'UpdatePricePropertiesAsBest #1 QueryForSP: <pre> ';
        // print_r($QueryForSP);
        $SPObj = new SqlManager();
        $SPData = $SPObj->GetQuery($QueryForSP);
        // echo 'UpdatePricePropertiesAsBest #2 SPData: <pre> ';
        // print_r($SPData);
        
        foreach ($SPData as $Item) {
            $BestRow = self::GetHomeValueByRangeForAMonth($Item, $M, $Y);

            if (isset($BestRow) && count($BestRow) && isset($BestRow['id'])) {
                self::UpdateHomeValueIsBest($BestRow['id'],$Item);
                echo "\n Cron-Function-Status :: CONFIG_PROCESS_HOME_VALUE_CUSTOM :: ";
                // Cron-Function-Status :: UPDATE_HOME_VALUE_IS_BEST_HAVING_MLS_NO
                $Parms = array('cron_function_name' => CONFIG_PROCESS_HOME_VALUE_CUSTOM, 'insights_property_id' => $Item['insights_property_id'], 
                'cron_function_status_flag' => UpdateHomeValueIsBestHavingMlsNO,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
            }else{
                ##### cron_status = 1_price_est_in_completed
                $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $Item['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusPriceEstInComplete,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusPriceEstInComplete);  
                print_r($Parms2);
                echo '<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $Item['insights_property_id']); 
                #####                
            }
        }

       /* 
        $QueryForSP = "SELECT 
        TIMESTAMPDIFF(MONTH, tblSmh.sold_date, DATE('".$Y."-".$M."-01')) sold_within,
        tblSmh.sold_price,
        im.guid,
        im.insights_property_id
        FROM tbl_insights_main im, 
        (SELECT sale_rec_date sold_date, sale_amt sold_price, insights_property_id FROM 
        (SELECT sale_rec_date, sale_amt, insights_property_id FROM tbl_insights_attom_sales_mortgage_history WHERE sale_amt > 0 AND sale_trans_type = 'Resale' ORDER BY sale_rec_date DESC)
        AS smh GROUP BY smh.insights_property_id)
        AS tblSmh 
        WHERE 
        (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0)
        AND im.insights_property_id = tblSmh.insights_property_id 
        ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND tblSmh.sold_date IS NOT NULL AND tblSmh.sold_date != '0000-00-00 00:00:00'
        AND im.insights_property_id NOT IN(
        SELECT ep.insights_property_id FROM tbl_insights_est_price_mls ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y." AND ep.is_best = 'Y'
        )
        AND im.insights_property_id IN(
        SELECT ep.insights_property_id FROM tbl_insights_est_price_mls ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y."
        )
        HAVING
        sold_within BETWEEN 0 AND 6
        ";
       */

        $QueryForSP = "SELECT 
            TIMESTAMPDIFF(MONTH, tblSmh.sold_date, DATE('".$Y."-".$M."-01')) sold_within,
            tblSmh.sold_price,
            mls.id
            FROM tbl_property_details_mls mls, 
            (SELECT sale_rec_date sold_date, sale_amt sold_price, insights_property_id FROM 
            (SELECT sale_rec_date, sale_amt, insights_property_id FROM tbl_insights_attom_sales_mortgage_history WHERE sale_amt > 0 AND sale_trans_type = 'Resale' ORDER BY sale_rec_date DESC)
            AS smh GROUP BY smh.insights_property_id)
            AS tblSmh 
            WHERE 
            (mls.id IS NULL OR mls.id = 0)
            AND mls.id = tblSmh.insights_property_id 
            ".AUTOMATION_CONDITION_WITH_ALIAS."
            AND tblSmh.sold_date IS NOT NULL AND tblSmh.sold_date != '0000-00-00 00:00:00'
            AND mls.id NOT IN(
            SELECT ep.insights_property_id FROM tbl_insights_est_price_mls ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y." AND ep.is_best = 'Y'
            )
            AND mls.id IN(
            SELECT ep.insights_property_id FROM tbl_insights_est_price_mls ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y."
            )
            HAVING
            sold_within BETWEEN 0 AND 6

            LIMIT 65
            ";
        echo 'UpdatePricePropertiesAsBest #3 QueryForSP: <pre> ';
        // print_r($QueryForSP);
        $SPObj = new SqlManager();
        $SPData = $SPObj->GetQuery($QueryForSP);
        // echo 'UpdatePricePropertiesAsBest #4 SPData: <pre> ';
        // print_r($SPData);
        foreach ($SPData as $Item) {
            $BestRow = self::GetHomeValueByRangeForAMonth($Item, $M, $Y);
            if (count($BestRow) && isset($BestRow) && isset($BestRow['id'])) {
                self::UpdateHomeValueIsBest($BestRow['id'], $Item);
                echo "\n Cron-Function-Status :: UPDATE_HOME_VALUE_IS_BEST :: ";
                // Cron-Function-Status :: UPDATE_HOME_VALUE_IS_BEST
                $Parms = array('cron_function_name' => CONFIG_GET_UPDATE_PRICE_PROPERTIES_AS_BEST, 'insights_property_id' => $Item['insights_property_id'], 
                'cron_function_status_flag' => UpdateHomeValueIsBestNotHavingMlsNO,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
            }else{
                  ##### cron_status = 1_price_est_in_completed
                  $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $Item['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusPriceEstInComplete,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusPriceEstInComplete);  
                print_r($Parms2);
                echo '<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $Item['insights_property_id']); 
                #####                
            }
        }
        // ".AUTOMATION_CONDITION_WITH_ALIAS."
        $Query = "SELECT max(id) id, insights_property_id FROM tbl_insights_est_price_mls
            WHERE 
            est_month = '".$M."' AND est_year = ".$Y." AND pcomp_criteria_id!=10000 
            AND insights_property_id NOT IN(SELECT insights_property_id FROM tbl_insights_est_price_mls WHERE est_month = '".$M."' AND est_year = ".$Y." AND is_best = 'Y')
            GROUP BY insights_property_id
            LIMIT 100";

        echo 'GetPricePropertiesAsBest #5 Query: <pre> ';
        print_r($Query);

        $Obj = new SqlManager();
        $IdArray = $Obj->GetQuery($Query);
        echo 'GetPricePropertiesAsBest #5 IdArray:count::  '. count($IdArray);

        if (count($IdArray)) {
            $Ids = array();
            $PropertyIds = array();
            foreach ($IdArray as $id) {
                $PropertyIds[] = $id['insights_property_id'];
                $Ids[] = $id['id'];
            }
            $PriorityQuery = "SELECT MAX(id) id, insights_property_id FROM `tbl_insights_est_price_mls` WHERE insights_property_id IN(   ".implode(', ', $PropertyIds)."    ) AND criteria != '' AND comp_properties != '' AND
                JSON_VALID(criteria) = 1 AND JSON_VALID(comp_properties) = 1 AND 
                JSON_EXTRACT(criteria, '$.set_style') = 'absolute' AND JSON_EXTRACT(criteria, '$.distance') = 0.5 AND JSON_LENGTH(comp_properties) >= 3 GROUP BY insights_property_id;";
            $Obj = new SqlManager();
            $PriorityData = $Obj->GetQuery($PriorityQuery);    
            if (count($PriorityData)) {
                $PriorityPropertyIds = array();
                $PriorityIds = array();
                foreach ($PriorityData as $priority) {
                    $PriorityPropertyIds[] = $priority['insights_property_id'];
                    $PriorityIds[] = $priority['id'];
                }

                foreach ($Ids as $key => $id) {
                    if (in_array($PropertyIds[$key], $PriorityPropertyIds)) {
                        unset($Ids[$key]);
                    }
                }
                $Ids = array_merge($Ids, $PriorityIds);
            }
           /* For properties which do not have sold price */
            $Query = "UPDATE tbl_insights_est_price_mls SET is_best = 'Y' WHERE  
            id IN(   ".implode(', ', $Ids)."    )";

            echo 'UpdatePricePropertiesAsBest #5.1 Query: <pre> ';
            print_r($Query);

            $Obj = new SqlManager();
            $Obj->ExecQuery($Query);
        }
        
    }

    private static function UpdateHomeValueIsBest($ID, $Item)
    {
        $isBest='Y';
        // $isBest='A'; // FOR JAN-2020
        $CheckIsBest = self::CheckHomeValueIsBest($Item);
        if (count($CheckIsBest)) {
            $isBest='P';
        }
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_price_mls'));
        $Obj->AddInsrtFlds(array('is_best' =>$isBest));
        $Obj->AddFldCond('id', $ID);
        $Obj->Update();
    }

    public static function  CheckHomeValueIsBest($Item)
    {
            $Obj = new SqlManager();
              $Obj->AddTbls(array('insights_est_price_mls'));
              $Obj->AddFlds(array('id'));
              $Obj->AddFldCond('insights_property_id', $Item['insights_property_id']);
              $Obj->AddFldCond('is_best', 'Y');
            // $Obj->AddFldCond('is_best', 'A');
              $Obj->AddFldCond('est_month', $Item['est_month']);
              $Obj->AddFldCond('est_year', $Item['est_year']);
              return $Obj->GetSingle();
    }    
    public static function UpdateRentalPropertiesAsBest($M, $Y)
    {
        $Query = "SELECT MAX(id) id FROM tbl_insights_est_rent_mls WHERE est_month = '".$M."' AND est_year = '".$Y."' AND insights_property_id NOT IN
        (SELECT insights_property_id FROM tbl_insights_est_rent_mls WHERE est_month = '".$M."' AND est_year = '".$Y."' AND is_best = 'Y')
        GROUP BY insights_property_id
        LIMIT 100";
        $Obj = new SqlManager();
        $RentalData = $Obj->ExecQuery($Query);
        if (isset($RentalData) && !empty($RentalData)) {
            $ids = [];
            foreach ($RentalData as $row) {
                $ids[] = $row['id'];
            }
            if(count($ids)) {
                $UpdateQuery = "UPDATE tbl_insights_est_rent_mls SET is_best = 'Y' WHERE id IN (" . implode(",", $ids) . ")";
                $Obj = new SqlManager();
                $Obj->ExecQuery($UpdateQuery);
            } else {
                return;
            }    
        } else {
            return;
        }
    }

    public static function UpdateAdjustmentPrice($M, $Y)
    {
        $Query = "SELECT 
        ep.id, sold_price, est_price, sold_date, list_price, mls.status, mls.id as insights_property_id
        FROM tbl_property_details_mls mls, tbl_insights_est_price_mls ep
        WHERE 
        mls.id = ep.insights_property_id 
        ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND ep.is_best = 'Y' 
        AND ep.est_month = '".$M."' AND ep.est_year = ".$Y."
        AND ep.adjustment_value = 0
        AND ((mls.status = 'Sold'
        AND mls.sold_price > ep.est_price
        AND (IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, mls.sold_date, DATE('".$Y."-".$M."-01')), -1) BETWEEN 0 AND 6)) 
        OR mls.status = 'Active')
        AND mls.id IN (SELECT icfs1.insights_property_id 
                        FROM tbl_insights_cron_function_status   icfs1
                        WHERE icfs1.cron_function_name='".CONFIG_GET_UPDATE_PRICE_PROPERTIES_AS_BEST_CUSTOM."'  AND icfs1.cron_function_status_flag='". UpdateHomeValueIsBestHavingMlsNO ."' 
                        AND icfs1.month=". $M ." AND  icfs1.year=". $Y ."  ) 

        ";

        $Obj = new SqlManager();
        $PropertyArr = $Obj->GetQuery($Query);
        $AdjustmentsArr = array();

        foreach ($PropertyArr as $Item) {
            if ($Item['status'] == 'Sold') {
                $Key = $Item['sold_price'].$Item['est_price'].$Item['sold_date'].'';
                if (!isset($AdjustmentsArr[$Key])) {
                    //Calulate the adjustment between 0.5% to 2% of $Item['sold_price']
                    $adjustment = ($Item['sold_price'] * rand(50, 200) / 10000);
                    $AdjustmentsArr[$Key] = $Item['sold_price'] + $adjustment;
                }
            }
        }

        echo "\n UpdateAdjustmentPrice :: ";
        print_r($PropertyArr);
        /* echo '<pre>';
        // print_r($PropertyArr);
        // print_r($AdjustmentsArr);
        exit; */

        foreach ($PropertyArr as $Item) {
            if ($Item['status'] == 'Sold') {
                $Key = $Item['sold_price'].$Item['est_price'].$Item['sold_date'].'';
                $AdjustmentValue = $AdjustmentsArr[$Key];
            } else
                $AdjustmentValue = $Item['list_price'];
            self::UpdateAdjustmentValue($Item['id'], array('adjustment_value' => $AdjustmentValue));
            echo "\n  Cron-Function-Status :: UPDATE_HOME_VALUE_IS_BEST_HAVING_MLS_NO :: ";
            // Cron-Function-Status :: UPDATE_HOME_VALUE_IS_BEST_HAVING_MLS_NO
            $Parms = array('cron_function_name' => CONFIG_UPDATE_ADJUSTMENT_PRICE_CUSTOM, 'insights_property_id' => $Item['insights_property_id'], 
            'cron_function_status_flag' => UpdateAdjustmentPrice,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);             
        }
    }

    private static function UpdateAdjustmentValue($ID, $Data)
    {
        if ($ID > 0) {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_est_price_mls'));
            $Obj->AddInsrtFlds($Data);
            $Obj->AddFldCond('id', $ID);
            $Obj->Update();

            echo "\n  UpdateAdjustmentValue:: $ID  :: "; print_r($Data);

        }
    }

    public static function InsertUpdateEstimatedPrice($Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_price_mls'));
        $Obj->AddInsrtFlds($Row);
        $Obj->InsertMultiple();    
    }

    public static function AddCalculatedRValues($CriteriaResults)
    {
        self::InsertUpdateEstimatedRPrice(array_values($CriteriaResults));
        /* echo '<pre>';
        // print_r($CriteriaResults);
        exit; */
    }

    public static function InsertUpdateEstimatedRPrice($Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_rent_mls'));
        $Obj->AddInsrtFlds($Row);
        $Obj->InsertMultiple();
    }

    public static function GetCompsSetToFilter($Property, $StricterRange = 1, $TimeStamp = 'NOW()')
    {
        $Obj = new SqlManager();

        $SquareFootLow = 0;
        $SquareFootHigh = 0;

        $PropertyType = '';
        if ($Property['property_type'] == 'SFR' || $Property['property_type'] == 'RESIDENTIAL ACREAGE' || $Property['property_type'] == 'RESIDENTIAL (NEC)' || $Property['property_type'] == 'SingleFamily')
            $PropertyType = 'Residential';
        else if ($Property['property_type'] == 'CONDOMINIUM' || $Property['property_type'] == 'Condominium')
            $PropertyType = 'Condominium';
        else if ($Property['property_type'] == 'MultiFamily5Plus' || $Property['property_type'] == 'MultiFamily2To4')
            $PropertyType = 'Multi-Family';
        else if ($Property['property_type'] == 'INDUSTRIAL (NEC)' || $Property['property_type'] == 'WAREHOUSE' || $Property['property_type'] == 'MOBILE HOME'
        || $Property['property_type'] == 'VacantResidentialLand' || $Property['property_type'] == 'Duplex' || $Property['property_type'] == 'Apartment'
        || $Property['property_type'] == 'Townhouse' || $Property['property_type'] == 'Mobile') {
            $PropertyType = '';
        } else
            $PropertyType = $Property['property_type'];

        $Query = "SELECT ";
        $Query .= "id,ml_number,list_price,IF(`status` = 'Sold',sold_price,list_price) sold_price,square_foot,style,`status`,sold_date,list_date,year_built,IF(`status` = 'Sold', TIMESTAMPDIFF(DAY, sold_date, ".$TimeStamp."), -1) sold_within, ROUND((3958*acos(cos(radians(".$Property['latitude']."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$Property['longitude']."))+sin(radians(".$Property['latitude']."))*sin(radians(latitude))))* 100 / 100,2) AS distance,public_comments ";
        $Query .= " FROM property_details_mls ";
        $Query .= " WHERE ";
        
        $QueryCondition = array();

        if ($PropertyType != '')
            $QueryCondition[] = " property_type = '".$PropertyType."' ";

        if ($StricterRange == 1) {
            $QueryCondition[] = " record_status != 'R' ";

            $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], 40);
            $SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
            $SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

            $QueryCondition[] = " (
                (`status` = 'Sold' AND (sold_date between DATE_SUB(".$TimeStamp.", INTERVAL 365 DAY) AND ".$TimeStamp."))
                OR (`status` = 'Active')
                OR (`status` LIKE 'Pending%' AND (pending_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
                OR (`status` = 'Contingent' AND (contingent_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
            )";
        } else if ($StricterRange == 2) {
            $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], 100);
            $SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
            $SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

            $QueryCondition[] = " (
                (`status` = 'Sold' AND (sold_date between DATE_SUB(".$TimeStamp.", INTERVAL 1460 DAY) AND ".$TimeStamp."))
                OR (`status` = 'Active')
                OR (`status` LIKE 'Pending%')
                OR (`status` = 'Contingent')
                OR (`status` = 'Removed')
            )";
        }

        if ($SquareFootLow > 0 && $SquareFootHigh > 0)
            $QueryCondition[] = " (square_foot BETWEEN ".$SquareFootLow." AND ".$SquareFootHigh.") ";
        
        if (isset($Property['id']))
            $QueryCondition[] = " id != ".$Property['id'];

        $Query .= " ".implode(' AND ', $QueryCondition)." ";

        $Query .= " GROUP BY id,address,unit_number,city_name,state_code,zip_code";
        $Query .= " HAVING distance <= 3";
        
        $Query .= " ORDER BY distance ASC, mls_created_date DESC";
      //  print_r($Query);

        return $Obj->GetQuery($Query);
    }

    private static function BKGetCompsSetToFilter($Property, $TimeStamp = 'NOW()')
    {
        $Obj = new SqlManager();

        $SquareFootLow = 0;
        $SquareFootHigh = 0;

        $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], 40);
        $SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
        $SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

        $PropertyType = '';
        if ($Property['property_type'] == 'SFR' || $Property['property_type'] == 'RESIDENTIAL ACREAGE' || $Property['property_type'] == 'RESIDENTIAL (NEC)' || $Property['property_type'] == 'SingleFamily')
            $PropertyType = 'Residential';
        else if ($Property['property_type'] == 'CONDOMINIUM' || $Property['property_type'] == 'Condominium')
            $PropertyType = 'Condominium';
        else if ($Property['property_type'] == 'MultiFamily5Plus' || $Property['property_type'] == 'MultiFamily2To4')
            $PropertyType = 'Multi-Family';
        else if ($Property['property_type'] == 'INDUSTRIAL (NEC)' || $Property['property_type'] == 'WAREHOUSE' || $Property['property_type'] == 'MOBILE HOME'
        || $Property['property_type'] == 'VacantResidentialLand' || $Property['property_type'] == 'Duplex' || $Property['property_type'] == 'Apartment'
        || $Property['property_type'] == 'Townhouse' || $Property['property_type'] == 'Mobile') {
            $PropertyType = '';
        } else
            $PropertyType = $Property['property_type'];

        $Query = "SELECT ";
        $Query .= "id,ml_number,list_price,IF(`status` = 'Sold',sold_price,list_price) sold_price,square_foot,style,`status`,sold_date,list_date,year_built,IF(`status` = 'Sold', TIMESTAMPDIFF(DAY, sold_date, ".$TimeStamp."), -1) sold_within, ROUND((3958*acos(cos(radians(".$Property['latitude']."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$Property['longitude']."))+sin(radians(".$Property['latitude']."))*sin(radians(latitude))))* 100 / 100,2) AS distance,public_comments ";
        $Query .= " FROM tbl_property_details_mls ";
        $Query .= " WHERE ";
        
        $QueryCondition = array();

        $QueryCondition[] = " record_status != 'R' ";

        if ($PropertyType != '')
            $QueryCondition[] = " AND property_type = '".$PropertyType."' ";
        
        if ($SquareFootLow > 0 && $SquareFootHigh > 0)
            $Query .= " AND (square_foot BETWEEN ".$SquareFootLow." AND ".$SquareFootHigh.") ";
        
        $Query .= " AND (
            (`status` = 'Sold' AND (sold_date between DATE_SUB(".$TimeStamp.", INTERVAL 1460 DAY) AND ".$TimeStamp."))
            OR (`status` = 'Active')
            OR (`status` LIKE 'Pending%')
            OR (`status` = 'Contingent')
        )";

        /* $Query .= " AND (
            (`status` = 'Sold' AND (sold_date between DATE_SUB(".$TimeStamp.", INTERVAL 365 DAY) AND ".$TimeStamp."))
            OR (`status` = 'Active')
            OR (`status` LIKE 'Pending%' AND (pending_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
            OR (`status` = 'Contingent' AND (contingent_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
        )"; */
        
        if (isset($Property['id']))
            $Query .= " AND id != ".$Property['id'];

        $Query .= " GROUP BY address,unit_number,city_name,state_code,zip_code";
        $Query .= " HAVING distance <= 3";
        
        $Query .= " ORDER BY distance ASC, mls_created_date DESC";
        
        return $Obj->GetQuery($Query);
    }

    public static function GetrCompsSetToFilter($Property, $TimeStamp = 'NOW()')
    {
        $Obj = new SqlManager();

        $SquareFootLow = 0;
        $SquareFootHigh = 0;

        $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], 50);
        $SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
        $SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

        $Query = "SELECT ";
        $Query .= "id,ml_number,list_price, square_foot,style,`status`, list_date,year_built,IF(`status` = 'Sold', TIMESTAMPDIFF(DAY, list_date, ".$TimeStamp."), -1) sold_within, ROUND((3958*acos(cos(radians(".$Property['latitude']."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$Property['longitude']."))+sin(radians(".$Property['latitude']."))*sin(radians(latitude))))* 100 / 100,2) AS distance,public_comments ";
        $Query .= " FROM tbl_property_rental_mls ";
        
        $Query .= " WHERE ";
        // $Query .= " record_status != 'R' ";
        $Query .= "  1=1 ";
        if ($SquareFootLow > 0 && $SquareFootHigh > 0)
            $Query .= " AND (square_foot BETWEEN ".$SquareFootLow." AND ".$SquareFootHigh.") ";
        
        // Arvind -11-May-2021 - Change sold_date interval range from 365 to 730 to get 2 years rental data.
        $Query .= " AND (
            ( (list_date between DATE_SUB(".$TimeStamp.", INTERVAL 1460 DAY) AND ".$TimeStamp."))
            
        )";
        /*
        -- Commenting this as per discussion with Vinod. Most rental comps' status is not updated and therefore the below status does not select 
        -- the rental comps   
        (`status` = 'Sold' AND (sold_date between DATE_SUB(".$TimeStamp.", INTERVAL 730 DAY) AND ".$TimeStamp."))
            
            OR (`status` = 'Active')
            OR (`status` LIKE 'Pending%' AND (pending_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
            OR (`status` = 'Contingent' AND (contingent_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
        */
        if (isset($Property['id']))
            $Query .= " AND id != ".$Property['id'];

        $Query .= " GROUP BY address,unit_number,city_name,state_code,zip_code";
        $Query .= " HAVING distance <= 5.0";

        $Query .= " ORDER BY distance ASC, mls_created_date DESC";
        
        return $Obj->GetQuery($Query);
    }

    public static function GetStageByLevel($PCompCriteriaID)
    {
        $Stage = array();
        for ($i = 1, $j = 3, $k = 8; $i <= 449, $j <= 451; $i += 8, $j += 8, $k += 8) {
            if ($PCompCriteriaID >= $i && $PCompCriteriaID <= $k) {
                $Stage = array('StartLevel' => $i, 'EndLevel' => $j);
                break;
            }
        }
        return $Stage;
    }

    public static function GetRStageByLevel($RCompCriteriaID)
    {
        $Stage = array();
        for ($i = 1, $j = 3, $k = 8; $i <= 425, $j <= 427; $i += 8, $j += 8, $k += 8) {
            if ($RCompCriteriaID >= $i && $RCompCriteriaID <= $k) {
                $Stage = array('StartLevel' => $i, 'EndLevel' => $j);
                break;
            }
        }
        return $Stage;
    }

    public static function AddCalculatedValues($CriteriaResults)
    {
        self::InsertUpdateEstimatedPrice(array_values($CriteriaResults));
         echo '<pre>';
        // print_r($CriteriaResults);
        // exit; */
    }

    public static function CalculateEstimatedPrice($SquareFoot, $AveragePricePerSqFt)
    {
        return round($SquareFoot * $AveragePricePerSqFt);
    }

    private static function CalculatePricePerSqFt($ComparablePropertyPrice, $ComparablePropertySquareFoot)
    {
        if ($ComparablePropertySquareFoot > 0)
            return $ComparablePropertyPrice / $ComparablePropertySquareFoot;
        return 0;    
    }

    public static function SalePriceHL($MedianEP, $Tolerance)
    {
        return array('sold_price_low' => ($MedianEP * (1 - $Tolerance)), 'sold_price_high' => ($MedianEP * (1 + $Tolerance)));
    }

    public static function CalculateAveragePricePerSqFt($Properties)
    {
        if (!count($Properties))
            return 0;

        $CalculatedValue = 0;
        foreach ($Properties as $Property)
            $CalculatedValue += self::CalculatePricePerSqFt($Property['sold_price'], $Property['square_foot']);

        return round($CalculatedValue / count($Properties), 2);
    }
    public static function CalculateRentAveragePricePerSqFt($Properties)
    {
        //  #$# 4.7
        if (!count($Properties))
            return 0;

        $CalculatedValue = 0;
        foreach ($Properties as $Property)
            $CalculatedValue += self::CalculatePricePerSqFt($Property['list_price'], $Property['square_foot']);

        return round($CalculatedValue / count($Properties), 2);
    }

    public static function ArrangeCompPrice($CompData)
    {
        $Prices = array();
        foreach ($CompData as $Item)
            $Prices[] = intval($Item['sold_price']);
        sort($Prices);
        return $Prices;
    }
    public static function ArrangeRCompPrice($CompData)
    {
        //  #$# 4.8
        $Prices = array();
        foreach ($CompData as $Item)
            $Prices[] = intval($Item['list_price']);
        sort($Prices);
        return $Prices;
    }
    
    public static function ProcessEstPrice($InsightsPropertyID, $Filter, $SquareFoot, $CompList, $Month, $Year, $CriteriaID)
    {
        $EstRow = array();
        $AveragePricePerSqFt = self::CalculateAveragePricePerSqFt($CompList);

        $EstimatedPrice = self::CalculateEstimatedPrice($SquareFoot, $AveragePricePerSqFt);

        $EstRow['insights_property_id'] = $InsightsPropertyID;
        $EstRow['est_month'] = $Month;
        $EstRow['est_year'] = $Year;
        $EstRow['est_price'] = $EstimatedPrice;
        $EstRow['pcomp_criteria_id'] = $CriteriaID;
        $Prices = self::ArrangeCompPrice($CompList);

        $CompLength = count($Prices);
        $EstRow['low_est_price'] = $Prices[0];
        $EstRow['high_est_price'] = end($Prices);
        $EstRow['avg_est_price'] = round(array_sum($Prices) / $CompLength);

        $MidIndex = 0;
        if ($CompLength % 2 == 0) {
            $MidIndex = $CompLength / 2;
            $EstRow['mid_est_price'] = round(($Prices[$MidIndex] + $Prices[$MidIndex -1]) / 2);
        } else {
            $MidIndex = ($CompLength - 1) / 2;
            $EstRow['mid_est_price'] = $Prices[$MidIndex];
        }

        $EstRow['comp_properties'] = json_encode($CompList);
        if (!$EstRow['comp_properties'])
        $EstRow['comp_properties'] = '';
        $EstRow['criteria'] = json_encode($Filter);
        if (!$EstRow['criteria'])
        $EstRow['criteria'] = '';
        
        return $EstRow;
    }

    public static function ProcessREstPrice($InsightsPropertyID, $Filter, $SquareFoot, $CompList, $Month, $Year, $CriteriaID)
    {
        $EstRow = array();
        echo '<hr>';
        //  #$# 4.7
        $AveragePricePerSqFt = self::CalculateRentAveragePricePerSqFt($CompList);
        
        $EstimatedPrice = self::CalculateEstimatedPrice($SquareFoot, $AveragePricePerSqFt);

        $EstRow['insights_property_id'] = $InsightsPropertyID;
        $EstRow['est_month'] = $Month;
        $EstRow['est_year'] = $Year;
        $EstRow['est_monthly_rent'] = $EstimatedPrice;
        $EstRow['rcomp_criteria_id'] = $CriteriaID;
        //  #$# 4.8
        $Prices = self::ArrangeRCompPrice($CompList);

        $CompLength = count($Prices);
        $EstRow['low_est_monthly_rent'] = $Prices[0];
        $EstRow['high_est_monthly_rent'] = end($Prices);
        $EstRow['avg_est_monthly_rent'] = round(array_sum($Prices) / $CompLength);

        $MidIndex = 0;
        if ($CompLength % 2 == 0) {
            $MidIndex = $CompLength / 2;
            $EstRow['median_est_monthly_rent'] = round(($Prices[$MidIndex] + $Prices[$MidIndex -1]) / 2);
        } else {
            $MidIndex = ($CompLength - 1) / 2;
            $EstRow['median_est_monthly_rent'] = $Prices[$MidIndex];
        }

        $EstRow['comp_properties'] = json_encode($CompList);
        $EstRow['comp_properties'] = $EstRow['comp_properties'] ? $EstRow['comp_properties'] : '';
        $EstRow['criteria'] = json_encode($Filter);
        $EstRow['criteria'] = $EstRow['criteria'] ? $EstRow['criteria'] : '';
        return $EstRow;
    }

    public static function ProcessAvgLevel($InsightsPropertyID, $StartLevel, $EndLevel, $CriteriaResults)
    {
        $AvgLvl = $EndLevel + 1;
        $AvgData = array('est_price' => 0, 'low_est_price' => 0, 'high_est_price' => 0, 'avg_est_price' => 0, 'mid_est_price' => 0, 'level_count' => 0);

        for ($I = $StartLevel; $I <= $EndLevel; $I++) {
            if (!isset($CriteriaResults[$I]))
                continue;

            $AvgData['est_price'] += $CriteriaResults[$I]['est_price'];
            $AvgData['low_est_price'] += $CriteriaResults[$I]['low_est_price'];
            $AvgData['high_est_price'] += $CriteriaResults[$I]['high_est_price'];
            $AvgData['avg_est_price'] += $CriteriaResults[$I]['avg_est_price'];
            $AvgData['mid_est_price'] += $CriteriaResults[$I]['mid_est_price'];
            $AvgData['level_count'] += 1;

            $AvgData['est_month'] = $CriteriaResults[$I]['est_month'];
            $AvgData['est_year'] = $CriteriaResults[$I]['est_year'];
        }

        if ($AvgData['level_count'] > 0) {
            $AvgData['insights_property_id'] = $InsightsPropertyID;

            $AvgData['est_price'] = $AvgData['est_price']/$AvgData['level_count'];
            $AvgData['pcomp_criteria_id'] = $AvgLvl;
            $AvgData['low_est_price'] = $AvgData['low_est_price']/$AvgData['level_count'];
            $AvgData['high_est_price'] = $AvgData['high_est_price']/$AvgData['level_count'];
            $AvgData['avg_est_price'] = $AvgData['avg_est_price']/$AvgData['level_count'];
            $AvgData['mid_est_price'] = $AvgData['mid_est_price']/$AvgData['level_count'];
            
            $AvgData['comp_properties'] = '';
            $AvgData['criteria'] = '';
            $CriteriaResults[$AvgLvl . ''] = $AvgData;            
        }

        return $CriteriaResults;
    }

    public static function ProcessRAvgLevel($InsightsPropertyID, $StartLevel, $EndLevel, $CriteriaResults)
    {
        $AvgLvl = $EndLevel + 1;
        $AvgData = array('est_monthly_rent' => 0, 'low_est_monthly_rent' => 0, 'high_est_monthly_rent' => 0, 'avg_est_monthly_rent' => 0, 'median_est_monthly_rent' => 0, 'level_count' => 0);

        for ($I = $StartLevel; $I <= $EndLevel; $I++) {
            if (!isset($CriteriaResults[$I]))
                continue;

            $AvgData['est_monthly_rent'] += $CriteriaResults[$I]['est_monthly_rent'];
            $AvgData['low_est_monthly_rent'] += $CriteriaResults[$I]['low_est_monthly_rent'];
            $AvgData['high_est_monthly_rent'] += $CriteriaResults[$I]['high_est_monthly_rent'];
            $AvgData['avg_est_monthly_rent'] += $CriteriaResults[$I]['avg_est_monthly_rent'];
            $AvgData['median_est_monthly_rent'] += $CriteriaResults[$I]['median_est_monthly_rent'];
            $AvgData['level_count'] += 1;

            $AvgData['est_month'] = $CriteriaResults[$I]['est_month'];
            $AvgData['est_year'] = $CriteriaResults[$I]['est_year'];
        }

        if ($AvgData['level_count'] > 0) {
            $AvgData['insights_property_id'] = $InsightsPropertyID;

            $AvgData['est_monthly_rent'] = $AvgData['est_monthly_rent']/$AvgData['level_count'];
            $AvgData['rcomp_criteria_id'] = $AvgLvl;
            $AvgData['low_est_monthly_rent'] = $AvgData['low_est_monthly_rent']/$AvgData['level_count'];
            $AvgData['high_est_monthly_rent'] = $AvgData['high_est_monthly_rent']/$AvgData['level_count'];
            $AvgData['avg_est_monthly_rent'] = $AvgData['avg_est_monthly_rent']/$AvgData['level_count'];
            $AvgData['median_est_monthly_rent'] = $AvgData['median_est_monthly_rent']/$AvgData['level_count'];

            $AvgData['comp_properties'] = '';
            $AvgData['criteria'] = '';

            $CriteriaResults[$AvgLvl . ''] = $AvgData;
        }

        return $CriteriaResults;
    }

    public static function NegativeDiffrence($SalePrice, $EstPrice)
    {
        return ( ( ($SalePrice - $EstPrice) / $SalePrice) * 100 );
    }

    public static function Stage($SubjectProperty, $DataSet, $CriteriaResults, $StartLevel, $EndLevel, $Month, $Year, $CheckingPrevious = false)
    {
        if ($StartLevel <= 281)
            $PropLimit = 3;
        else if ($StartLevel > 281 && $StartLevel <= 433)
            $PropLimit = 5;
        else
            $PropLimit = 2; 

        $CriteriaComps = array();
        global $LevelFilters;
        for ($Stage1Index = $StartLevel; $Stage1Index <= $EndLevel; $Stage1Index++) {
            $CriteriaComps[$Stage1Index] = self::FindComps($SubjectProperty, $LevelFilters[$Stage1Index], $DataSet);
            
            // print_r($CriteriaComps[$Stage1Index]);
            // exit;

            if (count($CriteriaComps[$Stage1Index]) >= $PropLimit) {
                // $CriteriaResults[$Stage1Index] = array();
                $CriteriaResults[$Stage1Index] = self::ProcessEstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage1Index], $SubjectProperty['square_foot'], $CriteriaComps[$Stage1Index], $Month, $Year, $Stage1Index);
            }
        }
        
        $CriteriaResults = self::ProcessAvgLevel($SubjectProperty['insights_property_id'], $StartLevel, $EndLevel, $CriteriaResults);

        $AvgLevel = $EndLevel + 1;
        $S2StartLevel = $EndLevel + 2;
        $S2EndLevel = $EndLevel + 4;

        if (isset($CriteriaResults[$AvgLevel]) && isset($CriteriaResults[$AvgLevel]['mid_est_price']) && $CriteriaResults[$AvgLevel]['mid_est_price'] > 0) {
            $SalePriceHighLow = self::SalePriceHL($CriteriaResults[$AvgLevel]['mid_est_price'], 0.15);
            
            for ($Stage2Index = $S2StartLevel, $Stage1Index = $StartLevel; $Stage2Index <= $S2EndLevel; $Stage2Index++, $Stage1Index++) {
                $LevelFilters[$Stage2Index] = array_merge($LevelFilters[$Stage1Index], $SalePriceHighLow);

                $CriteriaComps[$Stage2Index] = self::FindComps($SubjectProperty, $LevelFilters[$Stage2Index], $DataSet);
                if (count($CriteriaComps[$Stage2Index]) >= $PropLimit)
                    $CriteriaResults[$Stage2Index] = self::ProcessEstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage2Index], $SubjectProperty['square_foot'], $CriteriaComps[$Stage2Index], $Month, $Year, $Stage2Index);
            }

            $CriteriaResults = self::ProcessAvgLevel($SubjectProperty['insights_property_id'], $S2StartLevel, $S2EndLevel, $CriteriaResults);
        }

        $S2AvgLevel = $S2EndLevel + 1;
        
        if (isset($CriteriaResults[$S2AvgLevel])) {
            if ($SubjectProperty['sold_before'] >= 0 && $SubjectProperty['sold_before'] <= 24 && $SubjectProperty['sold_price'] > $CriteriaResults[$S2AvgLevel]['est_price'] && self::NegativeDiffrence($SubjectProperty['sold_price'], $CriteriaResults[$S2AvgLevel]['est_price']) > 10) {
                if ($StartLevel >= 0)
                    $S3StartLevel = $StartLevel + 0.1;
                else
                    $S3StartLevel = $StartLevel - 0.1;

                if ($EndLevel >= 0)
                    $S3EndLevel = $EndLevel + 0.1;
                else
                    $S3EndLevel = $EndLevel - 0.1;

                for ($Stage3Index = $S3StartLevel, $Stage1Index = $StartLevel; $Stage3Index <= $S3EndLevel; $Stage3Index++, $Stage1Index++) {
                    $Stage3Key = $Stage3Index . '';
                    $LevelFilters[$Stage3Key] = array_merge($LevelFilters[$Stage1Index], array('sold_price_per' => 20));

                    $CriteriaComps[$Stage3Key] = self::FindComps($SubjectProperty, $LevelFilters[$Stage3Key], $DataSet);
                    if (count($CriteriaComps[$Stage3Key]) >= $PropLimit)
                        $CriteriaResults[$Stage3Key] = self::ProcessEstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage3Key], $SubjectProperty['square_foot'], $CriteriaComps[$Stage3Key], $Month, $Year, $Stage3Index);
                }
                $CriteriaResults = self::ProcessAvgLevel($SubjectProperty['insights_property_id'], $S3StartLevel, $S3EndLevel, $CriteriaResults);
            }

            if (!($CriteriaResults[$S2AvgLevel]['level_count'] == 1 || $CriteriaResults[$S2AvgLevel]['low_est_price'] == $CriteriaResults[$S2AvgLevel]['high_est_price']) && !$CheckingPrevious) {
                self::AddCalculatedValues($CriteriaResults);
                return false;
            }
        }

        return $CriteriaResults;
    }

    public static function RStage($SubjectProperty, $CompsSet, $CriteriaResults, $StartLevel, $EndLevel, $Month, $Year, $CheckingPrevious = false)
    {
        if ($StartLevel <= 185)
            $PropLimit = 3;
        else
            $PropLimit = 5;

        $CriteriaComps = array();
        global $LevelFilters;
        for ($Stage1Index = $StartLevel; $Stage1Index <= $EndLevel; $Stage1Index++) {
            $CriteriaComps[$Stage1Index] = self::FindRComps($SubjectProperty, $LevelFilters[$Stage1Index], $CompsSet);
            if (count($CriteriaComps[$Stage1Index]) >= $PropLimit)
                $CriteriaResults[$Stage1Index] = self::ProcessREstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage1Index], $SubjectProperty['square_foot'], $CriteriaComps[$Stage1Index], $Month, $Year, $Stage1Index);
        }
        
        $CriteriaResults = self::ProcessRAvgLevel($SubjectProperty['insights_property_id'], $StartLevel, $EndLevel, $CriteriaResults);

        $AvgLevel = $EndLevel + 1;
        $S2StartLevel = $EndLevel + 2;
        $S2EndLevel = $EndLevel + 4;

        if (isset($CriteriaResults[$AvgLevel]) && isset($CriteriaResults[$AvgLevel]['median_est_monthly_rent']) && $CriteriaResults[$AvgLevel]['median_est_monthly_rent'] > 0) {
            $SalePriceHighLow = self::SalePriceHL($CriteriaResults[$AvgLevel]['median_est_monthly_rent'], 0.15);
            
            for ($Stage2Index = $S2StartLevel, $Stage1Index = $StartLevel; $Stage2Index <= $S2EndLevel; $Stage2Index++, $Stage1Index++) {
                $LevelFilters[$Stage2Index] = array_merge($LevelFilters[$Stage1Index], $SalePriceHighLow);

                $CriteriaComps[$Stage2Index] = self::FindRComps($SubjectProperty, $LevelFilters[$Stage2Index], $CompsSet);
                if (count($CriteriaComps[$Stage2Index]) >= $PropLimit)
                    $CriteriaResults[$Stage2Index] = self::ProcessREstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage2Index], $SubjectProperty['square_foot'], $CriteriaComps[$Stage2Index], $Month, $Year, $Stage2Index);
            }

            $CriteriaResults = self::ProcessRAvgLevel($SubjectProperty['insights_property_id'], $S2StartLevel, $S2EndLevel, $CriteriaResults);
        }

        $S2AvgLevel = $S2EndLevel + 1;
        
        if (isset($CriteriaResults[$S2AvgLevel])) {

            if ($SubjectProperty['sold_before'] >= 0 && $SubjectProperty['sold_before'] <= 24 && $SubjectProperty['list_price'] > $CriteriaResults[$S2AvgLevel]['est_monthly_rent'] && self::NegativeDiffrence($SubjectProperty['list_price'], $CriteriaResults[$S2AvgLevel]['est_monthly_rent']) > 10) {
                if ($StartLevel >= 0)
                    $S3StartLevel = $StartLevel + 0.1;
                else
                    $S3StartLevel = $StartLevel - 0.1;

                if ($EndLevel >= 0)
                    $S3EndLevel = $EndLevel + 0.1;
                else
                    $S3EndLevel = $EndLevel - 0.1;

                for ($Stage3Index = $S3StartLevel, $Stage1Index = $StartLevel; $Stage3Index <= $S3EndLevel; $Stage3Index++, $Stage1Index++) {
                    $Stage3Key = $Stage3Index . '';
                    $LevelFilters[$Stage3Key] = array_merge($LevelFilters[$Stage1Index], array('sold_price_per' => 20));

                    $CriteriaComps[$Stage3Key] = self::FindRComps($SubjectProperty, $LevelFilters[$Stage3Key], $CompsSet);
                    if (count($CriteriaComps[$Stage3Key]) >= $PropLimit)
                        $CriteriaResults[$Stage3Key] = self::ProcessREstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage3Key], $SubjectProperty['square_foot'], $CriteriaComps[$Stage3Key], $Month, $Year, $Stage3Index);
                }
                $CriteriaResults = self::ProcessRAvgLevel($SubjectProperty['insights_property_id'], $S3StartLevel, $S3EndLevel, $CriteriaResults);
            }

            if (($CriteriaResults[$S2AvgLevel]['level_count'] >= 1 /*|| $CriteriaResults[$S2AvgLevel]['low_est_monthly_rent'] == $CriteriaResults[$S2AvgLevel]['high_est_monthly_rent']*/) && !$CheckingPrevious) {
                self::AddCalculatedRValues($CriteriaResults);
                return false;
            }
        }

        return $CriteriaResults;
    }

    public static function GetRLevelFilters()
    {
        $LevelFilters = array();

        $LevelFilters[1] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[2] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[3] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[9] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[10] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[11] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[17] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[18] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[19] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[25] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[26] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[27] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[33] = array('distance' => 1.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[34] = array('distance' => 1.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[35] = array('distance' => 1.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[41] = array('distance' => 1.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[42] = array('distance' => 1.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[43] = array('distance' => 1.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[49] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[50] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[51] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[57] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[58] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[59] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[65] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[66] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[67] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[73] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[74] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[75] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[81] = array('distance' => 1.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[82] = array('distance' => 1.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[83] = array('distance' => 1.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[89] = array('distance' => 1.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[90] = array('distance' => 1.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[91] = array('distance' => 1.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[97] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[98] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[99] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[105] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[106] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[107] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[113] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[114] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[115] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[121] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[122] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[123] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[129] = array('distance' => 1.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[130] = array('distance' => 1.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[131] = array('distance' => 1.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);
        
        $LevelFilters[137] = array('distance' => 1.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[138] = array('distance' => 1.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[139] = array('distance' => 1.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[145] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[146] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[147] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[153] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[154] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[155] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[161] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[162] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[163] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[169] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[170] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[171] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[177] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[178] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[179] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[185] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[186] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[187] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);
        
        $LevelFilters[193] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[194] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[195] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[201] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[202] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[203] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[209] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[210] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[211] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[217] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[218] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[219] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[225] = array('distance' => 2.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[226] = array('distance' => 2.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[227] = array('distance' => 2.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[233] = array('distance' => 2.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[234] = array('distance' => 2.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[235] = array('distance' => 2.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[241] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[242] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[243] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[249] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[250] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[251] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[257] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[258] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[259] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[265] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[266] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[267] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[273] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[274] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[275] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[281] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[282] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[283] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[289] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[290] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[291] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[297] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[298] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[299] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[305] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[306] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[307] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[313] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[314] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[315] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[321] = array('distance' => 3.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[322] = array('distance' => 3.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[323] = array('distance' => 3.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[329] = array('distance' => 3.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[330] = array('distance' => 3.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[331] = array('distance' => 3.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[337] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[338] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[339] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[345] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[346] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[347] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[353] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[354] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[355] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[361] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[362] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[363] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[369] = array('distance' => 4, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[370] = array('distance' => 4, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[371] = array('distance' => 4, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[377] = array('distance' => 4, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[378] = array('distance' => 4, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[379] = array('distance' => 4, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[385] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[386] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[387] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[393] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[394] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[395] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[401] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[402] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[403] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[409] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[410] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[411] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[417] = array('distance' => 4.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[418] = array('distance' => 4.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[419] = array('distance' => 4.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[425] = array('distance' => 4.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[426] = array('distance' => 4.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[427] = array('distance' => 4.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        return $LevelFilters;
    }

    public static function FindComps($Property, $Filter, $DataSet)
    {
        $FinalDataSet = array();
        //$GetMlsHasStyle = HomeValueCustom :: GetMlsHasStyle();
        $FilterObj = new HVFilter();
        $FilterObj->setFilterParameters($Filter);
        $FilterObj->setSubjectProperty($Property);

        $FinalDataSet = array_filter($DataSet, [$FilterObj, 'distance']);
        
        if (isset($Filter['year_built_tolerance']) && $Filter['year_built_tolerance'] > 0) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'yearBuilt']);
        }

        if (isset($Filter['sold_within']) && $Filter['sold_within'] <= 180) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'soldWithin']);
        }

        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'squareFoot']);
        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'status']);
        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'soldPrice']);

        if (isset($Filter['set_style']) && isset($Property['style']) && $Property['style'] != '') {
            if ($Filter['set_style'] == 'absolute')
                $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'absoluteStyle']);
            else if ($Filter['set_style'] == 'relative')
                $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'relativeStyle']);
        }

        // if (isset($Filter['set_style']) && isset($Property['source']) && isset($GetMlsHasStyle) && in_array($Property['source'], $GetMlsHasStyle) ) {
        //     if ($Filter['set_style'] == 'absolute')
        //         $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'absoluteStyle']);
        //     else if ($Filter['set_style'] == 'relative')
        //         $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'relativeStyle']);
        // }

        if (!(isset($Filter['text_mining_exclusion']) && $Filter['text_mining_exclusion'] === true)) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'excludePublicComments']);
        }
        
        return array_slice($FinalDataSet, 0, 50);
    }

    public static function FindRComps($Property, $Filter, $DataSet)
    {
        $FinalDataSet = array();
        //$GetMlsHasStyle = HomeValueCustom :: GetMlsHasStyle();
        $FilterObj = new HVFilter();
        $FilterObj->setFilterParameters($Filter);
        //  #$# 4.5
        $FilterObj->setRSubjectProperty($Property);

        $FinalDataSet = array_filter($DataSet, [$FilterObj, 'distance']);
        
        if (isset($Filter['year_built_tolerance']) && $Filter['year_built_tolerance'] > 0) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'yearBuilt']);
        }

        if (isset($Filter['sold_within']) && $Filter['sold_within'] <= 180) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'soldWithin']);
        }

        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'squareFoot']);
        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'status']);
        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'soldPrice']);

        if (isset($Filter['set_style']) && isset($Property['style']) && $Property['style'] != '') {
            if ($Filter['set_style'] == 'absolute')
                $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'absoluteStyle']);
            else if ($Filter['set_style'] == 'relative')
                $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'relativeStyle']);
        }

        // if (isset($Filter['set_style']) && isset($Property['source']) && isset($GetMlsHasStyle) && in_array($Property['source'], $GetMlsHasStyle) ) {
        //     if ($Filter['set_style'] == 'absolute')
        //         $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'absoluteStyle']);
        //     else if ($Filter['set_style'] == 'relative')
        //         $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'relativeStyle']);
        // }

        return array_slice($FinalDataSet, 0, 50);
    }

    public  function GetHomeValueCompleted($month, $year, $queryCondition)
    {
        $Obj = new SqlManager();
        $query = "SELECT  mls.id insights_property_id
        FROM tbl_property_details_mls mls INNER JOIN tbl_insights_cron_function_status icfs ON icfs.insights_property_id  = mls.id 
        WHERE mls.homevalue_cron_ran = 'Y' AND icfs.cron_function_name='". MlsCronStatus ."' AND icfs.cron_function_status_flag='".MlsCronStatusHomeEstExternalCompleted."'  
        AND icfs.month = '".$month."' AND icfs.year = '".$year."' ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."";
        
        if (isset($queryCondition)) {
            $query .= $queryCondition;
        }
        $query .= "  ORDER BY mls.id ";
        $query .= "  LIMIT 50 ";
        $query .= "  ;";
        echo "query:: <pre>";
        print_r($query);
        // die('@@');
        // echo "</pre>";
        return $Obj->GetQuery($query);
    }    

    public static function FetchCompletedCompareData($month, $year)
    {
        $Obj = new SqlManager();
        $query = "SELECT icfs.insights_property_id FROM tbl_insights_cron_function_status icfs WHERE
        icfs.month = '".$month."' AND icfs.year = '".$year."' 
        AND icfs.cron_function_status_flag='Y' 
        AND icfs.cron_function_name ='". CONFIG_IS_CUSTOM_HOME_VALUE_COMPARE_COMPLETED ."' GROUP BY insights_property_id ";
        echo "FetchCompletedCompareData:: <pre>";
        print_r($query);
        // die('@@');
        // echo "</pre>";
        return $Obj->GetQuery($query);
    }

    public  function GetHomeValue($PropertyId)
    {
        $Obj = new SqlManager();
        $Query = "SELECT * FROM tbl_insights_est_price_mls WHERE insights_property_id=".$PropertyId." AND pcomp_criteria_id!=10000  
        AND est_month='".CURRENT_MONTH."' AND est_year= '".CURRENT_YEAR."' AND is_best = 'Y' LIMIT 1"; 
        // print_r($Query);			
        return $Obj->GetQuery($Query);  	
    }

    public  function GetExternalHomeValue($PropertyId)
    {
        $Obj = new SqlManager();
        $Query = "SELECT * FROM tbl_insights_est_price_mls WHERE insights_property_id=".$PropertyId." AND pcomp_criteria_id=10000 
        AND est_month='".CURRENT_MONTH."' AND est_year= '".CURRENT_YEAR."' ORDER BY est_price DESC LIMIT 1"; 
        // print_r($Query);			
        return $Obj->GetQuery($Query);  	
    }       
    
    public  function UpdateIsBestOld($PropertyId)
    {
        $Obj = new SqlManager();
        $Query = "UPDATE `tbl_insights_est_price_mls` SET `is_best` = 'O' WHERE `is_best` = 'Y' AND insights_property_id=".$PropertyId." 
        AND est_month='".CURRENT_MONTH."' AND est_year= '".CURRENT_YEAR."'  LIMIT 1
        "; 
        echo '<pre>';
        print_r($Query);			
         $Obj->ExecQuery($Query);  	
    }    
    
    public  function UpdateIsBest($PropertyId, $RowId)
    {
        $Obj = new SqlManager();
        $Query = "UPDATE `tbl_insights_est_price_mls` SET `is_best` = 'Y'  WHERE  `id` = '".$RowId."' AND insights_property_id=".$PropertyId." 
        AND est_month='".CURRENT_MONTH."' AND est_year= '".CURRENT_YEAR."' LIMIT 1 "; 
        echo '<pre>';
        print_r($Query);			
         $Obj->ExecQuery($Query);  	
    }       

    // Home Value Automation 
    public function CallGetInbSubjectProperty($GetInbSubjectPropertiesActive,$ScriptType)
    {

        echo '$GetInbSubjectPropertiesActive'; 
        print_r($GetInbSubjectPropertiesActive);
        if($ScriptType=='Adhoc'){
           
            $SubjectInbProperties = self::GetInbSubjectPropertyCustom();
        }else{
             
            $SubjectInbProperties = self::GetInbSubjectProperty(CURRENT_MONTH, CURRENT_YEAR);
        }
        
        echo '<hr>Home Value Properties: <pre>';
        foreach ($SubjectInbProperties as $item) {
            echo $item['insights_property_id'].'<hr>';
        }
        echo '<hr></pre>';
        echo '$SubjectInbProperties'; 
        print_r($SubjectInbProperties);
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($SubjectInbProperties,CONFIG_PROCESS_HOME_VALUE_CUSTOM,'P');              
        self::ProcessHV($SubjectInbProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_INB_SUBJECT_PROPERTIES);
        return $SubjectInbProperties ;
        
    }

    public static function GetCronFunctionStatus($PropertyId)
    {
        print_r('GetCronFunctionStatus');
        $Obj = new SqlManager();
        $Query = "SELECT * FROM insights_cron_function_status WHERE cron_function_name = '". MlsCronStatus ."' AND cron_function_status_flag = '".MlsCronStatusHomeEstExternalCompleted."' AND insights_property_id = ".$PropertyId." AND TIMESTAMPDIFF(MONTH, last_modified_date_time, NOW()) <= 3";
       // print_r($Query);
        return $Obj->GetQuery($Query);
    }
    
    public static function UpdateExternalHomeValue($ExternalPropertyData, $Property) {
        $Month = date('m');
        $Year = date('Y');
        if(!empty($ExternalPropertyData)) {
            echo 'Row :: <pre>';
            print_r($ExternalPropertyData);
            // Check property address not found in zData 
            if(isset($ExternalPropertyData->total) && $ExternalPropertyData->total == 0) {
                // $Parms = array('cron_function_name' => CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM, 'insights_property_id' => $Item['insights_property_id'], 'cron_function_status_flag' => AddressNotFoundInExternal);  
                // $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                
                $Parms = array('cron_function_name' => CONFIG_IS_HOME_EXTERNAL_API_CHECKED, 'insights_property_id' => $ExternalPropertyData->insights_property_id, 'cron_function_status_flag' => AddressNotFoundInExternal,
                'month' => CURRENT_MONTH,
                'year' => CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                
                ##### cron_status = 2_rent_est_external_failed 
                $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $ExternalPropertyData->insights_property_id, 
                    'cron_function_status_flag' => MlsCronStatusHomeEstExternalFailed,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR 
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusHomeEstExternalFailed);  
                print_r($Parms2);
                echo '####External API #1<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $ExternalPropertyData->insights_property_id); 
                #####                

            } else {
                if (isset($ExternalPropertyData) && count($ExternalPropertyData)) {
                        $ExternalPropertyData['est_month'] = $Month;
                        $ExternalPropertyData['est_year'] = $Year;
                       // $ExternalPropertyData['insights_property_id'] = $ExternalPropertyData['insights_property_id'];
                        if(!isset($ExternalPropertyData['est_price'])) {
                            $Parms = array('cron_function_name' => CONFIG_IS_HOME_EXTERNAL_API_CHECKED, 'insights_property_id' => $ExternalPropertyData['insights_property_id'], 'cron_function_status_flag' => HomeValueNotFoundInExternal,
                            'month' => CURRENT_MONTH,
                            'year' => CURRENT_YEAR );  
                            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 

                            ##### cron_status = 2_rent_est_external_failed 
                            $Parms1 = array(
                                'cron_function_name' => MlsCronStatus, 
                                'insights_property_id' => $ExternalPropertyData['insights_property_id'], 
                                'cron_function_status_flag' => MlsCronStatusHomeEstExternalFailed,
                                'month' => CURRENT_MONTH,
                                'year' => CURRENT_YEAR 
                            );  
                            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                            $Parms2 = array('cron_status' => MlsCronStatusHomeEstExternalFailed);  
                            print_r($Parms2);
                            echo '####External API #2<hr>';
                            $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $ExternalPropertyData['insights_property_id']); 
                            #####   
                        } else {
                            $Parms = array('cron_function_name' => CONFIG_IS_HOME_EXTERNAL_API_CHECKED, 'insights_property_id' => $ExternalPropertyData['insights_property_id'], 'cron_function_status_flag' => HomeValueFoundInExternal,
                            'month' => CURRENT_MONTH,
                            'year' => CURRENT_YEAR );  

                            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                            // Insert/Update in external estimate 
                            InsightExternalProperties::InsertUpdateZAVM($ExternalPropertyData, MLS_PROPERTY_SOURCE);
                            // Insert/Update in tbl_insights_est_rent_mls
                            InsightExternalProperties::InsertUpdateEstHomeMls($ExternalPropertyData);          
                            ##### cron_status = 2_rent_est_completed 
                            $Parms1 = array(
                                'cron_function_name' => MlsCronStatus, 
                                'insights_property_id' => $ExternalPropertyData['insights_property_id'], 
                                'cron_function_status_flag' => MlsCronStatusHomeEstExternalCompleted,
                                'month' => CURRENT_MONTH,
                                'year' => CURRENT_YEAR 
                            );  
                            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                            $PropertyDetailsArray = array();
                         
                            if(isset($ExternalPropertyData['tax_assessment_year']) && $ExternalPropertyData['tax_assessment_year']!='' && $ExternalPropertyData['tax_assessment_year'] != 0
                                && (empty($Property['tax_year']) || $Property['tax_year'] < $ExternalPropertyData['tax_assessment_year'])) {
                                $PropertyDetailsArray['tax_year'] = $ExternalPropertyData['tax_assessment_year'];
                                $PropertyDetailsArray['annual_taxes'] = $ExternalPropertyData['tax_assessment'];
                            }
                            $PropertyDetailsArray['cron_status'] = MlsCronStatusHomeEstExternalCompleted;
                            if (count($PropertyDetailsArray) > 0)
                                self::UpdatePropertyDetails($ExternalPropertyData['insights_property_id'],$PropertyDetailsArray);                                                                       
                            }
        
                        #### Inserting data from external property to table ####
                        $params2 = array( 
                            'zpid' => $ExternalPropertyData['zpid'],
                            'zillow_url' => $ExternalPropertyData['zillow_url'],
                            'street'=> $ExternalPropertyData['street'],
                            'zipcode'=> $ExternalPropertyData['zipcode'],
                            'city'=> $ExternalPropertyData['city'],
                            'state'=> $ExternalPropertyData['state'],
                            'latitude'=> $ExternalPropertyData['latitude'],
                            'longitude'=> $ExternalPropertyData['longitude'],
                            'fips_county'=> $ExternalPropertyData['fips_county'],
                            'tax_assessment_year'=> $ExternalPropertyData['tax_assessment_year'],
                            'tax_assessment'=> $ExternalPropertyData['tax_assessment'],
                            'year_built'=> $ExternalPropertyData['year_built'],
                            'lat_size'=> $ExternalPropertyData['lat_size'],
                            'living_square_foot'=> $ExternalPropertyData['living_square_foot'],
                            'bathrooms'=> $ExternalPropertyData['bathrooms'],
                            'bedrooms'=> $ExternalPropertyData['bedrooms'],
                            'sold_last_on'=> $ExternalPropertyData['sold_last_on'],
                            'est_price'=> $ExternalPropertyData['est_price'],
                            'external_est_price'=> $ExternalPropertyData['external_est_price'],
                            'low_est_price'=> $ExternalPropertyData['low_est_price'],
                            'external_low_est_price'=> $ExternalPropertyData['external_low_est_price'],
                            'high_est_price'=> $ExternalPropertyData['high_est_price'],
                            'external_high_est_price'=> $ExternalPropertyData['external_high_est_price'],
                            'est_monthly_rent'=> $ExternalPropertyData['est_monthly_rent'],
                            'external_monthly_rent'=> $ExternalPropertyData['external_monthly_rent'],
                            'low_est_monthly_rent'=> $ExternalPropertyData['low_est_monthly_rent'],
                            'external_low_est_monthly_rent'=> $ExternalPropertyData['external_low_est_monthly_rent'],
                            'high_est_monthly_rent'=> $ExternalPropertyData['high_est_monthly_rent'],
                            'external_high_est_monthly_rent'=> $ExternalPropertyData['external_high_est_monthly_rent'],
                            'est_month'=> $ExternalPropertyData['est_month'],
                            'est_year'=> $ExternalPropertyData['est_year'],
                            'insight_property_id'=> $ExternalPropertyData['insight_property_id']
                        );
                        Common::InsertData('tbl_external_property_data', $params2,false);
                } 
            }
        }  
    }

    public static function UpdatePropertyDetails($InsightsPropertyID, $Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('property_details_mls'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('id', $InsightsPropertyID);
        $Obj->Update();
    }

    public function CallGetNonInbSubjectProperty($GetNonInbSubjectPropertiesActive)
    {
        if($GetNonInbSubjectPropertiesActive){
            $SubjectNonInbProperties = self::GetNonInbSubjectProperty(CURRENT_MONTH, CURRENT_YEAR);
            echo 'SubjectNonInbProperties :: <pre>';
            print_r($SubjectNonInbProperties);    
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($SubjectNonInbProperties,CONFIG_IS_HOME_VALUE_COMPLETED,'P'); 
            self::ProcessHV($SubjectNonInbProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_NON_INB_SUBJECT_PROPERTIES);
        }   
    }

    public function CallGetExternalSubjectProperty($GetExternalSubjectPropertiesActive)
    {
        if($GetExternalSubjectPropertiesActive){
            $SubjectExternalProperties = self::GetExternalSubjectProperty(CURRENT_MONTH, CURRENT_YEAR);
            echo 'SubjectExternalProperties :: <pre>';
            print_r($SubjectExternalProperties);
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($SubjectExternalProperties,CONFIG_IS_HOME_VALUE_COMPLETED,'P'); 
            self::ProcessHV($SubjectExternalProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES);
        }        
    }


    /**
     * This function will return the tbl_property_details_mls records
     * which doesn't get home values and rent values from the external API.
     * Used in cron\home-value-custom.php cron job
     */
    public function GetInbSubjectPropertyForCustomHV()
    {
        ## Update the new Query here..
        $Obj = new SqlManager();
            // Original
            /*
            $Query =" SELECT mls.id  AS insights_property_id ,latitude, longitude, sold_price, sold_date, square_foot, property_type, style, year_built  FROM tbl_property_details_mls mls INNER JOIN tbl_insights_est_price_mls price ON(price.insights_property_id = mls.id   AND price.is_best = 'Y')  WHERE mls.record_status != 'R' AND (mls.homevalue_cron_ran IS NULL OR mls.homevalue_cron_ran != 'Y')  AND (mls.processed_matrix_date = '0000-00-00 00:00:00' OR mls.processed_matrix_date is null)  AND mls.county IN (SELECT county_name FROM county_master WHERE is_active = 1) AND mls.style IN(SELECT style FROM reis.tbl_property_style_master where display='Y')  AND mls.id not in ( select tbl_property_details_mls_id from  tbl_est_price_rent_is_best ) ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."  ORDER BY mls.id DESC LIMIT 1 ";
            */
            // Removed cond => AND mls.style IN(SELECT style FROM reis.tbl_property_style_master where display='Y')  
            // Removed cond => AND mls.cron_status='".MlsCronStatusRentEstCompleted."'
            $Query =" SELECT mls.id  AS insights_property_id ,latitude, longitude, list_price, list_date, square_foot, property_type, style, year_built  
            FROM tbl_property_details_mls mls 
            LEFT JOIN tbl_insights_est_price_mls price ON(price.insights_property_id = mls.id   AND price.is_best = 'Y') 
            LEFT JOIN tbl_insights_est_rent_mls rent ON(rent.insights_property_id = mls.id   AND rent.is_best = 'Y')  
            WHERE mls.record_status != 'R'
            AND (mls.cron_status='".MlsCronStatusAVMRentCompleted."' OR mls.cron_status='".MlsCronStatusAVMPriceCompleted."' OR mls.cron_status='".MlsCronStatusAVMRentInComplete."' OR mls.cron_status='".MlsCronStatusAVMPriceInComplete."')
            AND (mls.homevalue_cron_ran = 'Y')
            AND mls.county IN (SELECT county_name FROM county_master WHERE home_value_calculate = 1)
            AND mls.id not in ( select tbl_property_details_mls_id from  tbl_est_price_rent_is_best ) 
            ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."  
            GROUP BY insights_property_id 
            ORDER BY mls.id DESC LIMIT 65 ";
				
				/*
					 AND mls.id IN (SELECT icfs1.insights_property_id 
                   FROM tbl_insights_cron_function_status   icfs1
                   WHERE icfs1.cron_function_name='".CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM."'  AND icfs1.cron_function_status_flag='Y' 
                   AND icfs1.month='" . CURRENT_MONTH ."' AND  icfs1.year= " . CURRENT_YEAR ."  )
				*/
				
        // AND (mls.homevalue_cron_ran IS NULL OR mls.homevalue_cron_ran != 'Y') 
        // , im.insights_property_id ,
        // LEFT JOIN tbl_insights_main im ON(im.inbestments_property_id = mls.id)
        // mls.id not in ( select property_id from
        // tbl_property_details_avm avm
        // where
        // avm.homevalue_cron_ran != 'Y' or (avm.estimate_amount > 0 or avm.rent_amount > 0) 
        // ))

        /*
        $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude, mls.sold_price, mls.sold_date, mls.square_foot, mls.property_type, mls.style, mls.year_built, 
                    IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, sold_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before 
                    FROM 
                    tbl_property_details_mls mls 
                    LEFT JOIN tbl_insights_est_price_new_programmatic algo ON(algo.insights_property_id = mls.id AND algo.est_month = '" . CURRENT_MONTH ."' AND algo.est_year = " . CURRENT_YEAR .")
                    
                    LEFT JOIN tbl_insights_est_price_mls rent ON(rent.insights_property_id = mls.id AND algo.est_month = '" . CURRENT_MONTH ."' AND algo.est_year = " . CURRENT_YEAR .")
                    LEFT JOIN tbl_insights_est_price_mls price ON(price.insights_property_id = mls.id AND algo.est_month = '" . CURRENT_MONTH ."' AND algo.est_year = " . CURRENT_YEAR .")
                   

                    WHERE 
                    mls.latitude != 0 AND mls.longitude != 0 
                    AND (mls.homevalue_cron_ran IS not NULL OR mls.homevalue_cron_ran = 'Y') 
                    ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS." 
                    AND mls.square_foot > 0
                    GROUP BY mls.id 
                    ORDER BY mls.id 
                    DESC LIMIT 30 ";
        */            
            echo '#1:: GetInbSubjectPropertyForCustomHV:: <pre>';
            print_r($Query);

            // echo '<hr>';
            return $Obj->GetQuery($Query);
    }
   /**
     * This function will return the tbl_property_details_mls records
     * which doesn't get home values and rent values from the external API.
     * Used in cron\home-value-custom.php cron job
     */
    public function GetInbSubjectPropertyForCustomHVAdhoc()
    {
       $GetMlsHasStyle = HomeValueCustom :: GetMlsHasStyle();
        ## Update the new Query here..
        $Obj = new SqlManager();
        
        $Query =" SELECT mls.id  AS insights_property_id, latitude, longitude, sold_price, sold_date, square_foot, property_type, style, year_built FROM tbl_property_details_mls mls INNER JOIN tbl_insights_est_price_mls price ON(price.insights_property_id = mls.id AND price.is_best = 'Y') WHERE `status` = 'Active'  AND mls.county IN (SELECT county_name FROM county_master WHERE home_value_calculate = 1) AND (mls.style IN(SELECT style FROM reis.tbl_property_style_master where display='Y') OR (mls.style IS NULL AND mls.source IN(' ".implode("', '", $GetMlsHasStyle)."'))) AND mls.id IN (SELECT insights_property_id FROM tbl_insights_est_price_mls where is_best = 'Y') AND mls.id IN (SELECT insights_property_id FROM tbl_insights_est_rent_mls where is_best = 'Y')  AND mls.id not in ( select tbl_property_details_mls_id from tbl_est_price_rent_is_best) ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS." ORDER BY mls.id  LIMIT 50 ";
        return $Obj->GetQuery($Query);
    }

    /**
     * A function for inserting or updating the price and rent in tbl_property_details_avm AVM table
     * get tbl_insights_est_price_mls and tbl_insights_est_rent_mls
     * table is_best ='Y' and insert/update it into AVM table.
     * Used in cron\cron-update-hv-in-avm.php cron job
     */
    public function UpdateAVMtableForCustomHVandRent($InbPropertiesArray)
    {
        $InsertArray = array();
		$UpdateArray = array();
        if (count($InbPropertiesArray) > 0) {

            foreach ($InbPropertiesArray as $property) {
                // ##### cron_status = 3-avm_in_process 
                // $Parms1 = array(
                //     'cron_function_name' => MlsCronStatus, 
                //     'insights_property_id' => $property['insights_property_id'], 
                //     'cron_function_status_flag' => MlsCronStatusAVMInProcess 
                // );  
                // $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                // $Parms2 = array('cron_status' => MlsCronStatusAVMInProcess);  
                // print_r($Parms2);
                // echo '<hr>';
                // $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $property['insights_property_id']); 
                // #####

                ##### cron_status = 3_avm_price_in_process 
                $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $property['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusAVMPriceInProcess,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR 
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusAVMPriceInProcess);  
                print_r($Parms2);
                echo '<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $property['insights_property_id']); 
                #####

                ##### cron_status = 3_avm_rent_in_process 
                $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $property['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusAVMRentInProcess,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR 
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusAVMRentInProcess);  
                print_r($Parms2);
                echo '<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $property['insights_property_id']); 
                #####
                

                $property['est_month'] = CURRENT_MONTH;
                $property['est_year'] = CURRENT_YEAR;

                // get tbl_insights_est_price_mls values
                $isBestPrice =  self::GetHomeValueIsBestLatest($property);
                echo "GetHomeValueIsBest:##2: ";
                // print_r($isBestPrice);
                if (!empty($isBestPrice)) {
                    foreach ($isBestPrice as $item) {
                        # echo $item['insights_property_id'].'<hr>';
                    }
                }
                echo '<hr></pre>'; 
                // get tbl_insights_est_rent_mls values
                $isBestRent =  self::GetRentValueIsBestNew($property);
                echo "GetRentValueIsBestNew:##2: ";
                // print_r($isBestRent);
                if (!empty($isBestRent)) {
                    foreach ($isBestRent as $item) {
                        // echo $item['insights_property_id'].'<hr>';
                    }
                }
                echo '<hr></pre>'; 
                // check if the AVM already has record for the property_id
               $isRecordExist = self::checkIfRecordExist('tbl_property_details_avm','property_id', $property['insights_property_id']);

               $AVMRecord = array();
            #   id, rent_estimate_low, rent_estimate_high, property_id, AVM1_id, rent_amount, estimate_amount, estimate_amount_low, estimate_amount_high, home_details, graphs_and_data, map_this_home, comparables, latitude, longitude, year_built, lot_size_sq_ft, finished_size_sq_ft, status_code, status_msg, created_date, homevalue_cron_ran, homevalue_cron_ran_datetime

               $AVMRecord['property_id'] =  $property['insights_property_id'];
               $AVMRecord['longitude'] =  $property['longitude'] ?? null;
               $AVMRecord['latitude'] =  $property['latitude'] ?? null;
            //    $AVMRecord['year_built'] =  $property['year_built'] ?? null;
               $AVMRecord['created_date'] =  date(DB_DATETIME_FORMAT);
            //    $AVMRecord['homevalue_cron_ran'] =  'Y';
            //    $AVMRecord['homevalue_cron_ran_datetime'] =  date(DB_DATETIME_FORMAT);

               if(isset($isBestPrice) && (count($isBestPrice) > 0))
               {
                    $AVMRecord['estimate_amount'] = isset($isBestPrice['est_price']) ? $isBestPrice['est_price'] : 0;
                    $AVMRecord['estimate_amount_high'] = isset($isBestPrice['high_est_price']) ? $isBestPrice['high_est_price'] : 0;
                    // $AVMRecord['estimate_amount_mid'] = $isBestPrice['mid_est_price'] ?? 0;
                    $AVMRecord['estimate_amount_low'] = isset($isBestPrice['low_est_price']) ? $isBestPrice['low_est_price'] : 0;
               } else {
                    /**
                     * Need to update the status 3_avm_price_processed_not_set
                     */
                    ##### cron_status = 3_avm_rent_in_process 
                    $Parms1 = array(
                        'cron_function_name' => MlsCronStatus,
                        'insights_property_id' => $property['insights_property_id'],
                        'cron_function_status_flag' => MlsCronStatusAVMPriceInComplete,
                        'month' => CURRENT_MONTH,
                        'year' => CURRENT_YEAR
                    );
                    $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                    $Parms2 = array('cron_status' => MlsCronStatusAVMPriceInComplete);
                    print_r($Parms2);
                    echo '<hr>';
                    $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                    #####
                }

                if(isset($isBestRent) && (count($isBestRent) > 0) )
                {
                    $AVMRecord['rent_amount'] = isset($isBestRent['est_monthly_rent']) ? $isBestRent['est_monthly_rent'] : 0;
                    $AVMRecord['rent_estimate_high'] = isset($isBestRent['high_est_monthly_rent']) ? $isBestRent['high_est_monthly_rent'] : 0;
                // $AVMRecord['rent_estimate_mid'] = $isBestRent['median_est_monthly_rent'] ?? 0;
                    $AVMRecord['rent_estimate_low'] = isset($isBestRent['low_est_monthly_rent']) ? $isBestRent['low_est_monthly_rent'] : 0;
                } else {
                    $AVMRecord['rent_amount'] = 0;
                    $AVMRecord['rent_estimate_high'] = 0;
                    $AVMRecord['rent_estimate_low'] = 0;
                    /**
                     * Need to update the status 3_avm_rent_processed_not_set
                     */
                    ##### cron_status = 3_avm_rent_in_process 
                    $Parms1 = array(
                        'cron_function_name' => MlsCronStatus,
                        'insights_property_id' => $property['insights_property_id'],
                        'cron_function_status_flag' => MlsCronStatusAVMRentInComplete,
                        'month' => CURRENT_MONTH,
                        'year' => CURRENT_YEAR
                    );
                    $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                    $Parms2 = array('cron_status' => MlsCronStatusAVMRentInComplete);
                    print_r($Parms2);
                    echo '<hr>';
                    $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                    #####
                }

            //    echo ""; print_r();
               echo "isRecordExist:: "; print_r($isRecordExist);
                // if (isset($isBestPrice) && (count($isBestPrice) > 0) && isset($isBestRent) && (count($isBestRent) > 0)) {
                if ((isset($isBestPrice) && (count($isBestPrice) > 0)) || (isset($isBestRent) && (count($isBestRent) > 0))) {
                    if ($isRecordExist) {
                        // Update the existing AVM record
                        echo " Update the existing AVM record ";

                        unset($AVMRecord['created_date']);

                        self::UpdateAVMDetailsTable($property['insights_property_id'], $AVMRecord);
                    } else {
                        // Insert new record in AVM
                        echo "  Insert new record in AVM ";
                        $InsertArray[] = $AVMRecord;
                    }

                    // homevalue_cron_ran status in property_details_mls table
                    $MLSParam['homevalue_cron_ran'] =  'Y';
                    $MLSParam['homevalue_cron_ran_datetime'] =  date(DB_DATETIME_FORMAT);
                    // self::UpdateMLSDetailsTable($property['insights_property_id'], $MLSParam);
                    if (isset($isBestPrice) && count($isBestPrice) > 0) {
                        ##### cron_status = 3_avm_price_completed
                        $Parms1 = array(
                            'cron_function_name' => MlsCronStatus,
                            'insights_property_id' => $property['insights_property_id'],
                            'cron_function_status_flag' => MlsCronStatusAVMPriceCompleted,
                            'month' => CURRENT_MONTH,
                            'year' => CURRENT_YEAR
                        );
                        $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                        $Parms2 = array('cron_status' => MlsCronStatusAVMPriceCompleted);
                        print_r($Parms2);
                        echo '<hr>';
                        $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                        #####  
                    }
                    if (isset($isBestRent) && count($isBestRent) > 0) {
                        ##### cron_status = 3_avm_rent_completed
                        $Parms1 = array(
                            'cron_function_name' => MlsCronStatus,
                            'insights_property_id' => $property['insights_property_id'],
                            'cron_function_status_flag' => MlsCronStatusAVMRentCompleted,
                            'month' => CURRENT_MONTH,
                            'year' => CURRENT_YEAR
                        );
                        $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                        $Parms2 = array('cron_status' => MlsCronStatusAVMRentCompleted);
                        print_r($Parms2);
                        echo '<hr>';
                        $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                        #####  
                    }
                }                  
                // } 
                // else {
                //     ##### cron_status = 3_avm_incomplete
                //     $Parms1 = array(
                //         'cron_function_name' => MlsCronStatus,
                //         'insights_property_id' => $property['insights_property_id'],
                //         'cron_function_status_flag' => MlsCronStatusAVMInComplete
                //     );
                //     $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                //     $Parms2 = array('cron_status' => MlsCronStatusAVMInComplete);
                //     print_r($Parms2);
                //     echo '<hr>';
                //     $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                //     #####          
                // }

              
               
            } // End of for loop

            // Bulk Insert
            if (count($InsertArray)) {
                echo " InsertArray:: Insert new record in AVM ";
                if (count($InsertArray) > 750) {
                    $TempArray = array_chunk($InsertArray, 750);
                    foreach ($TempArray as $Item) {
                        echo 'InsertItemArray';
                        print_r($Item);
                        Common::InsertData('property_details_avm', $Item, false);
                    }
                } else {
                    Common::InsertData('property_details_avm', $InsertArray, true);
                } 
                // if (count($InsertArray) > 750) {
                //     $TempArray = array_chunk($InsertArray, 750);
                //     foreach ($TempArray as $Item) {
                //         Common::InsertData('property_details_avm', $Item, true);
                //     }
                // } else {
                //     Common::InsertData('property_details_avm', $InsertArray, true);
                // }
            }
            // $AVMInsertBulk = Common::InsertData('property_details_avm', $Item, true);

        }
        else{
            return false;
        }


    }

    /**
     * A function for inserting or updating the price and rent in tbl_est_price_rent_is_best isBest table
     * get tbl_insights_est_price_mls and tbl_insights_est_rent_mls
     * table is_best ='Y' and insert/update it into isBest table.
     * Used in cron\home-value-custom.php cron job
     */
    public function UpdatePriceRentIsBestTableForCustomHVandRent($InbPropertiesArray)
    {
        $InsertArray = array();
		$UpdateArray = array();
        if (count($InbPropertiesArray) > 0) {

            foreach ($InbPropertiesArray as $property) {
                ##### cron_status =4_is_best_price_in_process
                $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $property['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusIsBestPriceInProcess,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusIsBestPriceInProcess );  
                print_r($Parms2);
                echo '<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $property['insights_property_id']); 
                #####

                ##### cron_status =4_is_best_rent_in_process
                $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $property['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusIsBestRentInProcess,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusIsBestRentInProcess );  
                print_r($Parms2);
                echo '<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $property['insights_property_id']); 
                #####
                
                $property['est_month'] = CURRENT_MONTH;
                $property['est_year'] = CURRENT_YEAR;

                // get tbl_insights_est_price_mls values
                $isBestPrice =  self::GetHomeValueIsBestLatest($property);
                echo "GetHomeValueIsBest:##1: "; 
                // print_r($isBestPrice);
                if(!empty($isBestPrice)){
                    foreach ($isBestPrice as $item) {
                        echo $item.'<hr>';
                    }
    
                }
                echo '<hr></pre>'; 

                // get tbl_insights_est_rent_mls values
                $isBestRent =  self::GetRentValueIsBestNew($property);
                echo "GetRentValueIsBest:##1: "; 
                // print_r($isBestRent);
                if(!empty($isBestRent)){
                    foreach ($isBestRent as $item) {
                        echo $item.'<hr>';
                    }
    
                }
                echo '<hr></pre>';   
                // check if the tbl_est_price_rent_is_best already has record for the property_id (tbl_property_details_mls_id)
               $isRecordExist = self::checkIfRecordExist('tbl_est_price_rent_is_best','tbl_property_details_mls_id', $property['insights_property_id']);

               echo "checkIfRecordExist:: "; print_r($isRecordExist);

               $NewRecord = array();
           

               $NewRecord['tbl_property_details_mls_id'] =  $property['insights_property_id'];
            //    $NewRecord['longitude'] =  $property['longitude'] ?? null;
            //    $NewRecord['latitude'] =  $property['latitude'] ?? null;
            //    $NewRecord['year_built'] =  $property['year_built'] ?? null;
               $NewRecord['created_date'] =  date(DB_DATETIME_FORMAT);
            //    $NewRecord['homevalue_cron_ran'] =  'Y';
            //    $NewRecord['homevalue_cron_ran_datetime'] =  date(DB_DATETIME_FORMAT);
            
            # tbl_est_price_rent_is_best::    
            #   id, tbl_property_details_mls_id, price_high_inb, price_median_inb, price_low_inb, rent_high_inb, rent_median_inb, rent_low_inb, comp_price_search_criteria_inb, comp_rent_search_criteria_inb, price_comps_inb, rent_comps_inb, pcomp_criteria_id, rcomp_criteria_id, created_at, est_month, est_year

            # tbl_insights_est_price_mls::    
            # id, insights_property_id, est_price, adjustment_value, avg_est_price, high_est_price, low_est_price, mid_est_price, est_month, est_year, pcomp_criteria_id, comp_properties, criteria, is_best, is_best_bk_11102019, last_modified, last_modified_by, record_status

            # tbl_insights_est_price_mls::    
            # id, insights_property_id, est_monthly_rent, avg_est_monthly_rent, high_est_monthly_rent, low_est_monthly_rent, median_est_monthly_rent, est_month, est_year, rcomp_criteria_id, comp_properties, criteria, is_best, last_modified, last_modified_by

               if(isset($isBestPrice) && (count($isBestPrice) > 0))
               {
                    // $NewRecord['estimate_amount'] = $isBestPrice['est_price'] ?? 0;
                    $NewRecord['price_high_inb'] = $isBestPrice['high_est_price'] ?? 0;
                    $NewRecord['price_median_inb'] = $isBestPrice['mid_est_price'] ?? 0;
                    $NewRecord['price_low_inb'] = $isBestPrice['low_est_price'] ?? 0;

                    $NewRecord['est_month'] =  $property['est_month'] ?? CURRENT_MONTH;
                    $NewRecord['est_year'] =  $property['est_year'] ?? CURRENT_YEAR;
                    $NewRecord['comp_price_search_criteria_inb'] = $isBestPrice['criteria'] ?? null;
                    $NewRecord['price_comps_inb'] = $isBestPrice['comp_properties'] ?? null;
                    $NewRecord['pcomp_criteria_id'] = $isBestPrice['pcomp_criteria_id'] ?? null;
                   

               } else {
                    /**
                     * Need to update the status 4_is_best_price_processed_not_set
                     */
                    ##### cron_status = 4_is_best_price_processed_not_set 
                    $Parms1 = array(
                        'cron_function_name' => MlsCronStatus,
                        'insights_property_id' => $property['insights_property_id'],
                        'cron_function_status_flag' => MlsCronStatusIsBestPriceInComplete,
                        'month' => CURRENT_MONTH,
                        'year' => CURRENT_YEAR
                    );
                    $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                    $Parms2 = array('cron_status' => MlsCronStatusIsBestPriceInComplete);
                    print_r($Parms2);
                    echo '<hr>';
                    $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                    #####
                }

                if(isset($isBestRent) && (count($isBestRent) > 0) )
                {
                    // $NewRecord['rent_amount'] = $isBestRent['est_monthly_rent'] ?? 0;
                    $NewRecord['rent_high_inb'] = $isBestRent['high_est_monthly_rent'] ?? 0;
                    $NewRecord['rent_median_inb'] = $isBestRent['median_est_monthly_rent'] ?? 0;
                    $NewRecord['rent_low_inb'] = $isBestRent['low_est_monthly_rent'] ?? 0;

                    $NewRecord['est_month'] =  $property['est_month'] ?? CURRENT_MONTH;
                    $NewRecord['est_year'] =  $property['est_year'] ?? CURRENT_YEAR;
                    $NewRecord['comp_rent_search_criteria_inb'] = $isBestRent['criteria'] ?? null;
                    $NewRecord['rent_comps_inb'] = $isBestRent['comp_properties'] ?? null;
                    $NewRecord['rcomp_criteria_id'] = $isBestRent['rcomp_criteria_id'] ?? null;
                } else {
                    /**
                     * Need to update the status 4_is_best_rent__processed_not_set
                     */
                    ##### cron_status = 4_is_best_rent__processed_not_set 
                    $Parms1 = array(
                        'cron_function_name' => MlsCronStatus,
                        'insights_property_id' => $property['insights_property_id'],
                        'cron_function_status_flag' => MlsCronStatusIsBestRentInComplete,
                        'month' => CURRENT_MONTH,
                        'year' => CURRENT_YEAR
                    );
                    $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                    $Parms2 = array('cron_status' => MlsCronStatusIsBestRentInComplete);
                    print_r($Parms2);
                    echo '<hr>';
                    $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                    #####
                }


            //    echo ""; print_r();

            if((isset($isBestPrice) && (count($isBestPrice) > 0)) OR (isset($isBestRent) && (count($isBestRent) > 0)))
            {

                echo "isRecordExist:: "; print_r($isRecordExist);
 
                if ($isRecordExist) {
                    // Update the existing isBest record
                     echo " Update the existing isBest record ";
 
                     unset($NewRecord['created_date']);
 
                     self::UpdatePriceRentIsBestTable($property['insights_property_id'], $NewRecord);
                } else {
                    // Insert new record in isBest
                     echo "  Insert new record in isBest ";
                     $InsertArray[] = $NewRecord;
 
                }
                if (isset($isBestPrice) && count($isBestPrice) > 0) {
                    ##### cron_status = 4_is_best_price_completed
                    $Parms1 = array(
                        'cron_function_name' => MlsCronStatus,
                        'insights_property_id' => $property['insights_property_id'],
                        'cron_function_status_flag' => MlsCronStatusIsBestPriceCompleted,
                        'month' => CURRENT_MONTH,
                        'year' => CURRENT_YEAR
                    );
                    $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                    $Parms2 = array('cron_status' => MlsCronStatusIsBestPriceCompleted);
                    print_r($Parms2);
                    echo '<hr>';
                    $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                    #####  
                }
                if (isset($isBestRent) && count($isBestRent) > 0) {
                    ##### cron_status = 4_is_best_rent_completed
                    $Parms1 = array(
                        'cron_function_name' => MlsCronStatus,
                        'insights_property_id' => $property['insights_property_id'],
                        'cron_function_status_flag' => MlsCronStatusIsBestRentCompleted,
                        'month' => CURRENT_MONTH,
                        'year' => CURRENT_YEAR
                    );
                    $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms1, false);
                    $Parms2 = array('cron_status' => MlsCronStatusIsBestRentCompleted);
                    print_r($Parms2);
                    echo '<hr>';
                    $UpdateCronStatus = Common::UpdateTable('property_details_mls', $Parms2, 'id', $property['insights_property_id']);
                    #####  
                }
                    echo "\n  Cron-Function-Status :: CONFIG_IS_HOME_CUSTOM_VALUE_COMPLETED :: ";
                    // Cron-Function-Status :: CONFIG_IS_HOME_CUSTOM_VALUE_COMPLETED
                    $Parms = array('cron_function_name' => CONFIG_IS_HOME_CUSTOM_VALUE_COMPLETED, 'insights_property_id' => $property['insights_property_id'], 
                    'cron_function_status_flag' => 'Y', 'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                    $UpdatIsBestValues = Common::InsertData('insights_cron_function_status', $Parms, false);   

                        // Moved this to Update AVM cron 
                        // homevalue_cron_ran status in property_details_mls table
                    $MLSParam['homevalue_cron_ran'] =  'Y';
                    $MLSParam['homevalue_cron_ran_datetime'] =  date(DB_DATETIME_FORMAT);
                    self::UpdateMLSDetailsTable($property['insights_property_id'], $MLSParam);
            }
            // else{
            //     ##### cron_status =4_is_best_incomplete
            //     $Parms1 = array(
            //         'cron_function_name' => MlsCronStatus, 
            //         'insights_property_id' => $property['insights_property_id'], 
            //         'cron_function_status_flag' => MlsCronStatusIsBestInComplete,
            //         'month' => CURRENT_MONTH,
            //         'year' => CURRENT_YEAR
            //     );  
            //     $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
            //     $Parms2 = array('cron_status' => MlsCronStatusIsBestInComplete );  
            //     print_r($Parms2);
            //     echo '<hr>';
            //     $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $property['insights_property_id']); 
            //     #####
            // }
               
            } // End of for loop

            echo "InsertArray:: "; print_r($InsertArray);

            // Bulk Insert
            if (count($InsertArray)) {
                    // Common::InsertData('est_price_rent_is_best', $InsertArray, true);

                // if (count($InsertArray) > 750) {
                     echo "InsertArray:: If: count: "; print_r(count($InsertArray));

                    // $TempArray = array_chunk($InsertArray, 750);
                    foreach ($InsertArray as $Item) {
                        Common::InsertData('est_price_rent_is_best', $Item, false);
                    }
                // } else {
                //     echo "InsertArray::  else :"; //print_r($InsertArray);

                //     Common::InsertData('est_price_rent_is_best', $InsertArray, true);
                // }
            }
            // $AVMInsertBulk = Common::InsertData('est_price_rent_is_best', $Item, true);

        }else{
            return false;
        }


    }

    /**
     * Function for:
     * if (building_condition in ('Restored','Remodeled','Under Construction') or year_built within 2 years) 
     * then inb.price_median_inb = list_price + rand(100,500)
     * Add the above logic after you set the is_best.
     */
    public function UpdateIsBestMedianPrice()
    {
        /* Will update all such records in the cron job */
        $Query = "
        UPDATE tbl_est_price_rent_is_best best 
        INNER JOIN tbl_property_details_mls mls ON (best.tbl_property_details_mls_id = mls.id)
        SET
        best.price_median_inb = FLOOR( RAND() * (500-100) + 100) + mls.list_price
        WHERE best.price_median_inb < mls.list_price
        AND mls.building_condition in ('Restored','Remodeled','Under Construction')
        AND mls.year_built BETWEEN YEAR(DATE_SUB(CURDATE(),INTERVAL 2 YEAR)) AND YEAR(CURDATE())
        ;";

        echo 'UpdateIsBestMedianPrice Query: <pre> ';
        print_r($Query);

        $Obj = new SqlManager();
        $Obj->ExecQuery($Query);
    }

    

    /**
     * Used to check if the  record exist in the given table
     * @param $tableName : table to be checked
     * @param $columnName: column name to check in where clause
     * @param $columnValue: id or the value to match in records
     * @return true if record found else false
     */
    public function checkIfRecordExist($tableName, $columnName = 'id', $columnValue = null)
    {
        $count = 0;
        $Obj = new SqlManager();
        $Query  = "SELECT count(*) as `cnt` FROM " . $tableName ;
        $Query .= " WHERE " . $columnName . " = '" .$columnValue . "' ";
        // echo '# checkIfRecordExist:: <pre>';
        // print_r($Query);
        $count = $Obj->GetQuery($Query);

        // echo 'count:: '; print_r ($count);

        if (count($count) > 0 && $count[0]['cnt'] > 0)
        {
            return true;
        }
            return false;
    }

    /**
     * get the is_best Home value for $Item['insights_property_id'] = Property
     * @param $Item $Item['insights_property_id'], $Item['est_month'], $Item['est_year']
     */
    public static function GetHomeValueIsBest($Item)
    {
            $Obj = new SqlManager();
              $Obj->AddTbls(array('insights_est_price_mls'));
            //   $Obj->AddFlds(array('id', 'insights_property_id', 'est_price', 'high_est_price', 'mid_est_price', 'low_est_price'));
              $Obj->AddFlds(array('*'));
              $Obj->AddFldCond('insights_property_id', $Item['insights_property_id']);
              $Obj->AddFldCond('is_best', 'Y');
            // $Obj->AddFldCond('is_best', 'A');
              $Obj->AddFldCond('est_month', $Item['est_month']);
              $Obj->AddFldCond('est_year', $Item['est_year']);
              return $Obj->GetSingle();
    }

    /**
     * get the is_best Home value for $Item['insights_property_id'] = Property
     * @param $Item $Item['insights_property_id'], $Item['est_month'], $Item['est_year']
     */
    public static function GetHomeValueIsBestLatest($Item)
    {
            $Obj = new SqlManager();
              $Obj->AddTbls(array('insights_est_price_mls'));
            //   $Obj->AddFlds(array('id', 'insights_property_id', 'est_price', 'high_est_price', 'mid_est_price', 'low_est_price'));
              $Obj->AddFlds(array('*'));
              $Obj->AddFldCond('insights_property_id', $Item['insights_property_id']);
              $Obj->AddFldCond('is_best', 'Y');
            // $Obj->AddFldCond('is_best', 'A');
            //  $Obj->AddFldCond('est_month', $Item['est_month']);
             // $Obj->AddFldCond('est_year', $Item['est_year']);
              return $Obj->GetSingle();
    }
    /**
     * get the is_best Rent Value for $Item['insights_property_id'] = Property
     * @param $Item $Item['insights_property_id'], $Item['est_month'], $Item['est_year']
     */
    public static function GetRentValueIsBest($Item)
    {
            $Obj = new SqlManager();
              $Obj->AddTbls(array('insights_est_rent_mls'));
            //   $Obj->AddFlds(array('id', 'insights_property_id', 'est_monthly_rent', 'high_est_monthly_rent', 'median_est_monthly_rent', 'low_est_monthly_rent'));
              $Obj->AddFlds(array('*'));
              $Obj->AddFldCond('insights_property_id', $Item['insights_property_id']);
              $Obj->AddFldCond('is_best', 'Y');
            // $Obj->AddFldCond('is_best', 'A');
              $Obj->AddFldCond('est_month', $Item['est_month']);
              $Obj->AddFldCond('est_year', $Item['est_year']);
              return $Obj->GetSingle();
    } 


    /**
     * Update tbl_property_details_avm table
     * @param $PropertyID : unique property_id
     * @param $Data : Columns and Values Array need to be updated.
     */
    public static function UpdateAVMDetailsTable($PropertyID, $Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('property_details_avm'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('property_id', $PropertyID);
        $Obj->Update();
    }

    /**
     * Update tbl_est_price_rent_is_best table
     * @param $PropertyID : unique tbl_property_details_mls_id
     * @param $Data : Columns and Values Array need to be updated.
     */
    public static function UpdatePriceRentIsBestTable($PropertyID, $Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('est_price_rent_is_best'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('tbl_property_details_mls_id', $PropertyID);
        $Obj->Update();
    }

     /**
     * Update tbl_property_details_mls table
     * @param $PropertyID : unique id
     * @param $Data : Columns and Values Array need to be updated.
     */
    public static function UpdateMLSDetailsTable($PropertyID, $Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('property_details_mls'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('id', $PropertyID);
        $Obj->Update();
    }




    public function GetInbSubjectProperty()
    {
        $Obj = new SqlManager();
     
        $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude,mls.list_date, mls.list_price, mls.square_foot, mls.property_type, mls.style, mls.year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, list_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before, cron_status, mls.homevalue_cron_ran, mls.source,
        mls.address property_address, mls.city_name property_city, mls.state_code property_state, mls.zip_code property_zipcode, mls.unit_number unit_number,tax_year, mls.ml_number, mls.sold_price FROM property_details_mls mls  WHERE  mls.latitude != 0 AND mls.longitude != 0 
        AND (mls.homevalue_cron_ran IS NULL OR mls.homevalue_cron_ran != 'Y') ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."  AND mls.square_foot > 0 GROUP BY mls.id ORDER BY mls.id DESC LIMIT  50 ";

    
        return $Obj->GetQuery($Query);
    }    

    public function GetInbSubjectPropertyCustom()
    {
        $Obj = new SqlManager();
        $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude, mls.list_date, mls.list_price, mls.square_foot, mls.property_type, mls.style, mls.year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, list_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before,  cron_status, mls.homevalue_cron_ran, mls.ml_number FROM tbl_property_details_mls mls WHERE  mls.latitude != 0 AND mls.longitude != 0  AND mls.square_foot > 0 AND id NOT IN  ( SELECT insights_property_id FROM tbl_insights_est_price_mls ) AND `status` = 'Active'   AND record_status != 'R' AND mls.processed_matrix_date='0000-00-00 00:00:00'  AND id NOT IN (SELECT icfs.insights_property_id FROM tbl_insights_cron_function_status icfs WHERE icfs.cron_function_name='HOME_VALUE_CUSTOM:PROCESS_HOME_VALUE') ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS." ORDER BY mls.id  LIMIT 1 ";
        echo "GetInbSubjectPropertyCustom:: ";
        return $Obj->GetQuery($Query);
    } 

    public function GetNonInbSubjectProperty($M, $Y)
    {
        $Obj = new SqlManager();

        $Query = "SELECT 
        im.insights_property_id insights_property_id
        , ap.location_latitude latitude, ap.location_longitude longitude, ap.summary_year_built year_built
        , ap.summary_prop_land_use property_type, ap.living_size square_foot
        , 0 sold_price, -1 sold_before
        , algo.est_month
        FROM 
        tbl_insights_main im JOIN
        tbl_insights_attom_property ap 
        LEFT JOIN tbl_insights_est_price_mls algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
        LEFT JOIN tbl_insights_issues issue ON (im.insights_property_id = issue.insights_property_id)
        WHERE 
        (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0)
       
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM tbl_insights_cron_function_status icfs 
        LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icfs.cron_function_name='".CONFIG_GET_NON_INB_SUBJECT_PROPERTIES."'  AND  icf.cron_function_frequency='Monthly' AND 
        icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )
       
        AND im.insights_property_id IN (SELECT insights_property_id FROM tbl_insights_cron_function_status icfs 
        LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name 
        WHERE icfs.cron_function_name='".CONFIG_IS_EXTERNAL_API_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )
       
        AND im.checked_in_inbestments = 'Y'
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.insights_property_id = ap.insights_property_id 
        AND ap.location_latitude != 0 AND ap.location_longitude != 0
        AND ap.living_size > 0 
        
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 7";
        echo '#2:: GetNonInbSubjectProperty <pre>';
        print_r($Query);
        // echo '<hr>';
        // AND ((im.agent_id = 1238 AND im.insights_property_id > 3062) OR lender_id = 254 OR im.lender_id = 1402 OR (im.agent_id = 32 AND DATE(im.uploaded_datetime) = '2019-07-18') OR im.insights_property_id = 3)
        return $Obj->GetQuery($Query);
    }

    public function GetInbSubjectPropertyForAVMtableForCustomHVandRent($M, $Y)
    {
        $Obj = new SqlManager();
    
        $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude, mls.list_price, mls.list_date, mls.square_foot, mls.property_type, mls.style, mls.year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, list_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before  
        FROM  tbl_property_details_mls mls 
        LEFT JOIN tbl_insights_est_price_mls est_p ON(est_p.insights_property_id = mls.id  AND est_p.is_best = 'Y') 
        LEFT JOIN tbl_insights_est_rent_mls  est_r ON(est_r.insights_property_id = mls.id AND est_r.is_best = 'Y') 
        WHERE mls.record_status != 'R' 
        AND (mls.cron_status='".MlsCronStatusRentEstCompleted."' OR mls.cron_status='".MlsCronStatusRentEstExternalCompleted."' OR mls.cron_status='".MlsCronStatusRentEstExternalFailed."' OR mls.cron_status='".MlsCronStatusRentEstInComplete."')  
        AND (mls.homevalue_cron_ran = 'Y') 
        AND mls.id NOT IN ( Select property_id from tbl_property_details_avm where (estimate_amount IS NOT NULL or estimate_amount  != 0)) 
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS." GROUP BY insights_property_id LIMIT 65 ";
       
                  /*   
                        LEFT JOIN tbl_insights_cron_function_status icfs ON icfs.insights_property_id  = mls.id
                        AND (mls.homevalue_cron_ran IS NULL OR mls.homevalue_cron_ran != 'Y')    
                        AND icfs.cron_function_name= '". CONFIG_IS_HOME_VALUE_COMPLETED ."' AND icfs.cron_function_status_flag='Y'


                        AND icfs.month =". $M ." AND icfs.year = ". $Y ." 
                    AND im.insights_property_id NOT IN (SELECT icfs1.insights_property_id 
                        FROM tbl_insights_cron_function_status   icfs1
                        WHERE icfs1.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPARE_COMPLETED."'  AND icfs1.cron_function_status_flag='Y' 
                        AND icfs1.month=". $month ." AND  icfs1.year=". $year ."  ) 

                    */
        echo '#1:: GetInbSubjectPropertyForAVMtableForCustomHVandRent:: <pre>';
        print_r($Query);
        return $Obj->GetQuery($Query);
    }  
    public function GetPropertyForAVMAdhoc()
    {
        $Obj = new SqlManager();
        $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude, mls.sold_price, mls.sold_date, mls.square_foot, mls.property_type, mls.style, mls.year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, sold_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before 
        FROM tbl_property_details_mls mls 
        LEFT JOIN tbl_insights_est_price_mls est_p ON(est_p.insights_property_id = mls.id AND est_p.is_best = 'Y')  
        LEFT JOIN tbl_insights_est_rent_mls  est_r ON(est_r.insights_property_id = mls.id AND est_r.is_best = 'Y') 
        WHERE  `status` = 'Active' 
        AND mls.id NOT IN ( Select property_id from tbl_property_details_avm ) 
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS." 
        ORDER BY mls.id LIMIT 50 ";
        return $Obj->GetQuery($Query);
    }  
    public function GetExternalSubjectProperty($M, $Y)
    {
        // Check the source (field) = 'U' for data which modified by user
        $Obj = new SqlManager();
        $Query = "SELECT 
        im.insights_property_id insights_property_id, 
        zp.latitude, zp.longitude, zp.sold_last_for sold_price, zp.living_square_foot square_foot, zp.property_type property_type, 
        zp.year_built year_built, IF(zp.sold_last_on != '0000-00-00', TIMESTAMPDIFF(MONTH, zp.sold_last_on, DATE('".$Y."-".$M."-01')), -1) sold_before 
        FROM 
        tbl_insights_main im 
        JOIN tbl_insights_property_details_by_user zp ON(im.insights_property_id = zp.insights_property_id) 
        LEFT JOIN tbl_insights_est_price_mls algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
        LEFT JOIN tbl_insights_issues issue ON (im.insights_property_id = issue.insights_property_id)
        WHERE 
        (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0 )

        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM tbl_insights_cron_function_status icfs 
        LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icfs.cron_function_name='".CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES."'  AND  icf.cron_function_frequency='Monthly' AND 
        icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )
        
        AND im.insights_property_id IN (SELECT insights_property_id FROM tbl_insights_cron_function_status icfs 
        LEFT JOIN  tbl_insights_cron_function_frequency icf ON icfs.cron_function_name = icfs.cron_function_name 
        WHERE icfs.cron_function_name='".CONFIG_IS_EXTERNAL_API_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )
        
        AND im.tp_api = 'Y'
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.has_multi_match != 'Y'
        AND zp.living_square_foot > 0
      
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 7";
        echo '#3:: GetExternalSubjectProperty <pre>';
        print_r($Query);
        // echo '<hr>';
        return $Obj->GetQuery($Query);
    }


    public function ProcessHV($SubjectProperties, $Month, $Year,$CronFunctionName) {
        $BulkInsertData = array();
        global $LevelFilters;
        $TimeStamp = 'DATE(\''.$Year.'-'.$Month.'-01\')';
        try{
            foreach ($SubjectProperties as $SubjectProperty) {

                
                ##### cron_status = 1_price_est_in_process 
                $Parms1 = array('cron_function_name' => MlsCronStatus, 
                'insights_property_id' => $SubjectProperty['insights_property_id'],
                'cron_function_status_flag' => MlsCronStatusPriceEstInProcess,
                'month' => CURRENT_MONTH,
                'year' => CURRENT_YEAR );
                
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusPriceEstInProcess, 'homevalue_cron_ran' =>'Y', 'homevalue_cron_ran_datetime' =>date(DB_DATETIME_FORMAT));  
                
                print_r($Parms2);
                echo '<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $SubjectProperty['insights_property_id']); 
                ######
                $CompsSet = array();
                
                $LevelFilters = self::GetLevelFilters();
        
                // print_r($SubjectProperty);
                $CriteriaResults = array();
        
                $PreviousMonthData = self::GetPreviousMonthData($SubjectProperty['insights_property_id'], $Month, $Year);
                //:: PREVIOUS_MONTH_DATA_AVAILABLE 
                self::UpdateInsightsMain(array('checked_for_inbestments_avm' => 'Y'), $SubjectProperty['insights_property_id']);

                if (count($PreviousMonthData)) {
                    echo "\n :: PREVIOUS_MONTH_DATA_AVAILABLE :: "; print_r($PreviousMonthData);

                    $Lvls = self::GetStageByLevel($PreviousMonthData['pcomp_criteria_id']);
                    // Cron-Function-Status
                    $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                    'cron_function_status_flag' => PreviousMonthDataAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                        
                    if (isset($Lvls['StartLevel']) && $Lvls['StartLevel'] >= 441) {
                        $CompsSet = self::GetCompsSetToFilter($SubjectProperty, 2, $TimeStamp);
                    } else {
                        $CompsSet = self::GetCompsSetToFilter($SubjectProperty, 1, $TimeStamp);
                    }
                    if (count($CompsSet) !== 0){
                        // Cron-Function-Status - COMPSET_AVAILABLE
                        $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                        'cron_function_status_flag' => CompSetAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                        $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                    }                
            
                    if (count($Lvls)) {
                        
                        $CriteriaResults = self::Stage($SubjectProperty, $CompsSet, $CriteriaResults, $Lvls['StartLevel'], $Lvls['EndLevel'], $Month, $Year, true);
                        if (isset($CriteriaResults[$PreviousMonthData['pcomp_criteria_id']])) {
                            $EPTolerance = HVUtils::CalculateTolerance($PreviousMonthData['est_price'], 3);
                            $LEPTolerance = $PreviousMonthData['est_price'] - $EPTolerance;
                            $HEPTolerance = $PreviousMonthData['est_price'] + $EPTolerance;
        
                            if ($CriteriaResults[$PreviousMonthData['pcomp_criteria_id']]['est_price'] >= $LEPTolerance && $CriteriaResults[$PreviousMonthData['pcomp_criteria_id']]['est_price'] <= $HEPTolerance) {
                                $BulkInsertData = array_merge($BulkInsertData, $CriteriaResults);
                                // echo "\n CriteriaResults ::"; print_r($CriteriaResults);
                                // self::AddCalculatedValues($CriteriaResults);
                                continue;
                            }
                            // Cron-Function-Status - CRITERIA_RESULT_ADDED
                            $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                            'cron_function_status_flag' => CriteriaResultsAdded,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                           
                        }
                    
                    }
                // echo 'step1 :: ';
                }else{
                echo 'step2 :: ';
                    // Cron-Function-Status - PREVIOUS_MONTH_DATA_NOT_AVAILABLE
                    echo "\n Cron-Function-Status - PREVIOUS_MONTH_DATA_NOT_AVAILABLE";
                    $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                    'cron_function_status_flag' => PreviousMonthDataNotAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                           
                }

                if (count($CompsSet) === 0) {
                    $CompsSet = self::GetCompsSetToFilter($SubjectProperty, 1, $TimeStamp);
                    // Cron-Function-Status - COMPSET_NOT_AVAILABLE
                    echo "\n Cron-Function-Status - COMPSET_NOT_AVAILABLE "; 
                    $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                    'cron_function_status_flag' => CompSetNotAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);
                    echo ' step3 :: ';                 
                    
                }
        
                for ($i = 1, $j = 3; $i <= 449, $j <= 451; $i += 8, $j += 8) {
                    if (!(isset($SubjectProperty['year_built']) && $SubjectProperty['year_built'] > 0) && (($i >= 1 && $i <= 41) || ($i >= 97 && $i <= 137))) {
                        continue;
                    }
        
                    if ($i == 441) {
                        $CompsSet = self::GetCompsSetToFilter($SubjectProperty, 2, $TimeStamp);
                    }

                    $CriteriaResults = self::Stage($SubjectProperty, $CompsSet, $CriteriaResults, $i, $j, $Month, $Year);
            
                    if ($CriteriaResults === false) {
                        
                        break;
                    }
                }
                echo ' step4 :: ';  
                

                if ($CriteriaResults === false) {
                    echo ' step5 :: CONFIG_IS_HOME_VALUE_COMPLETED :: ';  
                    $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($SubjectProperty['insights_property_id'], CONFIG_PROCESS_HOME_VALUE_CUSTOM,'Y');   
                    ##### cron_status = 1_price_est_completed
                    $Parms1 = array('cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $SubjectProperty['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusPriceEstCompleted,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                    $Parms2 = array('cron_status' => MlsCronStatusPriceEstCompleted);  
                    print_r($Parms2);
                    echo '<hr>';
                    $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $SubjectProperty['insights_property_id']);  
                    ######                   
                    continue;
                }else{
                    ##### cron_status = 1_price_est_in_process 
                    $Parms1 = array('cron_function_name' => MlsCronStatus, 'insights_property_id' => $SubjectProperty['insights_property_id'], 'cron_function_status_flag' => MlsCronStatusPriceEstInComplete,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                    $Parms2 = array('cron_status' => MlsCronStatusPriceEstInComplete);  
                    print_r($Parms2);
                    echo 'InComplete#111<hr>';
                    $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $SubjectProperty['insights_property_id']); 
                    ######
                }

                // echo "\n CriteriaResults ::"; print_r($CriteriaResults);

                // Insert in new_Programmatic
                if ($CriteriaResults != null && is_array($CriteriaResults))
                {
                    echo '\n Insert in tbl_insights_est_price_mls  :: ';  
                    // echo "\n CriteriaResults ::"; print_r($CriteriaResults);
                    $BulkInsertData = array_merge($BulkInsertData, $CriteriaResults);

                    // self::AddCalculatedValues($CriteriaResults);
                }
                
                // Cron-Function-Status - CALCULATED_VALUES_ADDED
                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => CalculatedValuesAdded,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);     

                $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($SubjectProperty['insights_property_id'], CONFIG_PROCESS_HOME_VALUE_CUSTOM,'Y');    
                echo ' step6 :: ';                          
            }
            echo ' step7 :: ';  
            echo "\n BulkInsertData ::"; print_r($BulkInsertData);
            if(count($BulkInsertData)){
                self::AddCalculatedValues($BulkInsertData);
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
            print_r($e);
            exit;
        }
            
    }
   
    public function HomeValueExternalCompare()
    {

        # Get the GetInsightsReportVarianceCondition from tbl_settings
        $VarianceCondition = Common::GetSettingValues('INSIGHTS_REPORT_VARIANCE_CONDITION');
        $HomeValueAdjustment = Common::GetSettingValues('HomeValue_Adjustment_Percent');
        $HomeValueAdjustmentPercent=$HomeValueAdjustment['option_value'];
        $HomeValueCompareDifference = 4;
        $VarianceCompareData = array();
        $n=0;        
        $Condition="  ";
        $HavingCondition="HAVING  `State` = 'WA' AND `Variance_Percent` <=".$HomeValueAdjustmentPercent."  ";
        $GetHomeValueCompleted = self::GetHomeValueCompleted(CURRENT_MONTH, CURRENT_YEAR, $Condition );
        $FetchCompletedCompareData = self::FetchCompletedCompareData(CURRENT_MONTH, CURRENT_YEAR);
        if (count($GetHomeValueCompleted) > 0) {
            if (count($FetchCompletedCompareData) > 0) {
                foreach ($GetHomeValueCompleted as $key => $CompareData) {
                    if (in_array($CompareData, $FetchCompletedCompareData)) {
                        unset($GetHomeValueCompleted[$key]);
                    }
                }
            }
        }
        echo "GetHomeValueCompleted::<pre>";
        print_r($GetHomeValueCompleted);
        if(!empty($GetHomeValueCompleted)){
            foreach($GetHomeValueCompleted as $PropertyItem) {
                $Parms = array('cron_function_name' => CONFIG_IS_CUSTOM_HOME_VALUE_COMPARE_COMPLETED, 'insights_property_id' => $PropertyItem['insights_property_id'], 
                'cron_function_status_flag' => 'Y','tp_api'=>'N',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR ); 
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
               
                $GetHomeValue = self::GetHomeValue($PropertyItem['insights_property_id']);
                
				$GetCompProperties = (isset($GetHomeValue) && isset($GetHomeValue[0]['comp_properties'])) ? str_replace("'", "\'", $GetHomeValue[0]['comp_properties']) : "";
				$GetCriteria = (isset($GetHomeValue) && isset($GetHomeValue[0]['criteria'])) ? str_replace("'", "\'", $GetHomeValue[0]['criteria']) : "";
                $GetExternalHomeValue = self::GetExternalHomeValue($PropertyItem['insights_property_id']);
                echo "GetHomeValue::<pre>";
                print_r($GetHomeValue);
                echo "GetExternalHomeValue::<pre>";
                print_r($GetExternalHomeValue);      
                
                $HomeValue= (isset($GetHomeValue) && $GetHomeValue[0]['est_price']!=0) ? (double)$GetHomeValue[0]['est_price'] : 0; 
                if(isset($GetExternalHomeValue)){
                    $ExternalHomeValue = (isset($GetExternalHomeValue) && $GetExternalHomeValue[0]['est_price']!=0)? (double)$GetExternalHomeValue[0]['est_price'] : 0;    
                }
                
                // echo 'Home-Value:: '.$HomeValue." :: ".$ExternalHomeValue;
              
 
                if($HomeValue!='' && $ExternalHomeValue!='' && isset($GetExternalHomeValue[0])) 
                {
            
                  

                    $Query2 = "UPDATE tbl_insights_est_price_mls SET comp_properties = '".$GetCompProperties."', criteria = '".$GetCriteria."'   WHERE  id=".$GetExternalHomeValue[0]['id']." LIMIT 1 ";
                    echo 'Update Comp Property In External :: <pre>'; 
                    print_r($Query2);   
                    echo '<hr>';               
                    $Obj2 = new SqlManager();
                    $Obj2->ExecQuery($Query2);    

                    $HomeValueDifference=($HomeValue-$ExternalHomeValue)/$ExternalHomeValue;
                    $HomeValueDifferencePercent = round((float)$HomeValueDifference * 100 ,2);
                    echo 'Home-Value:: '.$HomeValue." :: ".$ExternalHomeValue." :: ".$HomeValueDifference." :: ".$HomeValueDifferencePercent;
                    

                    $VarianceCompareData[$n]['variance'] = $HomeValueDifference;
                    $VarianceCompareData[$n]['Variance_Percent'] = $HomeValueDifferencePercent ;
                    $VarianceDifference = false;
                    if($HomeValueDifferencePercent>=$HomeValueCompareDifference){
                        echo "<br> Above :: ".$PropertyItem['insights_property_id']." :: ".$HomeValueDifferencePercent." :: "."<br>";
                        $VarianceDifference = true;
                    } else if($HomeValueDifferencePercent < 0 ){
                        echo "<br> Below ::".$PropertyItem['insights_property_id']." :: ".$HomeValueDifferencePercent." :: "."<br>";
                        $VarianceDifference = true;
                    }
                    if($VarianceDifference)
                    {
                      $UpdateIsBestOld=self::UpdateIsBestOld($PropertyItem['insights_property_id']);
                      $UpdateIsBest=self::UpdateIsBest($PropertyItem['insights_property_id'], $GetExternalHomeValue[0]['id']);
                        
                      $Parms = array('cron_function_name' => CONFIG_HOME_VALUE_IS_BEST, 'insights_property_id' => $PropertyItem['insights_property_id'], 
                      'cron_function_status_flag' =>'pcomp_criteria_id: '.$GetExternalHomeValue[0]['pcomp_criteria_id'],  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR ); 
                      $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 

                    }                
                             
                }  
                
            }

        }        

    }
    public function IsBestNotSetProperties()
    {
        $GetProperties = self::GetHVCompleted(); 
        $i=1;  
        echo '<br>';
        foreach ($GetProperties as $property) {
            $IsBestCount = self::GetIsBestCount($property['insights_property_id']);
            // print_r($IsBestCount);
            echo $i." :: ".$property['insights_property_id']." :: ".$IsBestCount[0]['id']." :: ".$IsBestCount[0]['is_best']."<br>";
            $i++;
            // if($IsBestCount['CountRs'] >=0){
            //     // self::UpdateIsBestNew($property['property_id']);
            // }

        }
    }

    public function GetHVCompleted()
    {
        $Obj = new SqlManager();
        $Query = " SELECT * FROM tbl_insights_cron_function_status WHERE cron_function_name ='IS_HOME_VALUE_COMPLETED' 
                    AND cron_function_status_flag = 'Y'
                    AND month='".CURRENT_MONTH."' AND  year=".CURRENT_YEAR."
                    AND insights_property_id IN ( SELECT insights_property_id FROM tbl_insights_main WHERE primary_owner_id  IS NOT NULL  ".CONFIG_PROPERTY_CONDITION." )
                    ORDER BY insights_property_id
                     
                    "; 
        // echo '<br>GetHVCompleted:: <pre>';
        // print_r($Query);			
        return $Obj->GetQuery($Query);
         
    }

    public function GetIsBestCount($InsightPropertyId)
    {
        $Obj = new SqlManager();
        $Query = " SELECT * FROM tbl_insights_est_price_mls WHERE  
                     is_best = 'Y'
                    AND insights_property_id = ".$InsightPropertyId."
                    AND est_month='".CURRENT_MONTH."' AND  est_year=".CURRENT_YEAR."
                     ORDER BY insights_property_id 
                "; 
        // echo '<br>GetIsBestCount:: <pre>';
        // print_r($Query);			
        return $Obj->GetQuery($Query);
         
    }
    public  function UpdateIsBestNew($PropertyId)
    {
        $Obj = new SqlManager();
        $Query = "UPDATE `tbl_insights_est_price_mls` SET `is_best` = 'Y' WHERE   insights_property_id=".$PropertyId." 
        AND est_month='".CURRENT_MONTH."' AND est_year= ".CURRENT_YEAR." ORDER BY pcomp_criteria_id   LIMIT 1
        "; 
        // echo '<br>UpdateIsBestNew:: <pre>';
        // print_r($Query);			
        //  $Obj->ExecQuery($Query);  	
    } 

    // Rent Estimate 
    public function CallGetInbSubjectPropertyRent($GetInbSubjectPropertiesForRentActive, $ScriptType)
    {
        if($ScriptType=='Adhoc')
        {
            $InbSubjectProperties = self::GetInbSubjectPropertyRentAdhoc();
        }else{
            $InbSubjectProperties = self::GetInbSubjectPropertyRent();
        }   
        echo '<hr>Rent Estimate Properties: <pre>';
         
        foreach ($InbSubjectProperties as $item) {
            echo $item['insights_property_id'].'<hr>'; 
        }        
        echo '<hr></pre>';
         
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($InbSubjectProperties,CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM,'P'); 
        self::ProcessRE($InbSubjectProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_INB_SUBJECT_PROPERTIES_FOR_RENT);    
                 
    }
    // Rent Estimate Adhoc
    public function CallGetInbSubjectPropertyRentAdhoc($InbSubjectProperties)
    {
        // if($GetInbSubjectPropertiesForRentActive=='Active')
        // {
        //     $InbSubjectProperties = self::GetInbSubjectPropertyRentAdhoc(CURRENT_MONTH, CURRENT_YEAR);
        // }else{
        //     $InbSubjectProperties = self::GetInbSubjectPropertyRent(CURRENT_MONTH, CURRENT_YEAR);
        // }   
     
        echo '<hr>Rent Estimate Properties: <pre>';
        // print_r($InbSubjectProperties);
        foreach ($InbSubjectProperties as $item) {
            echo $item['insights_property_id'].'<hr>'; 
        }        
        echo '<hr></pre>';        
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($InbSubjectProperties,CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM,'P'); 
        self::ProcessRE($InbSubjectProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_INB_SUBJECT_PROPERTIES_FOR_RENT);    
                 
    }
    public function CallGetNonInbSubjectPropertyRent($GetNonInbSubjectPropertiesForRentActive)
    {
        if($GetNonInbSubjectPropertiesForRentActive)
        {
            $NonInbSubjectProperties = self::GetNonInbSubjectPropertyRent(CURRENT_MONTH, CURRENT_YEAR);
            echo 'NonInbSubjectProperties :: <pre>';
            print_r($NonInbSubjectProperties);        
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($NonInbSubjectProperties,CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM,'P'); 
            self::ProcessRE($NonInbSubjectProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_NON_INB_SUBJECT_PROPERTIES_FOR_RENT);
        }
    }
 
    public function CallGetExternalSubjectPropertyRent($GetExternalSubjectPropertiesForRentActive)
    {
        if($GetExternalSubjectPropertiesForRentActive)
        {
            $SubjectExternalProperties = self::GetExternalSubjectPropertyRent(CURRENT_MONTH, CURRENT_YEAR);
            echo 'SubjectExternalProperties :: <pre>';
            print_r($SubjectExternalProperties);      
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($SubjectExternalProperties,CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM,'P');   
            self::ProcessRE($SubjectExternalProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES_FOR_RENT);
        }
    }

    function GetInbSubjectPropertyRent()
    {
        $Obj = new SqlManager();
       /* 
            $Query = "SELECT 
            im.inbestments_property_id id, im.insights_property_id insights_property_id, latitude, longitude, sold_price, sold_date, square_foot, property_type, style, year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, sold_date, NOW()), -1) sold_before 
            FROM 
            tbl_insights_main im 
            JOIN tbl_property_details_mls mls ON(im.inbestments_property_id = mls.id) 
            LEFT JOIN tbl_insights_est_rent_mls algo ON(algo.insights_property_id = im.insights_property_id AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
            
            WHERE 
            im.inbestments_property_id IS NOT NULL 
            AND im.inbestments_property_id > 0 
            
            AND algo.est_month IS NULL AND algo.est_year IS NULL 
            AND mls.latitude != 0 AND mls.longitude != 0
            ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."
            AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM tbl_insights_cron_function_status icfs 
            
            LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
            icf.cron_function_name='".CONFIG_GET_INB_SUBJECT_PROPERTIES_FOR_RENT."'  AND  icf.cron_function_frequency='Monthly' AND 
            icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )   

            AND im.insights_property_id IN (SELECT insights_property_id FROM tbl_insights_cron_function_status icfs 
            LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name 
            WHERE icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
            AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )
                    
            AND mls.square_foot > 0
            
            GROUP BY im.insights_property_id
            ORDER BY im.insights_property_id DESC LIMIT 50";
      */

        echo '#1::Rent -  GetInbSubjectPropertyRent-Regular <pre>';
        // Original Query #$$$
        // $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude, mls.list_date, mls.list_price, mls.square_foot, mls.property_type, mls.style, mls.year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, list_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before, cron_status, mls.homevalue_cron_ran 
        // FROM tbl_property_details_mls mls 
        // WHERE mls.latitude != 0 AND mls.longitude != 0   
        // ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS." 
        // AND mls.square_foot > 0
        // AND (mls.cron_status='".MlsCronStatusPriceEstCompleted."' OR mls.cron_status='".MlsCronStatusPriceEstInComplete."')
        // GROUP BY mls.id ORDER BY mls.id DESC LIMIT 1";
        
        $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude, mls.list_date, mls.list_price, mls.square_foot, mls.property_type, mls.style, mls.year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, list_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before, cron_status, mls.homevalue_cron_ran, mls.source 
        FROM tbl_property_details_mls mls 
        WHERE mls.latitude != 0 AND mls.longitude != 0   
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS." 
        AND mls.square_foot > 0
       
        GROUP BY mls.id ORDER BY mls.id DESC LIMIT 100";
        echo '#1::Rent -  GetInbSubjectPropertyRent-Regular <pre>';
        // print_r($Query);

		/*
			        AND mls.id IN (SELECT icfs1.insights_property_id 
                        FROM tbl_insights_cron_function_status   icfs1
                        WHERE icfs1.cron_function_name='".CONFIG_UPDATE_ADJUSTMENT_PRICE_CUSTOM."'  AND icfs1.cron_function_status_flag='".UpdateAdjustmentPrice."' 
                        AND icfs1.month=". $M ." AND  icfs1.year=". $Y ."  ) 
		*/
    
        // AND ((im.agent_id = 1238 AND im.insights_property_id > 3062) OR lender_id = 254 OR im.lender_id = 1402 OR (im.agent_id = 32 AND DATE(im.uploaded_datetime) = '2019-07-18') OR im.insights_property_id = 3)
        return $Obj->GetQuery($Query);
    }    
    function GetInbSubjectPropertyRentAdhoc()
    {
        $Obj = new SqlManager();
      
        $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude, mls.list_date, mls.list_price, mls.square_foot, mls.property_type, mls.style, mls.year_built,IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, list_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before, cron_status, mls.homevalue_cron_ran 
        FROM tbl_property_details_mls mls  
        WHERE mls.latitude != 0 AND mls.longitude != 0  AND `status` = 'Active' 
        AND id NOT IN  ( SELECT insights_property_id FROM tbl_insights_est_rent_mls ) 
        AND mls.square_foot > 0 AND `status` = 'Active' AND record_status!='R'   
        AND mls.id NOT IN (SELECT icfs1.insights_property_id 
        FROM tbl_insights_cron_function_status   icfs1
        WHERE icfs1.cron_function_name='".CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM."'  AND icfs1.cron_function_status_flag='Y'  )
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS." 
        ORDER BY mls.mls_updated_date DESC   LIMIT 50";
		echo '<br>GetInbSubjectPropertyRentAdhoc:: <pre>';
        print_r($Query);			
        return $Obj->GetQuery($Query);
    }    
    function GetNonInbSubjectPropertyRent($M, $Y)
    {
        $Obj = new SqlManager();
        $Query = "SELECT im.insights_property_id, 
        ap.location_latitude latitude, ap.location_longitude longitude, 
        0 sold_price, 
        ap.summary_year_built year_built, ap.summary_prop_land_use property_type, 
        ap.gross_size square_foot, -1 sold_before, algo.est_month
        FROM tbl_insights_main im JOIN 
        tbl_insights_attom_property ap  
        LEFT JOIN tbl_insights_est_rent_mls algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
        
        WHERE 
        im.insights_property_id = ap.insights_property_id 
        
        AND (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0) 
        AND im.checked_in_inbestments = 'Y'
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM tbl_insights_cron_function_status icfs 
        LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icf.cron_function_name='".CONFIG_GET_NON_INB_SUBJECT_PROPERTIES_FOR_RENT."'  AND  icf.cron_function_frequency='Monthly' AND 
        icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )

        AND im.insights_property_id IN (SELECT insights_property_id FROM tbl_insights_cron_function_status icfs 
        LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name 
        WHERE icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )

        AND ap.gross_size > 0
        AND algo.est_month IS NULL AND algo.est_year IS NULL 
         
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 65";

        // AND ((im.agent_id = 1238 AND im.insights_property_id > 3062) OR lender_id = 254 OR im.lender_id = 1402 OR (im.agent_id = 32 AND DATE(im.uploaded_datetime) = '2019-07-18') OR im.insights_property_id = 3) 
        echo '#2:: Rent - GetNonInbSubjectPropertyRent <pre>';
        print_r($Query);

        return $Obj->GetQuery($Query);
    }

    public function GetExternalSubjectPropertyRent($M, $Y)
    {
        $Obj = new SqlManager();
        $Query = "SELECT 
        im.insights_property_id insights_property_id, 
        zp.latitude, zp.longitude, zp.sold_last_for sold_price, zp.living_square_foot square_foot, zp.property_type property_type, 
        zp.year_built year_built, IF(zp.sold_last_on != '0000-00-00', TIMESTAMPDIFF(MONTH, zp.sold_last_on, DATE('".$Y."-".$M."-01')), -1) sold_before 
        FROM 
        tbl_insights_main im 
        JOIN tbl_insights_property_details_by_user zp ON(im.insights_property_id = zp.insights_property_id) 
        LEFT JOIN tbl_insights_est_rent_mls algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
         
        WHERE 
        (im.inbestments_property_id IS NULL 
        OR im.inbestments_property_id = 0 )
        AND tp_api = 'Y'
        AND has_multi_match != 'Y'
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM tbl_insights_cron_function_status icfs 
        LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icf.cron_function_name='".CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES_FOR_RENT."'  AND  icf.cron_function_frequency='Monthly' AND 
        icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )        

        AND im.insights_property_id IN (SELECT insights_property_id FROM tbl_insights_cron_function_status icfs 
        LEFT JOIN  tbl_insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name 
        WHERE icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )

        AND algo.est_month IS NULL AND algo.est_year IS NULL 
        AND zp.living_square_foot > 0
        
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 10"; 
        echo '#3:: Rent - GetExternalSubjectPropertyRent <pre>';
        print_r($Query);

        // AND ((im.agent_id = 1238 AND im.insights_property_id > 3062) OR im.lender_id = 1402 OR (im.agent_id = 32 AND DATE(im.uploaded_datetime) = '2019-07-18') OR im.insights_property_id = 3)
        return $Obj->GetQuery($Query);
    }    
     
    public function ProcessRE($SubjectProperties, $Month, $Year,$CronFunctionName) {
        global $LevelFilters;
        $TimeStamp = 'DATE(\''.$Year.'-'.$Month.'-01\')';
        foreach ($SubjectProperties as $SubjectProperty) {
            ##### cron_status = 2_rent_est_in_process 
            $Parms1 = array(
                'cron_function_name' => MlsCronStatus, 
                'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => MlsCronStatusRentEstInProcess,
                'month' => CURRENT_MONTH,
                'year' => CURRENT_YEAR 
            );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
            $Parms2 = array('cron_status' => MlsCronStatusRentEstInProcess);  
            print_r($Parms2);
            echo '<hr>';
            $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $SubjectProperty['insights_property_id']); 


            $CompsSet = self::GetRCompsSetToFilter($SubjectProperty, $TimeStamp);

            $LevelFilters = self::GetRLevelFilters();

            // print_r($SubjectProperty);
            $CriteriaResults = array();

            for ($i = 1, $j = 3; $i <= 425, $j <= 427; $i += 8, $j += 8) {
                if (!(isset($SubjectProperty['year_built']) && $SubjectProperty['year_built'] > 0) && ($i >= 1 && $i <= 41)) {
                    continue;
                }

                $CriteriaResults = self::RStage($SubjectProperty, $CompsSet, $CriteriaResults, $i, $j, $Month, $Year);
        
                if ($CriteriaResults === false) {
                    break;
                }
            }

            if ($CriteriaResults === false) {
                ##### cron_status = 2_rent_est_completed 
                $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $SubjectProperty['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusRentEstCompleted,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusRentEstCompleted);  
                print_r($Parms2);
                echo '####1<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $SubjectProperty['insights_property_id']); 
                #####                
                $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($SubjectProperty['insights_property_id'], CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM,'Y'); 
                continue;
            }else{
                ##### cron_status = 2_rent_est_incomplete
                $Parms1 = array(
                    'cron_function_name' => MlsCronStatus, 
                    'insights_property_id' => $SubjectProperty['insights_property_id'], 
                    'cron_function_status_flag' => MlsCronStatusRentEstInComplete,
                    'month' => CURRENT_MONTH,
                    'year' => CURRENT_YEAR 
                );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                $Parms2 = array('cron_status' => MlsCronStatusRentEstInComplete);  
                print_r($Parms2);
                echo '####2<hr>';
                $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $SubjectProperty['insights_property_id']); 
                #####        
            }

            if ($CriteriaResults != null && is_array($CriteriaResults) && count($CriteriaResults)){
                self::AddCalculatedRValues($CriteriaResults);
                // Cron-Function-Status - CALCULATED_VALUES_ADDED
                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => CalculatedValuesAdded,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
            }

                   
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($SubjectProperty['insights_property_id'], CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM,'Y'); 
        }

        self::UpdateRentalPropertiesAsBest($Month, $Year);
    }

    /**
     * This function will return the tbl_property_details_mls records
     * which get rent values from the external API.
     * Used in cron\cron.rental-external-api.php cron job 
     */
    public function GetMlsPropertiesForPropertyDetailsAVM($M, $Y)
    {
        $Obj = new SqlManager();
    
        $Query = "SELECT mls.id AS insights_property_id, mls.latitude, mls.longitude, mls.sold_price, mls.sold_date, mls.square_foot, mls.property_type, mls.style, mls.year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, sold_date, DATE('" . CURRENT_YEAR ."-". CURRENT_MONTH ."-01')), -1) sold_before  FROM  tbl_property_details_mls mls 
        LEFT JOIN tbl_insights_est_price_mls est_p ON(est_p.insights_property_id = mls.id AND est_p.is_best = 'Y' )
        LEFT JOIN tbl_insights_est_rent_mls  est_r ON(est_r.insights_property_id = mls.id  AND est_p.is_best = 'Y')
        WHERE  est_r.rcomp_criteria_id=10000  AND mls.id NOT IN ( Select property_id from tbl_property_details_avm ) ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS." LIMIT 65";
        echo 'GetMlsPropertiesForPropertyDetailsAVM:: <pre>';
        print_r($Query);
        return $Obj->GetQuery($Query);
    }  

    /**
     * This function will return the tbl_property_details_mls records
     * which  rent values from the external API and stored values in the table tbl_insights_est_rent_mls with
     * est_r.rcomp_criteria_id=10000.
     * Used in cron\cron.rental-external-api.php cron job 
     */
    public function GetMlsPropertiesForEstRentNewProgrammatic()
    {
        $GetMlsHasStyle = HomeValueCustom :: GetMlsHasStyle();
        ## Update the new Query here..
        $Obj = new SqlManager();
        
            $Query =" SELECT mls.id  AS insights_property_id ,
                latitude, longitude, sold_price, sold_date, square_foot, property_type, style, year_built 
                FROM tbl_property_details_mls mls
                INNER JOIN tbl_insights_est_price_mls price ON(price.insights_property_id = mls.id  AND price.is_best = 'Y')
                INNER JOIN tbl_insights_est_rent_mls  est_r ON (est_r.insights_property_id = mls.id  AND est_r.is_best = 'Y')
                WHERE
                est_r.rcomp_criteria_id=10000
                AND mls.county IN (SELECT county_name FROM county_master WHERE home_value_calculate = 1)
                AND (mls.style IN(SELECT style FROM reis.tbl_property_style_master where display='Y') OR (mls.style IS NULL AND mls.source IN(' ".implode("', '", $GetMlsHasStyle)."')))
                AND mls.id not in (SELECT tbl_property_details_mls_id from tbl_est_price_rent_is_best )
                 ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS." ORDER BY mls.id 
                LIMIT 10 ";
            echo '#1:: GetMlsPropertiesForEstRentNewProgrammatic:: <pre>';
            print_r($Query);

            // echo '<hr>';
            return $Obj->GetQuery($Query);
    }
    /**
     * get the is_best Rent Value for $Item['insights_property_id'] = Property
     * @param $Item $Item['insights_property_id'], $Item['est_month'], $Item['est_year']
     */
    public static function GetRentValueIsBestNew($Item)
    {
            $Obj = new SqlManager();
              $Obj->AddTbls(array('insights_est_rent_mls'));
            //   $Obj->AddFlds(array('id', 'insights_property_id', 'est_monthly_rent', 'high_est_monthly_rent', 'median_est_monthly_rent', 'low_est_monthly_rent'));
              $Obj->AddFlds(array('*'));
              $Obj->AddFldCond('insights_property_id', $Item['insights_property_id']);
              $Obj->AddFldCond('is_best', 'Y');
            // $Obj->AddFldCond('is_best', 'A');
           
              return $Obj->GetSingle();
    } 



}

class HVUtils
{
    private static $msCommentsCondition;
    public static function GetCommentExclusion() {
        if (self::$msCommentsCondition == null) {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('textmining_master'));
            $Obj->AddFlds(array('phrase'));
            $PhrasesArr = $Obj->GetMultiple();

            self::$msCommentsCondition = array();
            foreach ($PhrasesArr as $Item)
                self::$msCommentsCondition[] = trim(strtolower($Item['phrase']));
        }
        return self::$msCommentsCondition;
    }
    public static function CalculateTolerance($Value, $TolerancePercentage)
    {
        return round(($Value / 100) * $TolerancePercentage);
    }
    public static function GetRelativeStyles($CurrentStyle)
    {
        $Condition = array();
        $SingleFamily = array(
            '10 - 1 Story',
            '11 - 1 1/2 Story',
            '12 - 2 Story',
            '13 - Tri-Level',
            '14 - Split Entry',
            '15 - Multi Level',
            '16 - 1 Story w/Bsmnt.',
            '17 - 1 1/2 Stry w/Bsmt',
            '18 - 2 Stories w/Bsmnt',
            'Half Duplex',
            'Modular Home',
            'Residential',
            'Single Family Residence',
            'Villa'
        );
        $Manufactured = array(
            '20 - Manuf-Single Wide', 
            '21 - Manuf-Double Wide', 
            '22 - Manuf-Triple Wide',
            'Manufactured Home - Post 1977'
        );
        $MultiFamily = array(
            '52 - Duplex', 
            '54 - 4-Plex', 
            '55 - 5-9 Units',
            'Duplex',
            'Multi-Family',
            'Quadruplex',
            'Triplex'
        );
        $Condo = array(
            '30 - Condo (1 Level)', 
            '31 - Condo (2 Levels)', 
            '33 - Co-op',
            '34 - Condo (3 Levels)',
            'Condo - Hotel',
            'Condominium'
        );

        if (in_array(trim($CurrentStyle), $SingleFamily)) {
            $Condition = $SingleFamily;
        } else if (in_array(trim($CurrentStyle), $Manufactured)) {
            $Condition = $Manufactured;
        } else if (in_array(trim($CurrentStyle), $MultiFamily)) {
            $Condition = $MultiFamily;
        } else if (in_array(trim($CurrentStyle), $Condo)) {
            $Condition = $Condo;
        } else
            $Condition = array(trim($CurrentStyle));
        return $Condition;
    }
}
class HVFilter
{
    private $Filter;
    private $Property;

    private $YearLow;
    private $YearHigher;

    private $SquareFootLow = 0;
    private $SquareFootHigh = 0;
    private $SoldPriceLow = 0;
    private $SoldPriceHigh = 0;

    public function distance($Item)
    {
        return $Item['distance'] <= $this->Filter['distance'];
    }

    public function yearBuilt($Item)
    {
        return $Item['year_built'] >= $this->YearLow && $Item['year_built'] <= $this->YearHigher;
    }

    public function squareFoot($Item)
    {
        return $Item['square_foot'] >= $this->SquareFootLow && $Item['square_foot'] <= $this->SquareFootHigh;
    }

    public function status($Item)
    {
        if (strtolower($this->Filter['status']) == 'sold') {
            return (strtolower($Item['status']) == 'sold');
        } else if (strtolower($this->Filter['status']) == 'sold,pending' || strtolower($this->Filter['status']) == 'pending,sold') {
            return (strtolower($Item['status']) != 'active' && strtolower($Item['status']) != 'contingent');
        }
        return true;
    }

    public function soldPrice($Item)
    {
        if ($this->SoldPriceLow > 0 && $this->SoldPriceHigh > 0) {
            if (strtolower($Item['status']) == 'sold')
                return $Item['sold_price'] >= $this->SoldPriceLow && $Item['sold_price'] <= $this->SoldPriceHigh;
            else
                return $Item['list_price'] >= $this->SoldPriceLow && $Item['list_price'] <= $this->SoldPriceHigh;
        }
        return true;
    }

    public function soldWithin($Item)
    {
        if ($Item['status'] == 'Sold') {
            return ($Item['sold_within'] <= $this->Filter['sold_within']);
        }
        return true;
    }

    public function absoluteStyle($Item)
    {
        return trim(strtolower($Item['style'])) == trim(strtolower($this->Property['style']));
    }

    public function relativeStyle($Item)
    {
        $RelativeStyles = HVUtils::GetRelativeStyles($this->Property['style']);
        return in_array( trim($Item['style']),  $RelativeStyles);
    }

    public function excludePublicComments($Item)
    {
        $PublicComments = strtolower($Item['public_comments']);
        $Comments = HVUtils::GetCommentExclusion();
        foreach ($Comments as $Comment) {
            if (!(strpos($PublicComments, $Comment) === false)) {
                return false;
            }
        }
        return true;
    }

    public function setFilterParameters($Filter)
    {
        $this->Filter = $Filter;
    }

    public function setSubjectProperty($Property)
    {
        $this->Property = $Property;

        if (isset($this->Filter['year_built_tolerance'])) {
            $this->YearLow = $Property['year_built'] - $this->Filter['year_built_tolerance'];
            $this->YearHigher = $Property['year_built'] + $this->Filter['year_built_tolerance'];
        }

        $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], $this->Filter['square_foot_per']);
        $this->SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
        $this->SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

        if (isset($this->Filter['sold_price_per']) && $this->Filter['sold_price_per'] > 0) {
            $SoldPriceTolerance = HVUtils::CalculateTolerance($Property['sold_price'], $this->Filter['sold_price_per']);
            $this->SoldPriceLow = $Property['sold_price'] - $SoldPriceTolerance;
            $this->SoldPriceHigh = $Property['sold_price'] + $SoldPriceTolerance;
        } else if (isset($this->Filter['sold_price_low']) && isset($this->Filter['sold_price_high']) && $this->Filter['sold_price_low'] > 0 && $this->Filter['sold_price_high'] > 0) {
            $this->SoldPriceLow = $this->Filter['sold_price_low'];
            $this->SoldPriceHigh = $this->Filter['sold_price_high'];
        }
    }

    public function setRSubjectProperty($Property)
    {
        //  #$# 4.5
        $this->Property = $Property;

        if (isset($this->Filter['year_built_tolerance'])) {
            $this->YearLow = $Property['year_built'] - $this->Filter['year_built_tolerance'];
            $this->YearHigher = $Property['year_built'] + $this->Filter['year_built_tolerance'];
        }

        $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], $this->Filter['square_foot_per']);
        $this->SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
        $this->SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

        if (isset($this->Filter['sold_price_per']) && $this->Filter['sold_price_per'] > 0) {
            $SoldPriceTolerance = HVUtils::CalculateTolerance($Property['list_price'], $this->Filter['sold_price_per']);
            $this->SoldPriceLow = $Property['list_price'] - $SoldPriceTolerance;
            $this->SoldPriceHigh = $Property['list_price'] + $SoldPriceTolerance;
        } else if (isset($this->Filter['sold_price_low']) && isset($this->Filter['sold_price_high']) && $this->Filter['sold_price_low'] > 0 && $this->Filter['sold_price_high'] > 0) {
            $this->SoldPriceLow = $this->Filter['sold_price_low'];
            $this->SoldPriceHigh = $this->Filter['sold_price_high'];
        }
    }

}
