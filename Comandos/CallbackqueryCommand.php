<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Funciones;
use Longman\TelegramBot\Entities\Keyboard;
/**
 * Callback query command
 *
 * This command handles all callback queries sent via inline keyboard buttons.
 *
 * @see InlinekeyboardCommand.php
 */
 error_reporting(E_ERROR);
class CallbackqueryCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     * @var string
     */
    protected $description = 'Reply to callback query';

    /**
     * @var string
     */
    protected $version = '1.1.1';

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
  
     public function execute()
    {
        $update         = $this->getUpdate();
        $callback_query = $update->getCallbackQuery();
        $callback_data  = $callback_query->getData();
		$callback_query_id = $callback_query->getId();
		$par='';
		$message = $callback_query->getMessage();
		$chat    = $message->getChat();
		$user    = $message->getFrom();
		$user_id    = $message->getFrom()->getId();
		$chat_id =  $callback_query->getMessage()->getChat()->getId();
		

		$data = [
					'chat_id'    => $callback_query->getMessage()->getChat()->getId(),
					'message_id' => $callback_query->getMessage()->getMessageId(),
					'text'       => '',  
				];
		if(is_numeric($callback_data)){
    
      }else{
        $response = Funciones::buscarAlbums($callback_data );
        $albums = json_decode($response, true);
        $data['callback_query_id'] = $callback_query_id;
         $arr = array_slice($albums["items"],0,5);
         foreach( $arr as $album){
          
          $boton =  new InlineKeyboardButton(['text' => $k["name"], 'url' => $k["id"]]);
          $lista = array(array($boton));
          
            Request::sendPhoto([
             'chat_id' => $chat_id,
              'photo'   => Request::encodeFile($album["images"][2]["url"]),
              'caption' => $album["name"]." - ".$album["release_date"],
              'reply_markup' = array("inline_keyboard" => $lista),
              ]);

         }
		
      }	
    }
	

}
