# astorbot

Telegram bot que lee api de spotify
Challenge del grupo Aprendiendo Tecnologias IT

## Como funciona

En api/index.php se genera el flow de autorizacion para consumir api de spotify, El mensaje que recibe el bot va a api search de spotify y devuelve json de bandas encontradas, el bot de telegram devuelve inline keyboard con botones respectivos. Luego segunda parte, al tocar un boton se ejecuta comando callbackquery que consulta en api/albums.php con id de banda y autorizacion inicial se recibe de api spotify lista de albums de dicha banda. El bot responde con los 5 primeros albums del array.

Bot realizado con https://github.com/php-telegram-bot
