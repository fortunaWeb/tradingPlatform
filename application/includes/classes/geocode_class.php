<?

require_once 'GeoObject.php';

 Class Geocode
{
     const EARTH_RADIUS = 6372795;

    static function getHorisontalCoords(array $poligonGoords)
    {
        $horisontalCoords = [];
        foreach ($poligonGoords as $poligonGoord) {
            $horisontalCoords[] = $poligonGoord['longitude'];
        }
        return $horisontalCoords;
    }

    static function getVerticalCoords(array $poligonGoords)
    {
        $verticalCoords = [];
        foreach ($poligonGoords as $poligonGoord) {
            $verticalCoords[] = $poligonGoord['latitude'];
        }
        return $verticalCoords;
    }

     static function updateVarCoords($varId)
     {
         $status = '';
         $var = DB::Select('topic_id, live_point, street, house, coords, metro_coords, distance_to_metro, metro_name',
             're_var', "id = {$varId}  LIMIT 1")[0];
         if($var['live_point'] != 'Сочи' && $var['topic_id'] <> 1){
             return ' NOT NSK ';
         }

         $now = new DateTime();
         $coords = Geocode::getCoordByAddress($var['live_point'],$var['street'],$var['house']);
         if($coords == ',')
             return '!!! BLOCK !!!';

         $metroName = Geocode::searchNearMetroName($coords);
         $metroCoords =  Geocode::getMetroCoords($metroName);
         $distanceToMetro = Geocode::searchNearMetroDistance($coords);

         if( empty($var['coords']) ||
             empty($var['metro_coords']) ||
             empty($var['metro_name']) ||
             !array_key_exists($var['metro_name'], self::metroList())
         ){
             $status =  "update";
             DB::Update("re_var",
                 "coords = '{$coords}',
                        metro_coords = '{$metroCoords}',
                        metro_name = '{$metroName}',
                        distance_to_metro = '{$distanceToMetro}'
                 ",
                 "id = '{$varId}'");
         }elseif (
             $metroName != $var['metro_name']
            || $coords != $var['coords']
            || $distanceToMetro != $var['distance_to_metro']
         ){
             $status =  "fixed";
             DB::Update("re_var",
                 "coords = '{$coords}',
                        metro_coords = '{$metroCoords}',
                        metro_name = '{$metroName}',
                        distance_to_metro = '{$distanceToMetro}'
                 ",
                 "id = '{$varId}'");
         }else{
             $status = 'checked';
         }

         DB::Insert('re_metro_update',
             'var_id, metro_old, metro, date_update, type, distance, var_coords',
             "{$varId}, '{$var['metro_name']}', '{$metroName}', '{$now->format(Translate::MYSQL_DATE_TIME)}',
              '{$status}', {$distanceToMetro}, '{$coords}' ");
        return $status;
     }

    static function getCoordByAddress($live_point, $street, $house)
    {
        if(empty($live_point) || empty($street) || empty($house)){
            return '';
        }
        $address = urlencode("{$live_point}, {$street}, {$house}");
        $html_url= "https://geocode-maps.yandex.ru/1.x/?format=json&apikey=66f45507-6248-4ef1-8634-1c0661e134cf&geocode={$address}";
        $rezult= self::getWebPageContent($html_url);
        $coords = json_decode($rezult['content'])->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
        $coordList =  explode(' ', $coords);
        $coordListRevert = $coordList[1].",".$coordList[0];
        return $coordListRevert;
    }

     static function searchNearMetroName($coords)
     {
         $object = new GeoObject($coords);
         return key(self::distanceToMetroNear($object));
     }

     static function searchNearMetroDistance($coords)
     {
         $object = new GeoObject($coords);
         return (int)ceil(current(self::distanceToMetroNear($object)));
     }

    static function getMetroCoords($metroName)
    {
        return self::metroList()[$metroName];
    }

    private function getWebPageContent($url)
    {
        $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
        curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
        curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
        curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $info    = curl_getinfo( $ch );
        curl_close( $ch );

        $info['errno']  = $err;
        $info['errmsg'] = $errmsg;
        $info['content'] = $content;
        return $info;
    }

     static function metroList()
     {
         $list['Площадь Гарина-Михайловского'] = '55.036352, 82.899019';
         $list['Площадь Гарина-Михайловского'] = '55.036072, 82.899722';
         $list['Площадь Гарина-Михайловского'] = '55.034615, 82.898740';
         $list['Площадь Гарина-Михайловского'] = '55.036001, 82.897533';
         $list['Площадь Гарина-Михайловского'] = '55.034764, 82.898072';

         $list['Сибирская']          = '55.042832, 82.920541';
         $list['Сибирская']          = '55.042076, 82.920876';

         $list['Маршала Покрышкина'] = '55.044127, 82.936757';
         $list['Маршала Покрышкина'] = '55.043585, 82.937149';
         $list['Маршала Покрышкина'] = '55.043357, 82.933630';
         $list['Маршала Покрышкина'] = '55.043810, 82.933952';

         $list['Березовая Роща']     = '55.043720,82.951615';
         $list['Бёрезовая Роща']     = '55.043720,82.951615';
         $list['Бёрезовая Роща']     = '55.044009, 82.952167';
         $list['Бёрезовая Роща']     = '55.043100, 82.954321';
         $list['Бёрезовая Роща']     = '55.044007, 82.950877';
         $list['Бёрезовая Роща']     = '55.043451, 82.951488';
         $list['Бёрезовая Роща']     = '55.042904, 82.954035';

         $list['Золотая Нива']       = '55.038107, 82.975389';
         $list['Золотая Нива']       = '55.038645, 82.975188';
         $list['Золотая Нива']       = '55.037747, 82.977135';
         $list['Золотая Нива']       = '55.037416, 82.976751';
         $list['Золотая Нива']       = '55.037524, 82.978160';
         $list['Золотая Нива']       = '55.036854, 82.977394';


         $list['Заельцовская']       = '55.060101, 82.911800';
         $list['Заельцовская']       = '55.060458, 82.912693';
         $list['Заельцовская']       = '55.058748, 82.913342';
         $list['Заельцовская']       = '55.058483, 82.912408';

         $list['Гагаринская']        = '55.052429, 82.914704';
         $list['Гагаринская']        = '55.052087, 82.914125';
         $list['Гагаринская']        = '55.050143, 82.914568';
         $list['Гагаринская']        = '55.050202, 82.915353';

         $list['Красный Проспект']   = '55.042586, 82.917809';
         $list['Красный Проспект']   = '55.042296, 82.916720';
         $list['Красный Проспект']   = '55.041831, 82.916744';
         $list['Красный Проспект']   = '55.041797, 82.917640';
         $list['Красный Проспект']   = '55.040339, 82.917205';
         $list['Красный Проспект']   = '55.040402, 82.918055';

         $list['Площадь Ленина']     = '55.030819, 82.920811';
         $list['Площадь Ленина']     = '55.030596, 82.919092';
         $list['Площадь Ленина']     = '55.029277, 82.920248';
         $list['Площадь Ленина']     = '55.029337, 82.921216';

         $list['Октябрьская']        = '55.019597, 82.937916';
         $list['Октябрьская']        = '55.019332, 82.937552';
         $list['Октябрьская']        = '55.018582, 82.940467';
         $list['Октябрьская']        = '55.018324, 82.939947';

         $list['Речной Вокзал']      = '55.009463, 82.939130';
         $list['Речной Вокзал']      = '55.008205, 82.937146';
         $list['Речной Вокзал']      = '55.008108, 82.937374';

         $list['Студенческая']       = '54.989932, 82.907209';
         $list['Студенческая']       = '54.989762, 82.907751';
         $list['Студенческая']       = '54.988738, 82.905224';
         $list['Студенческая']       = '54.988343, 82.905626';

         $list['Площадь Маркса']     = '54.983618, 82.896791';
         $list['Площадь Маркса']     = '54.983451, 82.897054';
         $list['Площадь Маркса']     = '54.982868, 82.894683';
         $list['Площадь Маркса']     = '54.982652, 82.896802';
         $list['Площадь Маркса']     = '54.983224, 82.891301';
         $list['Площадь Маркса']     = '54.982599, 82.891572';

         return $list;
     }


     private function calculateDistance(GeoObject $A, GeoObject $B)
     {
         // перевести координаты в радианы
         $lat1 = $A->x() * M_PI / 180;
         $lat2 = $B->x() * M_PI / 180;
         $long1 = $A->y() * M_PI / 180;
         $long2 = $B->y() * M_PI / 180;

         // косинусы и синусы широт и разницы долгот
         $cl1 = cos($lat1);
         $cl2 = cos($lat2);
         $sl1 = sin($lat1);
         $sl2 = sin($lat2);
         $delta = $long2 - $long1;
         $cdelta = cos($delta);
         $sdelta = sin($delta);

         // вычисления длины большого круга
         $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
         $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

         $ad = atan2($y, $x);
         $dist = $ad * self::EARTH_RADIUS;
         return $dist;
     }

     private function distanceToMetroNear(GeoObject $object)
     {
         $metriList = self::metroList();
         $distanses = [];
         foreach($metriList as $metroName => $metroCoord) {
             $metro = new GeoObject($metroCoord);
             $distanses[$metroName] = self::calculateDistance($metro, $object);
             unset($metro);
         }
         $nearMetro[array_search(min($distanses), $distanses)] = min($distanses);
         return  $nearMetro;
     }

}