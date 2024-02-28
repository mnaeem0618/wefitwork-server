var express = require("express");
var https = require("https");
var mysql = require("mysql");
var mysql2 = require('mysql2/promise');

var app = express();
var crypto = require("crypto");
var fs = require("fs");
const { send } = require("process");
// var key = fs.readFileSync("ssl/liveloftus_com.key");
// var cert = fs.readFileSync("ssl/liveloftus_com.crt");



const nodemailer = require('nodemailer');

const transporter = nodemailer.createTransport({
  host: "elusivehunters.com",
  port: 465,
  secure: true, // upgrade later with STARTTLS
  auth: {
    user: "notifications@elusivehunters.com",
    pass: "&hbaYWoM0n%1",
  },
});





app.use(express.urlencoded());

app.use(express.json());


var options = {
  // key: key,
  // cert: cert
};

var key = "RABZSVMAXCBZJWTKB79K9EZK5FJJ4ABA";
var iv = "K8ULM7TS36HMMECG";

const server = https.createServer(app);



var dbConnect = {
  host:'localhost', user: 'root', database: 'herosol_wefitwork' , password : ""
}


var con = mysql.createConnection({
  host: dbConnect.host,
  user: dbConnect.user,
  password: dbConnect.password,
  database: dbConnect.database,
});



con.connect(function (err) {
  if (err) throw err;
});

const io = require("socket.io")(server, {

  cors: {
    origin: '*',
  },
  methods: ["GET", "POST"]


});
//io.origins('*:*')
app.post('/notifications', (req, res) => {
  

  let notification = req.body;
console.log(notification);
  users.map((user) => {
    if (user.user_id == parseInt(notification.userId)) {
      io.to(user.socket).emit("receive-notification", {
        notificationImage: notification.senderImage,
        notificationBody: notification.notifyBody,
      });
    }
  });
res.sendStatus(200)
});



server.listen(4500);




var users = [];

io.on("connection", (socket) => {
  console.log("Connected!");



  socket.on("registerUser", (data) => {

    user = data.userId;

    var obj = {
      user_id: user,
      socket: socket.id,
    };
    users.push(obj);
    console.log(users);
  });

  socket.on("send-message", function (data, callback) {
    //console.log(data);
    sendMessage(data);


});


socket.on("updateMessageStatus", async function (data, callback) {
  const connection = await mysql2.createConnection({host:dbConnect.host, user: dbConnect.user, database: dbConnect.database , password : dbConnect.password});
  
  
  console.log(data);
  var messageData = data;
  const [update, msgs] = await connection.execute('update tbl_msgs set status="seen" where id=?', [messageData.messageId]);
  connection.end();
});

socket.on('disconnect', function () {


console.log("A user disconnected : " + socket.id);
    users.map((user) => {
      if (user.socket == socket.id) {
        users = users.filter((user) => user.socket != socket.id);
      }
    });
    console.log(users);
 

});

});


async function sendMessage(data){



  //const messageData = {conversationId: 1,senderId: 46,message: "test message", file : []};
  messageData = data;
 
  
  const connection = await mysql2.createConnection({host:dbConnect.host, user: dbConnect.user, database: dbConnect.database , password : dbConnect.password});
  
  
  const [result, fields] = await connection.execute('select * from tbl_conversations as tc where tc.id=?', [messageData.conversationId]);
  
  console.log(result[0].receiver);
  
  var receiverId = parseInt(result[0].receiver); //50
  var senderId = parseInt(result[0].sender); //46
  
  
  
  if(receiverId == parseInt(messageData.senderId)){
    receiverId = senderId;
    senderId = parseInt(result[0].receiver);
  
  }else{
    receiverId = parseInt(result[0].receiver);
    senderId = parseInt(result[0].sender);
  }
  
  
  let currentTime = getTimeInNy();
  
  
    let msgData = [messageData.conversationId,senderId, messageData.message,"sent",senderId,receiverId,currentTime];
  
      const [addMessage, f] = await connection.execute('INSERT INTO tbl_msgs (c_id, sender, msg, status,message_by, receiver, created_at) VALUES (?,?,?,?,?,?,?)', msgData);
    
  
      let messageId = addMessage.insertId;
  
  
      let files = messageData.file;
     // let fileNames = messageData.image_name;
      
      if(files.length > 0){
  
          
          for(i=0;i<files.length; i++){
              let fileData = [messageId,files[i].file_name,files[i].image_name];
              const [attachments, f] = await connection.execute('INSERT INTO tbl_msg_attachments (msg_id, name, file_name) VALUES (?,?,?)', fileData);
    
  
          }
  
      }
  

  const [userData, userfields] = await connection.execute('select * from tbl_members as m where m.id=?', [senderId]);
  
  
  
  //let userNoti = 0;
  
            users.map((user) => {
              //console.log(receiverId + "recevier")

              if (user.user_id == receiverId) {
                console.log(user.user_id);
    //            userNoti = 1;
                io.to(user.socket).emit("receive-message", {
                  messageId:messageId,
                  message: messageData.message,
                  senderId: messageData.senderId,
                  messageDate: currentTime,
                  convoId: doEncode(messageData.conversationId.toString()),
                  senderDp: userData[0].mem_image,
                  senderName:userData[0].mem_type == "company" ? userData[0].mem_fullname :  userData[0].mem_fname +" " + userData[0].mem_lname,
                  
                  file: messageData.file
                });
              }
            });
    // if(userNoti == 0){

    //   const [user, fields] = await connection.execute('select * from tbl_members where mem_id=?', [receiverId]);
  
    //   console.log(user[0].mem_email);

    //   // sendEmail(user[0].mem_email, "New Message - ", "You have a new message : \n " + messageData.message)

    // }        
  
            connection.end();
  
      
  
      


}


function sendEmail(userEmail, emailSubject, emailBody){
  const mailConfigurations = {
  
    // It should be a string of sender email
    from: 'notifications@elusivehunters.com',
      
    // Comma Separated list of mails
    to: userEmail,
  
    // Subject of Email
    subject: emailSubject,
      
    // This would be the text of email body
    text: emailBody
  };
  
  
  transporter.sendMail(mailConfigurations, function(error, info){
    if (error) throw Error(error);
       console.log('Email Sent Successfully');
    console.log(info);
  });
  

}

function decrypt_token(data) {
  var decipher = crypto.createDecipheriv("aes-256-cbc", key, iv),
    buffer = Buffer.concat([
      decipher.update(Buffer.from(data, "base64")),
      decipher.final(),
    ]);
  var data = buffer.toString();
  data = data.split("-");
  return data;
}


function encrypt(plain_text) {
  var encryptionMethod = "AES-256-CBC";
  var encryptor = crypto.createCipheriv(encryptionMethod, key, iv);
  return encryptor.update(plain_text, 'utf8', 'base64') + encryptor.final('base64');
};

function decrypt(encryptedMessage) {
  var encryptionMethod = "AES-256-CBC";
  var decryptor = crypto.createDecipheriv(encryptionMethod, key, iv);
  return decryptor.update(encryptedMessage, 'base64', 'utf8') + decryptor.final('utf8');
};





function sessionNumber(){

  const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';


    let result = '';
    const charactersLength = characters.length;
    for ( let i = 0; i < 8; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;


}

function getTimeInNy(){
  let newyork_str = new Date().toLocaleString("en-US", { timeZone: "America/New_York" });

let date_newyork = new Date(newyork_str);
let year = date_newyork.getFullYear();
let month = ("0" + (date_newyork.getMonth() + 1)).slice(-2);
let date = ("0" + date_newyork.getDate()).slice(-2);
let hrs = (date_newyork.getHours() > 10 ? date_newyork.getHours() : "0" + date_newyork.getHours());
let mins = (date_newyork.getMinutes());
let sec = (date_newyork.getSeconds());
let date_time = year + "-" + month + "-" + date + " " + hrs + ":" + mins + ":" + sec;
return date_time;
}

function getCurrentTimeInNy(){
  let newyork_str = new Date().toLocaleString("en-US", { timeZone: "America/New_York" });
console.log(newyork_str);
  let date_newyork = new Date(newyork_str);
  return date_newyork;
}

function doDecode(string, key = 'preciousprotection') {
  let hash = '';
  let hashedKey = crypto.createHash('sha1').update(key).digest('hex');
  
  let strLen = string.length;
  let keyLen = hashedKey.length;
  let j = 0;

  for (let i = 0; i < strLen; i += 2) {
      let subStr = string.substring(i, i + 2).split('').reverse().join('');
      let ordStr = parseInt(subStr, 36).toString(16);
      ordStr = parseInt(ordStr, 16);

      if (j === keyLen) {
          j = 0;
      }
      
      let ordKey = hashedKey.charCodeAt(j);
      j++;
      
      hash += String.fromCharCode(ordStr - ordKey);
  }
  
  let decodedHash = Buffer.from(hash, 'base64').toString('utf8');
  return decodedHash;
}


function doEncode(string, key = 'preciousprotection') {
  let hash = '';
  let encodedString = Buffer.from(string).toString('base64');
  let hashedKey = crypto.createHash('sha1').update(key).digest('hex');
  
  let strLen = encodedString.length;
  let keyLen = hashedKey.length;
  let j = 0;
  
  for (let i = 0; i < strLen; i++) {
      let ordStr = encodedString.charCodeAt(i);
      if (j === keyLen) {
          j = 0;
      }
      let ordKey = hashedKey.charCodeAt(j);
      j++;
      
      let sum = (ordStr + ordKey).toString(16);
      let converted = parseInt(sum, 16).toString(36);
      hash += converted.split('').reverse().join('');
  }
  return hash;
}
