<h1>Experiment Three </h1>
<h2>Our Implementation of the Secure Cookie Scheme</h2>
<p> <code>session id | expiration time | (data)k | HMAC(session id | expiration time | data, k)</code>
<br/> where k = HMAC(session id | expiration time, sk)</p>
<p><strong>NOTE</strong> sk = server key </p>
