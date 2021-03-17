<?php
namespace Longman\TelegramBot;
use Longman\TelegramBot\Entities\InlineKeyboard;

class Funciones {

public static function dump($data, $chat_id = 480434336 )
{
    $dump = var_export($data, true);
    // Write the dump to the debug log, if enabled.
    TelegramLog::debug($dump);

    // Send the dump to the passed chat_id.
    if ($chat_id !== null || (property_exists(self::class, 'dump_chat_id') && $chat_id = self::$dump_chat_id)) {
        $result = Request::sendMessage([
            'chat_id'                  => $chat_id,
            'text'                     => $dump,
            'disable_web_page_preview' => true,
            'disable_notification'     => true,
        ]);

        if ($result->isOk()) {
            return $result;
        }

    }

    return Request::emptyResponse();
}


	//// buscar
public static function buscarBanda( $texto ){

	$busqueda = urlencode($texto);
	$result = file_get_contents("../api/index.php?q=$busqueda");
	//
	//self::dump($result);
	return($result);
	}

	//// buscar
public static function buscarAlbums( $idbanda ){

        $result = file_get_contents("../api/albums.php?id=$idbanda");
        //
        //self::dump($result);
        return($result);
        }
    

}//fin clase


?>
