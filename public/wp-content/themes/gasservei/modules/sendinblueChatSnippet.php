<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* Inline script printed out in the header */
add_action('wp_head', function() {
?>
<script type="text/javascript">
(function() {
  window.sib = { equeue: [], client_key: "3sb15wg3oggvfd3nd0sjy" };
  /* OPTIONAL: email to identify request*/
  // window.sib.email_id = 'example@domain.com';
  /* OPTIONAL: to hide the chat on your script uncomment this line (0 = chat hidden; 1 = display chat) */
  // window.sib.display_chat = 0;
  // window.sib.display_logo = 0;
  /* OPTIONAL: to overwrite the default welcome message uncomment this line*/
  // window.sib.custom_welcome_message = 'Hello, how can we help you?';
  /* OPTIONAL: to overwrite the default offline message uncomment this line*/
  // window.sib.custom_offline_message = 'We are currently offline. In order to answer you, please indicate your email in your messages.';
  window.sendinblue = {}; for (var j = ['track', 'identify', 'trackLink', 'page'], i = 0; i < j.length; i++) { (function(k) { window.sendinblue[k] = function(){ var arg = Array.prototype.slice.call(arguments); (window.sib[k] || function() { var t = {}; t[k] = arg; window.sib.equeue.push(t);})(arg[0], arg[1], arg[2]);};})(j[i]);}var n = document.createElement("script"),i = document.getElementsByTagName("script")[0]; n.type = "text/javascript", n.id = "sendinblue-js", n.async = !0, n.src = 'https://sibautomation.com/sa.js?key=' + window.sib.client_key, i.parentNode.insertBefore(n, i), window.sendinblue.page();
})();
</script>
<?php
});
