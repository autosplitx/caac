<?php require_once('../../private/initialize.php'); ?>
<?php

if (isset($_POST['name']) && isset($_POST['body'])) {

  $name = $_POST['name'];
  $email = 'autosplitz@gmail.com';
  $subject = $_POST['subject'];
  $body = $_POST['body'];

  require './PHPMailer/PHPMailerAutoload.php';
  // require '../staff/mail/PHPMailer/PHPMailerAutoload.php';

  //Create a new PHPMailer instance
  $mail = new PHPMailer;

  //Tell PHPMailer to use SMTP
  $mail->isSMTP();

  //Enable SMTP debugging
  // 0 = off (for production use)
  // 1 = client messages
  // 2 = client and server messages
  // $mail->SMTPDebug = 4;

  //Ask for HTML-friendly debug output
  $mail->Debugoutput = 'html';

  //Set the hostname of the mail server
  $mail->Host = 'smtp.gmail.com';
  // use
  // $mail->Host = gethostbyname('smtp.gmail.com');
  // if your network does not support SMTP over IPv6

  //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
  $mail->Port = 587;

  //Set the encryption system to use - ssl (deprecated) or tls
  $mail->SMTPSecure = 'tls';

  //Whether to use SMTP authentication
  $mail->SMTPAuth = true;

  //Username to use for SMTP authentication - use full email address for gmail
  $mail->Username = "ademola0926@gmail.com";

  //Password to use for SMTP authentication
  $mail->Password = "Abdulghafar1";

  //Set who the message is to be sent from
  $mail->setFrom('ademola0926@gmail.com', 'CAAC');

  //Set an alternative reply-to address
  $mail->addReplyTo('ademola0926@gmail.com', 'Coker Aguda Area Council');

  //Set who the message is to be sent to
  $mail->addAddress($email, 'CAAC');

  //Set the subject line
  $mail->isHTML(true);
  $mail->Subject = $subject;

  //Read an HTML message body from an external file, convert referenced images to embedded,
  //convert HTML into a basic plain-text alternative body
  // $mail->msgHTML(file_get_contents('contents.php'), dirname(__FILE__));

  //Replace the plain text body with one created manually
  $mail->AltBody = 'This is a plain-text message body from phpmailer';
  $mail->Body = '
  <body>
    <h1 style="text-transform:uppercase;">Applicant</h1>
    <table style="font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;border-collapse:collapse;width:100%;">
      <thead>
        <tr>
          <th style="border:1px solid #ddd;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4CAF50;color:white;">Name</th>
          <th style="border:1px solid #ddd;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4CAF50;color:white;">Subject</th>
          <th style="border:1px solid #ddd;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4CAF50;color:white;">Message</th>
        </tr>
      </thead>
      <tbody id="mailTable">
        <tr>
          <td style="border-collapse:collapse;border:1px solid #ddd;padding:8px;">' . $name . '</td>
          <td style="border-collapse:collapse;border:1px solid #ddd;padding:8px;">' . $subject . '</td>
          <td style="border-collapse:collapse;border:1px solid #ddd;padding:8px;">' . $body . '</td>
        </tr>
      </tbody>
    </table>
  </body>
                ';
  //Attach an image file
  $mail->addAttachment('../img/mainlogo.png');
  // $mail->msgHTML(file_get_contents('contents.php'), __DIR__);

  //send the message, check for errors
  if (!$mail->send()) {
    $status = 'failed';
    $response = "Mailer Error: " . $mail->ErrorInfo;
  } else {
    $status = 'success';
    $response = 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
    exit(json_encode(['status' => $status, 'response' => $response]));
  }

  //Section 2: IMAP
  //IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
  //Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
  //You can use imap_getmailboxes($imapStream, '/imap/ssl') to get a list of available folders or labels, this can
  //be useful if you are trying to get this working on a non-Gmail IMAP server.
  // function save_mail($mail)
  // {
  //   //You can change 'Sent Mail' to any other folder or tag
  //   $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";

  //   //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
  //   $imapStream = imap_open($path, $mail->Username, $mail->Password);

  //   $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
  //   imap_close($imapStream);

  //   return $result;
  // }
}
