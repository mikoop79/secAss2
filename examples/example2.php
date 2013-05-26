<h1>Experiment Two </h1>
<h2>Implementation of Fu's Secure Cookie Scheme</h2>
<p>username | expiration time| data | HMAC(username | expiration time | data , sk) 
<br/> where sk  is the server key</p>
<p><strong>Note</strong> the data is sent unencrypted, just part of the cookie value</p>
