@component('mail::message')

<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
  <div style="margin:20px auto;width:70%;padding:5px 0">
    <div style="border-bottom:1px solid #eee">
      <a href="" style="font-size:1.0em;color: #00466a;text-decoration:none;font-weight:600">Your eBay</a>
    </div>
    <p style="font-size:0.8em">Hi,</p>
    <p>Thank you for choosing Your Brand. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
    <h2 style="background: #00466a;margin: 0 auto; width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">{{$data['otp']}}</h2>
    <p style="font-size:0.9em;">Regards,<br />Your eBay</p>
    <hr style="border:none;border-top:1px solid #eee" />
    <div style="padding:4px 0; color:#aaa; font-size:0.4em; line-height:0.4; font-weight:100">
      <p>Your evaly</p>
      <p>Badda, Dhaka</p>
      <p>Bangladesh</p>
    </div>
  </div>
</div> 

Thanks,<br>
{{ $data['name'] }}
@endcomponent
