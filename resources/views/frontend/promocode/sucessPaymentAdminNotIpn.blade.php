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
                    <td style="font-size:14px;padding:20px 20px 0;font-weight:600;font-family:Arial; margin:0px;">
                        <p style="padding:0 0 5px 0; margin: 0;">Hello Admin,</p>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
                        <p style="padding:0 0 5px 0; margin:0; color: #52595f;">Recently, {{$user['fullname']}} has purchased valentine's package.</p>
                    </td>
                </tr>

          <tr>

          <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
                        <p style="padding:0 0 5px 0; margin:0; color: #52595f;">User Details:</p>
                    </td>
          </tr>

                <tr>
                       <td style="padding:0 20px; margin:0; font-size:14px; font-family:Arial; ">
                         
                     <table style="padding:5px 20px; margin:0; background:#fafafa; width:100%;">
                      <tr>
                      <td style="text-align: left;">
                        <b>Fullname:</b> {{$user['fullname']}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Valentine's Fullname:</b> {{$user['valentine_fullname']}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Email:</b> {{$user['email']}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Contact:</b> {{$user['contact']}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Promo Code:</b> {{$user['promocode']}}
                      </td>
                      </tr>
                     </table>
                  
                     </td>
                  </tr>
                  <tr>
                      <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
                          <p style="padding:0 0 5px 0; margin:0; color: #52595f;">Package Details:</p>
                      </td>
                  </tr>
                  <tr>
                       <td style="padding:0 20px; margin:0; font-size:14px; font-family:Arial; ">
                         
                     <table style="padding:5px 20px; margin:0; background:#fafafa; width:100%;">
                      <tr>
                      <td style="text-align: left;">
                        <b>Package Name:</b> <a href="http://www.upeverest.com/package/valentines-package">{{$package['title']}}</a>
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Price:</b> NPR {{$dPrice['price']}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Date:</b> {{$dPrice['daterange']}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Extension:</b> {{$extension}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Total Price:</b> {{$user['amt']}}
                      </td>
                      </tr>
                     </table>
                  
                     </td>
                  </tr>
	<tr>

          <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
                        <p style="padding:0 0 5px 0; margin:0; color: #52595f;">Payment Details:</p>
                    </td>
          </tr>

<tr>
                       <td style="padding:0 20px; margin:0; font-size:14px; font-family:Arial; ">
                         
                     <table style="padding:5px 20px; margin:0; background:#fafafa; width:100%;">
                      <tr>
                      <td style="text-align: left;">
                        <b>Reference Code:</b> {{$payment['refId']}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Product Id:</b> {{$payment['oid']}}
                      </td>
                      </tr>
                      <tr>
                      <td style="text-align: left;">
                        <b>Amount:</b> {{$payment['amt']}}
                      </td>
                      </tr>
                     </table>
                  
                     </td>
                  </tr>


                  <tr>
       <td style="background:#fff; padding:10px;"></td>
                  </tr>

<tr style="font-size:14px; padding:0px; margin:0; font-family:Arial;" class="w320 mobile-spacing">
                        <td style="padding:10px 20px 20px 20px;">
                            <p style="padding:0 0 5px 0; margin:0; color:#52595f; font-style: italic;">If you have any queries, please feel free to contact us at <a style="color:#500847;" href="mailto:info@upeverest.com">info@upeverest.com</a></p>
                        </td>
                 </tr>

                 <tr class="footer" style="padding:0; margin:0;">
                        <td style="padding:0 20px 10px;font-family:Arial;">
                            <p style="font-size:14px;line-height:normal; 
                            margin:0; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc;">Have a wonderful time!</p>
                        </td>
                </tr>

                <tr>
                        <td style="font-weight: bold;font-family:Arial; margin:0 0 20px 0; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0 0 20px 0; padding:0;">UpEverest Team</p>
                        </td>
                    </tr>
                  <!--  <tr>
                        <td style="font-weight: bold;font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0;">UpEverest Team</p>
                        </td>
                    </tr> -->
            </table>
        </center>
    </div>
</body>
</html>