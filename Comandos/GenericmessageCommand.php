<?php
namespace Longman\TelegramBot\Commands\SystemCommands;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Funciones;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;

class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';
    protected $description = 'Handle generic message';
    protected $version = '1.1.0';
    protected $need_mysql = true;
    public function executeNoDb()
    {
        // Do nothing
        return Request::emptyResponse();
    }
    public function execute()
    {
        //If a conversation is busy, execute the conversation command after handling the message
        $conversation = new Conversation(
            $this->getMessage()->getFrom()->getId(),
            $this->getMessage()->getChat()->getId()
        );
        $message = $this->getMessage();
    
        //You can use $command as param
        $chat_id = $message->getChat()->getId();
        $user_id = $message->getFrom()->getId();
        $command = $message->getCommand();
	    $data = [
            'chat_id' => $chat_id,
            'text'    => 'GM' . $command . ' not found.. :(',
        ];

        if ($conversation->exists() && ($command = $conversation->getCommand())) {
            return $this->telegram->executeCommand($command);
		}
		
		$texto_ingresado= trim($message->getText());	
		
		if ( trim($texto_ingresado) == '' )  return Request::emptyResponse();
        
		
		if ($message->getPhoto() != null) {
            // foto del qr
            // http(s)://api.qrserver.com/v1/read-qr-code/?fileurl=[URL-encoded-webaddress-url-to-qrcode-image-file]
          
        } else { //es texto inicia busqueda
 
            $response = Funciones::buscarBanda($texto_ingresado);
            
            $respuestas = json_decode($response, true);
            //Funciones::dump($respuestas["artists"]["items"]);
            $lista = array();

            foreach($respuestas["artists"]["items"] as $k){
                //Funciones::dump($k["name"]);
                $boton =  new InlineKeyboardButton(['text' => $k["name"], 'callback_data' => $k["id"]]);
                array_push($lista, array($boton));
            }
            
            $response = "resultados encontrados";
            $inline_keyboard = new InlineKeyboard($lista);
            $data['reply_markup'] = array("inline_keyboard" => $lista);
            $data['text']= $response;
            Request::sendMessage($data); 
            
            
        }
		
    }
}



