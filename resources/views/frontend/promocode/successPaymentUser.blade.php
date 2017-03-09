<html lang="en" style="background:#fbfbfb;">
<head>
    <meta charset="UTF-8">
</head>

<body>
    <div style="margin:0 auto; padding:50px 0; width: 100%;">
        <center>
            <table style="width:600px; margin:0px auto; background:#fff; padding:0px; border:1px solid #ececec" cellpadding="0" cellspacing="0" border="0">
                <tr class="logo">
                    <td style="padding:0 20px 10px; border-bottom:1px dashed #500847; margin:0;">
                        <a href="http://upeverest.com" style="display:block;">
                            <img class="w320" height="100" src="http://upeverest.com/images/upeverest-logo.png" alt="company logo">
                        </a>
                    </td>
                </tr>
    <tr class="main-content" style="padding:0; margin:0;">
                    <td style="font-size:14px;padding:20px 20px 0px;font-weight:600;font-family:Arial; margin-top:10px;">
                        <p style="padding:0 0 5px 0; margin: 0;">Hello {{$user['fullname']}},</p><br>
                    </td>
                </tr>
                    <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
                        <p style="padding:0 0 5px 0; margin:0;">Thank you for purchasing valentine's package.</p><br><br>
                        <p style="padding:0 0 5px 0; margin:0;">Please find below your itinerary:</p><br><br>
                        <p><strong>Package Name:</strong> <a href="http://www.upeverest.com/package/valentines-package">{{$package['title']}}</a></p>
                        <p><strong>Price:</strong> NPR {{$dPrice['price']}}</p>
                        <p><strong>Date:</strong> {{$dPrice['daterange']}}</p>
                        <p><strong>Extension:</strong> {{$extension}}</p><br>
                        <p><strong>Total Price:</strong> {{$user['amt']}}</p><br>
                    </td>
                </tr>
               
                <tr style="font-size:14px; padding:0px; margin:0; font-family:Arial;" class="w320 mobile-spacing">
                        <td style="padding:10px 20px 20px 20px;">
                            <p style="padding:0 0 5px 0; margin:0; color:#52595f; font-weight:bold;">Note: The Flight Details will be sent in a separate email within 12 hours.</p>
                        </td>
                 </tr>

                <tr style="font-size:14px; padding:0px; margin:0; font-family:Arial;" class="w320 mobile-spacing">
                        <td style="padding:0px 20px 20px 20px;">
                            <p style="padding:0 0 5px 0; margin:0; color:#52595f; font-style: italic;">If you have any queries, please feel free to contact us at <a style="color:#500847;" href="mailto:info@upeverest.com">info@upeverest.com</a></p>
                        </td>
                 </tr>

                <tr class="footer" style="padding:0; margin:0;">
                        <td style="padding:0 20px 10px;font-family:Arial;">
                            <p style="font-size:14px;line-height:normal; 
                            margin:0; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc; font-weight: bold;">Happy Valentine's</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; margin:0 0 20px 0; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0 0 20px 0; padding:0;">UpEverest Team</p>
                        </td>
                    </tr>
             
            </table>
        </center>
    </div>
</body>
</html>