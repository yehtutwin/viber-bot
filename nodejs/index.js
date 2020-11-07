'use strict';

const ViberBot = require('viber-bot').Bot;
const BotEvents = require('viber-bot').Events;

const TextMessage = require('viber-bot').Message.Text;
const UrlMessage = require('viber-bot').Message.Url;
const ContactMessage = require('viber-bot').Message.Contact;
const PictureMessage = require('viber-bot').Message.Picture;
const VideoMessage = require('viber-bot').Message.Video;
const LocationMessage = require('viber-bot').Message.Location;
const StickerMessage = require('viber-bot').Message.Sticker;
const FileMessage = require('viber-bot').Message.File;
const RichMediaMessage = require('viber-bot').Message.RichMedia;
const KeyboardMessage = require('viber-bot').Message.Keyboard;

const ngrok = require('./get_public_url');

function say(response, message) {
    response.send(new TextMessage(message));
}

function checkUrlAvailability(botResponse, urlToCheck) {

    if (urlToCheck === '') {
        say(botResponse, 'I need a Text to check');
        return;
    }

    // say(botResponse, 'One second...Let me check!');
    // setTimeout(function() {
    //     say(botResponse, 'Here comes the answer :P!');
    // }, 1000);

    // ================================
    // TextMessage object
    const message = new TextMessage('hello');
    // ================================

    // ================================
    // Url Message object
    // let url = "https://google.com"
    // const message = new UrlMessage(url);
    // ================================

    // ================================
    // Contact Message object
    // let contactName = "Ko Ko";
    // let contactPhoneNumber = "09420084765";
    // const message = new ContactMessage(contactName, contactPhoneNumber);
    // ================================

    // ================================
    // Picture Message object
    // let url = "https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png";
    // const message = new PictureMessage(url);
    // ================================

    // ================================
    // Video Message object
    // let url = "https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_480_1_5MG.mp4";
    // let size = 1;
    // const message = new VideoMessage(url, size);
    // ================================

    // ================================
    // Location Message object
    // let latitude = '16.812775';
    // let longitude = '96.129981';
    // const message = new LocationMessage(latitude, longitude);
    // ================================

    // ================================
    // Sticker Message object
    // let stickerId = '40132';
    // const message = new StickerMessage(stickerId);
    // ================================

    // ================================
    // File Message object
    // let url = 'https://file-examples-com.github.io/uploads/2017/10/file-sample_150kB.pdf';
    // let sizeInBytes = '102400';
    // let filename = 'FileMessageTest.pdf';
    // const message = new FileMessage(url, sizeInBytes, filename);
    // ================================

    // ================================
    // RichMedia Message object
    // const SAMPLE_RICH_MEDIA = {
    //     "ButtonsGroupColumns": 6,
    //     "ButtonsGroupRows": 5,
    //     "BgColor": "#FFFFFF",
    //     "Buttons": [{
    //         "ActionBody": "https://www.google.com",
    //         "ActionType": "open-url",
    //         "BgMediaType": "picture",
    //         "Image": "https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png",
    //         "BgColor": "#000000",
    //         "TextOpacity": 60,
    //         "Rows": 4,
    //         "Columns": 6
    //     }, {
    //         "ActionBody": "https://www.facebook.com",
    //         "ActionType": "open-url",
    //         "BgColor": "#85bb65",
    //         "Text": "Buy",
    //         "TextOpacity": 60,
    //         "Rows": 1,
    //         "Columns": 6
    //     }]
    // };
    // const message = new RichMediaMessage(SAMPLE_RICH_MEDIA);
    // ================================

    // ================================
    // Keyboard Message object
    // const SAMPLE_KEYBOARD = {
    //     "Type": "keyboard",
    //     "Revision": 1,
    //     "Buttons": [
    //         {
    //             "Columns": 3,
    //             "Rows": 2,
    //             "BgColor": "#e6f5ff",
    //             "BgMedia": "http://www.jqueryscript.net/images/Simplest-Responsive-jQuery-Image-Lightbox-Plugin-simple-lightbox.jpg",
    //             "BgMediaType": "picture",
    //             "BgLoop": true,
    //             "ActionType": "reply",
    //             "ActionBody": "Yes"
    //         }
    //     ]
    // };
    // const message = new KeyboardMessage(SAMPLE_KEYBOARD);

    console.log(message);
    botResponse.send(message);
}

const bot = new ViberBot({
	authToken: 'YourAccessTokenHere',
	name: "CBT",
	avatar: "http://viber.com/avatar.jpg" // It is recommended to be 720x720, and no more than 100kb.
});

// The user will get those messages on first registration
bot.onSubscribe(response => {
    say(response, `Hi there ${response.userProfile.name}. I am ${bot.name}! Feel free to ask me if a web site is down for everyone or just you. Just send me a name of a website and I'll do the rest!`);
});

// Perfect! Now here's the key part:
bot.on(BotEvents.MESSAGE_RECEIVED, (message, response) => {
    // This sample bot can answer only text messages, let's make sure the user is aware of that.
    if (!(message instanceof TextMessage)) {
        say(response, `Sorry. I can only understand text messages.`);
        
        if(message instanceof PictureMessage) {
            say(response, `You sent picture message`);
        }
    }
});

bot.onTextMessage(/./, (message, response) => {
    checkUrlAvailability(response, message.text);
});

bot.getBotProfile().then(response => console.log(`Bot Named: ${response.name}`));

// Wasn't that easy? Let's create HTTPS server and set the webhook:
const http = require('http');
const port = process.env.PORT || 5000;

if (process.env.NOW_URL || process.env.HEROKU_URL) {
    const http = require('http');
    const port = process.env.PORT || 5000;

    http.createServer(bot.middleware()).listen(port, () => bot.setWebhook(process.env.NOW_URL || process.env.HEROKU_URL));
} else {
    return ngrok.getPublicUrl().then(publicUrl => {
        const http = require('http');
        const port = process.env.PORT || 5000;

        console.log('publicUrl => ', publicUrl);

        http.createServer(bot.middleware()).listen(port, () => bot.setWebhook(publicUrl));

    }).catch(error => {
        console.log('Can not connect to ngrok server. Is it running?');
        console.error(error);
        process.exit(1);
    });
}