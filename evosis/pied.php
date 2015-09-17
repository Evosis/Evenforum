<?php
echo '
</div>

';
?>

  <!-- this cssfile can be found in the jScrollPane package -->
    <link rel="stylesheet" type="text/css" href="style/jquery.jscrollpane.css" />
 
    <!-- latest jQuery direct from google's CDN -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- the jScrollPane script -->
    <script type="text/javascript" src="/javascript/jquery.jscrollpane.min.js"></script>
 
    <!--instantiate after some browser sniffing to rule out webkit browsers-->
    <script type="text/javascript">
     
      $(document).ready(function () {
          if (!$.browser.webkit) {
              $('.container').jScrollPane();
          }
      });
     
    </script>
