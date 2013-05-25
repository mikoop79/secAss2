<h1>Experiment Two </h1>
<h2>Implementation of Fu's Secure Cookie Scheme</h2>
<p>username | expiration time| (data)k | HMAC(username | expiration time | data , k) <br/> where k = HMAC(username | expiration time, sk)</p>
<p><strong>NOTE</strong> sk = serverkey</p>